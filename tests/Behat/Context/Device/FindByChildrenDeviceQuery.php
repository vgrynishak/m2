<?php

namespace App\Tests\Behat\Context\Device;

use App\App\Handler\Device\FindByChildrenDeviceHandler;
use App\App\Query\Device\FindByChildrenDeviceQuery as ChildrenDeviceQuery;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\Group;
use App\Core\Model\Device\GroupId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use PHPUnit\Framework\Assert;

class FindByChildrenDeviceQuery implements Context
{
    /** @var FindByChildrenDeviceHandler */
    private $findByChildrenDeviceHandler;

    /** @var CollectionInterface */
    private $groups;
    /** @var ChildrenDeviceQuery */
    private $findByChildrenDeviceQuery;

    /**
     * FindByRootDeviceQuery constructor.
     * @param FindByChildrenDeviceHandler $findByChildrenDeviceHandler
     */
    public function __construct(
        FindByChildrenDeviceHandler $findByChildrenDeviceHandler
    ) {
        $this->findByChildrenDeviceHandler = $findByChildrenDeviceHandler;
    }

    /**
     * @Given Device param id :deviceId
     * @param string $deviceId
     * @throws InvalidDeviceIdException
     * @throws \App\Core\Model\Exception\InvalidGroupIdException
     */
    public function deviceParamId(string $deviceId): void
    {
        $this->findByChildrenDeviceQuery = new ChildrenDeviceQuery(
            new DeviceId($deviceId)
        );

        $this->findByChildrenDeviceQuery->setGroupId(new GroupId(Group::GROUP_EVERY_ON_SITE_DEVICE));
    }

    /**
     * @When I call find by children device query handler
     */
    public function iCallFindByChildrenDeviceQueryHandler(): void
    {
        /** @var FindByChildrenDeviceHandler $parser */
        $parser = $this->findByChildrenDeviceHandler;
        try {
            $this->groups = $parser($this->findByChildrenDeviceQuery);
        } catch (FailGetListDevice $e) {
            throw new \Exception($e->getMessage());
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
