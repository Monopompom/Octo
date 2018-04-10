<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 4/10/2018
 * Time: 15:30
 */

namespace App\Traits;


use ReCaptcha\ReCaptcha;

trait ReCaptchaTrait {

    public function verifyCaptcha($response) {
        $secret = env('SETTINGS_GOOGLE_RECAPTCHA_SECRET_KEY');
        $ReCaptcha = new ReCaptcha($secret);
        $remoteIP = $_SERVER['REMOTE_ADDR'];
        $status = $ReCaptcha->verify($response, $remoteIP);

        return $status->isSuccess();
    }
}