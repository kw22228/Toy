<?php

namespace common\mail\interfaces;

interface ITemplateData
{
    public function getTemplateData(array $props): array;
}
