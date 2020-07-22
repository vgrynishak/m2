<?php

namespace App\Tests\Behat\Context\Paragraph\Mapper;

use App\App\Doctrine\Entity\StyleTemplate;
use App\App\Doctrine\Repository\StyleTemplateRepository;
use App\App\Mapper\Paragraph\StyleTemplateEntityMapperInterface;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;

class StyleTemplateEntityMapper implements Context
{
    /** @var object */
    private $result;

    /** @var StyleTemplateEntityMapperInterface */
    private $mapper;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var StyleTemplate */
    private $styleTemplateEntity;

    /**
     * StyleTemplateEntityMapper constructor.
     * @param StyleTemplateEntityMapperInterface $mapper
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        StyleTemplateEntityMapperInterface $mapper,
        EntityManagerInterface $entityManager
    ) {
        $this->mapper = $mapper;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given I’m set correct StyleTemplate Entity
     */
    public function imSetCorrectStyletemplateEntity()
    {
        /** @var StyleTemplateRepository $styleTemplateRepository */
        $styleTemplateRepository = $this->entityManager->getRepository('App:StyleTemplate');
        /** @var StyleTemplate styleTemplateEntity */
        $this->styleTemplateEntity = $styleTemplateRepository->find('3a45f743-424c-4839-a395-ead0cd2e70c3');
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->styleTemplateEntity);
    }

    /**
     * @Then I should get StyleTemplate that Implements StyleTemplate Interface
     */
    public function iShouldGetStyletemplateThatImplementsStyletemplateInterface()
    {
        Assert::assertTrue($this->result instanceof StyleTemplateInterface);
    }
}
