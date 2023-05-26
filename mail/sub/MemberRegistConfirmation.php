<?php

/**
 * Author: kjw
 * Date: 20230523
 */

namespace common\mail\sub;

use common\mail\compositions\MemberTemplateData;
use common\mail\MailService;
use common\service\MemberService;
use common\util\Constant;

/** 회원가입 완료 메일 */
class MemberRegistConfirmation extends MailService
{
    public function __construct()
    {
        parent::__construct(new MemberTemplateData(), Constant::MEMBER_REGIST_CONFIRMATION);
    }

    protected function renderMailTemplateWithData(): string
    {
        if (empty($this->getData())) $this->setTemplateData();

        $member = $this->getData()->getData()[0];
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
                                                <img src='https://file.mk.co.kr/wkforum/img/top_17.png' alt='' width='850' height='221' style='display:block;'>
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
                                                                        {$member->getName_ko()}님,<span style='color:black;'>안녕하십니까,</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:20px;font-weight:500;'>
                                                                        <span style='font-size:20px;color:#333333;font-weight:600;'>세계지식포럼 회원가입이 완료되었습니다.</span>
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines(10)}
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(35)}
                                                    {$this->getCommonTemplate()->dropLines(15)}
                                                    <tr>
                                                        <td style='font-size:20px;font-weight:600;color:#dc1c4d;'>가입자 정보</td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(10)}
                                                    <tr>
                                                        <td>
                                                            <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                                                                <tbody>
                                                                    <tr>
                                                                        <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:2px solid #363636;'><span style='font-family:'Malgun Gothic';font-size:15px;font-weight:500;color:#333333;'>성함</span></td>
                                                                        <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:2px solid #363636;text-align:left;'><span style='font-family:'Malgun Gothic';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$member->getName_ko()}</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:'Malgun Gothic';font-size:15px;font-weight:500;color:#333333;'>소속</span></td>
                                                                        <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:'Malgun Gothic';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$member->getCompany_ko()}</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;'><span style='font-family:'Malgun Gothic';font-size:15px;font-weight:500;color:#333333;'>아이디(이메일)</span></td>
                                                                        <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:left;'><span style='font-family:'Malgun Gothic';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$member->getUser_id()}</span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <ul style='padding-left:15px'>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:'Malgun Gothic';font-weight:500;font-size:14px;color:#656565;'>수정이 필요하시면 이메일(wkf_reg@mk.co.kr, registration@wkforum.org)또는 전화 (02-2000-2620~3)로 연락주시기 바랍니다.</p>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(35)}

                                                    <tr>
                                                        <td style='font-size:20px;font-weight:600;color:#dc1c4d;border-bottom:2px solid #363636;text-align:left;padding-bottom:10px;'>
                                                            회원가입 가입자 혜택
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(5)}
                                                    <tr>
                                                        <td>
                                                            <ul style='padding-left:15px'>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:'Malgun Gothic';font-weight:500;font-size:14px;color:#656565;'>오픈세션 참가신청이 가능합니다.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:'Malgun Gothic';font-weight:500;font-size:14px;color:#656565;'>세계지식포럼의 다양한 정보를 제공받으실 수 있습니다.</p>
                                                                </li>

                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(35)}
                                                    {$this->getCommonTemplate()->dropLines(15)}
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
