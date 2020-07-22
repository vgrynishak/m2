<?php

namespace App\Tests\Behat\Context\Paragraph\Mapper;

use App\App\Command\Paragraph\CreateRootWithoutDeviceCommand;
use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\App\Command\Paragraph\Mapper\ParagraphMapperByCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapRootParagraphWithoutDeviceCommand implements Context
{
    private const USER_ID = 1;
    /** @var object */
    private $exception;
    /** @var ParagraphMapperByCommandInterface */
    private $mapper;
    /** @var RootParagraphWithoutDeviceInterface */
    private $result;
    /** @var array */
    private $data;
    /** @var CreateRootWithoutDeviceCommandInterface */
    private $command;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * MapRootParagraphWithoutDeviceCommand constructor.
     * @param ParagraphMapperByCommandInterface $mapper
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        ParagraphMapperByCommandInterface $mapper,
        UserQueryRepositoryInterface $userQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->mapper = $mapper;
        $this->userQueryRepository = $userQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    private function dataProvider()
    {
        return [
            'id' => '6f6d8aca-5283-4317-b38f-0017355d7a94',
            'sectionId' => 'f9e00cc7-5983-4081-8838-0a54f93cab2d',
            'styleTemplateId' => '3a45f743-424c-4839-a395-ead0cd2e70c3'
        ];
    }

    private function createCommand()
    {
        try {
            /** @var CustomHeaderInterface $header */
            $header = $this->headerFactory->makeCustom('Root Paragraph Without Device\'');

            /** @var CreateRootWithoutDeviceCommandInterface $command */
            $command = new CreateRootWithoutDeviceCommand(
                new ParagraphId($this->data['id']),
                new SectionId($this->data['sectionId']),
                true,
                $header
            );

            /** @var UserInterface $user */
            $user = $this->userQueryRepository->find(self::USER_ID);

            $command->setCreatedAt(new \DateTime());
            $command->setCreatedBy($user);

            $this->command = $command;
        } catch (InvalidParagraphIdException |
        InvalidSectionIdException
        $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Given I’m set full correct RootParagraphWithoutDevice Command
     * @throws InvalidStyleTemplateIdException
     */
    public function imSetFullCorrectRootparagraphwithoutdeviceCommand()
    {
        $this->data = $this->dataProvider();
        $this->createCommand();
        $this->command->setStyleTemplateId(new StyleTemplateId($this->data['styleTemplateId']));
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->command);
    }

    /**
     * @Then I should get RootParagraphWithoutDevice that Implement RootParagraphWithoutDeviceInterface
     */
    public function iShouldGetRootparagraphwithoutdeviceThatImplementRootparagraphwithoutdeviceinterface()
    {
        Assert::assertTrue($this->result instanceof RootParagraphWithoutDeviceInterface);
    }

    /**
     * @Then Paragraph base properties of RootParagraphWithoutDevice are correct
     */
    public function paragraphBasePropertiesOfRootparagraphwithoutdeviceAreCorrect()
    {
        Assert::assertEquals($this->result->isPrintable(), true);
        Assert::assertTrue($this->result->getCreatedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getCreatedAt() instanceof \DateTime);
        Assert::assertTrue($this->result->getUpdatedAt() instanceof \DateTime);
    }
}
