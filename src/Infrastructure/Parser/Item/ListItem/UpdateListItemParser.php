<?php

namespace App\Infrastructure\Parser\Item\ListItem;

use App\App\Command\Item\ListItem\UpdateListItemCommand;
use App\App\Command\Item\ListItem\UpdateListItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdateListItem;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class UpdateListItemParser extends BaseListItemParser implements UpdateListItemParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(Request $request): UpdateListItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('updateListItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body['updateListItem'], new UpdateListItemCommand());
        } catch (\Exception $exception) {
            throw new FailUpdateListItem('Bad request. ' . $exception->getMessage());
        }
    }
}
