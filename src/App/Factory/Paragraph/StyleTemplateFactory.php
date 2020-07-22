<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\StyleTemplate;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Paragraph\StyleTemplateInterface;

class StyleTemplateFactory implements StyleTemplateFactoryInterface
{
    /**
     * @param string $id
     * @param string $name
     * @return StyleTemplateInterface
     * @throws InvalidStyleTemplateIdException
     */
    public function make(string $id, string $name): StyleTemplateInterface
    {
        /** @var StyleTemplateId $styleTemplateId */
        $styleTemplateId = new StyleTemplateId($id);

        return new StyleTemplate($styleTemplateId, $name);
    }
}
