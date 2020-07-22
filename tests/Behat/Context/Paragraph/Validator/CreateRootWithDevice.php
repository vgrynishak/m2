<?php

namespace App\Tests\Behat\Context\Paragraph\Validator;

use App\Core\Model\Paragraph\Header\NoHeader;
use App\App\Command\Paragraph\CreateRootWithDeviceCommand;
use App\App\Command\Paragraph\Validator\CreateRootWithDeviceValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilter;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use ReflectionClass;
use ReflectionException;

class CreateRootWithDevice implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var CreateRootWithDeviceValidatorInterface */
    private $validator;
    /** @var CreateRootWithDeviceCommand */
    private $command;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var bool */
    private $result;
    /** @var array */
    private $errors;
    /** @var UserInterface */
    private $user;
    /** @var HeaderFactoryInterface */
    private $headerFactory;
    /** @var ReflectionClass */
    private $reflection;

    /**
     * CreateRootWithDevice constructor.
     * @param CreateRootWithDeviceValidatorInterface $validator
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        CreateRootWithDeviceValidatorInterface $validator,
        UserQueryRepositoryInterface $userQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->validator = $validator;
        $this->userQueryRepository = $userQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    private function rootWithDeviceDataProvider()
    {
        return [
            "id" => "cd807e10-3ca5-42b3-a523-dd4a3f7b4ab1",
            "title" => "Child paragraph with device",
            "sectionId" => "6647e03a-4f98-4a25-acc7-0ebad8fba229",
            "deviceId" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
            "filterId" => ParagraphFilter::FILTER_ON_SITE,
            "styleTemplateId" => "3a45f743-424c-4839-a395-ead0cd2e70c3"
        ];
    }

    /**
     * @param $data
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     * @throws ReflectionException
     */
    private function createCommand($data)
    {
        /** @var UserInterface $user */
        $this->user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);
        /** @var DeviceCardHeaderInterface $header */
        $header = $this->headerFactory->makeDeviceCard();

        $this->command = new CreateRootWithDeviceCommand(
            new ParagraphId($data['id']),
            new SectionId($data['sectionId']),
            new DeviceId($data['deviceId']),
            new ParagraphFilterId($data['filterId']),
            $header
        );
        $this->reflection = new ReflectionClass($this->command);
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     * @throws InvalidStyleTemplateIdException
     * @throws ReflectionException
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $data = $this->rootWithDeviceDataProvider();
        $this->createCommand($data);

        $this->command->setCreatedBy($this->user);
        $this->command->setCreatedAt(new \DateTime());
        $this->command->setPrintable(true);
        $this->command->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
    }

    /**
     * @When I call CreateRootWithDeviceValidator
     */
    public function iCallCreaterootwithdevicevalidator()
    {
        if ($this->command) {
            if ($this->validator->validate($this->command)) {
                $this->result = true;
            } else {
                $this->errors = $this->validator->getErrors();
            }
        }
    }

    /**
     * @param $param
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     * @throws InvalidStyleTemplateIdException
     * @throws ReflectionException
     * @Given param :param is empty
     */
    public function paramIsEmpty($param)
    {
        $data = $this->rootWithDeviceDataProvider();
        $this->createCommand($data);

        $this->command->setCreatedBy($this->user);
        $this->command->setCreatedAt(new \DateTime());
        $this->command->setPrintable(true);

        if ($param != 'styleTemplateId') {
            $this->command->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
        }
    }

    /**
     * @Given I'm set param :param with incorrect value
     * @param $param
     */
    public function imSetParamWithIncorrectValue($param)
    {
        try {
            $data = $this->rootWithDeviceDataProvider();

            if ($param == 'id') {
                $data['id'] = '63bea125-46f1-4d59-b6ec-13000d13ac9f';
            } else {
                $data[$param] = '0c1429ce-3cf4-4aa8-a77d-2167a3ef7399';
            }
            $this->createCommand($data);

            if ($param == 'user') {
                $this->command->setCreatedBy($this->wrongUser());
            } else {
                $this->command->setCreatedBy($this->user);
            }

            $this->command->setCreatedAt(new \DateTime());
            $this->command->setPrintable(true);
            $this->command->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
        } catch (Exception $exception) {
            $this->command = false;
        }
    }

    private function wrongUser()
    {
        /** @var UserEntity $userEntity */
        $userEntity = new UserEntity;
        $userEntity->setId(0000000000000);
        /** @var User $user */
        return new User($userEntity);
    }

    /**
     * @throws Exception
     * @Then I should get true result
     */
    public function iShouldGetTrueResult()
    {
        if (!empty($this->errors)) {
            $errorMessages = implode(PHP_EOL, $this->errors);
            throw new Exception($errorMessages);
        }
    }

    /**
     * @Then I should get message error :errorMessage
     *
     * @param $errorMessage
     * @throws Exception
     */
    public function iShouldGetMessageError($errorMessage)
    {
        if (array_search($errorMessage, $this->errors) === false) {
            throw new Exception("There is no Exception: '{$errorMessage}'");
        }
    }

    /**
     * @throws ReflectionException
     * @Given I'm set header with incorrect implementing
     */
    public function imSetHeaderWithIncorrectImplementing()
    {
        $reflectionField = $this->reflection->getProperty('header');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->command,
            new NoHeader()
        );
    }
}
