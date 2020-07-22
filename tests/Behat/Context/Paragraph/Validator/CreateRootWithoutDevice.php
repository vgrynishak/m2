<?php

namespace App\Tests\Behat\Context\Paragraph\Validator;

use App\Core\Model\Paragraph\Header\DeviceCardHeader;
use App\App\Command\Paragraph\CreateRootWithoutDeviceCommand;
use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\User\UserInterface;
use App\App\Command\Paragraph\Validator\CreateRootWithoutDeviceValidatorInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\User;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use App\App\Doctrine\Entity\User as UserEntity;
use ReflectionClass;
use ReflectionException;

class CreateRootWithoutDevice implements Context
{
    private const USER_ID = 1;

    /** @var CreateRootWithoutDeviceValidatorInterface */
    private $createRootWithoutDeviceValidator;
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateRootWithoutDeviceCommandInterface */
    private $command;
    /** @var array */
    private $errors;
    /** @var UserInterface */
    private $user;
    /** @var HeaderFactoryInterface */
    private $headerFactory;
    /** @var ReflectionClass */
    private $reflection;

    /**
     * CreateRootWithoutDevice constructor.
     * @param CreateRootWithoutDeviceValidatorInterface $validator
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        CreateRootWithoutDeviceValidatorInterface $validator,
        UserQueryRepositoryInterface $userQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->createRootWithoutDeviceValidator = $validator;
        $this->userQueryRepository = $userQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    private function dataProvider()
    {
        return [
            "id" => "17df641a-1604-40c2-8b2d-6d2842b3ed3d",
            "styleTemplateId" => "c11bbcc0-7862-4ffa-8669-586bca31e4c6",
            "sectionId" => '6647e03a-4f98-4a25-acc7-0ebad8fba229'
        ];
    }

    /**
     * @param $data
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     * @throws ReflectionException
     */
    private function createCommand($data)
    {
        /** @var UserInterface $user */
        $this->user = $this->userQueryRepository->find(self::USER_ID);
        /** @var CustomHeaderInterface $header */
        $header = $this->headerFactory->makeCustom("Root paragraph without device");

        /** @var CreateRootWithoutDeviceCommandInterface $command */
        $command = new CreateRootWithoutDeviceCommand(
            new ParagraphId($data['id']),
            new SectionId($data['sectionId']),
            true,
            $header
        );

        $this->command = $command;
        $this->reflection = new ReflectionClass($this->command);
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
     * @Then I should get message error :message
     * @param $message
     * @throws Exception
     */
    public function iShouldGetMessageError($message)
    {
        if (array_search($message, $this->errors) === false) {
            throw new Exception("There is no Exception: '{$message}'");
        }
    }

    /**
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     * @throws InvalidStyleTemplateIdException
     * @throws ReflectionException
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $data = $this->dataProvider();

        $this->createCommand($data);
        $this->command->setCreatedBy($this->user);
        $this->command->setCreatedAt(new \DateTime());
        $this->command->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
    }

    /**
     * @When I call Method Validate
     */
    public function iCallMethodValidate()
    {
        if ($this->command) {
            if ($this->createRootWithoutDeviceValidator->validate($this->command)) {
                $this->result = true;
            } else {
                $this->errors = $this->createRootWithoutDeviceValidator->getErrors();
            }
        }
    }

    /**
     * @Then I should get true result
     * @throws Exception
     */
    public function iShouldGetTrueResult()
    {
        if (!empty($this->errors)) {
            $errorMessages = implode(PHP_EOL, $this->errors);
            throw new Exception($errorMessages);
        }
    }

    /**
     * @Given I'm set param :param with incorrect value
     */
    public function imSetParamWithIncorrectValue($param)
    {
        try {
            $data = $this->dataProvider();

            if ($param == 'id') {
                $data['id'] = '63bea125-46f1-4d59-b6ec-13000d13ac9f';
            } else {
                $data[$param] = '8b110931-fece-42d4-8db0-d30dd85616ee';
            }
            $this->createCommand($data);

            if ($param == 'user') {
                $this->command->setCreatedBy($this->wrongUser());
            } else {
                $this->command->setCreatedBy($this->user);
            }

            $this->command->setCreatedAt(new \DateTime());
            $this->command->setPrintable(true);

            if ($param == 'styleTemplateId') {
                $this->command->setStyleTemplateId(new StyleTemplateId('683e155a-93b9-423c-a1e6-bbf7814cc4e1'));
            } else {
                $this->command->setStyleTemplateId(new StyleTemplateId($data['styleTemplateId']));
            }
        } catch (Exception $exception) {
            $this->command = false;
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
            new DeviceCardHeader()
        );
    }
}
