<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/config.php';

use common\util\Constant;
use common\mail\MailService;

$user_id = 'kw22228@naver.com';

// $mailInstance = MailService::createMailInstance(Constant::MEMBER_REGIST_CONFIRMATION);
// echo $mailInstance
//     ->setLang(Constant::KOREA)
//     ->setProps(['user_id' => $user_id])
//     ->sendMail();

// $mailInstance = MailService::createMailInstance(Constant::MEMBER_REGIST_INFORMATION);
// echo $mailInstance
//     ->setLang(Constant::KOREA)
//     ->setProps(['reg_d_no' => 43357])
//     ->sendMail();

$mailInstance = MailService::createMailInstance(Constant::DEPOSIT_INFORMATION);
echo $mailInstance
    ->setLang(Constant::KOREA)
    ->setProps(['reg_d_no' => 43357])
    ->sendMail();
