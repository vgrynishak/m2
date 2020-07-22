<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Paragraph\ParagraphFilter;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;

class ParagraphFilterFactory implements ParagraphFilterFactoryInterface
{
    /**
     * @param string $alias
     * @param string $name
     * @return ParagraphFilterInterface
     * @throws InvalidParagraphFilterIdException
     */
    public function make(string $alias, string $name): ParagraphFilterInterface
    {
        $paragraphFilterId = new ParagraphFilterId($alias);

        return new ParagraphFilter($paragraphFilterId, $name);
    }
}
