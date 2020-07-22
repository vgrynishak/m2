<?php


namespace App\App\Repository\Device\Service;

interface DeviceTreeBuilderInterface
{
    /**
     * @param $deviceORMArray
     * @return mixed
     */
    public function build($deviceORMArray);
}