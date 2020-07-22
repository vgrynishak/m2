<?php

namespace App\Infrastructure\Parser\Item\InputItem;

use App\App\Command\Item\InputItem\CreateInputItemCommand;
use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateInputItem;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreateInputItemParser extends BaseInputItemParser implements CreateInputItemParserInterface
{
    /**
     * @param Request $request
     * @return CreateInputItemCommandInterface
     * @throws FailCreateInputItem
     */
    public function parse(Request $request): CreateInputItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('createInputItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body['createInputItem'], new CreateInputItemCommand());
        } catch (\Exception $exception) {
            throw new FailCreateInputItem('Bad request. ' . $exception->getMessage());
        }
    }
}
