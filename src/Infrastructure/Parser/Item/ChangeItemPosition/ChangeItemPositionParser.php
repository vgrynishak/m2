<?php

namespace App\Infrastructure\Parser\Item\ChangeItemPosition;

use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommand;
use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommandInterface;
use App\Core\Model\Item\ItemId;
use App\Infrastructure\Exception\Item\FailChangeItemPosition;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class ChangeItemPositionParser implements ChangeItemPositionParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(Request $request): ChangeItemPositionCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('changeItemPositionRequest', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['changeItemPositionRequest'];

            if (!array_key_exists('id', $data)) {
                throw new InvalidArgumentException('Item Id is required field');
            }

            if (!array_key_exists('newPosition', $data)) {
                throw new InvalidArgumentException('newPosition is required field');
            }

            return new ChangeItemPositionCommand(new ItemId($data['id']), $data['newPosition']);

        } catch (\Exception $exception) {
            throw new FailChangeItemPosition('Bad request. ' . $exception->getMessage());
        }
    }
}
