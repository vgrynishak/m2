<?php

namespace App\Infrastructure\ParamConverter\ReportTemplate;

use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as ParamConverterConfig;
use Symfony\Component\HttpFoundation\Request;

class ReportTemplateIdConverter implements ReportTemplateIdConverterInterface
{
    /**
     * @param Request $request
     * @param ParamConverterConfig $configuration
     * @return bool
     * @throws InvalidReportTemplateIdException
     * @throws InvalidModelIdException
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
            $reportTemplateId = new ReportTemplateId($value);
            $request->attributes->set($paramName, $reportTemplateId);

            return true;
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidReportTemplateIdException('Invalid ReportTemplateId given');
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

        return ReportTemplateId::class === $class;
    }
}
