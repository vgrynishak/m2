<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\StyleTemplate as StyleTemplateEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class StyleTemplateFixtures
 * @package App\App\Doctrine\DataFixtures
 */
class StyleTemplateFixtures extends Fixture
{
    public const STYLE_TEMPLATE_TEST_REFERENCE = 'style-template-test';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var StyleTemplateEntity $styleTemplateEntity */
        $styleTemplateEntity = new StyleTemplateEntity();
        $styleTemplateEntity->setId("3a45f743-424c-4839-a395-ead0cd2e70c3");
        $styleTemplateEntity->setName("Test ST");
        $styleTemplateEntity->setBody('body');
        $manager->persist($styleTemplateEntity);
        $manager->flush();
        $this->addReference(self::STYLE_TEMPLATE_TEST_REFERENCE, $styleTemplateEntity);
    }
}
