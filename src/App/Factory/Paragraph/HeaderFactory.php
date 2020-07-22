<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Paragraph\Header\CustomHeader;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeader;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeader;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;

class HeaderFactory implements HeaderFactoryInterface
{
    /**
     * @param string $value
     * @return CustomHeaderInterface
     */
    public function makeCustom(string $value): CustomHeaderInterface
    {
        return new CustomHeader($value);
    }

    /**
     * @return DeviceCardHeaderInterface
     */
    public function makeDeviceCard(): DeviceCardHeaderInterface
    {
        return new DeviceCardHeader();
    }

    /**
     * @return NoHeaderInterface
     */
    public function makeNoHeader(): NoHeaderInterface
    {
        return new NoHeader();
    }
}
