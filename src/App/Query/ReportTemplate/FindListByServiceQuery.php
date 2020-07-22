<?php

namespace App\App\Query\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Service\ServiceId;

class FindListByServiceQuery implements MessageInterface
{
    /**
     * @var ServiceId
     */
    private $serviceId;

    /**
     * FindListByServiceQuery constructor.
     * @param ServiceId $serviceId
     */
    public function __construct(ServiceId $serviceId)
    {
        $this->serviceId = $serviceId;
    }

    /**
     * @return ServiceId
     */
    public function getServiceId() : ServiceId
    {
        return $this->serviceId;
    }
}
