<?php

namespace App\Infrastructure\ParamConverter\Service;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverterConfig;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Service\ServiceId;

class ServiceIdConverter implements ServiceIdConverterInterface
{
    /**
     * @param Request $request
     * @param ParamConverterConfig $configuration
     *
     * @return bool
     * @throws InvalidServiceIdException
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
            $serviceId = new ServiceId($value);
            $request->attributes->set($paramName, $serviceId);

            return true;
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidServiceIdException('Invalid ServiceId given');
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

        return ServiceId::class === $class;
    }
}
