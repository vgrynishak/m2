<?php

namespace App\Tests\Behat\Context\Paragraph\Mapper;

use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\User\UserInterface;
use App\App\Command\Paragraph\CreateRootWithDeviceCommand;
use App\App\Command\Paragraph\CreateRootWithDeviceCommandInterface;
use App\App\Command\Paragraph\Mapper\ParagraphMapperByCommandInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class MapRootParagraphWithDeviceCommand implements Context
{
    private const USER_ID = 1;

    /** @var object */
    private $exception;
    /** @var ParagraphMapperByCommandInterface */
    private $mapper;
    /** @var RootParagraphWithDeviceInterface */
    private $result;
    /** @var array */
    private $data;
    /** @var CreateRootWithDeviceCommandInterface */
    private $command;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * MapRootParagraphWithDeviceCommand constructor.
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
            'deviceId' => '63bea125-46f1-4d59-b6ec-65000d13ac1f',
            'paragraphFilterId' => 'inspection',
            'title' => 'Test Title',
            'styleTemplateId' => '3a45f743-424c-4839-a395-ead0cd2e70c3'
        ];
    }

    private function createCommand()
    {
        try {
            /** @var CustomHeaderInterface $header */
            $header = $this->headerFactory->makeCustom('Test Title');

            $command = new CreateRootWithDeviceCommand(
                new ParagraphId($this->data['id']),
                new SectionId($this->data['sectionId']),
                new DeviceId($this->data['deviceId']),
                new ParagraphFilterId($this->data['paragraphFilterId']),
                $header
            );

            $user = $this->userQueryRepository->find(self::USER_ID);

            $command->setPrintable(true);
            $command->setCreatedAt(new DateTime());
            $command->setCreatedBy($user);

            $this->command = $command;
        } catch (InvalidParagraphIdException |
            InvalidSectionIdException |
            InvalidDeviceIdException |
            InvalidParagraphFilterIdException
            $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->command);
    }

    /**
     * @Then I should get RootParagraphWithDevice that Implement RootParagraphWithDeviceInterface
     */
    public function iShouldGetRootparagraphwithdeviceThatImplementRootparagraphwithdeviceinterface()
    {
        Assert::assertTrue($this->result instanceof RootParagraphWithDeviceInterface);
    }

    /**
     * @Given I’m set full correct RootParagraphWithDevice Command
     * @throws InvalidStyleTemplateIdException
     */
    public function imSetFullCorrectRootparagraphwithdeviceCommand()
    {
        $this->data = $this->dataProvider();
        $this->createCommand();

        $this->command->setStyleTemplateId(new StyleTemplateId($this->data['styleTemplateId']));
    }

    /**
     * @Then property Title should be :title
     * @param $title
     */
    public function propertyTitleShouldBe($title)
    {
        Assert::assertEquals($this->result->getHeader()->getValue(), $title);
    }

    /**
     * @Then property styleTemplate should be instance of StyletemplateId
     */
    public function propertyStyletemplateShouldBeInstanceOfStyletemplateid()
    {
        Assert::assertTrue($this->result->getStyleTemplateId() instanceof StyleTemplateId);
    }

    /**
     * @Given param Title is empty
     * @throws InvalidStyleTemplateIdException
     */
    public function paramTitleIsEmpty()
    {
        $this->data = $this->dataProvider();
        $this->createCommand();

        $this->command->setStyleTemplateId(new StyleTemplateId($this->data['styleTemplateId']));
    }

    /**
     * @Given param StyleTemplate is empty
     */
    public function paramStyletemplateIsEmpty()
    {
        $this->data = $this->dataProvider();
        $this->createCommand();
    }

    /**
     * @Then Paragraph base properties are correct
     */
    public function paragraphBasePropertiesAreCorrect()
    {
        Assert::assertEquals($this->result->isPrintable(), true);
        Assert::assertTrue($this->result->getCreatedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getCreatedAt() instanceof DateTime);
        Assert::assertTrue($this->result->getUpdatedAt() instanceof DateTime);
    }
}
