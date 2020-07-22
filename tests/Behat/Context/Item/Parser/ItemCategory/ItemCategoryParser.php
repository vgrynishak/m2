<?php

namespace App\Tests\Behat\Context\Item\Parser\ItemCategory;

use App\App\Component\Mock\Request\MockRequestInterface;
use App\App\Query\Item\AllListGroupedByCategoryQuery;
use App\Infrastructure\Parser\Item\ItemCategory\ItemCategoryParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class ItemCategoryParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var AllListGroupedByCategoryQuery */
    private $parsingResult;
    /** @var ItemCategoryParserInterface */
    private $parser;
    /** @var MockRequestInterface */
    private $mockRequest;

    /**
     * ItemCategoryParser constructor.
     * @param ItemCategoryParserInterface $parser
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        ItemCategoryParserInterface $parser,
        MockRequestInterface $mockRequest
    ) {
        $this->parser = $parser;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @When I call ItemCategory Parser
     */
    public function iCallItemCategoryParser()
    {
        $mockRequest = new Request();

        $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);
        $this->parsingResult = $this->parser->parse(true);
    }

    /**
     * @Then I should get AllListGroupedByCategoryQuery
     */
    public function iShouldGetAllListGroupedByCategoryQuery()
    {
        Assert::assertInstanceOf(AllListGroupedByCategoryQuery::class, $this->parsingResult);
    }
}
