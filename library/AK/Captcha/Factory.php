<?php

class AK_Captcha_Factory
{
	public static function getCaptcha($type) {
        switch ($type) {
            case AK_Captcha_Enum::WAVE : return new AK_Captcha_Wave(); exit;
            case AK_Captcha_Enum::B2EVO : return new AK_Captcha_Image(); exit;
            default : throw new Exception ('Incorrect captcha type'); exit;
        }
    }
}