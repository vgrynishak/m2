<?php

namespace App\Tests\Behat\Context\Device;

use App\Core\Model\Device\GroupId;
use App\Core\Model\Device\GroupInterface;
use App\Core\Repository\Device\GroupQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class GroupQueryRepository implements Context
{
    public const GROUP_ID = "related_to_inspected_device";
    /** @var GroupId */
    private $id;
    /** @var GroupQueryRepositoryInterface */
    private  $groupQueryRepository;
    private $group;

    public function __construct(
        GroupQueryRepositoryInterface $groupQueryRepository
    )
    {
        $this->groupQueryRepository = $groupQueryRepository;
    }

    /**
     * @Given I'm Set correct param Id
     */
    public function imSetCorrectParamId()
    {
        $this->id = new GroupId(
            self::GROUP_ID
        );
    }

    /**
     * @When I Call Method Find
     */
    public function iCallMethodFind()
    {
        $this->group = $this->groupQueryRepository->find($this->id);
    }

    /**
     * @Then I should get Group that Implement GroupInterface
     */
    public function iShouldGetGroupThatImplementGroupinterface()
    {
        Assert::assertTrue($this->group instanceof GroupInterface);
    }

}