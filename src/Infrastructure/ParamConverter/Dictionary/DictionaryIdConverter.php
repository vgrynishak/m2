<?php

namespace App\Infrastructure\ParamConverter\Dictionary;

use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class DictionaryIdConverter implements DictionaryIdConverterInterface
{
    /**
     * @inheritDoc
     * @throws InvalidDictionaryIdException
     */
    public function apply(Request $request, ParamConverter $configuration)
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
            $dictionaryId = new DictionaryId($value);
            $request->attributes->set($paramName, $dictionaryId);

            return true;
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidDictionaryIdException('Invalid DictionaryId given');
        }
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        $class = $configuration->getClass();

        return DictionaryId::class === $class;
    }
}
