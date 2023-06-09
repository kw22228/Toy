<?php

namespace common\mail\compositions;

use common\dataSet\ResponseResult;
use common\mail\interfaces\ITemplateData;
use common\util\Constant;

class FindPasswordTemplateData implements ITemplateData
{
    public function getTemplateData(array $props): array
    {
        @[
            'user_id' => $user_id,
            'user_name' => $user_name,
            'authCode' => $authCode,
            'name_en_given' => $name_en_given,
            'name_en_family' => $name_en_family,
            'email' => $email,
        ] = $props;

        $responseResult = new ResponseResult(ResponseResult::ERROR, 'is not used');
        $responseResult->setCode(ResponseResult::SUCCESS);
        $responseResult->setMsg(Constant::SUCCESS);
        $responseResult->setData([
            'user_id' => $user_id,
            'user_name' => $user_name ?? '',
            'name_en_given' => $name_en_given ?? '',
            'name_en_family' => $name_en_family ?? '',
            'authCode' => $authCode
        ]);

        return [
            'emailAddress' => $email ?? '',
            'resultData' => $responseResult
        ];
    }
}
