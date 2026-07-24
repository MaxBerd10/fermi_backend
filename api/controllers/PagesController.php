<?php

namespace api\controllers;

use Yii;
use backend\models\About;
use backend\models\Corusel;
use backend\models\Counter;
use backend\models\Course;
use backend\models\Departments;
use backend\models\Documents;
use backend\models\Faculty;
use backend\models\Img;
use backend\models\Leadercategory;
use backend\models\Page;
use backend\models\Post;
use backend\models\Schedule;
use backend\models\Video;
use backend\modules\menumanager\models\Menu;

/**
 * CMS-content read endpoints: home aggregate, about, generic pages, faculty,
 * departments, leaders, documents, schedule, search, sitemap.
 *
 * The "leaders attached to an arbitrary content page via matching slug"
 * quirk (Leadercategory.slug === Page/Faculty/Departments.slug) is a known
 * fragile legacy coupling — per the approved plan it is preserved as-is here,
 * not replaced with a real FK, so existing CMS content keeps working unchanged.
 */
class PagesController extends BaseApiController
{
    public function actionHome()
    {
        $lang = $this->resolveLang();
        $news = Post::find()->where(['status' => 1])->orderBy('date DESC')->limit(3)->all();
        $images = Img::find()->where(['status' => 1])->orderBy('id DESC')->limit(3)->asArray()->all();
        $videos = Video::find()->where(['status' => 1])->orderBy('id DESC')->limit(3)->asArray()->all();
        $faculties = Faculty::getFaculty();
        $departments = Departments::find()
            ->select(['slug', 'img', 'title_uz', 'title_ru', 'title_en'])
            ->where(['status' => 1])
            ->asArray()
            ->all();
        $corusel = Corusel::getCorusel();

        return $this->success([
            'corusel' => array_map(fn($c) => $this->mapCorusel($c, $lang), $corusel),
            'about' => $this->mapAbout(About::getAbout(), $lang),
            'counter' => Counter::getCounter(),
            'news' => array_map(fn($p) => $this->mapPost($p, $lang), $news),
            'images' => array_map(fn($i) => ['id' => (int) $i['id'], 'img' => $this->assetUrl($i['img'])], $images),
            'videos' => array_map(fn($v) => ['id' => (int) $v['id'], 'video' => $this->assetUrl($v['video']), 'url' => $v['url']], $videos),
            'faculties' => array_map(fn($f) => $this->mapFacultyListItem($f, $lang), $faculties),
            'departments' => array_map(fn($d) => $this->mapDepartmentListItem($d, $lang), $departments),
        ]);
    }

    public function actionAbout($slug)
    {
        $lang = $this->resolveLang();
        $about = About::find()->where(['slug' => $slug])->asArray()->one();
        if (!$about) {
            return $this->fail('NOT_FOUND', 'Sahifa topilmadi.', null, 404);
        }
        return $this->success($this->mapAbout($about, $lang, true));
    }

    public function actionPage($slug)
    {
        $lang = $this->resolveLang();
        $menuId = Yii::$app->request->get('menuId');
        $page = Page::find()->where(['slug' => $slug])->asArray()->one();
        if (!$page) {
            return $this->fail('NOT_FOUND', 'Sahifa topilmadi.', null, 404);
        }
        return $this->success([
            'id' => (int) $page['id'],
            'title' => $page['title_' . $lang],
            'content' => $this->assetUrlsInHtml($page['content_' . $lang]),
            'slug' => $page['slug'],
            'file' => $this->assetUrl($this->localizedFile($page, $lang)),
            'menu' => $this->menuBranch($menuId, $lang),
            'leaders' => $this->leadersForSlug($slug, $lang),
        ]);
    }

    public function actionFacultyIndex()
    {
        $lang = $this->resolveLang();
        $items = Faculty::getFaculty();
        return $this->success(array_map(fn($f) => $this->mapFacultyListItem($f, $lang), $items));
    }

    public function actionFacultyView($slug)
    {
        $lang = $this->resolveLang();
        $menuId = Yii::$app->request->get('menuId');
        $faculty = Faculty::find()->where(['slug' => $slug])->asArray()->one();
        if (!$faculty) {
            return $this->fail('NOT_FOUND', 'Fakultet topilmadi.', null, 404);
        }
        return $this->success([
            'id' => (int) $faculty['id'],
            'title' => $faculty['title_' . $lang],
            'content' => $this->assetUrlsInHtml($faculty['content_' . $lang]),
            'img' => $this->assetUrl($faculty['img']),
            'slug' => $faculty['slug'],
            'menu' => $this->menuBranch($menuId, $lang),
            'leaders' => $this->leadersForSlug($slug, $lang),
        ]);
    }

    public function actionDepartmentsIndex()
    {
        $lang = $this->resolveLang();
        // Unlike Departments::getDepartmenst(), select only listing fields —
        // content_uz/ru/en on this table holds CKEditor-authored HTML with
        // large embedded images and blew the memory limit when fetched in bulk.
        $items = Departments::find()
            ->select(['slug', 'img', 'title_uz', 'title_ru', 'title_en'])
            ->where(['status' => 1])
            ->asArray()
            ->all();
        return $this->success(array_map(fn($d) => $this->mapDepartmentListItem($d, $lang), $items));
    }

    public function actionDepartmentsView($slug)
    {
        $lang = $this->resolveLang();
        $menuId = Yii::$app->request->get('menuId');
        $dept = Departments::find()->where(['slug' => $slug])->asArray()->one();
        if (!$dept) {
            return $this->fail('NOT_FOUND', 'Kafedra topilmadi.', null, 404);
        }
        return $this->success([
            'id' => (int) $dept['id'],
            'title' => $dept['title_' . $lang],
            'content' => $this->assetUrlsInHtml($dept['content_' . $lang]),
            'img' => $this->assetUrl($dept['img']),
            'slug' => $dept['slug'],
            'menu' => $this->menuBranch($menuId, $lang),
            'leaders' => $this->leadersForSlug($slug, $lang),
        ]);
    }

    public function actionLeaders($categorySlug)
    {
        $lang = $this->resolveLang();
        $menuId = Yii::$app->request->get('menuId');
        $category = Leadercategory::find()->where(['slug' => $categorySlug])->asArray()->one();
        if (!$category) {
            return $this->fail('NOT_FOUND', 'Bo\'lim topilmadi.', null, 404);
        }
        $leaders = \backend\models\Leader::find()
            ->where(['status' => 1, 'category_id' => $category['id']])
            ->all();
        return $this->success([
            'category' => ['id' => (int) $category['id'], 'title' => $category['title_' . $lang]],
            'menu' => $this->menuBranch($menuId, $lang),
            'leaders' => array_map(fn($l) => $this->mapLeader($l, $lang), $leaders),
        ]);
    }

    public function actionDocuments($slug)
    {
        $lang = $this->resolveLang();
        $menuId = Yii::$app->request->get('menuId');
        $document = Documents::find()->where(['status' => 1, 'slug' => $slug])->asArray()->one();
        if (!$document) {
            return $this->fail('NOT_FOUND', 'Hujjat topilmadi.', null, 404);
        }
        $items = \backend\models\DocumentsItem::find()
            ->where(['status' => 1, 'document_id' => $document['id']])
            ->asArray()
            ->all();
        return $this->success([
            'id' => (int) $document['id'],
            'title' => $document['title_' . $lang],
            'menu' => $this->menuBranch($menuId, $lang),
            'items' => array_map(fn($i) => [
                'id' => (int) $i['id'],
                'title' => $i['title_' . $lang],
                'content' => $this->assetUrlsInHtml($i['content_' . $lang]),
                'slug' => $i['slug'],
            ], $items),
        ]);
    }

    public function actionSchedule()
    {
        $lang = $this->resolveLang();
        $courses = Course::find()->where(['status' => 1])->all();
        $result = [];
        foreach ($courses as $course) {
            $schedules = Schedule::find()->where(['status' => 1, 'course_id' => $course->id])->all();
            $result[] = [
                'id' => (int) $course->id,
                'title' => $course->{'title_' . $lang} ?: $course->title_uz,
                'schedules' => array_map(fn($s) => [
                    'id' => (int) $s->id,
                    'title' => $s->{'title_' . $lang} ?: $s->title_uz,
                    'file' => $this->assetUrl($s->file),
                ], $schedules),
            ];
        }
        return $this->success($result);
    }

    public function actionSearch()
    {
        $lang = $this->resolveLang();
        $q = Yii::$app->request->get('q', '');
        $page = max(1, (int) Yii::$app->request->get('page', 1));
        $pageSize = 3;

        $postQuery = Post::find()->where(['status' => 1])
            ->andWhere(['like', 'title_uz', $q])
            ->orWhere(['like', 'title_ru', $q])
            ->orWhere(['like', 'title_en', $q]);
        $total = (clone $postQuery)->count();
        $posts = $postQuery->offset(($page - 1) * $pageSize)->limit($pageSize)->all();

        $pages = Page::find()->where(['status' => 1])
            ->andWhere(['like', 'title_uz', $q])
            ->orWhere(['like', 'title_ru', $q])
            ->orWhere(['like', 'title_en', $q])
            ->all();

        return $this->success([
            'posts' => array_map(fn($p) => $this->mapPost($p, $lang), $posts),
            'pages' => array_map(fn($p) => ['title' => $p->{'title_' . $lang}, 'slug' => $p->slug], $pages),
        ], ['page' => $page, 'pageSize' => $pageSize, 'total' => (int) $total]);
    }

    public function actionSitemap()
    {
        $lang = $this->resolveLang();
        $roots = Menu::find()->where(['lvl' => 1, 'status' => 1, 'active' => 1, 'disabled' => 0])->all();
        $build = function ($node) use (&$build, $lang) {
            $title = $lang === 'ru' ? $node->title_ru : ($lang === 'en' ? $node->title_en : $node->title_uz);
            $children = [];
            foreach ($node->activeSubMenus as $child) {
                $children[] = $build($child);
            }
            return ['id' => (int) $node->id, 'title' => $title, 'children' => $children];
        };
        return $this->success(array_map($build, $roots));
    }

    // --- mapping helpers -------------------------------------------------

    /**
     * Legacy shablon.php special-cases id==4 (registration link) and id==12
     * (telegram channel); every other slide links to `site/events`, a route
     * with no corresponding controller action (dead code) — so those slides
     * get no href here rather than a fake link.
     */
    private function mapCorusel($c, $lang)
    {
        $href = null;
        if ($c['id'] == 4) {
            $href = 'https://magistr.edu.uz/login';
        } elseif ($c['id'] == 12) {
            $href = 'https://t.me/fjstiqabul2021';
        }
        return [
            'id' => (int) $c['id'],
            'title' => $c['title_' . $lang],
            'content' => $this->assetUrlsInHtml($c['content_' . $lang]),
            'img' => $this->assetUrl($c['img']),
            'href' => $href,
        ];
    }

    private function mapAbout($about, $lang, $withUrl = false)
    {
        if (!$about) {
            return null;
        }
        $data = [
            'id' => (int) $about['id'],
            'title' => $about['title_' . $lang],
            'content' => $this->assetUrlsInHtml($about['content_' . $lang]),
            'img' => $this->assetUrl($about['img']),
            'slug' => $about['slug'],
        ];
        if ($withUrl) {
            $data['url'] = $about['url'];
        }
        return $data;
    }

    private function mapPost($post, $lang)
    {
        return [
            'id' => (int) $post->id,
            'title' => $post->{'title_' . $lang},
            'content' => $this->assetUrlsInHtml($post->{'content_' . $lang}),
            'img' => $this->assetUrl($post->img),
            'slug' => $post->slug,
            'date' => $post->date,
            'seen' => (int) $post->seen,
            'category' => $post->category ? [
                'id' => (int) $post->category->id,
                'title' => $post->category->{'title_' . $lang},
                'slug' => $post->category->slug,
            ] : null,
        ];
    }

    private function mapFacultyListItem($f, $lang)
    {
        return [
            'id' => (int) $f['id'],
            'title' => $f['title_' . $lang],
            'img' => $this->assetUrl($f['img']),
            'slug' => $f['slug'],
        ];
    }

    private function mapDepartmentListItem($d, $lang)
    {
        return [
            'title' => $d['title_' . $lang],
            'img' => $this->assetUrl($d['img']),
            'slug' => $d['slug'],
        ];
    }

    private function mapLeader($l, $lang)
    {
        return [
            'id' => (int) $l->id,
            'name' => $l->{'name_' . $lang} ?: $l->name_uz,
            'position' => $l->{'position_' . $lang} ?: $l->position_uz,
            'activity' => $this->assetUrlsInHtml($l->{'activity_' . $lang} ?: $l->activity_uz),
            'biography' => $this->assetUrlsInHtml($l->{'biography_' . $lang} ?: $l->biography_uz),
            'receptionDays' => $l->{'reception_days_' . $lang} ?: $l->reception_days_uz,
            'phone' => $l->phone,
            'faks' => $l->faks,
            'email' => $l->email,
            'photo' => $this->assetUrl($l->rasm),
        ];
    }

    /**
     * Preserves the legacy quirk: a Leadercategory whose `slug` happens to
     * match the current content page's slug gets its leaders attached here.
     */
    private function leadersForSlug($slug, $lang)
    {
        $category = Leadercategory::find()->where(['slug' => $slug])->one();
        if (!$category) {
            return [];
        }
        $leaders = \backend\models\Leader::find()->where(['category_id' => $category->id])->all();
        return array_map(fn($l) => $this->mapLeader($l, $lang), $leaders);
    }

    private function menuBranch($menuId, $lang)
    {
        if (!$menuId) {
            return null;
        }
        $menu = Menu::findOne($menuId);
        if (!$menu) {
            return null;
        }
        $title = $lang === 'ru' ? $menu->title_ru : ($lang === 'en' ? $menu->title_en : $menu->title_uz);
        $subMenus = [];
        foreach ($menu->activeSubMenus as $sub) {
            $subTitle = $lang === 'ru' ? $sub->title_ru : ($lang === 'en' ? $sub->title_en : $sub->title_uz);
            $subMenus[] = ['id' => (int) $sub->id, 'title' => $subTitle, 'urlType' => $sub->url_type, 'urlValue' => $sub->url_value];
        }
        return ['id' => (int) $menu->id, 'title' => $title, 'subMenus' => $subMenus];
    }

    private function localizedFile($record, $lang)
    {
        $field = $lang === 'ru' ? 'file_ru' : ($lang === 'en' ? 'file_en' : 'file');
        return $record[$field] ?? null;
    }
}
