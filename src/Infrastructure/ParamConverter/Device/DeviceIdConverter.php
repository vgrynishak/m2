<?php

namespace App\Infrastructure\ParamConverter\Device;

use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Device\DeviceId;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverterConfig;
use Symfony\Component\HttpFoundation\Request;

class DeviceIdConverter implements DeviceIdConverterInterface
{
    /**
     * @param Request $request
     * @param ParamConverterConfig $configuration
     * @return bool
     * @throws InvalidDeviceIdException
     */
    public function apply(Request $request, ParamConverterConfig $configuration): bool
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
            $reportTemplateId = new DeviceId($value);
            $request->attributes->set($paramName, $reportTemplateId);

            return true;
        } catch (InvalidArgumentException $exception) {
            throw new InvalidDeviceIdException('Invalid DeviceId given');
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

        return DeviceId::class === $class;
    }
}
