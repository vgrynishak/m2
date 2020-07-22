<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\HeaderType;
use App\App\Doctrine\Entity\Paragraph;
use App\App\Doctrine\Entity\ParagraphFilter;
use App\App\Doctrine\Repository\HeaderTypeRepository;
use App\App\Doctrine\Repository\ParagraphFilterRepository;
use App\App\Doctrine\Repository\ParagraphRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ParagraphFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var ParagraphFilterRepository $paragraphFilterRepository */
        $paragraphFilterRepository = $manager->getRepository('App:ParagraphFilter');
        /** @var HeaderTypeRepository $headerTypeRepository */
        $headerTypeRepository = $manager->getRepository('App:HeaderType');
        /** @var ParagraphFilter $paragraphFilter */
        $paragraphFilter = $paragraphFilterRepository->find('on_site');
        /** @var HeaderType $paragraphHeaderCustom */
        $paragraphHeaderCustom = $headerTypeRepository->find('custom_title');
        /** @var HeaderType $paragraphHeaderDeviceCard */
        $paragraphHeaderDeviceCard = $headerTypeRepository->find('device_card');

        $rootParagraph = new Paragraph();
        $rootParagraph->setId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d');
        $rootParagraph->setSection($this->getReference(ReportTemplateFixtures::SECTION_TEST_REFERENCE));
        $rootParagraph->setTitle('Root Section Level 1');
        $rootParagraph->setPosition(1);
        $rootParagraph->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $rootParagraph->setPrintable(1);
        $rootParagraph->setCreatedAt(new DateTime("@1574085977"));
        $rootParagraph->setUpdatedAt(new DateTime("@1574085977"));
        $rootParagraph->setLevel(2);
        $rootParagraph->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $rootParagraph->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $rootParagraph->setParagraphFilter($paragraphFilter);
        $rootParagraph->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $rootParagraph->setHeaderType($paragraphHeaderCustom);

        $manager->persist($rootParagraph);

        $childParagraph = new Paragraph();
        $childParagraph->setId('d1a01008-d6e0-4b6f-9d40-f68f91a34b65');
        $childParagraph->setSection($this->getReference(ReportTemplateFixtures::SECTION_TEST_REFERENCE));
        $childParagraph->setTitle('');
        $childParagraph->setPosition(1);
        $childParagraph->setParent($rootParagraph);
        $childParagraph->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $childParagraph->setPrintable(1);
        $childParagraph->setCreatedAt(new DateTime("@1574085977"));
        $childParagraph->setUpdatedAt(new DateTime("@1574085977"));
        $childParagraph->setLevel(2);
        $childParagraph->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $childParagraph->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $childParagraph->setParagraphFilter($paragraphFilter);
        $childParagraph->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $childParagraph->setHeaderType($paragraphHeaderDeviceCard);

        $manager->persist($childParagraph);

        $nextChildParagraph = new Paragraph();
        $nextChildParagraph->setId('7182f809-4bea-4593-8402-eca220477542');
        $nextChildParagraph->setSection($this->getReference(ReportTemplateFixtures::SECTION_TEST_REFERENCE));
        $nextChildParagraph->setTitle('Child Section Level 3');
        $nextChildParagraph->setPosition(1);
        $nextChildParagraph->setParent($childParagraph);
        $nextChildParagraph->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $nextChildParagraph->setPrintable(1);
        $nextChildParagraph->setCreatedAt(new DateTime("@1574085977"));
        $nextChildParagraph->setUpdatedAt(new DateTime("@1574085977"));
        $nextChildParagraph->setLevel(3);
        $nextChildParagraph->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $nextChildParagraph->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $nextChildParagraph->setParagraphFilter($paragraphFilter);
        $nextChildParagraph->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $nextChildParagraph->setHeaderType($paragraphHeaderDeviceCard);

        $manager->persist($nextChildParagraph);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            ReportTemplateFixtures::class,
            DeviceFixtures::class,
            UserFixtures::class
        );
    }
}
