<?php

namespace common\mail\compositions;

use common\mail\interfaces\ITemplateData;
use common\service\MemberService;

class MemberTemplateData implements ITemplateData
{
    public function getTemplateData(array $props): array
    {
        @['user_id' => $user_id] = $props;
        if (empty($user_id)) return [];

        $memberServiceCls = new MemberService();
        $memberResult = $memberServiceCls->selOneMember($user_id);

        if ($memberResult->getTotal() < 1) return [];

        return [
            'emailAddress' => $memberResult->getData()[0]->getUser_id(),
            'resultData' => $memberResult
        ];
    }
}
