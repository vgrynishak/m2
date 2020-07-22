<?php

namespace App\Tests\Behat\Context\Device\Service;

use App\App\Repository\Device\Service\DeviceTreeBuilderInterface;
use App\App\Repository\Exception\NonDevices;
use App\Core\Model\Device\Device;
use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\Core\Model\Exception\InvalidDivisionIdException;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use PHPUnit\Framework\Assert;

class BuildTree implements Context
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var DeviceTreeBuilderInterface */
    private $deviceTreeBuilder;
    /** @var array  */
    private $deviceORMArray = [];
    /** @var CollectionInterface  */
    private $deviceTree = [];
    /** @var Exception */
    private $exception;
    /** @var string  */
    private $previousName ='';

    public function __construct(
        EntityManagerInterface $entityManager, DeviceTreeBuilderInterface $deviceTreeBuilder)
    {
        $this->entityManager = $entityManager;
        $this->deviceTreeBuilder = $deviceTreeBuilder;
        $this->deviceTree = [];
        $this->deviceORMArray = [];
    }

    /**
     * @Given I should have array of Devices
     */
    public function iShouldHaveArrayOfDevices()
    {
        $this->deviceORMArray = $this->entityManager->getRepository("App:Device")
            ->getAllDevicesOrderedByNameAsc();
    }

    /**
     * @When I call build method
     */
    public function iCallBuildMethod()
    {
        try {
            $this->deviceTree = $this->deviceTreeBuilder->build($this->deviceORMArray);
        } catch (Exception | NonDevices | InvalidDivisionIdException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should have tree array of devices
     * @throws Exception
     */
    public function iShouldHaveTreeArrayOfDevices()
    {
        if (!is_object($this->deviceTree)) {
            throw new Exception("Wrong type of Device List");
        }

        foreach ($this->deviceTree->getIterator() as $deviceTreeItem) {
            if (!$deviceTreeItem instanceof Device) {
                throw new Exception("Wrong type of root array element");
            }
            if (!empty($deviceTreeItem->getChildren()) and !$deviceTreeItem->getChildren() instanceof Set){
                throw new Exception("Wrong type of children collection");
            }
            if (!empty($this->previousName) and !$this->isNamesSortByAlphabet($this->previousName, $deviceTreeItem->getName())) {
                throw new Exception("Wrong sorting for devices list");
            }
            $this->previousName = $deviceTreeItem->getName();
        }
    }

    /**
     * @Given I should have empty array of Devices
     */
    public function iShouldHaveEmptyArrayOfDevices()
    {
        $this->deviceORMArray = [];
    }

    /**
     * @param $exceptionMessage
     * @throws Exception
     *
     * @Then I should have Exception :exceptionMessage
     */
    public function iShouldHaveException($exceptionMessage)
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception("There is no Exception");
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);
    }

    /**
     * @Given I should have array of Devices with device with level more then two
     */
    public function iShouldHaveArrayOfDevicesWithDeviceWithLevelMoreThenTwo()
    {
        $this->deviceORMArray = $this->entityManager->getRepository("App:Device")
            ->getAllDevicesOrderedByNameAsc();

        if (gettype($this->deviceORMArray) == "array" and !empty($this->deviceORMArray))
        {
            /** @var DeviceEntity $deviceORMItem */
            $deviceORMItem = $this->deviceORMArray[0];
            $deviceORMItem->setLevel(5);
            $this->deviceORMArray[0] = $deviceORMItem;
        }
    }
    /**
     * @param $previousName
     * @param $currentName
     * @return bool
     */
    private function isNamesSortByAlphabet($previousName, $currentName)
    {
        $previousNameFirsCharCode = ord(strtolower($previousName[0]));
        $currentNameFirsCharCode = ord(strtolower($currentName[0]));

        if ($previousNameFirsCharCode == $currentNameFirsCharCode) {
            $previousNameSecondCharCode = ord(strtolower($previousName[1]));
            $currentNameSecondCharCode = ord(strtolower($currentName[1]));
            if ($previousNameSecondCharCode == $currentNameSecondCharCode) {
                $previousNameThirdCharCode = ord(strtolower($previousName[2]));
                $currentNameThirdCharCode = ord(strtolower($currentName[2]));
                if ($previousNameThirdCharCode > $currentNameThirdCharCode) {
                    return false;
                }
            }
            if ($previousNameSecondCharCode > $currentNameSecondCharCode) {
                return false;
            }
        }

        if ($previousNameFirsCharCode > $currentNameFirsCharCode) {
            return false;
        }

        return true;
    }
}
