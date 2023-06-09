<?php

/**
 * Author: kjw
 * Date: 20230523
 */

namespace common\mail\sub;

use common\dataSet\Registration\ForumChargeInfo;
use common\mail\compositions\ChargeTemplateData;
use common\mail\MailService;
use common\util\Constant;
use ErrorException;

class DepositInformation extends MailService
{
    public function __construct()
    {
        parent::__construct(new ChargeTemplateData(), Constant::DEPOSIT_INFORMATION);
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
                                                <img src='https://file.mk.co.kr/wkforum/img/top_06.png' alt=' width='850' height='221' style='display:block;'>
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
                                                                        세계지식포럼 <span style='font-size:20px;color:#333333;font-weight:600;'>참가신청</span>이 접수되었습니다.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->drawLines()}
                                                                {$this->getCommonTemplate()->dropLines(10)}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='font-size:15px;font-weight:600;text-align:center;vertical-align:middle;display:flex;justify-content:center;align-items:center;'>
                                                                        <span style='color:#dc1c4d;'>&#10686;</span>&nbsp;<span>참가비 입금이 확인된 후에 최종 등록이 완료됨을 알려드립니다.</span>
                                                                    </td>
                                                                </tr>
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
                                                    {$this->getCommonTemplate()->dropLines()}
                                                    
                                                    {$this->getCommonTemplate()->getChargeTemplate($charge)}

                                                    {$this->getCommonTemplate()->dropLines(35)}
                                                    {$this->getCommonTemplate()->dropLines()}
                                                    
                                                    {$this->getCommonTemplate()->getPayTemplate($charge,$members)}

                                                    {$this->getCommonTemplate()->dropLines(30)}
                                                    {$this->getCommonTemplate()->dropLines(5)}

                                                    {$this->getCommonTemplate()->getRefundTemplate()}

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
                                            <img src='//file.mk.co.kr/wkforum/img/top_12.png' alt='' width='850' height='221' style='display:block;'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding:80px 80px 40px 80px'>
                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                <tr>
                                                    <td bgcolor='#f7f7f7' style='padding:60px 30px 20px 30px'>
                                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                            <tr>
                                                                <td style='padding:0 95px 0 95px;font-size:25px;font-weight:600;color:#dc1c4d;font-family:\'Arial\';'>
                                                                    Dear {$member->getEng_first_name()} {$member->getEng_last_name()}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding:10px 75px 0 95px;font-size:17px;font-weight:100;font-family:\'Arial\';'>Thank you for your interest in the World Knowledge Forum.</td>
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
                                                                <p style='margin-bottom:7px; margin-top:0;margin-left:-5px;font-family:\'Arial\';font-weight:500;font-size:14px;color:#656565;line-height:1.7;'>If you like to modify the information, please contact the secretariat via email<br/>(wkf_reg@mk.co.kr, registration@wkforum.org)</p>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                {$this->getCommonTemplate()->dropLines(35)}
                                                {$this->getCommonTemplate()->dropLines()}
                                                
                                                {$this->getCommonTemplate()->getEngChargeTemplate($member)}

                                                {$this->getCommonTemplate()->dropLines(35)}
                                                {$this->getCommonTemplate()->dropLines()}
                                                
                                                {$this->getCommonTemplate()->getEngPayTemplate($charge,$member)}

                                                {$this->getCommonTemplate()->dropLines(30)}
                                                {$this->getCommonTemplate()->dropLines(5)}
                                                
                                                {$this->getCommonTemplate()->getEngRegistrationConfirmTemplate()}

                                                {$this->getCommonTemplate()->dropLines(30)}
                                                {$this->getCommonTemplate()->dropLines(5)}
                                                
                                                {$this->getCommonTemplate()->getRefundTemplate($this->getlang())}

                                                {$this->getCommonTemplate()->dropLines(35)}
                                                {$this->getCommonTemplate()->dropLines()}
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    {$this->getCommonTemplate()->getFooterTemplate($this->getLang())}
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
