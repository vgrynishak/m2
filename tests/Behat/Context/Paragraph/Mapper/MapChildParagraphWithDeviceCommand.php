<?php

namespace App\Tests\Behat\Context\Paragraph\Mapper;

use App\App\Command\Paragraph\CreateChildWithDeviceCommand;
use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Command\Paragraph\Mapper\ParagraphMapperByCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;

class MapChildParagraphWithDeviceCommand implements Context
{
    private const USER_ID = 1;
    /** @var object */
    private $exception;
    /** @var ParagraphMapperByCommandInterface */
    private $mapper;
    /** @var ChildParagraphWithDeviceInterface */
    private $result;
    /** @var array */
    private $data;
    /** @var CreateChildWithDeviceCommandInterface */
    private $command;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * MapChildParagraphWithDeviceCommand constructor.
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
            'sectionId' => '6647e03a-4f98-4a25-acc7-0ebad8fba229',
            'deviceId' => '63bea125-46f1-4d59-b6ec-65000d13ac1f',
            'parentId' => 'd1a01008-d6e0-4b6f-9d40-f68f91a34b65',
            'paragraphFilterId' => 'inspection',
            'styleTemplateId' => '3a45f743-424c-4839-a395-ead0cd2e70c3'
        ];
    }

    /**
     * @throws Exception
     */
    private function createCommand()
    {
        try {
            /** @var DeviceCardHeaderInterface $header */
            $header = $this->headerFactory->makeCustom('Test Title');

            /** @var CreateChildWithDeviceCommandInterface $command */
            $command = new CreateChildWithDeviceCommand(
                new ParagraphId($this->data['id']),
                new ParagraphId($this->data['parentId']),
                new DeviceId($this->data['deviceId']),
                new ParagraphFilterId($this->data['paragraphFilterId']),
                new SectionId($this->data['sectionId']),
                $header
            );

            $user = $this->userQueryRepository->find(self::USER_ID);

            $command->setPrintable(true);
            $command->setCreatedAt(new \DateTime());
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
     * @throws InvalidStyleTemplateIdException
     * @Given I’m set full correct ChildParagraphWithDevice Command
     */
    public function imSetFullCorrectChildparagraphwithdeviceCommand()
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
     * @Then I should get ChildParagraphWithDevice that Implement ChildParagraphWithDeviceInterface
     */
    public function iShouldGetChildparagraphwithdeviceThatImplementChildparagraphwithdeviceinterface()
    {
        Assert::assertTrue($this->result instanceof ChildParagraphWithDeviceInterface);
    }

    /**
     * @Then Paragraph base properties are correct
     */
    public function paragraphBasePropertiesAreCorrect()
    {
        Assert::assertEquals($this->result->isPrintable(), true);
        Assert::assertTrue($this->result->getCreatedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getCreatedAt() instanceof \DateTime);
        Assert::assertTrue($this->result->getUpdatedAt() instanceof \DateTime);
    }

    /**
     * @Then property styleTemplate should be instance of StyletemplateId
     */
    public function propertyStyletemplateShouldBeInstanceOfStyletemplateid()
    {
        Assert::assertTrue($this->result->getStyleTemplateId() instanceof StyleTemplateId);
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
     * @throws InvalidStyleTemplateIdException
     * @Given param Title is empty
     */
    public function paramTitleIsEmpty()
    {
        $this->data = $this->dataProvider();
        $this->createCommand();

        $this->command->setStyleTemplateId(new StyleTemplateId($this->data['styleTemplateId']));
    }

    /**
     * @throws Exception
     * @Given param StyleTemplate is empty
     */
    public function paramStyletemplateIsEmpty()
    {
        $this->data = $this->dataProvider();
        $this->createCommand();
    }
}
