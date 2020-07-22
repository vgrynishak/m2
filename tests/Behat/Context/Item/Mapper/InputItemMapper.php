<?php

namespace App\Tests\Behat\Context\Item\Mapper;

use App\App\Doctrine\Entity\Item\Item;
use App\App\Doctrine\Mapper\Item\ItemMapperInterface;
use App\Core\Model\Answer\Answer;
use App\Core\Model\Answer\AnswerAssessment\AnswerAssessmentId;
use App\Core\Model\Answer\AnswerId;
use App\Core\Model\Item\InputItem\InputItemInterface;
use App\Core\Model\Item\ItemCategory\ItemCategoryId;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Item\InputItem\ShortTextInputItem;
use App\Core\Model\Paragraph\ParagraphId;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class InputItemMapper implements Context
{
    /** @var InputItemInterface | ItemInterface */
    private $inputItem;
    /** @var ItemMapperInterface */
    private $mapper;
    private $item;

    public function __construct(
        ItemMapperInterface $itemMapper
    ) {
        $this->mapper = $itemMapper;
    }

    /**
     * @Given I'm Set exists Input model
     * @throws \Exception
     */
    public function imSetExistsInputModel(): void
    {
        $inputItem = new ShortTextInputItem(
            new ItemId('63bea125-46f1-4d59-b6ec-65000d13ac1a'),
            new ParagraphId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d'),
            new ItemType(new ItemTypeId('short_text_input'), new ItemCategoryId('question'), 'Short Text Input')
        );
        $inputItem->setCreatedAt(new \DateTime());
        $inputItem->setUpdatedAt(new \DateTime());
        $inputItem->setRequire(true);
        $inputItem->setRemember(true);
        $inputItem->setLabel('label');
        $inputItem->setNFPA('nfpa');
        $inputItem->setPosition(22);
        $inputItem->setDefaultAnswer(new Answer(
            new AnswerId('63bea125-46f1-4d59-b6ec-65000d13ac1f'),
            new ItemId('63bea125-46f1-4d59-b6ec-65000d13ac1a'),
            new AnswerAssessmentId('63bea124-46f1-4d59-b6ec-65000d13ac1a')
            )
        );
        $inputItem->setPlaceholder('asdasd');

        $this->inputItem = $inputItem;
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap(): void
    {
        $this->item = $this->mapper->map($this->inputItem);
    }

    /**
     * @Then I should get same InputEntity
     */
    public function iShouldGetSameInputentity(): void
    {
        Assert::assertInstanceOf(Item::class, $this->item);
    }

    /**
     * @Given I'm Set new Input model
     * @throws \Exception
     */
    public function imSetNewInputModel(): void
    {
        $inputItem = new ShortTextInputItem(
            new ItemId('63bea125-46f1-4d59-b6ec-65000d13ad1a'),
            new ParagraphId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d'),
            new ItemType(new ItemTypeId('short_text_input'), new ItemCategoryId('question'), 'Short Text Input')
        );

        $inputItem->setCreatedAt(new \DateTime());
        $inputItem->setUpdatedAt(new \DateTime());
        $inputItem->setRequire(true);
        $inputItem->setRemember(true);
        $inputItem->setLabel('label');
        $inputItem->setNFPA('nfpa');
        $inputItem->setPosition(22);
        $inputItem->setDefaultAnswer(new Answer(
                new AnswerId('63bea125-46f1-4d59-b6ec-65000d13ac1f'),
                new ItemId('63bea125-46f1-4d59-b6ec-65000d13ac1a'),
                new AnswerAssessmentId('63bea124-46f1-4d59-b6ec-65000d13ac1a')
            )
        );
        $inputItem->setPlaceholder('asdasd');

        $this->inputItem = $inputItem;
    }

    /**
     * @When I Call Method MapNew
     */
    public function iCallMethodMapNew(): void
    {
        $this->item = $this->mapper->mapNew($this->inputItem);
    }
}