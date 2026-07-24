<?php

namespace api\controllers;

use Yii;
use backend\modules\menumanager\models\Menu;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * /v1/admin/menu-tree — full menu tree editor backing the React admin's
 * drag-drop UI. Unlike the public MenuController (api/controllers/MenuController.php,
 * which only returns active/enabled nodes resolved for one language), this
 * exposes every node/language/flag so admins can edit and reorder them.
 *
 * The whole site menu lives under a single implicit wrapper row (id=1, the
 * nested-set's actual root — see Menu::tableName()'s `menyu` table), so
 * "no parent" in the admin UI means "append under id=1", never
 * NestedSetsBehavior::makeRoot() (that would start a brand-new, disconnected
 * tree that the public site would never render).
 */
class AdminMenuController extends BaseApiController
{
    private const TREE_ROOT_ID = 1;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['options'],
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if ($action->id === 'options') {
            return true;
        }
        $identity = Yii::$app->user->identity;
        if (!$identity || !$identity->isAdmin()) {
            throw new ForbiddenHttpException('Bu amal uchun administrator huquqi kerak.');
        }
        return true;
    }

    public function actionIndex()
    {
        $root = Menu::findOne(self::TREE_ROOT_ID);
        if (!$root) {
            return $this->fail('NOT_FOUND', 'Menyu ildizi topilmadi.', null, 404);
        }
        $descendants = Menu::find()
            ->andWhere(['root' => $root->root])
            ->andWhere(['>', 'lft', $root->lft])
            ->andWhere(['<', 'rgt', $root->rgt])
            ->orderBy(['lft' => SORT_ASC])
            ->all();
        return $this->success($this->buildForest($descendants));
    }

    public function actionCreate()
    {
        $body = Yii::$app->request->getBodyParams();
        $parentId = $body['parentId'] ?? self::TREE_ROOT_ID;
        $parent = Menu::findOne($parentId);
        if (!$parent) {
            return $this->fail('NOT_FOUND', 'Ota bo\'lim topilmadi.', null, 404);
        }

        $node = new Menu();
        $this->loadFields($node, $body);
        $node->name = $node->title_uz;

        if (!$node->appendTo($parent)) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $node->errors, 422);
        }
        return $this->success($this->nodeToArray($node));
    }

    public function actionUpdate($id)
    {
        $node = $this->findNode($id);
        $this->loadFields($node, Yii::$app->request->getBodyParams());
        $node->name = $node->title_uz;
        if (!$node->save()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $node->errors, 422);
        }
        return $this->success($this->nodeToArray($node));
    }

    public function actionDelete($id)
    {
        $node = $this->findNode($id);
        $node->deleteWithChildren();
        return $this->success(['deleted' => true]);
    }

    /**
     * Drag-drop reposition. $position is 'before'|'after'|'child' relative to
     * $targetId — maps directly onto NestedSetsBehavior's own primitives.
     */
    public function actionMove($id)
    {
        $node = $this->findNode($id);
        $body = Yii::$app->request->getBodyParams();
        $targetId = $body['targetId'] ?? null;
        $position = $body['position'] ?? 'child';
        $target = $targetId ? $this->findNode($targetId) : null;

        if (!$target) {
            return $this->fail('VALIDATION_ERROR', 'Maqsad tugun ko\'rsatilmagan.', null, 422);
        }

        if ($position === 'before') {
            $ok = $node->insertBefore($target);
        } elseif ($position === 'after') {
            $ok = $node->insertAfter($target);
        } else {
            $ok = $node->appendTo($target);
        }

        if (!$ok) {
            return $this->fail('MOVE_FAILED', 'Elementni ko\'chirib bo\'lmadi (masalan, o\'zining ichiga ko\'chirish mumkin emas).', null, 422);
        }
        return $this->success(['moved' => true]);
    }

    /**
     * @param int $id
     * @return Menu
     */
    private function findNode($id)
    {
        $node = Menu::findOne($id);
        if (!$node || (int) $node->id === self::TREE_ROOT_ID) {
            throw new NotFoundHttpException('Menyu elementi topilmadi.');
        }
        return $node;
    }

    private function loadFields(Menu $node, array $body)
    {
        foreach (['title_uz', 'title_ru', 'title_en', 'url_type', 'url_value'] as $f) {
            if (array_key_exists($f, $body)) {
                $node->$f = $body[$f];
            }
        }
        foreach (['status', 'active', 'disabled'] as $f) {
            if (array_key_exists($f, $body)) {
                $node->$f = (int) $body[$f];
            }
        }
    }

    private function nodeToArray(Menu $node)
    {
        return [
            'id' => (int) $node->id,
            'parentId' => null,
            'titleUz' => $node->title_uz,
            'titleRu' => $node->title_ru,
            'titleEn' => $node->title_en,
            'urlType' => $node->url_type,
            'urlValue' => $node->url_value,
            'status' => (int) $node->status,
            'active' => (int) $node->active,
            'disabled' => (int) $node->disabled,
            'lvl' => (int) $node->lvl,
            'children' => [],
        ];
    }

    /**
     * Rebuilds parent/child nesting from a flat lft-ordered node list. Walks
     * once, tracking an open-ancestor stack keyed by rgt (standard nested-set
     * preorder-to-tree reconstruction), then assembles the result by id
     * lookup + recursion — avoids N+1 child queries and PHP array-reference
     * aliasing pitfalls.
     *
     * @param Menu[] $nodes
     * @return array
     */
    private function buildForest(array $nodes)
    {
        $byId = [];
        $childIdsOf = [];
        $topIds = [];
        /** @var array{id:int,rgt:int}[] $stack open ancestors, outermost first */
        $stack = [];

        foreach ($nodes as $node) {
            $id = (int) $node->id;
            $byId[$id] = $this->nodeToArray($node);

            while (!empty($stack) && $node->lft > end($stack)['rgt']) {
                array_pop($stack);
            }

            if (empty($stack)) {
                $topIds[] = $id;
            } else {
                $childIdsOf[end($stack)['id']][] = $id;
            }

            $stack[] = ['id' => $id, 'rgt' => (int) $node->rgt];
        }

        $assemble = function ($id) use (&$assemble, $byId, $childIdsOf) {
            $entry = $byId[$id];
            foreach ($childIdsOf[$id] ?? [] as $childId) {
                $entry['children'][] = $assemble($childId);
            }
            return $entry;
        };

        return array_map($assemble, $topIds);
    }
}
