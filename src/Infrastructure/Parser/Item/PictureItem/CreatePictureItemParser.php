<?php


namespace App\Infrastructure\Parser\Item\PictureItem;


use App\App\Command\Item\PictureItem\CreatePictureItemCommand;
use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Exception\Item\FailCreatePictureItem;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class CreatePictureItemParser extends BasePictureItemParser implements CreatePictureItemParserInterface
{

    /**
     * @param Request $request
     * @return CreatePictureItemCommandInterface
     * @throws FailCreatePictureItem
     */
    public function parse(Request $request): CreatePictureItemCommandInterface
    {
        try{
            $body = $request->request->all();

            if (!array_key_exists('createPictureItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand($body["createPictureItem"], new CreatePictureItemCommand());
        } catch (InvalidArgumentException | InvalidParagraphIdException | \Exception $exception) {
            throw new FailCreatePictureItem('Bad request. ' . $exception->getMessage());
        }
    }
}