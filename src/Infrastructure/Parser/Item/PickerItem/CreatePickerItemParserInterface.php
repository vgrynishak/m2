<?php

namespace App\Infrastructure\Parser\Item\PickerItem;

use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreatePickerItem;
use Symfony\Component\HttpFoundation\Request;

interface CreatePickerItemParserInterface
{
    /**
     * @param Request $request
     * @return CreatePickerItemCommandInterface
     * @throws FailCreatePickerItem
     */
    public function parse(Request $request): CreatePickerItemCommandInterface;
}
