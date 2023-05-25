<?php

namespace common\mail\compositions;

use common\mail\interfaces\ITemplateData;
use common\service\Registration;

class ChargeTemplateData implements ITemplateData
{
    public function getTemplateData(array $props): array
    {
        @['reg_d_no' => $reg_d_no] = $props;
        if (empty($reg_d_no)) return [];

        $registrationCls = new Registration();
        $registrationResult = $registrationCls->getChargeInfo($reg_d_no);

        if ($registrationResult->getTotal() < 1) return [];

        return [
            'emailAddress' => $registrationResult->getData()['charge'][0]->getD_email(),
            'resultData' => $registrationResult
        ];
    }
}
