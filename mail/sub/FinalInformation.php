<?php

namespace common\mail\sub;

use common\mail\compositions\ChargeTemplateData;
use common\mail\MailService;
use common\service\Registration;
use common\util\Constant;

class FinalInformation extends MailService
{
    public function __construct()
    {
        parent::__construct(new ChargeTemplateData(), Constant::FINAL_INFORMATION);
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

        $membersHtml = join("", array_map(function ($index, $memberData) use ($members) {
            $member = $memberData[0];
            $border = $index === 0 ? "border-top:2px solid #363636;" : "border-top:1px solid #d8d8d8;";
            $border_bottom = (count($members) - 1) === $index ? 'border-bottom:1px solid #d8d8d8;' : '';

            return "
            <tr>
                <td align='center' bgcolor='#f5f5f5' style='width:35%;{$border}{$border_bottom}'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>참가자 " . ($index + 1) . "</span></td>
                <td align='center' bgcolor='#FFFFFF' style='width:65%;{$border}{$border_bottom}text-align:left;'>
                        <span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>
                            <label style='color:red;'>{$member->getJumin_number1()}</label>
                        </span>
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
                                                <img src='https://file.mk.co.kr/wkforum/img/top_09.png' alt='' width='850' height='221' style='display:block;'>
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
                                                                        세계지식포럼 <span style='font-size:20px;color:#333333;font-weight:600;'>참가신청</span>이 완료되었습니다.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding:0 25px 0 25px;'>
                                                            <ul style='padding-left:30px'>
                                                                <li style='color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;margin-left:-5px;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;line-height:1.7;'>아래 정보를 확인하신 후 수정이 필요하시면 이메일(wkf_reg@mk.co.kr, registration@wkforum.org) 또는 전화(02-2000-2620~3)로 연락주시기 바랍니다.</p>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(35)}
                                                    {$this->getCommonTemplate()->dropLines()}
                                                    <tr>
                                                        <td style='font-size:20px;font-weight:600;color:#dc1c4d;'>
                                                            참가자 정보
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(10)}
                                                    <tr>
                                                        <td>
                                                            <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                                                                <tbody>{$membersHtml}</tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(35)}
                                                    {$this->getCommonTemplate()->dropLines()}
                                                    
                                                    {$this->getCommonTemplate()->getChargeTemplate($charge)} <!-- 담당자 정보 ->

                                                    {$this->getCommonTemplate()->dropLines(35)}
                                                    {$this->getCommonTemplate()->dropLines()}
                                                    
                                                    {$this->getCommonTemplate()->getPayTemplate($charge,$members,$this->getLang(), true)} <!-- 결제 정보 ->

                                                    {$this->getCommonTemplate()->dropLines(30)}
                                                    {$this->getCommonTemplate()->dropLines(5)}
                                                    
                                                    {$this->getCommonTemplate()->getRefundTemplate()} <!-- 환불 및 취소 정책 ->

                                                    {$this->getCommonTemplate()->dropLines(35)}
                                                    {$this->getCommonTemplate()->dropLines()}
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
        </body>
        ";
    }
}
