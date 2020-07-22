<?php


namespace App\Infrastructure\Parser\Item\PictureItem;

use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreatePickerItem;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreatePictureItemParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return CreatePictureItemCommandInterface
     * @throws FailCreatePickerItem
     */
    public function parse(Request $request): CreatePictureItemCommandInterface;
}