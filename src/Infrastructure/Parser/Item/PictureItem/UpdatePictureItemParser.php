<?php

namespace App\Infrastructure\Parser\Item\PictureItem;

use App\App\Command\Item\PictureItem\UpdatePictureItemCommand;
use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Exception\Item\FailUpdatePictureItem;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class UpdatePictureItemParser extends BasePictureItemParser implements UpdatePictureItemParserInterface
{

    /**
     * @param Request $request
     * @return UpdatePictureItemCommandInterface
     * @throws FailUpdatePictureItem
     */
    public function parse(Request $request): UpdatePictureItemCommandInterface
    {
        try{
            $body = $request->request->all();

            if (!array_key_exists('updatePictureItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body["updatePictureItem"], new UpdatePictureItemCommand());
        } catch (InvalidArgumentException | InvalidParagraphIdException | \Exception $exception) {
            throw new FailUpdatePictureItem('Bad request. ' . $exception->getMessage());
        }
    }
}