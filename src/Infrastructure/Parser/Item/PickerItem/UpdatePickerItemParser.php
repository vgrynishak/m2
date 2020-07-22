<?php

namespace App\Infrastructure\Parser\Item\PickerItem;

use App\App\Command\Item\PickerItem\UpdatePickerItemCommand;
use App\App\Command\Item\PickerItem\UpdatePickerItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdatePickerItem;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class UpdatePickerItemParser extends BasePickerItemParser implements UpdatePickerItemParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(Request $request): UpdatePickerItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('updatePickerItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body['updatePickerItem'], new UpdatePickerItemCommand());
        } catch (\Exception $exception) {
            throw new FailUpdatePickerItem('Bad request. ' . $exception->getMessage());
        }
    }
}
