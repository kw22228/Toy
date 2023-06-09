<?php

/**
 * Author: kjw
 * Date: 20230523
 */

namespace common\mail\sub;

use common\mail\compositions\ChargeTemplateData;
use common\mail\MailService;
use common\util\Constant;
use common\util\Util;

class CardPaymentInformation extends MailService
{
    public function __construct()
    {
        parent::__construct(new ChargeTemplateData(), Constant::CARD_PAYMENT_INFORMATION);
    }

    public function setLang(string $lang): self
    {
        if ($lang === Constant::ENGLISH)
            throw new \ErrorException('카드결제안내 메일은 영문으로 보낼 수 없습니다.', -200);

        parent::setLang($lang);
        return $this;
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
                                                <img src='https://file.mk.co.kr/wkforum/img/top_08.png' alt='' width='850' height='221' style='display:block;'>
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
                                                                        안녕하십니까,
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:25px;font-weight:300;'>
                                                                        매일경제 세계지식포럼 사무국 입니다.
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='font-size: 0; line-height: 0;border-bottom:1px solid #d8d8d8;' height='15'>&nbsp;
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines(10)}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='font-size:15px;font-weight:600;text-align:center;vertical-align:middle;display:flex;justify-content:center;align-items:center;'>
                                                                        <span style='color:#dc1c4d;'>&#10686;</span>&nbsp;<span>아래 버튼을 누르시면 카드 결제창으로 안내됩니다.</span>
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines(35)}
                                                                <tr>
                                                                    <td style='font-size:15px;text-align:center;width:100%;display:flex;justify-content:center'>
                                                                        <a href='https://www.wkforum.org/payment?reg_no=" . md5($charge->getReg_d_no()) . "' target='_blank' style='border:2px solid #dc1c4d;display:block;padding:15px 0;background:#ffffff;text-decoration:none;color:#dc1c4d;font-weight:600;position:relative;width:500px;'>
                                                                            카드결제 바로가기<img src='https://file.mk.co.kr/wkforum/img/right_arrow_img_1.png' alt='' width='20' height='14' style='display:block;position:absolute;top:50%;right:15px;transform:translate(-50%, -50%);'>
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
                                                            결제 정보
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(10)}
                                                    <tr>
                                                        <td>
                                                            <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%;border-bottom:1px solid #f5f5f5;'>
                                                                <tbody>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:2px solid #363636;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>참가비</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:2px solid #363636;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . number_format($charge->getD_reg_amount()) . "원</span></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    {$this->getCommonTemplate()->dropLines(10)}
                                                    {$this->getCommonTemplate()->dropLines(10)}
                                                    {$this->getCommonTemplate()->dropLines(10)}

                                                    {$this->getCommonTemplate()->getRefundTemplate()}

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
