<?php

/**
 * Author: kjw
 * Date: 20230523
 */

namespace common\mail\sub;

use common\crypt\AES;
use common\mail\compositions\SpeakerTemplateData;
use common\mail\MailService;
use common\util\Constant;
use ErrorException;

class AgendaMail extends MailService
{
    public function __construct(string $type)
    {
        parent::__construct(new SpeakerTemplateData(), $type);
    }

    public function setLang(string $lang): self
    {
        if ($lang === Constant::KOREA)
            throw new ErrorException('아젠다 메일은 국문으로 보낼 수 없습니다.', -200);

        parent::setLang($lang);
        return $this;
    }

    protected function renderMailTemplateWithData(): string
    {
        if (empty($this->getData())) $this->setTemplateData();
        return $this->getMailTemplate();
    }

    private function createAgendaText(): string
    {
        switch ($this->getEmailNo()) {
            case Constant::PRE_AGENDA_MAIL:
                return "Please click on the icon below to download your preliminary agenda for your participation in the World Knowledge Forum.";
            case Constant::FINAL_AGENDA_MAIL:
                return "Please click on the icon below to download your final agenda for your participation in the World Knowledge Forum.";
            case Constant::ONLINE_FINAL_AGENDA_MAIL:
                return "Please click on the icon below to download your preliminary agenda for your participation in the World Knowledge Forum.
                Please note that all of the dates and times notified in your schedule are written in Korea Standard Time (KST). Make sure you double check by coverting to your local time.";
            default:
                throw new ErrorException('EmailNo not allowed by Agenda Mail', -301);
        }
    }

    private function createAgendaUrl(string $encodedSpuid): string|ErrorException
    {
        $type = $this->getEmailNo() == Constant::PRE_AGENDA_MAIL
            ? Constant::PRE_AGENDA
            : (in_array($this->getEmailNo(), [Constant::FINAL_AGENDA_MAIL, Constant::ONLINE_FINAL_AGENDA_MAIL])
                ? Constant::FINAL_AGENDA
                : throw new ErrorException('EmailNo not allowed by Agenda Mail', -301));

        return "https://wkforum.org/agenda?download=pdf&type={$type}&spuid={$encodedSpuid}";
    }

    private function enCryptSpuid(string $spuid): string
    {
        $aesCls = new AES();
        return $aesCls->AESEncryptCtr($spuid, Constant::AESCRYPT_PASSWORD, Constant::AESCRYPT_BITS);
    }

    protected function getMailTemplate(): string
    {
        $speaker = $this->getData()->getData()[0];

        return "
        <body style='margin: 0; padding: 0;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' >
                <tr>
                    <td>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' width='1000' style='border-collapse: collapse;'>
                            <tr>
                                <td>
                                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='850'>
                                        <tr>
                                            <td align='center' bgcolor='#70bbd9'>
                                                <img src='https://wkforum.org/2022/agenda/images/top_{$this->getEmailNo()}.png' alt=' width='850' height='221' style='display:block;'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding:80px 0px;background:#f7f7f7'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td style='padding:35px 50px'>
                                                            <table border='0' cellpadding='0' cellspacing='0' width='100%' style='background:white;padding:40px 20px;border:5px solid gray'>
                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:25px;font-weight:600;color:#dc1c4d;'>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-size:30px;font-weight:600;text-align:center'>
                                                                        <span>'{$speaker->getFull_name_eng()}'</span>
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                {$this->getCommonTemplate()->dropLines(10)}
                                                                {$this->getCommonTemplate()->dropLines()}
                                                                <tr>
                                                                    <td style='font-size:18px;font-weight:300;text-align:center;vertical-align:middle;display:flex;justify-content:center;align-items:center;'>
                                                                        <span style='font-weight:550;'>{$this->createAgendaText()}</span>
                                                                    </td>
                                                                </tr>
                                                                {$this->getCommonTemplate()->dropLines(30)}
                                                                <tr>
                                                                    <td style='font-size:15px;font-weight:500;text-align:left;vertical-align:middle;display:flex;justify-content:center;align-items:center;color:blue'>
                                                                        <span>* This email is sent from an account used solely for outgoing messages. Please refrain from replying to this email address. If you have any inquiries, kindly contact one of our staff members who have been your main point of contact.</span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                    {$this->getCommonTemplate()->dropLines(35)}

                                                    <tr>
                                                        <td style='text-align:center;'>
                                                            <a href='{$this->createAgendaUrl($this->enCryptSpuid($speaker->getSpuid()))}' target='_blank' style='text-decoration:none;color:white;background:#dc1c4d;padding:15px 20px;font-weight:550'>Check Your Agenda</a>
                                                        </td>
                                                    </tr>

                                                    {$this->getCommonTemplate()->dropLines(20)}
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
