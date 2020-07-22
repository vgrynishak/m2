<?php

namespace App\App\Component\UUID;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UuidParamConverter implements ParamConverterInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws NotFoundHttpException When invalid uuid given
     * @throws \Exception
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = $configuration->getName();
        if (!$request->attributes->has($param)) {
            return false;
        }
        $value = $request->attributes->get($param);
        if (!$value && $configuration->isOptional()) {
            return false;
        }
        try {
            $uuid = new UUID($value);
            $request->attributes->set($param, $uuid);

            return true;
        } catch (\InvalidArgumentException $e) {
            throw new NotFoundHttpException('Invalid UUID given');
        }
    }

    public function supports(ParamConverter $configuration)
    {
        $class = $configuration->getClass();

        return UUID::class === $class;
    }
}
