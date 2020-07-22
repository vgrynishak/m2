<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;

interface HeaderFactoryInterface
{
    /**
     * @param string $value
     * @return CustomHeaderInterface
     */
    public function makeCustom(string $value): CustomHeaderInterface;

    /**
     * @return DeviceCardHeaderInterface
     */
    public function makeDeviceCard(): DeviceCardHeaderInterface;

    /**
     * @return NoHeaderInterface
     */
    public function makeNoHeader(): NoHeaderInterface;
}
