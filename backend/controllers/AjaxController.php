<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\User;
use sintret\whatsapp\WhatsApp;

class AjaxController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['todolist', 'select', 'send-chat', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        echo 'index';
    }

    public function actionTodolist() {
        $id = (int) $_POST['id'];
        $title = $_POST['title'];
        $type = (int) $_POST['type'];
        if ($id) {
            $model = \sintret\todolist\models\ToDoList::findOne($id);
            $model->status = 1;
            $model->save();
        } elseif ($title) {
            $model = new \sintret\todolist\models\ToDoList();
            $model->title = $title;
            $model->userId = Yii::$app->user->id;
            if ($model->save()) {
                echo $model->data();
            }
        } elseif (isset($_POST['type'])) {
            $model = new \sintret\todolist\models\ToDoList();
            echo $model->data($type);
        } else {
            $model = new \sintret\todolist\models\ToDoList();
            echo $model->data();
        }
    }

    public function actionSendChat() {
        if (!empty($_POST)) {
            echo \sintret\chat\ChatRoom::sendChat($_POST);
            $message = Yii::$app->user->identity->username . ' : ' . $_POST['message'];
            $pos = strpos($message, "@");
            if ($pos !== FALSE) {
                $setting = \common\models\Setting::findOne(1);
                $number = $setting->whatsappNumber;
                $app = Yii::$app->name;
                $password = $setting->whatsappPassword;
                $w = new WhatsApp($number, $app, $password);
                $usernameSendgrid = $setting->sendgridUsername;
                $passwordSendgrid = $setting->sendgridPassword;
                $users = \common\models\User::find()->where(['status' => \common\models\User::STATUS_ACTIVE])->all();
                foreach ($users as $model) {
                    $aprot = '@' . strtolower($model->username);
                    if (strpos($message, $aprot) !== false) {
                        $sendgrid = new \SendGrid($usernameSendgrid, $passwordSendgrid, array("turn_off_ssl_verification" => true));
                        $email = new \SendGrid\Email();
                        $email->addTo($model->email)->
                                setFrom($setting->emailAdmin)->
                                setSubject('Chat from ' . \Yii::$app->name)->
                                setHtml($message);
                        $sendgrid->send($email);
                        //send whatsapp
                        $w->send($model->phone, $message);
                    } else {

                    }
                }
            }
        }
    }

    public function actionTest() {
        $setting = \common\models\Setting::findOne(1);
        $number = $setting->whatsappNumber;
        $app = Yii::$app->name;
        $password = $setting->whatsappPassword;
        $phone = '6281575068530';
        $message = 'this is just test, please dont remain';
        $w = new WhatsApp($number, $app, $password);
        echo $w->send($phone, $message);
    }

}
