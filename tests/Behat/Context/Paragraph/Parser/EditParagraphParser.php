<?php

namespace App\Tests\Behat\Context\Paragraph\Parser;

use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Infrastructure\Exception\Paragraph\FailEditAction;
use App\Infrastructure\ParamConverter\Paragraph\ParagraphIdConverterInterface;
use App\Infrastructure\Parser\Paragraph\EditParagraphParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class EditParagraphParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var EditParagraphParserInterface */
    private $parser;

    /** @var MockRequestInterface */
    private $mockRequest;

    /** @var array */
    private $data;

    /** @var EditParagraphCommandInterface */
    private $result;

    /** @var Exception */
    private $exception;

    /** @var ParagraphIdConverterInterface */
    private $paragraphIdConverter;

    /** @var Request */
    private $request;

    /**
     * EditParagraphParser constructor.
     * @param EditParagraphParserInterface $parser
     * @param MockRequestInterface $mockRequest
     * @param ParagraphIdConverterInterface $paragraphIdConverter
     */
    public function __construct(
        EditParagraphParserInterface $parser,
        MockRequestInterface $mockRequest,
        ParagraphIdConverterInterface $paragraphIdConverter
    ) {
        $this->parser = $parser;
        $this->mockRequest = $mockRequest;
        $this->paragraphIdConverter = $paragraphIdConverter;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->data['editParagraphRequest']['title'] = 'New Title';

        try {
            /** @var Request $request */
            $this->request = new Request([], $this->data);
            $this->request->attributes->set('paragraphId', '2e84d3f6-a908-408c-b1a1-c7b7aef30824');
        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @When I call method Parse
     */
    public function iCallMethodParse()
    {
        try {
            $paramConverterData = [
                'name' => 'paragraphId',
                'class' => 'App\Core\Model\Paragraph\ParagraphId',
                'isOptional' => false,
                'converter' => 'paragraph_id.param_converter'
            ];

            /** @var ParamConverter $paramConverter */
            $paramConverter = new ParamConverter($paramConverterData);
            $this->paragraphIdConverter->apply($this->request, $paramConverter);
            $this->mockRequest->pushRequestByUserEmail($this->request, self::ADMIN_USER_EMAIL);
            $this->result = $this->parser->parse($this->request);
        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Given I'm set incorrect parentKey
     */
    public function imSetIncorrectParentkey()
    {
        $this->data = ['wrongKey' => []];

        try {
            /** @var Request $request */
            $this->request = new Request([], $this->data);
        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get FailEditAction Exception
     */
    public function iShouldGetFaileditactionException()
    {
        Assert::assertTrue($this->exception instanceof FailEditAction);
    }

    /**
     * @Then error message should be :message
     * @param $message
     */
    public function errorMessageShouldBe($message)
    {
        Assert::assertEquals($this->exception->getMessage(), $message);
    }

    /**
     * @Then I should get Command that implements EditParagraphCommandInterface
     */
    public function iShouldGetCommandThatImplementsEditparagraphcommandinterface()
    {
        Assert::assertTrue($this->result instanceof EditParagraphCommandInterface);
    }

    /**
     * @Given I'm set request with incorrect Id
     */
    public function imSetRequestWithIncorrectId()
    {
        $this->data['editParagraphRequest']['title'] = 'New Title';

        try {
            /** @var Request $request */
            $this->request = new Request([], $this->data);
            $this->request->attributes->set('paragraphId', 'wrong_UUID');

        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get Exception
     */
    public function iShouldGetException()
    {
        Assert::assertTrue($this->exception instanceof Exception);
    }

    /**
     * @Then property header should be instance of CustomHeaderInterface
     */
    public function propertyHeaderShouldBeInstanceOfCustomheaderinterface()
    {
        Assert::assertTrue($this->result->getHeader() instanceof CustomHeaderInterface);
    }

    /**
     * @param $param
     * @Given param :param is empty
     */
    public function paramIsEmpty($param)
    {
        $this->data['editParagraphRequest'][$param] = '';
        /** @var Request $request */
        $this->request = new Request([], $this->data);
        $this->request->attributes->set('paragraphId', '2e84d3f6-a908-408c-b1a1-c7b7aef30824');
    }

    /**
     * @Then Style HeaderType should be instance of DeviceCardInterface
     */
    public function styleHeadertypeShouldBeInstanceOfDevicecardinterface()
    {
        Assert::assertTrue($this->result->getHeader() instanceof DeviceCardHeaderInterface);
    }

    /**
     * @Given I'm set params without title
     */
    public function imSetParamsWithoutTitle()
    {
        $this->data = [
            'editParagraphRequest' => []
        ];

        try {
            /** @var Request $request */
            $this->request = new Request([], $this->data);
            $this->request->attributes->set('paragraphId', '2e84d3f6-a908-408c-b1a1-c7b7aef30824');
        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Given I'm set params without Id
     */
    public function imSetParamsWithoutId()
    {
        $this->data['editParagraphRequest']['title'] = 'New Title';

        try {
            /** @var Request $request */
            $this->request = new Request([], $this->data);
        } catch (Exception $exception) {
            $this->exception = $exception;
        }
    }
}
