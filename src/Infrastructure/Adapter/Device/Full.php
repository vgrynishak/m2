<?php

namespace App\Infrastructure\Adapter\Device;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Infrastructure\Adapter\DTO\Device\Full as FullDeviceDTO;

class Full
{
    /**
     * @param DeviceInterface $device
     * @return FullDeviceDTO
     */
    public static function adapt(DeviceInterface $device): FullDeviceDTO
    {
        /** @var FullDeviceDTO $fullDevice */
        $fullDevice = new FullDeviceDTO(
            $device->getId()->getValue(),
            $device->getName(),
            $device->getLevel(),
            $device->getDivisionId()->getValue(),
            $device->getUpdatedAt()->getTimestamp(),
            $device->getCreatedAt()->getTimestamp()
        );

        if ($device->getParentId() instanceof DeviceId) {
            $fullDevice->setParentId($device->getParentId()->getValue());
        }
        $fullDevice->setDescription($device->getDescription());

        return $fullDevice;
    }
}
