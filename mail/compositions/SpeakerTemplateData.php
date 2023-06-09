<?php

namespace common\mail\compositions;

use common\mail\interfaces\ITemplateData;
use common\service\SpeakerService;

class SpeakerTemplateData implements ITemplateData
{
    public function getTemplateData(array $props): array
    {
        @['spuid' => $spuid] = $props;
        if (empty($spuid)) return [];

        $speakerServiceCls = new SpeakerService();
        $speakerResult = $speakerServiceCls->getSpeakerList(['spuid' => $spuid]);

        if ($speakerResult->getTotal() < 1) return [];

        $speaker = $speakerResult->getData()[0];
        return [
            'emailAddress' => $speaker->getEmail() ?? '',
            'referenceEmailAddress' => !empty($speaker->getC_email()) ? [$speaker->getC_email()] : [],
            'resultData' => $speakerResult
        ];
    }
}
