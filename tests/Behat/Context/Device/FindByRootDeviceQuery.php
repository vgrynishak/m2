<?php

namespace App\Tests\Behat\Context\Device;

use App\App\Handler\Device\FindByRootDeviceHandler;
use App\Core\Model\Device\DeviceId;
use Behat\Behat\Context\Context;
use App\App\Query\Device\FindByRootDeviceQuery as RootDeviceQuery;
use App\Core\Model\Exception\InvalidDeviceIdException;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use PHPUnit\Framework\Assert;
use PHPUnit\Util\Exception;

class FindByRootDeviceQuery implements Context
{
    /** @var FindByRootDeviceHandler */
    private $findByRootDeviceHandler;

    /** @var CollectionInterface */
    private $groups;
    /** @var RootDeviceQuery */
    private $findByRootDeviceQuery;

    /**
     * FindByRootDeviceQuery constructor.
     * @param FindByRootDeviceHandler $findByRootDeviceHandler
     */
    public function __construct(
        FindByRootDeviceHandler $findByRootDeviceHandler
    ) {
        $this->findByRootDeviceHandler = $findByRootDeviceHandler;
    }

    /**
     * @Given Device param id :deviceId
     * @param string $deviceId
     * @throws InvalidDeviceIdException
     */
    public function deviceParamId(string $deviceId): void
    {
        $this->findByRootDeviceQuery = new RootDeviceQuery(
            new DeviceId($deviceId)
        );
    }

    /**
     * @When I call find by root device query handler
     */
    public function iCallFindByRootDeviceQueryHandler(): void
    {
        /** @var FindByRootDeviceHandler $parser */
        $parser = $this->findByRootDeviceHandler;
        try {
            $this->groups = $parser($this->findByRootDeviceQuery);
        } catch (FailGetListDevice $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @Then I should have CollectionInterface
     */
    public function iShouldHaveCollectionInterface(): void
    {
        Assert::assertInstanceOf(CollectionInterface::class, $this->groups);
    }
}