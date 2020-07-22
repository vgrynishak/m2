<?php

namespace App\Tests\Behat\Context\InfoSource\Adapter;

use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\InfoSource\Full as DeviceDynamicFieldsGetByDeviceIdAdapter;
use PHPUnit\Framework\Assert;

class GetInfoSourceByDeviceIdAdapter implements Context
{
    /** @var array */
    private $predefinedData;
    /** @var InfoSourceQueryRepositoryInterface */
    private $infoSourceQueryRepository;
    /** @var CollectionInterface */
    private $deviceDynamicFields;
    /** @var array */
    private $deviceDynamicFieldsAdaptedStructure;
    /** @var bool */
    private $result;

    /**
     * GetInfoSourceByDeviceIdAdapter constructor.
     * @param InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
     */
    public function __construct(
        InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
    ) {
        $this->infoSourceQueryRepository = $infoSourceQueryRepository;
    }

    /**
     * @Given I'm set correct InfoSource data for full adapter
     */
    public function imSetCorrectDevicedynamicfieldDataForFullAdapter()
    {
        $this->deviceDynamicFields = $this->infoSourceQueryRepository->findAllByDictionaryId(
            new DictionaryId('a1bfa48f-29c8-4b7f-aa0a-f1a8ffce8015')
        );
    }

    /**
     * @Given I'm set incorrect DeviceDynamicFields data for short adapter
     */
    public function imSetIncorrectDevicedynamicfieldsDataForShortAdapter()
    {
        $this->deviceDynamicFields = $this->infoSourceQueryRepository->findAllByDictionaryId(
            new DictionaryId('0456cf66-177f-4186-8978-d332102b31ff')
        );
    }

    /**
     * @Given Create correct predefined data
     */
    public function createCorrectPredefinedData()
    {
        $this->deviceDynamicFieldsAdaptedStructure =
            DeviceDynamicFieldsGetByDeviceIdAdapter::adaptList($this->deviceDynamicFields);
        $this->deviceDynamicFieldsAdaptedStructure =
            $this->objectToArray($this->deviceDynamicFieldsAdaptedStructure["resultDeviceDynamicFields"]);

        $this->predefinedData["resultDeviceDynamicFields"] =
            [
                [
                    "id" => "fire_extinguisher_size",
                    "dictionaryId" => "a1bfa48f-29c8-4b7f-aa0a-f1a8ffce8015",
                    "name" => "Size"
                ],
                [
                    "id" => "fire_extinguisher_type",
                    "dictionaryId" => "a1bfa48f-29c8-4b7f-aa0a-f1a8ffce8015",
                    "name" => "Type"
                ]
            ];
    }

    public function objectToArray($data): array
    {
        $result = array();

        $data = (array) $data;
        foreach ($data as $key => $value) {
            $key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
            if (is_object($value)) {
                $value = (array) $value;
            }
            if (is_array($value)) {
                $result[$key] = $this->objectToArray($value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * @When I compere GetInfoSourceByDeviceIdAdapter data with predefined data
     */
    public function iCompereGetdevicedynamicfieldsbydeviceidadapterDataWithPredefinedData()
    {
        if (json_encode($this->deviceDynamicFieldsAdaptedStructure, true) ===
            json_encode($this->predefinedData["resultDeviceDynamicFields"], true)) {
            $this->result = true;
        } else {
            $this->result = false;
        }
    }

    /**
     * @Then I should get the same structure
     */
    public function iShouldGetTheSameStructure()
    {
        Assert::assertEquals($this->result, true);
    }

    /**
     * @Then I should not get the same structure
     */
    public function iShouldNotGetTheSameStructure()
    {
        Assert::assertEquals($this->result, false);
    }
}
