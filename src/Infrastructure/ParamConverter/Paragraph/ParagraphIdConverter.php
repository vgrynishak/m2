<?php

namespace App\Infrastructure\ParamConverter\Paragraph;

use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Paragraph\ParagraphId;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverterConfig;

class ParagraphIdConverter implements ParagraphIdConverterInterface
{
    /**
     * @param Request $request
     * @param ParamConverterConfig $configuration
     * @return bool
     * @throws InvalidParagraphIdException
     */
    public function apply(Request $request, ParamConverterConfig $configuration)
    {
        $paramName = $configuration->getName();
        if (!$request->attributes->has($paramName)) {
            return false;
        }

        $value = $request->attributes->get($paramName);
        if (!$value && $configuration->isOptional()) {
            return false;
        }

        try {
            $reportTemplateId = new ParagraphId($value);
            $request->attributes->set($paramName, $reportTemplateId);

            return true;
        } catch (InvalidArgumentException $exception) {
            throw new InvalidParagraphIdException('Invalid ParagraphId given');
        }
    }

    /**
     * @param ParamConverterConfig $configuration
     *
     * @return bool
     */
    public function supports(ParamConverterConfig $configuration)
    {
        $class = $configuration->getClass();

        return ParagraphId::class === $class;
    }
}
