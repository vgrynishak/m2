<?php

namespace App\Infrastructure\Parser\Item\PickerItem;

use App\App\Command\Item\PickerItem\UpdatePickerItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdatePickerItem;
use Symfony\Component\HttpFoundation\Request;

interface UpdatePickerItemParserInterface
{
    /**
     * @param Request $request
     * @return UpdatePickerItemCommandInterface
     * @throws FailUpdatePickerItem
     */
    public function parse(Request $request): UpdatePickerItemCommandInterface;
}
