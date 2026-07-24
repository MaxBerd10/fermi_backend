<?php

namespace api\controllers;

use backend\modules\menumanager\models\Menu;

/**
 * GET /v1/menu — full active nested menu tree, pre-nested as JSON (no lft/rgt
 * nested-set math needed client-side). Each node's `href` is resolved
 * server-side to the SAME legacy URL patterns frontend/config/main.php's
 * urlManager already uses (kept for SEO per the approved plan), so the React
 * router just needs matching routes for those exact paths — see Menu::getUrl()
 * for the original PHP-route dispatch this mirrors.
 */
class MenuController extends BaseApiController
{
    /**
     * Legacy urlManager rewrites the Yii route stored in url_value for
     * url_type='c-action' back to a pretty path. Only routes actually reachable
     * from the menu data need an entry here; anything else falls back to
     * "/site/{route}" (still resolvable by a catch-all API-driven route if ever needed).
     */
    private const C_ACTION_ROUTES = [
        'site/index' => '/',
        'site/gallery' => '/galereya',
        'site/video' => '/video',
        'site/sitemap' => '/sitemap',
        'site/schedule' => '/schedule',
        'site/search' => '/search',
        'site/all' => '/news',
    ];

    public function actionIndex()
    {
        $lang = $this->resolveLang();
        $roots = Menu::find()
            ->where(['lvl' => 1, 'status' => 1, 'active' => 1, 'disabled' => 0])
            ->all();

        $tree = [];
        foreach ($roots as $root) {
            $tree[] = $this->nodeToArray($root, $lang, null);
        }
        return $this->success($tree);
    }

    public function actionBreadcrumb($id)
    {
        $lang = $this->resolveLang();
        $node = Menu::findOne($id);
        if (!$node) {
            return $this->fail('NOT_FOUND', 'Menyu topilmadi.', null, 404);
        }
        $chain = [];
        $ancestors = $node->parents()->all(); // kartik\tree\models\Tree::parents()
        foreach ($ancestors as $ancestor) {
            $chain[] = $this->nodeToArray($ancestor, $lang, null, false);
        }
        $chain[] = $this->nodeToArray($node, $lang, null, false);
        return $this->success($chain);
    }

    /**
     * @param Menu $node
     * @param string $lang
     * @param int|null $parentId own parent's id, used as the `menu_id` route
     *   param exactly like the legacy `$submenu->getUrl(['menu_id'=>$menu->id])`
     *   call sites do; falls back to the node's own id when there is no parent
     *   (top-level items) so the generated URL is always well-formed.
     * @param bool $withChildren
     * @return array
     */
    private function nodeToArray(Menu $node, $lang, $parentId, $withChildren = true)
    {
        $title = $lang === 'ru' ? $node->title_ru : ($lang === 'en' ? $node->title_en : $node->title_uz);
        $data = [
            'id' => (int) $node->id,
            'title' => $title,
            'urlType' => $node->url_type,
            'urlValue' => $node->url_value,
            'href' => $this->resolveHref($node, $parentId),
        ];
        if ($withChildren) {
            $children = [];
            foreach ($node->activeSubMenus as $child) {
                $children[] = $this->nodeToArray($child, $lang, $node->id);
            }
            $data['children'] = $children;
        }
        return $data;
    }

    private function resolveHref(Menu $node, $parentId)
    {
        $menuId = $parentId ?? $node->id;
        $value = $node->url_value;
        switch ($node->url_type) {
            case 'main':
                return '/';
            case 'page':
                return "/blog/{$menuId}/{$value}";
            case 'category':
                return "/news/{$menuId}/{$value}";
            case 'leader':
                return "/leader/{$menuId}/{$value}";
            case 'documents':
                return "/documents/{$menuId}/{$value}";
            case 'faculty':
                return "/faculty/{$menuId}/{$value}";
            case 'departments':
                return "/departments/{$menuId}/{$value}";
            case 'c-action':
                // Unlike the other C_ACTION_ROUTES targets, the legacy
                // 'virtual-reception/<menu_id>' rule takes a menu_id segment —
                // it needs the same dynamic {menuId} the page/category/etc.
                // cases below build, so it can't live in the static lookup table.
                if ($value === 'site/virtual-reception') {
                    return "/virtual-reception/{$menuId}";
                }
                return self::C_ACTION_ROUTES[$value] ?? ('/site/' . ltrim(str_replace('site/', '', $value), '/'));
            case 'other':
            default:
                return $value ?: '#';
        }
    }
}
