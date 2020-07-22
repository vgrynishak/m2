<?php

namespace App\Tests\Behat\Context\InfoSource\Validator;

use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQuery;
use App\App\Query\InfoSource\Validator\InfoSourceListByDeviceIdValidatorInterface;
use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQueryInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;

class GetInfoSourceByDeviceIdValidator implements Context
{
    /** @var bool */
    private $result;
    /** @var InfoSourceListByDeviceIdValidatorInterface */
    private $getDeviceDynamicFieldListByDeviceIdValidator;
    /** @var InfoSourceListByDictionaryIdQueryInterface */
    private $getDeviceDynamicFieldListByDeviceIdQuery;
    /** @var ReflectionClass */
    private $reflectionClass;

    /**
     * GetInfoSourceByDeviceIdValidator constructor.
     * @param InfoSourceListByDeviceIdValidatorInterface $getDeviceDynamicFieldListByDeviceIdValidator
     */
    public function __construct(
        InfoSourceListByDeviceIdValidatorInterface $getDeviceDynamicFieldListByDeviceIdValidator
    ) {
        $this->getDeviceDynamicFieldListByDeviceIdValidator = $getDeviceDynamicFieldListByDeviceIdValidator;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidDeviceIdException
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        $this->getDeviceDynamicFieldListByDeviceIdQuery = new InfoSourceListByDictionaryIdQuery(
            new DictionaryId("081a5bbd-d5fe-4838-867e-5b7e3af7bf91")
        );
        $this->reflectionClass = new ReflectionClass($this->getDeviceDynamicFieldListByDeviceIdQuery);
    }

    /**
     * @When I call InfoSourceListByDeviceIdValidator
     */
    public function iCallGetdevicedynamicfieldlistbydeviceidvalidator()
    {
        if ($this->getDeviceDynamicFieldListByDeviceIdValidator->validate(
            $this->getDeviceDynamicFieldListByDeviceIdQuery
        )) {
            $this->result = true;
        } else {
            $this->result = $this->getDeviceDynamicFieldListByDeviceIdValidator->getFirstErrorMessage();
        }
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
     * @throws InvalidDeviceIdException
     * @throws ReflectionException
     * @Given Device with id is not exist
     */
    public function deviceWithIdIsNotExist()
    {
        $reflectionField = $this->reflectionClass->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->getDeviceDynamicFieldListByDeviceIdQuery,
            new DictionaryId('63bea125-46f1-4d59-b6ec-65000d13ac11')
        );
    }

    /**
     * @param $errorMessage
     * @Then I should get message error :errorMessage
     */
    public function iShouldGetMessageError($errorMessage)
    {
        Assert::assertEquals($this->result, $errorMessage);
    }
}
