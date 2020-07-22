<?php

namespace App\Infrastructure\Parser\Item\InputItem;

use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateInputItem;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateInputItemParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return CreateInputItemCommandInterface
     * @throws FailCreateInputItem
     */
    public function parse(Request $request): CreateInputItemCommandInterface;
}
