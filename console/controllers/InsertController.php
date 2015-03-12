<?php

namespace console\controllers;

use yii\console\Controller;
use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use common\models\Setting;
use common\models\Member;

class InsertController extends Controller {

    public function actionInit() {
        $model = new User;
        $model->username = 'admin';
        $model->auth_key = 'OocVKRx-iludROmUFYj4HmxNeC8v0-FG';
        $model->password_hash = '$2y$13$0d3FeUDYGSyZft.3I77hV.E357FsqqAJFqaWPstWODMbdlSvxV2gC';
        $model->email = 'sintret@gmail.com';
        $model->phone = '6281575068530';
        $model->role = User::ROLE_ADMIN;
        $model->status = User::STATUS_ACTIVE;
        if ($model->save()) {
            echo "\r\n success insert user, with username:admin and password:123456 \r\n";
        } else {
            echo json_encode($model->getErrors());
        }
        
        $model = new Member;
        $model->username = 'admin';
        $model->auth_key = 'OocVKRx-iludROmUFYj4HmxNeC8v0-FG';
        $model->password_hash = '$2y$13$0d3FeUDYGSyZft.3I77hV.E357FsqqAJFqaWPstWODMbdlSvxV2gC';
        $model->email = 'sintret@gmail.com';
        $model->phone = '6281575068530';
        $model->role = Member::ROLE_ADMIN;
        $model->status = Member::STATUS_ACTIVE;
        if ($model->save()) {
            echo "\r\n success insert member, with username:admin and password:123456 \r\n";
        } else {
            echo json_encode($model->getErrors());
        }

        $setting = new Setting;
        $setting->emailAdmin = 'sintret@gmail.com';
        $setting->emailSupport = 'sintret@gmail.com';
        $setting->emailOrder = 'sintret@gmail.com';
        $setting->facebook = 'https://www.facebook.com/sintret';
        $setting->instagram = 'https://instagram.com/andyfitria/';
        $setting->google = 'https://google.com/sintret/';
         if ($setting->save()) {
            echo "\r\n success insert advanced settings... \r\n";
        } else {
            echo json_encode($setting->getErrors());
        }
    }

}
