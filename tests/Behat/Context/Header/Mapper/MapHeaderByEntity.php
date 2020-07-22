<?php

namespace App\Tests\Behat\Context\Header\Mapper;

use App\App\Doctrine\Entity\HeaderType as HeaderTypeEntity;
use App\App\Doctrine\Repository\HeaderTypeRepository;
use App\App\Mapper\Paragraph\DoctrineEntityHeaderMapperInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapHeaderByEntity implements Context
{
    /** @var HeaderTypeRepository */
    private $headerTypeRepository;
    /** @var HeaderTypeEntity */
    private $headerTypeEntity;
    /** @var BaseHeaderInterface */
    private $result;
    /** @var DoctrineEntityHeaderMapperInterface */
    private $doctrineEntityHeaderMapper;

    /**
     * MapHeaderByEntity constructor.
     * @param HeaderTypeRepository $headerTypeRepository
     * @param DoctrineEntityHeaderMapperInterface $doctrineEntityHeaderMapper
     */
    public function __construct(
        HeaderTypeRepository $headerTypeRepository,
        DoctrineEntityHeaderMapperInterface $doctrineEntityHeaderMapper
    ) {
        $this->headerTypeRepository = $headerTypeRepository;
        $this->doctrineEntityHeaderMapper = $doctrineEntityHeaderMapper;
    }

    /**
     * @param $type
     * @Given I’m find HeaderTypeEntity with :type HeaderType
     */
    public function imFindHeadertypeentityWithHeadertype($type)
    {
        $this->headerTypeEntity = $this->headerTypeRepository->find($type);
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->doctrineEntityHeaderMapper->map($this->headerTypeEntity, 'test');
    }

    /**
     * @Then I should get Header that Implements NoHeaderInterface
     */
    public function iShouldGetHeaderThatImplementsNoheaderinterface()
    {
        Assert::assertTrue($this->result instanceof NoHeaderInterface);
    }

    /**
     * @Then I should get Header that Implements DeviceCardHeaderInterface
     */
    public function iShouldGetHeaderThatImplementsDevicecardheaderinterface()
    {
        Assert::assertTrue($this->result instanceof DeviceCardHeaderInterface);
    }

    /**
     * @Then I should get Header that Implements CustomHeaderInterface
     */
    public function iShouldGetHeaderThatImplementsCustomheaderinterface()
    {
        Assert::assertTrue($this->result instanceof CustomHeaderInterface);
    }
}
