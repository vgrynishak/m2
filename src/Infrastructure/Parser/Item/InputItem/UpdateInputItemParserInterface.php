<?php

namespace App\Infrastructure\Parser\Item\InputItem;

use App\App\Command\Item\InputItem\UpdateInputItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdateInputItem;
use Symfony\Component\HttpFoundation\Request;

interface UpdateInputItemParserInterface
{
    /**
     * @param Request $request
     * @return UpdateInputItemCommandInterface
     * @throws FailUpdateInputItem
     */
    public function parse(Request $request): UpdateInputItemCommandInterface;
}
