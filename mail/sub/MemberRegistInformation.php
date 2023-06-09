<?php

/**
 * Author: kjw
 * Date: 20230523
 */

namespace common\mail\sub;

use common\dataSet\Member\MemberInfo;
use common\dataSet\Registration\ForumChargeInfo;
use common\dataSet\Registration\ForumGroupInfo;
use common\mail\compositions\ChargeTemplateData;
use common\mail\MailService;
use common\util\Constant;

/** 회원가입 안내 메일 */
class MemberRegistInformation extends MailService
{
    public function __construct()
    {
        parent::__construct(new ChargeTemplateData(), Constant::MEMBER_REGIST_INFORMATION);
    }

    protected function renderMailTemplateWithData(): string
    {
        if (empty($this->getData())) $this->setTemplateData();
        return $this->getChargeMailTemplate();
    }

    protected function getChargeMailTemplate(): string
    {
        $registration = $this->getData()->getData();
        $charge = $registration['charge'][0];
        $members = $registration['member_list'] ?? $registration['registry'];

        return $this->getLang() === Constant::ENGLISH
            ? $this->getChargeEngTemplate($charge, $members)
            : $this->getChargeKorTemplate($charge, $members);
    }

    protected function getChargeKorTemplate(ForumChargeInfo $charge, array $members): string
    {
        $membersHtml = join("", array_map(function ($index, $memberData) {
            $member = $memberData instanceof ForumGroupInfo ? $memberData : $memberData[0];
            $border = $index === 0 ? "border-top:2px solid #363636;" : "border-top:1px solid #d8d8d8;";
            return "
            <tr>
                <td align='center' bgcolor='#FFFFFF' style='{$border}width:70px;'>
                    <span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>참가자 " . ($index + 1) . "</span>
                </td>
                <td align='center' bgcolor='#FFFFFF' style='{$border}text-align:left;'>
                        <span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:0px;'>
                            <label style='color:red;'>{$member->getJumin_number1()}</label>
                        </span>
                </td>
                <td align='center' bgcolor='#FFFFFF' style='{$border}width:120px;text-align:left;'>
                    <a href='https://www.wkforum.org/member/join' target='_blank' style='width:95%;border:2px solid #dc1c4d;display:block;padding:10px 0;background:#ffffff;text-decoration:none;color:#dc1c4d;font-weight:600;position:relative;text-align:center;text-indent:-20px;font-size:12px;font-weight:bold;'>
                        바로가기<img src='https://file.mk.co.kr/wkforum/img/right_arrow_img_1.png' alt='' width='20' height='14' style='position:absolute;top:50%;right:15px;'>
                    </a>
                </td>
            </tr>
            ";
        }, array_keys($members), $members));

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
                                                <img src='https://file.mk.co.kr/wkforum/img/top_07.png' alt='' width='850' height='221' style='display:block;'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding:80px 80px 40px 80px'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td bgcolor='#f7f7f7' style='padding:60px 30px 20px 30px'>
                                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:25px;font-weight:600;color:#dc1c4d;'>
                                                                        {$charge->getD_name()} 담당자 님
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:20px;font-weight:500;'>
                                                                        세계지식포럼 <span style='font-size:20px;color:#333333;font-weight:600;'>참가신청</span>이 확인되었습니다.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->drawLines()}
                                                                {$this->getCommonTemplate()->dropLines(10)}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='font-size:15px;font-weight:600;text-align:center;vertical-align:middle;display:flex;justify-content:center;align-items:center;'>
                                                                        <span style='color:#dc1c4d;'>&#10686;</span>&nbsp;<span>아래 참가자 개별 링크를 통해 회원가입 후 서비스를 이용하실 수 있습니다.</span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->drawLines(35)}
                                                    {$this->getCommonTemplate()->dropLines()}
                                                    <tr>
                                                        <td style='font-size:20px;font-weight:600;color:#dc1c4d;'>
                                                            참가자 정보
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->drawLines(10)}
                                                    <tr>
                                                        <td>
                                                            <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%;border-bottom:1px solid #d8d8d8;'>
                                                                <tbody>{$membersHtml}</tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <ul style='padding-left:15px'>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>정보를 확인하신 후 수정이 필요하시면 이메일 (wkf_reg@mk.co.kr, registration@wkforum.org) 또는 전화(02-2000-2620~3)로 연락주시기 바랍니다.</p>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->drawLines(30)}
                                                </table>
                                            </td>
                                        </tr>
                                        {$this->getCommonTemplate()->getFooterTemplate()}
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>";
    }

    protected function getChargeEngTemplate(ForumChargeInfo $charge, array $members): string
    {

        $member = $members[0][0];
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
                                            <img src='https://file.mk.co.kr/wkforum/img/top_13.png' alt='' width='850' height='221' style='display:block;'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding:80px 80px 40px 80px'>
                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                <tr>
                                                    <td bgcolor='#f7f7f7' style='padding:60px 30px 20px 30px'>
                                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                            <tr>
                                                                <td style='padding:0 35px 0 35px;font-size:30px;font-weight:600;color:#dc1c4d;font-family:\'Arial\';'>
                                                                Dear {$member->getEng_first_name()} {$member->getEng_last_name()}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding:10px 35px 0px 35px;font-size:20px;font-weight:300;font-family:\'Arial\';'>
                                                                    Thank you for your interest in the World Knowledge Forum.
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            {$this->getCommonTemplate()->drawLines()}
                                                            {$this->getCommonTemplate()->dropLines(10)}
                                                            {$this->getCommonTemplate()->dropLines()}
                                                            <tr>
                                                                <td style='font-size:15px;font-weight:600;text-align:center;vertical-align:middle;display:flex;justify-content:center;align-items:center;font-family:\'Arial\';'>
                                                                    <span style='color:#dc1c4d;'>&#10686;</span>&nbsp;<span>You can use the service after singing up as a member through the link below.</span>
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines(35)}
                                                            <tr>
                                                                <td style='font-size:15px;text-align:center;width:100%;'>
                                                                    <a href='https://www.wkforum.org/en/member/join' target='_black' style='width:25%;border:2px solid #dc1c4d;display:inline-flex;padding:15px 10px;background:#ffffff;text-decoration:none;color:#dc1c4d;font-size:24px;font-weight:600;position:relative;justify-content:center;align-items:center;text-align:center;'>
                                                                        Sign up<img src='https://file.mk.co.kr/wkforum/img/right_arrow_img_1.png' alt='' width='20' height='14' style='display:block;position:absolute;top:44%;right:17px;margin-top:5px;margin-left:10px;'>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            {$this->getCommonTemplate()->dropLines(35)}
                                                        </table>
                                                    </td>
                                                </tr>

                                                {$this->getCommonTemplate()->dropLines(35)}
                                                {$this->getCommonTemplate()->dropLines(35)}
                                                <tr>
                                                    <td style='font-size:20px;font-weight:600;color:#dc1c4d;'>
                                                        Personal Information
                                                    </td>
                                                </tr>
                                                {$this->getCommonTemplate()->dropLines(10)}
                                                <tr>
                                                    <td>
                                                        <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                                                            <tbody>
                                                            <tr>
                                                                <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:2px solid #363636;'><span style='font-family:\'Arial\';font-size:15px;font-weight:500;color:#333333;'>Given Name</span></td>
                                                                <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:2px solid #363636;text-align:left;'><span style='font-family:\'Arial\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$member->getEng_first_name()}</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Arial\';font-size:15px;font-weight:500;color:#333333;'>Family Name</span></td>
                                                                <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Arial\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$member->getEng_last_name()}</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Arial\';font-size:15px;font-weight:500;color:#333333;'>Organization/Institution</span></td>
                                                                <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Arial\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$member->getEng_affiliation()}</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Arial\';font-size:15px;font-weight:500;color:#333333;'>e-mail</span></td>
                                                                <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Arial\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$member->getEmail()}</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;'><span style='font-family:\'Arial\';font-size:15px;font-weight:500;color:#333333;'>Verification Code</span></td>
                                                                <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Arial\';font-size:15px;font-weight:600;color:red;margin-left:15px;'>{$member->getJumin_number1()}</span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style='font-size: 0; line-height: 0;' height='80'>&nbsp;
                                                    </td>
                                                </tr>


                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='center'>
                                            <img src='https://file.mk.co.kr/wkforum/img/footer_eng.png'  usemap='#link' alt='' width='850' height='194' style='display:block;'>
                                            <map name='link'>
                                                <area shape='rect' coords='276,104,569,145' target='_blank' href='http://wkforum.org/WKF/2021/en/' style='outline:0;'></map>
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
