<?php

namespace frontend\models;

use common\models\Member;
use yii\base\Model;
use Yii;
use sintret\gii\models\Notification;
use common\models\Setting;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Member', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\Member', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return Member |null the saved model or null if saving fails
     */
    public function signup() {
        if ($this->validate()) {
            $user = new Member();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->status = Member::STATUS_ACTIVE;
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Well done! successfully to registered data!  ');

                $notification = new Notification();
                $notification->title = 'member';
                $notification->message = 'new member, username:' . $user->username;
                $notification->params = \yii\helpers\Json::encode(['model' => 'Member', 'id' => $user->id]);
                if ($notification->save()) {
                    $this->sendEmail($this->email);
                    Yii::$app->session->setFlash('success', 'please check your email!  ');
                } else {
                    print_r($notification->getErrors());
                    exit(0);
                }

                return $user;
            } else {
                return $user->getErrors();
            }
        }

        return null;
    }

    public function sendEmail($mail) {
        $setting = Setting::find()->where(['id' => 1])->one();
        $username = $setting->sendgridUsername;
        $password = $setting->sendgridPassword;
        $mail_admin = $setting->emailAdmin;

        $sendgrid = new \SendGrid($username, $password, array("turn_off_ssl_verification" => true));
        $email = new \SendGrid\Email();
        $subject = 'Registrasi Berhasil';
        $body = 'Thanks ' . $this->username . ',';
        $body .= "\n";
        $body .= "Registrasi anda berhasil, kami akan segera mereview kembali registrasi anda. \n";
        $body .= "Thanks, \n";
        $body .= Yii::$app->name;


        $email->addTo($mail)->
                setFrom($mail_admin)->
                setSubject('Registrasi berhasil')->
                setHtml($body)->
                addCategory("registrasi");

        $response = $sendgrid->send($email);
        //return $response;
        //send whatsapp
        if ($setting->whatsappNumber && $setting->whatsappPassword) {
            $number = $setting->whatsappNumber;
            $app = Yii::$app->name;
            $password = $setting->whatsappPassword;
            $w = new WhatsApp($number, $app, $password);
            $w->send($setting->whatsappSend, $body);
        }
    }

}
