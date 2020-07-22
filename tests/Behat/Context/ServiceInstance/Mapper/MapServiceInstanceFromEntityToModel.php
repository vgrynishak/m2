<?php

namespace App\Tests\Behat\Context\ServiceInstance\Mapper;

use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\App\Doctrine\Repository\ServiceInstanceRepository;
use App\App\Mapper\ServiceInstance\DoctrineEntityServiceInstanceMapperInterface;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Model\User\UserInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class MapServiceInstanceFromEntityToModel implements Context
{
    /** @var ServiceInstanceRepository */
    private $serviceInstanceRepository;
    /** @var DoctrineEntityServiceInstanceMapperInterface */
    private $doctrineEntityServiceInstanceMapper;
    /** @var ServiceInstanceEntity */
    private $serviceInstanceEntity;
    /** @var ServiceInstanceInterface */
    private $serviceInstance;

    /**
     * MapServiceInstanceFromEntityToModel constructor.
     * @param ServiceInstanceRepository $serviceInstanceRepository
     * @param DoctrineEntityServiceInstanceMapperInterface $doctrineEntityServiceInstanceMapper
     */
    public function __construct(
        ServiceInstanceRepository $serviceInstanceRepository,
        DoctrineEntityServiceInstanceMapperInterface $doctrineEntityServiceInstanceMapper
    ) {
        $this->serviceInstanceRepository = $serviceInstanceRepository;
        $this->doctrineEntityServiceInstanceMapper = $doctrineEntityServiceInstanceMapper;
    }

    /**
     * @Given I’m find and set correct ServiceInstanceEntity
     */
    public function imFindAndSetCorrectServiceinstanceentity()
    {
        $this->serviceInstanceEntity = $this->serviceInstanceRepository->find('6c614218-3ead-11ea-b77f-2e728ce88125');
    }

    /**
     * @When I call Method map
     */
    public function iCallMethodMap()
    {
        $this->serviceInstance = $this->doctrineEntityServiceInstanceMapper->map($this->serviceInstanceEntity);
    }

    /**
     * @Then I should get ServiceInstance that Implements ServiceInstanceInterface
     */
    public function iShouldGetServiceinstanceThatImplementsServiceinstanceinterface()
    {
        Assert::assertTrue($this->serviceInstance instanceof ServiceInstanceInterface);
        Assert::assertTrue($this->serviceInstance->getService() instanceof ServiceInterface);
        Assert::assertTrue($this->serviceInstance->getFacilityId() instanceof FacilityId);
        Assert::assertTrue($this->serviceInstance->getId() instanceof ServiceInstanceId);
        Assert::assertTrue($this->serviceInstance->getCreatedBy() instanceof UserInterface);
        Assert::assertTrue($this->serviceInstance->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->serviceInstance->getCreatedAt() instanceof DateTime);
        Assert::assertTrue($this->serviceInstance->getModifiedAt() instanceof DateTime);
    }
}
