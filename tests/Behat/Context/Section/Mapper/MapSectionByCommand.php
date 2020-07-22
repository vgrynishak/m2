<?php

namespace App\Tests\Behat\Context\Section\Mapper;

use App\App\Command\Section\CreateSectionCommand;
use App\App\Command\Section\Mapper\SectionMapperByCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class MapSectionByCommand implements Context
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateSectionCommand */
    private $createSectionCommand;
    /** @var SectionInterface */
    private $result;
    /** @var SectionMapperByCommandInterface */
    private $mapper;

    /**
     * MapSectionByCommand constructor.
     * @param SectionMapperByCommandInterface $mapper
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        SectionMapperByCommandInterface $mapper,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->mapper = $mapper;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I’m set correct CreateSectionCommand
     */
    public function imSetCorrectCreatesectioncommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);

        $this->createSectionCommand = new CreateSectionCommand(
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba229'),
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            'title'
        );

        $this->createSectionCommand->setCreatedAt(new DateTime());
        $this->createSectionCommand->setCreatedBy($user);
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->createSectionCommand);
    }

    /**
     * @Then I should get Section that Implements SectionInterface
     */
    public function iShouldGetSectionThatImplementsSectioninterface()
    {
        Assert::assertTrue($this->result instanceof SectionInterface);
    }
}
