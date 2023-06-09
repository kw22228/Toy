<?php

/**
 * Author: kjw
 * Date: 20230523
 */

namespace common\mail\sub;

use common\mail\compositions\FindPasswordTemplateData;
use common\mail\MailService;
use common\util\Constant;

class FindPassword extends MailService
{
    public function __construct()
    {
        parent::__construct(new FindPasswordTemplateData(), Constant::FIND_PASSWORD);
    }

    protected function renderMailTemplateWithData(): string
    {
        if (empty($this->getData())) $this->setTemplateData();
        return $this->getLang() === Constant::ENGLISH
            ? $this->getEngFindPasswordMailTemplate()
            : $this->getFindPasswordMailTemplate();
    }

    protected function getFindPasswordMailTemplate(): string
    {
        @[
            'user_id' => $user_id,
            'user_name' => $user_name,
            'authCode' => $authCode
        ] = $this->getData()->getData();

        return "
        <body style='margin: 0; padding: 0;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                <tr>
                    <td>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' width='850' style='border-collapse: collapse;'>
                            <tr>
                                <td>
                                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='850'>
                                        <tr>
                                            <td align='center' bgcolor='#70bbd9'>
                                                <img src='https://file.mk.co.kr/wkforum/top_19.png' alt='' width='850' height='207' style='display:block;'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#f5f5f5' style='padding:80px 60px 100px 60px'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td bgcolor='#ffffff' style='padding:60px 30px 90px 30px'>
                                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>

                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:25px;font-weight:600;text-align:center;'>
                                                                        귀하의 패스워드를 변경하세요.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->drawLines()}
                                                                {$this->getCommonTemplate()->dropLines(10)}
                                                                {$this->getCommonTemplate()->dropLines(35)}
                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                        {$user_name}님,
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                        귀하의 패스워드 변경 요청이 접수되었습니다.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                        패스워드 변경을 진행하시려면,
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                        아래의 보안코드번호 6자리를 <strong style='color:#dc1c4d;'>비밀번호 찾기 페이지-보안코드번호 입력란</strong>에 입력해 주세요.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines(35)}
                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;'>
                                                                        <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%;border-bottom:1px solid #ece5e5;'>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td align='center' bgcolor='#f5f5f5' style='width:40%;border-top:2px solid #363636;padding:20px 0;'><span style='font-family:'Malgun Gothic';font-size:15px;font-weight:600;color:#dc1c4d;'>보안코드번호</span></td>
                                                                                <td align='center' bgcolor='#FFFFFF' style='width:60%;border-top:2px solid #363636;text-align:center;padding:20px 0;'><span style='font-family:'Malgun Gothic';font-size:18px;font-weight:600;color:#333333;margin-left:15px;'>{$authCode}</span></td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;'>
                                                                        <ul style='padding-left:20px'>
                                                                            <li style='font-size:10px;color:#dc1c4d;'>
                                                                                <p style='margin-bottom:7px; margin-top:0;font-family:'Malgun Gothic';font-weight:400;font-size:14px;color:#656565;'>확인 하신 후 문의사항이 있으시면 이메일(wkf_reg@mk.co.kr) 또는 전화 (02-2000-2620~3)로 연락주시기 바랍니다.</p>
                                                                            </li>

                                                                        </ul>

                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines(35)}

                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                        감사합니다.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines(35)}
                                                                <tr>
                                                                    <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                        세계지식포럼 사무국
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>";
    }

    protected function getEngFindPasswordMailTemplate(): string
    {
        @[
            'user_id' => $user_id,
            'name_en_given' => $name_en_given,
            'name_en_family' => $name_en_family,
            'authCode' => $authCode
        ] = $this->getData()->getData();

        return "
        <body style='margin: 0; padding: 0;'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%' >
            <tr>
                <td>
                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='850' style='border-collapse: collapse;'>
                        <tr>
                            <td>
                                <table align='center' border='0' cellpadding='0' cellspacing='0' width='850'>
                                    <tr>
                                        <td align='center' bgcolor='#70bbd9'>
                                            <img src='https://file.mk.co.kr/wkforum/top_19.png' alt='' width='850' height='207' style='display:block;'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor='#f5f5f5' style='padding:80px 60px 100px 60px'>
                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                <tr>
                                                    <td bgcolor='#ffffff' style='padding:60px 30px 90px 30px'>
                                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>

                                                            <tr>
                                                                <td style='padding:0 95px 0 95px;font-size:25px;font-weight:600;text-align:center;'>
                                                                    Please change your password.
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            <tr>
                                                                <td style='font-size: 0; line-height: 0;border-bottom:1px solid #d0d0d0;' height='15'>&nbsp;
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines(10)}
                                                            {$this->getCommonTemplate()->dropLines(35)}
                                                            <tr>
                                                                <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                    Dear $name_en_given $name_en_family,
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            <tr>
                                                                <td style='padding:0 15px 0 15px;font-size:15px;font-weight:400;text-align:left;'>
                                                                    Your request to change the password has been received.
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            <tr>
                                                                <td style='padding:0 15px 0 15px;font-size:15px;font-weight:400;text-align:left;'>
                                                                    If you want to continue, please type the 6-digit security code below into
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            <tr>
                                                                <td style='padding:0 15px 0 15px;font-size:15px;font-weight:400;text-align:left;'>
                                                                    the <strong style='color:#dc1c4d'>'Find your password' page - 'Security code'</strong> box.
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            {$this->getCommonTemplate()->dropLines(35)}
                                                            <tr>
                                                                <td style='padding:0 15px 0 15px;'>
                                                                    <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%;border-bottom:1px solid #f5f5f5;'>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td align='center' bgcolor='#f5f5f5' style='width:40%;border-top:2px solid #363636;padding:20px 0;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#dc1c4d;'>Security Code</span></td>
                                                                            <td align='center' bgcolor='#FFFFFF' style='width:60%;border-top:2px solid #363636;text-align:center;padding:20px 0;'><span style='font-family:\'Malgun Gothic\';font-size:18px;font-weight:600;color:#333333;margin-left:15px;'>{$authCode}</span></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding:0 15px 0 15px;'>
                                                                    <ul style='padding-left:20px'>
                                                                        <li style='font-size:10px;color:#dc1c4d;'>
                                                                            <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:400;font-size:14px;color:#656565;'>If you have any questions, please contact the World Knowledge Forum Secretariat.</p>
                                                                        </li>

                                                                    </ul>

                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines(35)}
                                                            <tr>
                                                                <td style='padding:0 15px 0 15px;font-size:15px;font-weight:600;text-align:left;'>
                                                                    Thank you.
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines(35)}
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        </body>";
    }
}
