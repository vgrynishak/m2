<?php

namespace App\Tests\Behat\Context\ServiceInstance\QueryRepository;

use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Repository\ServiceInstance\ServiceInstanceQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ServiceInstanceQueryRepository implements Context
{
    /** @var ServiceInstanceQueryRepositoryInterface */
    private $serviceInstanceQueryRepository;
    /** @var ServiceInstanceId */
    private $serviceInstanceId;
    /** @var ServiceInstanceInterface | null */
    private $serviceInstance;

    /**
     * ServiceInstanceQueryRepository constructor.
     * @param ServiceInstanceQueryRepositoryInterface $serviceInstanceQueryRepository
     */
    public function __construct(ServiceInstanceQueryRepositoryInterface $serviceInstanceQueryRepository)
    {
        $this->serviceInstanceQueryRepository = $serviceInstanceQueryRepository;
    }

    /**
     * @Given I'm set ServiceInstanceId
     */
    public function imSetServiceinstanceid()
    {
        $this->serviceInstanceId = new ServiceInstanceId('6c614218-3ead-11ea-b77f-2e728ce88125');
    }

    /**
     * @When I Call Method find
     */
    public function iCallMethodFind()
    {
        $this->serviceInstance = $this->serviceInstanceQueryRepository->find($this->serviceInstanceId);
    }

    /**
     * @Then I should get ServiceInstanceInterface
     */
    public function iShouldGetServiceinstanceinterface()
    {
        Assert::assertTrue($this->serviceInstance instanceof ServiceInstanceInterface);
    }

    /**
     * @Given I'm set incorrect ServiceInstanceId
     */
    public function imSetIncorrectServiceinstanceid()
    {
        $this->serviceInstanceId = new ServiceInstanceId('6c614218-3ead-11ea-b77f-2e728ce88124');
    }

    /**
     * @Then I should not get ServiceInstanceInterface
     */
    public function iShouldNotGetServiceinstanceinterface()
    {
        Assert::assertTrue(!$this->serviceInstance instanceof ServiceInstanceInterface);
    }
}
