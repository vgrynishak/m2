<?php

namespace App\Tests\Behat\Context\Item\Validator\UpdatePickerItem;

use App\App\Command\Item\PickerItem\UpdatePickerItemCommandInterface;
use App\App\Command\Item\PickerItem\Validator\UpdatePickerItemValidatorInterface;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\App\Doctrine\Repository\Item\ItemTypeRepository;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Parser\Item\PickerItem\UpdatePickerItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class UpdatePickerItemValidator implements Context
{
    /** @var UpdatePickerItemValidatorInterface */
    private $validator;

    /** @var UpdatePickerItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var \Exception */
    private $exception;

    /** @var UpdatePickerItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    /** @var ItemRepository */
    private $itemRepository;

    /** @var ItemTypeRepository */
    private $itemTypeRepository;

    /**
     * UpdatePickerItemValidator constructor.
     * @param UpdatePickerItemValidatorInterface $validator
     * @param UpdatePickerItemParserInterface $parser
     * @param ItemRepository $itemRepository
     * @param ItemTypeRepository $itemTypeRepository
     */
    public function __construct(
        UpdatePickerItemValidatorInterface $validator,
        UpdatePickerItemParserInterface $parser,
        ItemRepository $itemRepository,
        ItemTypeRepository $itemTypeRepository
    ) {
        $this->validator    = $validator;
        $this->parser       = $parser;
        $this->itemRepository = $itemRepository;
        $this->itemTypeRepository = $itemTypeRepository;
    }

    private function prepareData()
    {
        $this->requestData['updatePickerItem'] = [
            'id' => '63bea125-46f1-4d59-b6ec-65000d13ac1a',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => ItemType::TIME_INTERVAL,
            'placeholder' => 'placeholder test',
            'label' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => false
        ];
    }
    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $item = $this->itemRepository->find('63bea125-46f1-4d59-b6ec-65000d13ac1a');
        $item->setItemTypeId($this->itemTypeRepository->find(ItemType::TIME_INTERVAL));
        $this->prepareData();
    }

    /**
     * @When I call UpdatePickerItemValidator
     */
    public function iCallUpdatePickerItemValidator(): void
    {
        $request = new Request([], $this->requestData);
        $this->command = $this->parser->parse($request);

        try {
            $this->result = $this->validator->validate($this->command);
         } catch (\Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get true result
     */
    public function iShouldGetTrueResult(): void
    {
        Assert::assertTrue($this->result);
    }

    /**
     * @Given I'm set not exists param paragraphId
     */
    public function imSetNotExistsParamParagraphId(): void
    {
        $this->requestData['updatePickerItem']['paragraphId'] = '8408e9ad-cbb9-4670-9924-e93e3db562fd';
    }

    /**
     * @Then I should get message error :arg1
     * @param $errorMessage
     */
    public function iShouldGetMessageError($errorMessage): void
    {
        if (!$this->exception instanceof \Exception) {
            throw new \RuntimeException('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $errorMessage);
    }

    /**
     * @Given I'm set param :arg1 with incorrect value
     * @param $paramName
     */
    public function imSetParamWithIncorrectValue($paramName): void
    {
        $this->requestData['updatePickerItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set param :arg1 without device and param remembered true
     */
    public function imSetParamWithoutDeviceAndParamRememberedTrue(): void
    {
        $this->requestData['updatePickerItem']['remembered'] = true;
    }

    /**
     * @Given I'm set not exists param ItemId
     */
    public function imSetNotExistsParamItemId(): void
    {
        $this->requestData['updatePickerItem']['id'] = 'edc0c5c0-2a9f-4dee-984e-e9e731f1066a';
    }
}
