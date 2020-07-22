<?php

namespace App\Infrastructure\Parser\Item\ListItem;

use App\App\Command\Item\ListItem\UpdateListItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdateListItem;
use Symfony\Component\HttpFoundation\Request;

interface UpdateListItemParserInterface
{
    /**
     * @param Request $request
     * @return UpdateListItemCommandInterface
     * @throws FailUpdateListItem
     */
    public function parse(Request $request): UpdateListItemCommandInterface;
}
