<?php

/**
 * Author: kjw
 * Date: 20230523
 */

namespace common\mail;

// use common\mail\sub\CardPaymentInformation;
// use common\mail\sub\FinalInformation;
// use common\mail\sub\FindPassword;

use common\dataSet\ResponseResult;
use common\mail\interfaces\ITemplateData;
use common\mail\sub\MemberRegistConfirmation;
use common\mail\sub\MemberRegistInformation;
use common\mail\sub\DepositInformation;
use common\util\Constant;
use common\util\Util;

abstract class MailService
{
    protected const WKF_SENDMAIL_PATH = 'https://mkpost.mk.co.kr/wkf/new/send.php';
    private string $lang = Constant::KOREA;
    private string $emailAddress = '';
    private array $props;
    private ResponseResult|null $data = null;
    private ITemplateData $iTemplateData;

    protected function __construct(ITemplateData $iTemplateData)
    {
        $this->setITemplateData($iTemplateData);
    }

    /** SubClass Factory */
    public static function createMailInstance(string $type): mixed
    {
        switch ($type) {
            case Constant::MEMBER_REGIST_INFORMATION:
                return new MemberRegistInformation();

            case Constant::MEMBER_REGIST_CONFIRMATION:
                return new MemberRegistConfirmation();

                // case Constant::FIND_PASSWORD:
                //     return new FindPassword();

            case Constant::DEPOSIT_INFORMATION:
                return new DepositInformation();

                // case Constant::CARD_PAYMENT_INFORMATION:
                //     return new CardPaymentInformation();

                // case Constant::FINAL_INFORMATION:
                //     return new FinalInformation();

            default:
                throw new \ErrorException('Cannot instantiate abstract class.');
        }
    }
    /** SubClass Factory END */

    /** Getter/Setter */
    public function setLang(string $lang): self
    {
        $this->lang = $lang;
        return $this;
    }
    protected function getLang(): string
    {
        return $this->lang;
    }

    protected function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }
    protected function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setProps(array $props): self
    {
        $this->props = $props;
        return $this;
    }
    protected function getProps(): array
    {
        return $this->props;
    }

    protected function setData(ResponseResult $data): self
    {
        $this->data = $data;
        return $this;
    }
    protected function getData(): ResponseResult|null
    {
        return $this->data;
    }

    protected function setITemplateData(ITemplateData $iTemplateData): self
    {
        $this->iTemplateData = $iTemplateData;
        return $this;
    }
    protected function getITemplateData(): ITemplateData
    {
        return $this->iTemplateData;
    }
    /** Getter/Setter END */

    /** Helper */
    protected function makePostData(): array
    {
        if (empty($this->getData())) $this->setTemplateData();

        return [
            'emailAddress' => $this->getEmailAddress() ?? '',
            'template' => $this->getHtmlTemplate()
        ];
    }
    /** Helper End */

    /** Abstract */
    abstract protected function renderMailTemplateWithData(): string;
    /** Abstract End */

    protected function setTemplateData()
    {
        if (empty($this->getITemplateData()) || empty($this->getProps())) return $this;

        @[
            'emailAddress' => $emailAddress,
            'resultData' => $resultData
        ] = $this
            ->getITemplateData()
            ->getTemplateData($this->getProps());

        if (!(empty($emailAddress) && empty($resultData))) {
            $this
                ->setEmailAddress($emailAddress)
                ->setData($resultData);
        }

        return $this;
    }

    protected function getHtmlTemplate()
    {
        return "
        <!DOCTYPE html>
        <html lang='ko'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
            <title>WKF 2023</title>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        </head>
        {$this->renderMailTemplateWithData()}
        </html>
        ";
    }

    public function getPreview(): string
    {
        return $this->getHtmlTemplate();
    }
    public function sendMail()
    {
        var_dump($this->makePostData());
        // $res = Util::useCurl_new(
        //     self::WKF_SENDMAIL_PATH,
        //     ['Content-Type: application/json'],
        //     json_encode($this->makePostData())
        // );

        // var_dump($res);
    }
}
