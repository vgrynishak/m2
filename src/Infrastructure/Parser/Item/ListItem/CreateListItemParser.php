<?php

namespace App\Infrastructure\Parser\Item\ListItem;

use App\App\Command\Item\ListItem\CreateListItemCommand;
use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateListItem;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreateListItemParser extends BaseListItemParser implements CreateListItemParserInterface
{

    /**
     * @param Request $request
     * @return CreateListItemCommandInterface
     * @throws FailCreateListItem
     */
    public function parse(Request $request): CreateListItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('createListItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body['createListItem'], new CreateListItemCommand());
        } catch (\Exception $exception) {
            throw new FailCreateListItem('Bad request. ' . $exception->getMessage());
        }
    }
}
