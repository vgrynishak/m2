<?php

namespace App\Infrastructure\Parser\Item\ListItem;

use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateListItem;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateListItemParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return CreateListItemCommandInterface
     * @throws FailCreateListItem
     */
    public function parse(Request $request): CreateListItemCommandInterface;
}
