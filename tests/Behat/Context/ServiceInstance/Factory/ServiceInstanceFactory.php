<?php

namespace App\Tests\Behat\Context\ServiceInstance\Factory;

use App\App\Component\UUID\UUID;
use App\App\Factory\ServiceInstance\ServiceInstanceFactoryInterface;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Exception\InvalidServiceInstanceIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\Service;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use Exception;

class ServiceInstanceFactory implements Context
{
    /** @var array */
    private $correctParams = [];
    /** @var ServiceInstanceFactoryInterface */
    private $serviceInstanceFactory;
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var ServiceInstanceInterface */
    private $result;

    /**
     * ServiceInstanceFactory constructor.
     * @param ServiceInstanceFactoryInterface $serviceInstanceFactory
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     */
    public function __construct(
        ServiceInstanceFactoryInterface $serviceInstanceFactory,
        ServiceQueryRepositoryInterface $serviceQueryRepository
    ) {
        $this->serviceInstanceFactory = $serviceInstanceFactory;
        $this->serviceQueryRepository = $serviceQueryRepository;
    }

    /**
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     * @throws InvalidServiceInstanceIdException
     * @Given I'm Set Correct Params For ServiceInstance
     */
    public function imSetCorrectParamsForServiceinstance()
    {
        /** @var Service $service */
        $service = $this->serviceQueryRepository->find(new ServiceId('63bea125-46f1-4d59-b6ec-65000d13acc1'));
        /** @var UUID $newUUID */
        $newUUID = new UUID();

        $this->correctParams['id'] = new ServiceInstanceId($newUUID->getValue());
        $this->correctParams['service'] = $service;
        $this->correctParams['facilityId'] = new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9');
    }

    /**
     * @When I Call Method make
     */
    public function iCallMethodMake()
    {
        $this->result = $this->serviceInstanceFactory->make(
            $this->correctParams['id'],
            $this->correctParams['service'],
            $this->correctParams['facilityId']
        );
    }

    /**
     * @throws Exception
     * @Then I Should Get Correct ServiceInstance
     */
    public function iShouldGetCorrectServiceinstance()
    {
        if (!$this->result instanceof ServiceInstanceInterface) {
            throw new Exception("Result is not implemented ServiceInstanceInterface");
        }

        $this->checkBaseField();
    }

    /**
     * @throws Exception
     */
    private function checkBaseField()
    {
        if (!$this->result->getCreatedAt() instanceof DateTime) {
            throw new Exception("ServiceInstance does`t has createdAt field");
        }

        if (!$this->result->getModifiedAt() instanceof DateTime) {
            throw new Exception("ServiceInstance does`t has modifiedAt field");
        }
    }
}
