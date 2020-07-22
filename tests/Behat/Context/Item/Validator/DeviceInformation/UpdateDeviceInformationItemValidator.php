<?php

namespace App\Tests\Behat\Context\Item\Validator\DeviceInformation;

use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\Validator\UpdateDeviceInformationItemValidatorInterface;
use App\App\Command\Item\ListItem\UpdateListItemCommandInterface;
use App\App\Command\Item\ListItem\Validator\UpdateListItemValidatorInterface;
use App\App\Doctrine\Repository\Item\InfoSourceRepository;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\App\Doctrine\Repository\Item\ItemTypeRepository;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Parser\Item\DeviceInformationItem\UpdateDeviceInformationItemParserInterface;
use App\Infrastructure\Parser\Item\ListItem\UpdateListItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class UpdateDeviceInformationItemValidator implements Context
{
    /** @var UpdateDeviceInformationItemValidatorInterface */
    private $validator;

    /** @var UpdateDeviceInformationItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var UpdateDeviceInformationItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    /** @var \Exception */
    private $exception;

    /** @var ItemRepository */
    private $itemRepository;

    /** @var ItemTypeRepository */
    private $itemTypeRepository;

    /** @var InfoSourceRepository  */
    private $infoSourceRepository;

    /**
     * UpdateDeviceInformationItemValidator constructor.
     * @param UpdateDeviceInformationItemValidatorInterface $validator
     * @param UpdateDeviceInformationItemParserInterface $parser
     * @param ItemRepository $itemRepository
     * @param ItemTypeRepository $itemTypeRepository
     * @param InfoSourceRepository $infoSourceRepository
     */
    public function __construct(
        UpdateDeviceInformationItemValidatorInterface $validator,
        UpdateDeviceInformationItemParserInterface $parser,
        ItemRepository $itemRepository,
        ItemTypeRepository $itemTypeRepository,
        InfoSourceRepository $infoSourceRepository
    ) {
        $this->validator = $validator;
        $this->parser = $parser;
        $this->itemRepository = $itemRepository;
        $this->itemTypeRepository = $itemTypeRepository;
        $this->infoSourceRepository = $infoSourceRepository;
    }

    private function prepareData()
    {
        $this->requestData['updateDeviceInformationItem'] = [
            'id' => '63bea125-46f1-4d59-b6ec-65000d13ac1a',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => ItemType::INFORMATION_DEVICE_RELATED,
            'label' => 'test',
            'infoSource' => [
                'infoSourceId' => 'backflow_size',
            ]
        ];
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $item = $this->itemRepository->find('63bea125-46f1-4d59-b6ec-65000d13ac1a');
        $item->setItemTypeId($this->itemTypeRepository->find(ItemType::INFORMATION_DEVICE_RELATED));
        $item->setInfoSource($this->infoSourceRepository->find('backflow_size'));
        $this->prepareData();
    }

    /**
     * @When I call Update DeviceInformation Item Validator
     */
    public function iCallUpdateDeviceinformationItemValidator()
    {
        $request = new Request([], $this->requestData);
        $this->command = $this->parser->parse($request);

        try {
            $this->result = $this->validator->validate($this->command);
        } catch (\InvalidArgumentException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get true result
     */
    public function iShouldGetTrueResult()
    {
        Assert::assertTrue($this->result);
    }

    /**
     * @Given I'm set not exists param paragraphId
     */
    public function imSetNotExistsParamParagraphid()
    {
        $this->requestData['updateDeviceInformationItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Then I should get message error :arg1
     */
    public function iShouldGetMessageError($errorMessage)
    {
        if (!$this->exception instanceof \Exception) {
            throw new \RuntimeException('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $errorMessage);
    }

    /**
     * @Given I'm set not exists param ItemId
     */
    public function imSetNotExistsParamItemid()
    {
        $this->requestData['updateDeviceInformationItem']['id'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Given I'm set param :arg1 with incorrect value
     */
    public function imSetParamWithIncorrectValue($paramName)
    {
        $this->requestData['updateDeviceInformationItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set not exists param infoSource
     */
    public function imSetNotExistsParamInfosource()
    {
        $this->requestData['updateDeviceInformationItem']['infoSource']['infoSourceId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }
}
