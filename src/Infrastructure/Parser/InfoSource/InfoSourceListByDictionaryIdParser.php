<?php

namespace App\Infrastructure\Parser\InfoSource;

use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQuery;
use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQueryInterface;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Infrastructure\Exception\InfoSource\FailGetInfoSourceListByDictionaryId;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Exception;

class InfoSourceListByDictionaryIdParser implements InfoSourceListByDictionaryIdParserInterface
{
    /**
     * @param Request $request
     * @return InfoSourceListByDictionaryIdQueryInterface
     * @throws FailGetInfoSourceListByDictionaryId
     */
    public function parse(Request $request): InfoSourceListByDictionaryIdQueryInterface
    {
        try {
            /** @var DictionaryId $dictionaryId */
            $dictionaryId = $request->get('dictionaryId');
            if (!$dictionaryId instanceof DictionaryId) {
                throw new InvalidArgumentException('Dictionary Id is required field');
            }

            return new InfoSourceListByDictionaryIdQuery($dictionaryId);
        } catch (InvalidArgumentException | Exception $exception) {
            throw new FailGetInfoSourceListByDictionaryId('Bad request. ' . $exception->getMessage());
        }
    }
}
