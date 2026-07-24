<?php

namespace api\controllers;

use Yii;
use backend\models\Acceptance;
use backend\models\Contact;
use backend\models\Virtual;
use yii\web\UploadedFile;

/**
 * The three public write endpoints (no auth required — same as the legacy
 * site, which lets anonymous visitors submit these). Field names are
 * normalized to camelCase ids (regionId/districtId/quarterId/categoryId/
 * facultyId) instead of the legacy raw POST keys (viloyat/tuman/manzil/
 * rahbar/fakultet), and both forms now require actual ids throughout —
 * fixing the legacy virtual-reception.php bug where the quarter select
 * submitted a name string instead of an id (see LookupController).
 */
class FormsController extends BaseApiController
{
    public function verbs()
    {
        return [
            'contact' => ['POST'],
            'qabul' => ['POST'],
            'virtual-reception' => ['POST'],
        ];
    }

    public function actionContact()
    {
        $post = Yii::$app->request->post();
        $model = new Contact();
        // Always 'contact-form': the 'rector' scenario only requires
        // name/email/message, but the `contact` table's phone/subject columns
        // are NOT NULL regardless of scenario — a save under 'rector' with
        // those omitted fails at the DB layer. The legacy contact-form.php
        // view always collects all five fields anyway.
        $model->scenario = 'contact-form';
        $model->name = $post['name'] ?? null;
        $model->email = $post['email'] ?? null;
        $model->message = $post['message'] ?? null;
        $model->phone = $post['phone'] ?? null;
        $model->subject = $post['subject'] ?? null;

        if (!$model->validate()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $model->errors, 422);
        }
        if (!$model->save(false)) {
            return $this->fail('SAVE_FAILED', 'Xabarni saqlashda xatolik yuz berdi.', null, 500);
        }
        return $this->success(['submitted' => true]);
    }

    public function actionQabul()
    {
        $post = Yii::$app->request->post();
        $model = new Acceptance();
        $model->category_id = $post['categoryId'] ?? null;
        $model->date = $post['date'] ?? null;
        $model->subject = $post['subject'] ?? null;
        $model->fish = $post['fish'] ?? null;
        $model->phone = $post['phone'] ?? null;
        $model->email = $post['email'] ?? null;
        $model->region_id = $post['regionId'] ?? null;
        $model->district_id = $post['districtId'] ?? null;
        $model->quater_id = $post['quarterId'] ?? null;
        $model->status = 1;

        if (!$model->validate()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $model->errors, 422);
        }
        if (!$model->save(false)) {
            return $this->fail('SAVE_FAILED', 'Arizani saqlashda xatolik yuz berdi.', null, 500);
        }
        return $this->success(['submitted' => true, 'id' => (int) $model->id]);
    }

    public function actionVirtualReception()
    {
        $post = Yii::$app->request->post();
        $model = new Virtual();
        $model->fish = $post['fish'] ?? null;
        $model->province = $post['provinceId'] ?? null;
        $model->fog = $post['districtId'] ?? null;
        $model->address = $post['address'] ?? null;
        $model->phone = $post['phone'] ?? null;
        $model->email = $post['email'] ?? null;
        $model->gender = $post['gender'] ?? null;
        $model->faculty_id = $post['facultyId'] ?? null;
        $model->text = $post['text'] ?? null;
        $model->status = 0;

        $model->file = UploadedFile::getInstanceByName('file');
        if (!$model->validate()) {
            return $this->fail('VALIDATION_ERROR', 'Ma\'lumotlar noto\'g\'ri kiritilgan.', $model->errors, 422);
        }
        if ($model->file) {
            $fileName = $model->file->baseName . '_' . uniqid() . '.' . $model->file->extension;
            $model->file->saveAs(Yii::getAlias('@frontend/web/uploads/virtual/') . $fileName);
            $model->file = $fileName;
        }
        if (!$model->save(false)) {
            return $this->fail('SAVE_FAILED', 'Murojaatni saqlashda xatolik yuz berdi.', null, 500);
        }
        return $this->success(['submitted' => true, 'id' => (int) $model->id]);
    }
}
