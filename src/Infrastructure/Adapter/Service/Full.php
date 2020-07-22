<?php

namespace App\Infrastructure\Adapter\Service;

use App\Core\Model\Facility\Facility;
use App\Core\Model\Facility\FacilityInterface;
use App\Infrastructure\Adapter\DTO\Service\Full as FullServiceDTO;
use App\Core\Model\Service\ServiceInterface;

class Full
{
    /**
     * @param ServiceInterface $service
     * @return FullServiceDTO
     */
    public static function adapt(ServiceInterface $service): FullServiceDTO
    {
        /** @var FullServiceDTO $fullService */
        $fullService = new FullServiceDTO(
            $service->getId()->getValue(),
            $service->getDevice()->getValue(),
            $service->getName(),
            $service->getCreatedAt()->getTimestamp(),
            $service->getUpdatedAt()->getTimestamp()
        );

        if ($service->getFacility() instanceof Facility) {
            $fullService->setFacilityId($service->getFacility()->getId()->getValue());
        }
        $fullService->setComment($service->getComment());

        return $fullService;
    }
}
