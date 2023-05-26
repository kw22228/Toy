<?php

namespace common\mail\sub;

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
        $members = $registration['member_list'];

        $membersHtml = join("", array_map(function ($index, $memberData) {
            $member = $memberData[0];
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
}
