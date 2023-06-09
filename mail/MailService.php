<?php

/**
 * Author: kjw (추후 완전한 모듈로 전환. 현재 결합도 높음.)
 * Date: 20230523
 */

namespace common\mail;

use common\dataSet\ResponseResult;
use common\mail\compositions\CommonTemplate;
use common\mail\interfaces\ITemplateData;
use common\mail\sub\AgendaMail;
use common\mail\sub\MemberRegistConfirmation;
use common\mail\sub\MemberRegistInformation;
use common\mail\sub\DepositInformation;
use common\mail\sub\FinalInformation;
use common\mail\sub\CardPaymentInformation;
use common\mail\sub\FindPassword;
use common\util\Constant;
use common\util\Util;
use ErrorException;

abstract class MailService
{
    /** Static instance */
    protected const WKF_SENDMAIL_PATH = 'https://mkpost.mk.co.kr/wkf/new/send.php';
    protected const SENDER = [
        Constant::KOREA => '세계지식포럼',
        Constant::ENGLISH => 'WKForum'
    ];

    /** Instance */
    private string $lang = Constant::KOREA;
    private string $emailAddress = '';
    private array $referenceEmailAddress = [];
    private int $emailNo = 0;
    private array $props;

    /** Composition instance */
    private ResponseResult|null $data = null;
    private CommonTemplate $commonTemplate;
    private ITemplateData $iTemplateData;

    protected function __construct(ITemplateData $iTemplateData, int $emailNo)
    {
        $this
            ->setCommonTemplate(new CommonTemplate())
            ->setITemplateData($iTemplateData)
            ->setEmailNo($emailNo);
    }

    /** SubClass Factory */
    public static function createMailInstance(string $type): mixed
    {
        switch ($type) {
            case Constant::MEMBER_REGIST_INFORMATION:
                return new MemberRegistInformation();

            case Constant::MEMBER_REGIST_CONFIRMATION:
                return new MemberRegistConfirmation();

            case Constant::FIND_PASSWORD:
                return new FindPassword();

            case Constant::DEPOSIT_INFORMATION:
                return new DepositInformation();

            case Constant::CARD_PAYMENT_INFORMATION:
                return new CardPaymentInformation();

            case Constant::FINAL_INFORMATION:
                return new FinalInformation();

            case Constant::PRE_AGENDA_MAIL:
            case Constant::FINAL_AGENDA_MAIL:
            case Constant::ONLINE_FINAL_AGENDA_MAIL:
                return new AgendaMail($type);

            default:
                throw new ErrorException('Cannot instantiate abstract class.');
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

    protected function setReferenceEmailAddress(array $referenceEmailAddress): self
    {
        $this->referenceEmailAddress = $referenceEmailAddress;
        return $this;
    }
    protected function getReferenceEmailAddress(): array
    {
        return $this->referenceEmailAddress;
    }

    protected function setEmailNo(int $emailNo): self
    {
        $this->emailNo = $emailNo;
        return $this;
    }
    protected function getEmailNo(): int
    {
        return $this->emailNo;
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

    protected function setCommonTemplate(CommonTemplate $commonTemplate): self
    {
        $this->commonTemplate = $commonTemplate;
        return $this;
    }
    protected function getCommonTemplate(): CommonTemplate
    {
        return $this->commonTemplate;
    }
    /** Getter/Setter END */

    /** Helper */
    protected function getEmailTitle(): string
    {
        switch ($this->getEmailNo()) {
            case Constant::FINAL_INFORMATION:
                return $this->getLang() === Constant::ENGLISH ? 'Registration Confirmation' : '세계지식포럼 최종 등록완료 안내';
            case Constant::DEPOSIT_INFORMATION:
                return $this->getLang() === Constant::ENGLISH ? 'Registration Notification' : '세계지식포럼 등록신청 확인 안내';
            case Constant::CARD_PAYMENT_INFORMATION:
                return '세계지식포럼 등록 결제 안내';
            case Constant::MEMBER_REGIST_CONFIRMATION:
                return $this->getLang() === Constant::ENGLISH ? 'Member registration completion guide' : '회원가입 완료 안내';
            case Constant::MEMBER_REGIST_INFORMATION:
                return $this->getLang() === Constant::ENGLISH ? 'Participant Guide' : '세계지식포럼 회원가입 안내';
            case Constant::FIND_PASSWORD:
                return $this->getlang() === Constant::ENGLISH ? 'Password Finding Security Code' : '비밀번호 찾기 인증번호';
            case Constant::PRE_AGENDA_MAIL:
                return 'Pre Agenda';
            case Constant::FINAL_AGENDA_MAIL:
                return 'Final Agenda';
            case Constant::ONLINE_FINAL_AGENDA_MAIL:
                return 'Online Final Agenda';
            default:
                return '';
        }
    }
    protected function makePostData(): array
    {
        if (empty($this->getData())) $this->setTemplateData();
        if (empty($this->getEmailAddress())) throw new ErrorException('The email address to send does not exist.', -201);
        if (empty($this->getHtmlTemplate())) throw new ErrorException('The mail template to send does not exist.', -202);

        return [
            'sender' => self::SENDER[$this->getLang()],
            'emailTitle' => $this->getEmailTitle(),
            'emailAddress' => $this->getEmailAddress() ?? '',
            'referenceEmailAddress' => $this->getReferenceEmailAddress(),
            'template' => $this->getHtmlTemplate()
        ];
    }
    /** Helper End */

    /** Abstract */
    abstract protected function renderMailTemplateWithData(): string;
    /** Abstract End */

    protected function setTemplateData(): self|ErrorException
    {
        if (empty($this->getITemplateData()) || empty($this->getProps()))
            throw new ErrorException('Props is not initialized.', -205);

        @[
            'emailAddress' => $emailAddress,
            'referenceEmailAddress' => $referenceEmailAddress,
            'resultData' => $resultData
        ] = $this
            ->getITemplateData()
            ->getTemplateData($this->getProps());

        if (!(empty($emailAddress) && empty($resultData))) {
            $this
                ->setEmailAddress($emailAddress)
                ->setData($resultData);
        }

        if (!empty($referenceEmailAddress)) {
            $this->setReferenceEmailAddress($referenceEmailAddress);
        }

        return $this;
    }

    protected function getHtmlTemplate(): string
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
        return Util::useCurl_new(
            self::WKF_SENDMAIL_PATH,
            ['Content-Type: application/json'],
            json_encode($this->makePostData())
        );
    }
}
