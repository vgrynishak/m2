<?php

namespace App\Infrastructure\Parser\Item\PickerItem;

use App\App\Command\Item\PickerItem\CreatePickerItemCommand;
use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreatePickerItem;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreatePickerItemParser extends BasePickerItemParser implements CreatePickerItemParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(Request $request): CreatePickerItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('createPickerItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body['createPickerItem'], new CreatePickerItemCommand());
        } catch (\Exception $exception) {
            throw new FailCreatePickerItem('Bad request. ' . $exception->getMessage());
        }
    }
}
