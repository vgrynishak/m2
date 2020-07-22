<?php

namespace App\Infrastructure\ParamConverter\Section;

use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Section\SectionId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverterConfig;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class SectionIdConverter implements SectionIdConverterInterface
{
    /**
     * @param Request $request
     * @param ParamConverterConfig $configuration
     * @return bool
     * @throws InvalidSectionIdException
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
            $serviceId = new SectionId($value);
            $request->attributes->set($paramName, $serviceId);

            return true;
        } catch (InvalidArgumentException $exception) {
            throw new InvalidSectionIdException('Invalid SectionId given');
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

        return SectionId::class === $class;
    }
}
