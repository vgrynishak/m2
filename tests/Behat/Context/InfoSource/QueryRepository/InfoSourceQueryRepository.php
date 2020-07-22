<?php

namespace App\Tests\Behat\Context\InfoSource\QueryRepository;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface;
use App\Core\Repository\DeviceDynamicField\DeviceDynamicFieldQueryRepositoryInterface;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use PHPUnit\Framework\Assert;

class InfoSourceQueryRepository implements Context
{
    /** @var DeviceDynamicFieldQueryRepositoryInterface */
    private $infoSourceQueryRepository;
    /** @var InfoSourceId */
    private $infoSourceId;
    /** @var InfoSourceInterface | null */
    private $InfoSourceInterface;
    /** @var CollectionInterface | null */
    private $infoSources;
    /** @var DeviceId */
    private $deviceId;

    /**
     * InfoSourceQueryRepository constructor.
     * @param InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
     */
    public function __construct(InfoSourceQueryRepositoryInterface $infoSourceQueryRepository)
    {
        $this->infoSourceQueryRepository = $infoSourceQueryRepository;
    }

    /**
     * @Given I'm set InfoSourceId
     */
    public function imSetInfoSourceID()
    {
        $this->infoSourceId = new InfoSourceId('backflow_size');
    }

    /**
     * @When I Call Method find
     */
    public function iCallMethodFind()
    {
        $this->InfoSourceInterface = $this->infoSourceQueryRepository->find($this->infoSourceId);
    }

    /**
     * @Then I should get InfoSourceInterface
     */
    public function iShouldGetInfoSourceInterface()
    {
        Assert::assertTrue($this->InfoSourceInterface instanceof InfoSourceInterface);
    }

    /**
     * @Given I'm set DeviceId
     */
    public function imSetDeviceid()
    {
        $this->deviceId = new DictionaryId('081a5bbd-d5fe-4838-867e-5b7e3af7bf91');
    }

    /**
     * @When I Call Method findAllByDeviceId
     */
    public function iCallMethodFindallbydeviceid()
    {
        $this->infoSources = $this->infoSourceQueryRepository->findAllByDictionaryId($this->deviceId);
    }

    /**
     * @Then I should get InfoSourceInterface Collection
     */
    public function iShouldGetDeviceInfoSourceInterfaceCollection()
    {
        Assert::assertTrue($this->infoSources instanceof CollectionInterface);
    }

    /**
     * @Given I'm set incorrect InfoSourceId
     */
    public function imSetIncorrectInfoSourceId()
    {
        $this->infoSourceId = new InfoSourceId('backflow_size_test');
    }

    /**
     * @Then I should not get InfoSourceInterface
     */
    public function iShouldNotGetInfoSourceinterface()
    {
        Assert::assertTrue(!$this->InfoSourceInterface instanceof InfoSourceInterface);
    }

    /**
     * @Given I'm set incorrect DeviceId
     */
    public function imSetIncorrectDeviceid()
    {
        $this->deviceId = new DictionaryId('081a5bbd-d5fe-4838-867e-5b7e3af7bf92');
    }

    /**
     * @Then I should not get InfoSourceInterface Collection
     */
    public function iShouldNotGetInfoSourceinterfaceCollection()
    {
        Assert::assertTrue(!$this->infoSources instanceof CollectionInterface);
    }
}
