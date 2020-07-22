<?php

namespace App\Infrastructure\Parser\Item\InputItem;

use App\App\Command\Item\InputItem\UpdateInputItemCommand;
use App\App\Command\Item\InputItem\UpdateInputItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdateInputItem;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class UpdateInputItemParser extends BaseInputItemParser implements UpdateInputItemParserInterface
{
    /**
     * @param Request $request
     * @return UpdateInputItemCommandInterface
     * @throws FailUpdateInputItem
     */
    public function parse(Request $request): UpdateInputItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('updateInputItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body['updateInputItem'], new UpdateInputItemCommand());
        } catch (\Exception $exception) {
            throw new FailUpdateInputItem('Bad request. ' . $exception->getMessage());
        }
    }
}
