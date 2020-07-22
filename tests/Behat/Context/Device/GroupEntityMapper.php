<?php

namespace App\Tests\Behat\Context\Device;

use App\App\Doctrine\Entity\Group;
use App\App\Doctrine\Repository\GroupRepository;
use App\App\Mapper\Device\GroupEntityMapperInterface;
use App\Core\Model\Device\GroupId;
use App\Core\Model\Device\GroupInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class GroupEntityMapper implements Context
{
    public const GROUP_ID = "related_to_inspected_device";
    /** @var GroupId */
    private $id;
    /** @var GroupEntityMapperInterface */
    private  $mapper;
    /** @var GroupRepository */
    private $groupEntityRepository;
    /** @var Group */
    private $entityGroup;
    /** @var \App\Core\Model\Device\Group */
    private $modelGroup;

    public function __construct(
        GroupEntityMapperInterface $mapper,
        GroupRepository $groupEntityRepository
    )
    {
        $this->groupEntityRepository = $groupEntityRepository;
        $this->mapper = $mapper;
    }

    /**
     * @Given I'm Set correct Entity Group
     */
    public function imSetCorrectEntityGroup()
    {
        $this->entityGroup = $this->groupEntityRepository->find(self::GROUP_ID);
    }

    /**
     * @When I Call Method map
     */
    public function iCallMethodMap()
    {
        $this->modelGroup = $this->mapper->map($this->entityGroup);
    }

    /**
     * @Then I should get Group that Implement GroupInterface
     */
    public function iShouldGetGroupThatImplementGroupinterface()
    {
        Assert::assertInstanceOf(GroupInterface::class, $this->modelGroup);
    }
}