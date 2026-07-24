<?php

namespace api\controllers;

use Yii;
use backend\models\ConnectLeader;
use backend\models\Counter;
use backend\models\Districts;
use backend\models\Logo;
use backend\models\Network;
use backend\models\Quarters;
use backend\models\Regions;
use backend\models\Setting;
use backend\models\UsefulSites;

/**
 * Site-wide chrome (Setting/Logo/Network/UsefulSites/Counter bundled for
 * Navbar/Footer) plus the region -> district -> quarter cascading lookups
 * used by the qabul/virtual-reception forms, and the ConnectLeader dropdown.
 *
 * Districts/Quarters here are id-based only (?regionId=/?districtId=),
 * fixing the legacy virtual-reception.php bug where the quarter select
 * submitted a name string instead of an id — see FormsController.
 */
class LookupController extends BaseApiController
{
    public function actionSettings()
    {
        $lang = $this->resolveLang();
        $setting = Setting::getSetting();
        $logo = Logo::getLogo();
        $networks = Network::getNetwork();
        $usefulSites = UsefulSites::find()->where(['status' => 1])->asArray()->all();
        $counter = Counter::getCounter();

        return $this->success([
            'setting' => $setting ? [
                'phone' => $setting['phone'],
                'email' => $setting['email'],
                'faks' => $setting['faks'],
                'address' => $setting['address_' . $lang],
            ] : null,
            'logo' => $logo ? [
                'img' => $this->assetUrl($logo['img']),
                'title' => $logo['title_' . $lang],
                'subtitle' => $logo['subtitle_' . $lang] ?? null,
            ] : null,
            'networks' => array_map(fn($n) => [
                'title' => $n['titlte'],
                'icon' => $n['icon'],
                'url' => $n['url'],
            ], $networks),
            'usefulSites' => array_map(fn($s) => [
                'title' => $s['title_' . $lang],
                'img' => $this->assetUrl($s['img']),
                'url' => $s['url'],
            ], $usefulSites),
            'counter' => $counter,
        ]);
    }

    public function actionRegions()
    {
        return $this->success(array_map(fn($r) => [
            'id' => (int) $r['id'],
            'name' => $r['name'],
        ], Regions::getRegions()));
    }

    public function actionDistricts()
    {
        $regionId = Yii::$app->request->get('regionId');
        if (!$regionId) {
            return $this->fail('VALIDATION_ERROR', 'regionId talab qilinadi.', null, 422);
        }
        $items = Districts::find()->where(['region_id' => $regionId])->asArray()->all();
        return $this->success(array_map(fn($d) => [
            'id' => (int) $d['id'],
            'regionId' => (int) $d['region_id'],
            'name' => $d['name'],
        ], $items));
    }

    public function actionQuarters()
    {
        $districtId = Yii::$app->request->get('districtId');
        if (!$districtId) {
            return $this->fail('VALIDATION_ERROR', 'districtId talab qilinadi.', null, 422);
        }
        $items = Quarters::find()->where(['district_id' => $districtId])->asArray()->all();
        return $this->success(array_map(fn($q) => [
            'id' => (int) $q['id'],
            'districtId' => (int) $q['district_id'],
            'name' => $q['name'],
        ], $items));
    }

    public function actionConnectLeaders()
    {
        return $this->success(array_map(fn($c) => [
            'id' => (int) $c['id'],
            'name' => $c['name'],
        ], ConnectLeader::getConnect()));
    }
}
