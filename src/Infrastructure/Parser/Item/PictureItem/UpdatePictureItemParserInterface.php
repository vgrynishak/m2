<?php


namespace App\Infrastructure\Parser\Item\PictureItem;

use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdatePictureItem;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface UpdatePictureItemParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return UpdatePictureItemCommandInterface
     * @throws FailUpdatePictureItem
     */
    public function parse(Request $request): UpdatePictureItemCommandInterface;
}