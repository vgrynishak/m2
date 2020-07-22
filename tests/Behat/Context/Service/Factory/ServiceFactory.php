<?php

namespace App\Tests\Behat\Context\Service\Factory;

use App\App\Factory\Service\ServiceFactoryInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ServiceFactory implements Context
{
    /** @var array */
    private $params;

    /** @var ServiceInterface */
    private $result;

    /** @var ServiceFactoryInterface */
    private $factory;

    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;

    /**
     * ServiceFactory constructor.
     * @param ServiceFactoryInterface $serviceFactory
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     */
    public function __construct(
        ServiceFactoryInterface $serviceFactory,
        FacilityQueryRepositoryInterface $facilityQueryRepository
    ) {
        $this->factory = $serviceFactory;
        $this->facilityQueryRepository = $facilityQueryRepository;
    }

    /**
     * @Given I'm Set Correct Params For Service
     */
    public function imSetCorrectParamsForService()
    {
        /** @var FacilityInterface $facility */
        $facility = $this->facilityQueryRepository->find(new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'));

        $this->params = [
            new ServiceId('dbbfd29e-cded-4dbf-9cce-ddc79df78082'),
            new DeviceId('182e62ef-f7ac-4854-b575-0023a8732cff'),
            $facility,
            'New Factory Test Service'
        ];
    }

    /**
     * @When I Call Method make
     */
    public function iCallMethodMake()
    {
        $this->result = $this->factory->make(...$this->params);
    }

    /**
     * @Then I Should Get Service implements ServiceInterface
     */
    public function iShouldGetServiceImplementsServiceinterface()
    {
        Assert::assertTrue($this->result instanceof ServiceInterface);
    }
}
