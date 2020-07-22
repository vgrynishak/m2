<?php

namespace App\Infrastructure\Adapter\Device;

use App\Core\Model\Device\DeviceInterface;
use App\Infrastructure\Adapter\DTO\Device\ShortForGetOneReportTemplate as ShortDeviceDTO;

class ShortForGetOneReportTemplate
{
    /**
     * @param DeviceInterface $device
     * @return ShortDeviceDTO
     */
    public static function adapt(DeviceInterface $device): ShortDeviceDTO
    {
        return new ShortDeviceDTO(
            $device->getId()->getValue(),
            $device->getName(),
            $device->getLevel()
        );
    }
}
