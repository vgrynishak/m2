<?php

namespace App\Tests\Behat\Context\Section\CommandRepository;

use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class SectionCommandRepository implements Context
{
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var SectionInterface */
    private $section;
    /** @var SectionInterface | null */
    private $result;
    /** @var SectionCommandRepositoryInterface */
    private $sectionCommandRepository;
    /** @var Connection */
    private $doctrineConnection;

    /**
     * SectionCommandRepository constructor.
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param SectionCommandRepositoryInterface $sectionCommandRepository
     * @param Connection $connection
     */
    public function __construct(
        SectionQueryRepositoryInterface $sectionQueryRepository,
        SectionCommandRepositoryInterface $sectionCommandRepository,
        Connection $connection
    ) {
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->sectionCommandRepository = $sectionCommandRepository;
        $this->doctrineConnection = $connection;
    }

    /**
     * @Given I'm find SectionInterface which I want to delete
     */
    public function imFindSectioninterfaceWhichIWantToDelete()
    {
        $this->section = $this->sectionQueryRepository->find(new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba223'));
    }

    /**
     * @throws InvalidSectionIdException
     * @throws ConnectionException
     *
     * @When I Call Method Delete
     */
    public function iCallMethodDelete()
    {
        $this->doctrineConnection->beginTransaction();

        $this->sectionCommandRepository->delete($this->section);
        $this->result = $this->sectionQueryRepository->find(new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba223'));
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should not get this Section
     */
    public function iShouldNotGetThisSection()
    {
        Assert::assertEquals($this->result instanceof SectionInterface, false);
    }
}
