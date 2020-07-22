<?php
namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\HeaderType;
use App\App\Doctrine\Entity\Paragraph;
use App\App\Doctrine\Entity\ParagraphFilter;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplate;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersionStatus;
use App\App\Doctrine\Entity\Section;
use App\App\Doctrine\Repository\HeaderTypeRepository;
use App\App\Doctrine\Repository\ParagraphFilterRepository;
use App\App\Doctrine\Repository\ReportTemplate\ReportTemplateVersionStatusRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DateTime;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;

/**
 * Class ServiceFixtures
 * @package App\App\Doctrine\DataFixtures
 */
class ReportTemplateFixtures extends Fixture implements DependentFixtureInterface
{
    public const PARAGRAPH_TEST_REFERENCE = 'paragraph-test';
    public const PARAGRAPH_SECOND_TEST_REFERENCE = 'paragraph-second-test';
    public const PARAGRAPH_THIRD_TEST_REFERENCE = 'paragraph-third-test';
    public const PARAGRAPH_FOURTH_TEST_REFERENCE = 'paragraph-fourth-test';
    public const PARAGRAPH_ROOT_2_REFERENCE = 'paragraph-root-2';
    public const PARAGRAPH_ROOT_3_REFERENCE = 'paragraph-root-3';
    public const PARAGRAPH_ROOT_4_REFERENCE = 'paragraph-root-4';
    public const PARAGRAPH_CHILD_1_REFERENCE = 'paragraph-child-1';
    public const PARAGRAPH_CHILD_2_REFERENCE = 'paragraph-child-2';
    public const PARAGRAPH_CHILD_3_REFERENCE = 'paragraph-child-3';
    public const PARAGRAPH_CHILD_4_REFERENCE = 'paragraph-child-4';
    public const PARAGRAPH_CHILD_5_REFERENCE = 'paragraph-child-5';
    public const PARAGRAPH_CHILD_6_REFERENCE = 'paragraph-child-6';
    public const PARAGRAPH_CHILD_7_REFERENCE = 'paragraph-child-7';
    public const REPORT_TEMPLATE_DELETED_REFERENCE = 'report-template-deleted';
    public const REPORT_TEMPLATE_VERSION_DELETED_REFERENCE = 'report-template-version-deleted';
    public const REPORT_TEMPLATE_TEST_REFERENCE = 'report-template-test';
    public const REPORT_TEMPLATE_TEST_SECOND_REFERENCE = 'report-template-test-second';
    public const REPORT_TEMPLATE_VERSION_TEST_REFERENCE = 'report-template-version-test';
    public const REPORT_TEMPLATE_VERSION_TEST_SECOND_REFERENCE = 'report-template-version-test-second';
    public const SECTION_TEST_REFERENCE = 'section-test';
    public const SECTION_ONE_TEST_REFERENCE = 'section-one-test';
    public const SECTION_TWO_TEST_REFERENCE = 'section-two-test';
    public const SECTION_THREE_TEST_REFERENCE = 'section-three-test';
    public const SECTION_FOUR_TEST_REFERENCE = 'section-four-test';
    public const SECTION_FIVE_TEST_REFERENCE = 'section-five-test';
    public const SECTION_SIX_TEST_REFERENCE = 'section-six-test';
    public const SECTION_SEVEN_TEST_REFERENCE = 'section-seven-test';

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        /** @var ReportTemplateVersionStatusRepository $reportTemplateVersionStatusRepository */
        $reportTemplateVersionStatusRepository = $manager
            ->getRepository("App:ReportTemplate\ReportTemplateVersionStatus");

        /** @var ParagraphFilterRepository $paragraphFilterRepository */
        $paragraphFilterRepository = $manager->getRepository('App:ParagraphFilter');
        /** @var ParagraphFilter $paragraphFilterByInspection */
        $paragraphFilterByInspection = $paragraphFilterRepository->find('inspection');
        /** @var HeaderTypeRepository $headerTypeRepository */
        $headerTypeRepository = $manager->getRepository('App:HeaderType');
        /** @var HeaderType $paragraphHeaderDeviceCard */
        $paragraphHeaderNoHeader = $headerTypeRepository->find('no_header');
        /** @var HeaderType $paragraphHeaderCustom */
        $paragraphHeaderCustom = $headerTypeRepository->find('custom_title');
        /** @var HeaderType $paragraphHeaderDeviceCard */
        $paragraphHeaderDeviceCard = $headerTypeRepository->find('device_card');

        /** @var ReportTemplate $reportTemplateDeleted */
        $reportTemplateDeleted = new ReportTemplate();
        $reportTemplateDeleted->setId("63bea125-46f1-4d59-b6ec-65000d13ac44");
        $reportTemplateDeleted->setName("Test_With_Deleted_Status");
        $reportTemplateDeleted->setDescription("Fire Alarm System desciption");
        $reportTemplateDeleted->setCreatedAt(new DateTime("@1573837077"));
        $reportTemplateDeleted->setService($this->getReference(ServiceFixtures::SERVICE_TEST_REFERENCE));
        $reportTemplateDeleted->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $manager->persist($reportTemplateDeleted);
        $this->addReference(self::REPORT_TEMPLATE_DELETED_REFERENCE, $reportTemplateDeleted);


        /** @var ReportTemplateVersion $reportTemplateVersionDeleted */
        $reportTemplateVersionDeleted = new ReportTemplateVersion();
        $reportTemplateVersionDeleted->setId("6647e03a-4f98-4a25-acc7-0ebad8fba240");
        $reportTemplateVersionDeleted->setVersionNumber(1);
        $reportTemplateVersionDeleted->setCreatedAt(new DateTime("@1573837077"));
        $reportTemplateVersionDeleted->setUpdatedAt(new DateTime("@1573837077"));
        $reportTemplateVersionDeleted->setReportTemplate($reportTemplateDeleted);
        $reportTemplateVersionDeleted->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $reportTemplateVersionDeleted->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        /** @var ReportTemplateVersionStatus $deletedStatus */
        $deletedStatus = $reportTemplateVersionStatusRepository->find(ReportTemplateStatus::DELETED);
        $reportTemplateVersionDeleted->setReportTemplateVersionStatus($deletedStatus);
        $manager->persist($reportTemplateVersionDeleted);
        $this->addReference(self::REPORT_TEMPLATE_VERSION_DELETED_REFERENCE, $reportTemplateVersionDeleted);

        /** @var ReportTemplate $reportTemplate */
        $reportTemplate = new ReportTemplate();
        $reportTemplate->setId("63bea125-46f1-4d59-b6ec-65000d13ac34");
        $reportTemplate->setName("Test");
        $reportTemplate->setDescription("Fire Alarm System desciption");
        $reportTemplate->setCreatedAt(new DateTime("@1573837077"));
        $reportTemplate->setService($this->getReference(ServiceFixtures::SERVICE_TEST_REFERENCE));
        $reportTemplate->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $manager->persist($reportTemplate);
        $this->addReference(self::REPORT_TEMPLATE_TEST_REFERENCE, $reportTemplate);


        /** @var ReportTemplateVersion $reportTemplateVersion */
        $reportTemplateVersion = new ReportTemplateVersion();
        $reportTemplateVersion->setId("6647e03a-4f98-4a25-acc7-0ebad8fba230");
        $reportTemplateVersion->setVersionNumber(1);
        $reportTemplateVersion->setCreatedAt(new DateTime("@1573837077"));
        $reportTemplateVersion->setUpdatedAt(new DateTime("@1573837077"));
        $reportTemplateVersion->setReportTemplate($reportTemplate);
        $reportTemplateVersion->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $reportTemplateVersion->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        /** @var ReportTemplateVersionStatus $draftStatus */
        $draftStatus = $reportTemplateVersionStatusRepository->find(ReportTemplateStatus::DRAFT);
        $reportTemplateVersion->setReportTemplateVersionStatus($draftStatus);
        $manager->persist($reportTemplateVersion);
        $this->addReference(self::REPORT_TEMPLATE_VERSION_TEST_REFERENCE, $reportTemplateVersion);


        /** @var Section $section */
        $section = new Section();
        $section->setId("6647e03a-4f98-4a25-acc7-0ebad8fba229");
        $section->setReportTemplateVersion($reportTemplateVersion);
        $section->setCreatedAt(new DateTime("@1573837077"));
        $section->setUpdatedAt(new DateTime("@1573837077"));
        $section->setPrintable(1);
        $manager->persist($section);
        $this->addReference(self::SECTION_TEST_REFERENCE, $section);

        /** @var Section $sectionOne */
        $sectionOne = new Section();
        $sectionOne->setId("6647e03a-4f98-4a25-acc7-0ebad8fba228");
        $sectionOne->setReportTemplateVersion($reportTemplateVersion);
        $sectionOne->setCreatedAt(new DateTime("@1573837077"));
        $sectionOne->setUpdatedAt(new DateTime("@1573837077"));
        $sectionOne->setPrintable(1);
        $sectionOne->setPosition(1);
        $sectionOne->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $sectionOne->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($sectionOne);
        $this->addReference(self::SECTION_ONE_TEST_REFERENCE, $sectionOne);

        /** @var Section $sectionTwo */
        $sectionTwo = new Section();
        $sectionTwo->setId("6647e03a-4f98-4a25-acc7-0ebad8fba227");
        $sectionTwo->setReportTemplateVersion($reportTemplateVersion);
        $sectionTwo->setCreatedAt(new DateTime("@1573837077"));
        $sectionTwo->setUpdatedAt(new DateTime("@1573837077"));
        $sectionTwo->setPrintable(1);
        $sectionTwo->setPosition(2);
        $sectionTwo->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $sectionTwo->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($sectionTwo);
        $this->addReference(self::SECTION_TWO_TEST_REFERENCE, $sectionTwo);

        /** @var Section $sectionThree */
        $sectionThree = new Section();
        $sectionThree->setId("6647e03a-4f98-4a25-acc7-0ebad8fba226");
        $sectionThree->setReportTemplateVersion($reportTemplateVersion);
        $sectionThree->setCreatedAt(new DateTime("@1573837077"));
        $sectionThree->setUpdatedAt(new DateTime("@1573837077"));
        $sectionThree->setPrintable(1);
        $sectionThree->setPosition(3);
        $sectionThree->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $sectionThree->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($sectionThree);
        $this->addReference(self::SECTION_THREE_TEST_REFERENCE, $sectionThree);

        /** @var Section $sectionFour */
        $sectionFour = new Section();
        $sectionFour->setId("6647e03a-4f98-4a25-acc7-0ebad8fba225");
        $sectionFour->setReportTemplateVersion($reportTemplateVersion);
        $sectionFour->setCreatedAt(new DateTime("@1573837077"));
        $sectionFour->setUpdatedAt(new DateTime("@1573837077"));
        $sectionFour->setPrintable(1);
        $sectionFour->setPosition(4);
        $sectionFour->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $sectionFour->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($sectionFour);
        $this->addReference(self::SECTION_FOUR_TEST_REFERENCE, $sectionFour);

        /** @var Section $sectionFive */
        $sectionFive = new Section();
        $sectionFive->setId("6647e03a-4f98-4a25-acc7-0ebad8fba224");
        $sectionFive->setReportTemplateVersion($reportTemplateVersion);
        $sectionFive->setCreatedAt(new DateTime("@1573837077"));
        $sectionFive->setUpdatedAt(new DateTime("@1573837077"));
        $sectionFive->setPrintable(1);
        $sectionFive->setPosition(5);
        $sectionFive->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $sectionFive->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($sectionFive);
        $this->addReference(self::SECTION_FIVE_TEST_REFERENCE, $sectionFive);

        /** @var Section $sectionSix */
        $sectionSix = new Section();
        $sectionSix->setId("6647e03a-4f98-4a25-acc7-0ebad8fba223");
        $sectionSix->setReportTemplateVersion($reportTemplateVersion);
        $sectionSix->setCreatedAt(new DateTime("@1573837077"));
        $sectionSix->setUpdatedAt(new DateTime("@1573837077"));
        $sectionSix->setPrintable(1);
        $sectionSix->setPosition(6);
        $sectionSix->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $sectionSix->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($sectionSix);
        $this->addReference(self::SECTION_SIX_TEST_REFERENCE, $sectionSix);


        $paragraph = new Paragraph();
        $paragraph->setId("63bea125-46f1-4d59-b6ec-13000d13ac9f");
        $paragraph->setSection($section);
        $paragraph->setTitle("Paragraph Title");
        $paragraph->setPosition(1);
        $paragraph->setPrintable(1);
        $paragraph->setCreatedAt(new DateTime("@1574085977"));
        $paragraph->setUpdatedAt(new DateTime("@1574085977"));
        $paragraph->setLevel(1);
        $paragraph->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraph->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraph->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraph->setHeaderType($paragraphHeaderCustom);
        $manager->persist($paragraph);
        $this->addReference(self::PARAGRAPH_TEST_REFERENCE, $paragraph);

        /** @var Paragraph $paragraphRoot2 */
        $paragraphRoot2 = new Paragraph();
        $paragraphRoot2->setId("63bea125-46f1-4d59-b6ec-13001d13ac9f");
        $paragraphRoot2->setSection($section);
        $paragraphRoot2->setTitle("Paragraph Title");
        $paragraphRoot2->setPosition(2);
        $paragraphRoot2->setPrintable(1);
        $paragraphRoot2->setCreatedAt(new DateTime("@1574085977"));
        $paragraphRoot2->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphRoot2->setLevel(1);
        $paragraphRoot2->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphRoot2->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphRoot2->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphRoot2->setHeaderType($paragraphHeaderNoHeader);
        $manager->persist($paragraphRoot2);
        $this->addReference(self::PARAGRAPH_ROOT_2_REFERENCE, $paragraphRoot2);

        /** @var Paragraph $paragraphRoot3 */
        $paragraphRoot3 = new Paragraph();
        $paragraphRoot3->setId("63bea125-46f1-4d59-b6ec-13002d13ac9f");
        $paragraphRoot3->setSection($section);
        $paragraphRoot3->setTitle("Paragraph Title");
        $paragraphRoot3->setPosition(3);
        $paragraphRoot3->setPrintable(1);
        $paragraphRoot3->setCreatedAt(new DateTime("@1574085977"));
        $paragraphRoot3->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphRoot3->setLevel(1);
        $paragraphRoot3->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphRoot3->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphRoot3->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphRoot3->setHeaderType($paragraphHeaderNoHeader);
        $manager->persist($paragraphRoot3);
        $this->addReference(self::PARAGRAPH_ROOT_3_REFERENCE, $paragraphRoot3);

        /** @var Paragraph $paragraphRoot4 */
        $paragraphRoot4 = new Paragraph();
        $paragraphRoot4->setId("63bea125-46f1-4d59-b6ec-13003d13ac9f");
        $paragraphRoot4->setSection($section);
        $paragraphRoot4->setTitle("Paragraph Title");
        $paragraphRoot4->setPosition(4);
        $paragraphRoot4->setPrintable(1);
        $paragraphRoot4->setCreatedAt(new DateTime("@1574085977"));
        $paragraphRoot4->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphRoot4->setLevel(1);
        $paragraphRoot4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphRoot4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphRoot4->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphRoot4->setHeaderType($paragraphHeaderNoHeader);
        $manager->persist($paragraphRoot4);
        $this->addReference(self::PARAGRAPH_ROOT_4_REFERENCE, $paragraphRoot4);

        /** @var Paragraph $paragraphChild1ForRoot3 */
        $paragraphChild1ForRoot3 = new Paragraph();
        $paragraphChild1ForRoot3->setId("63bea125-46f1-4d59-b6ec-13004d13ac9f");
        $paragraphChild1ForRoot3->setSection($section);
        $paragraphChild1ForRoot3->setTitle("Paragraph Title");
        $paragraphChild1ForRoot3->setPosition(1);
        $paragraphChild1ForRoot3->setPrintable(1);
        $paragraphChild1ForRoot3->setCreatedAt(new DateTime("@1574085977"));
        $paragraphChild1ForRoot3->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphChild1ForRoot3->setLevel(2);
        $paragraphChild1ForRoot3->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild1ForRoot3->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild1ForRoot3->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphChild1ForRoot3->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphChild1ForRoot3->setParagraphFilter($paragraphFilterByInspection);
        $paragraphChild1ForRoot3->setParent($paragraphRoot3);
        $paragraphChild1ForRoot3->setHeaderType($paragraphHeaderDeviceCard);
        $manager->persist($paragraphChild1ForRoot3);
        $this->addReference(self::PARAGRAPH_CHILD_1_REFERENCE, $paragraphChild1ForRoot3);

        /** @var Paragraph $paragraphChild2ForRoot4 */
        $paragraphChild2ForRoot4 = new Paragraph();
        $paragraphChild2ForRoot4->setId("63bea125-46f1-4d59-b6ec-13005d13ac9f");
        $paragraphChild2ForRoot4->setSection($section);
        $paragraphChild2ForRoot4->setTitle("Paragraph Title");
        $paragraphChild2ForRoot4->setPosition(1);
        $paragraphChild2ForRoot4->setPrintable(1);
        $paragraphChild2ForRoot4->setCreatedAt(new DateTime("@1574085977"));
        $paragraphChild2ForRoot4->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphChild2ForRoot4->setLevel(2);
        $paragraphChild2ForRoot4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild2ForRoot4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild2ForRoot4->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphChild2ForRoot4->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphChild2ForRoot4->setParent($paragraphRoot4);
        $paragraphChild2ForRoot4->setParagraphFilter($paragraphFilterByInspection);
        $paragraphChild2ForRoot4->setHeaderType($paragraphHeaderDeviceCard);
        $manager->persist($paragraphChild2ForRoot4);
        $this->addReference(self::PARAGRAPH_CHILD_2_REFERENCE, $paragraphChild2ForRoot4);

        /** @var Paragraph $paragraphChild3ForRoot4 */
        $paragraphChild3ForRoot4 = new Paragraph();
        $paragraphChild3ForRoot4->setId("63bea125-46f1-4d59-b6ec-13006d13ac9f");
        $paragraphChild3ForRoot4->setSection($section);
        $paragraphChild3ForRoot4->setTitle("Paragraph Title");
        $paragraphChild3ForRoot4->setPosition(2);
        $paragraphChild3ForRoot4->setPrintable(1);
        $paragraphChild3ForRoot4->setCreatedAt(new DateTime("@1574085977"));
        $paragraphChild3ForRoot4->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphChild3ForRoot4->setLevel(2);
        $paragraphChild3ForRoot4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild3ForRoot4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild3ForRoot4->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphChild3ForRoot4->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphChild3ForRoot4->setParent($paragraphRoot4);
        $paragraphChild3ForRoot4->setParagraphFilter($paragraphFilterByInspection);
        $paragraphChild3ForRoot4->setHeaderType($paragraphHeaderDeviceCard);
        $manager->persist($paragraphChild3ForRoot4);
        $this->addReference(self::PARAGRAPH_CHILD_3_REFERENCE, $paragraphChild3ForRoot4);

        /** @var Paragraph $paragraphChild4ForRoot4 */
        $paragraphChild4ForRoot4 = new Paragraph();
        $paragraphChild4ForRoot4->setId("63bea125-46f1-4d59-b6ec-13007d13ac9f");
        $paragraphChild4ForRoot4->setSection($section);
        $paragraphChild4ForRoot4->setTitle("Paragraph Title");
        $paragraphChild4ForRoot4->setPosition(3);
        $paragraphChild4ForRoot4->setPrintable(1);
        $paragraphChild4ForRoot4->setCreatedAt(new DateTime("@1574085977"));
        $paragraphChild4ForRoot4->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphChild4ForRoot4->setLevel(2);
        $paragraphChild4ForRoot4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild4ForRoot4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild4ForRoot4->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphChild4ForRoot4->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphChild4ForRoot4->setParent($paragraphRoot4);
        $paragraphChild4ForRoot4->setParagraphFilter($paragraphFilterByInspection);
        $paragraphChild4ForRoot4->setHeaderType($paragraphHeaderDeviceCard);
        $manager->persist($paragraphChild4ForRoot4);
        $this->addReference(self::PARAGRAPH_CHILD_4_REFERENCE, $paragraphChild4ForRoot4);

        /** @var Paragraph $paragraphChild5ForChild4 */
        $paragraphChild5ForChild4 = new Paragraph();
        $paragraphChild5ForChild4->setId("63bea125-46f1-4d59-b6ec-13008d13ac9f");
        $paragraphChild5ForChild4->setSection($section);
        $paragraphChild5ForChild4->setTitle("Paragraph Title");
        $paragraphChild5ForChild4->setPosition(1);
        $paragraphChild5ForChild4->setPrintable(1);
        $paragraphChild5ForChild4->setCreatedAt(new DateTime("@1574085977"));
        $paragraphChild5ForChild4->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphChild5ForChild4->setLevel(3);
        $paragraphChild5ForChild4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild5ForChild4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild5ForChild4->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphChild5ForChild4->setParent($paragraphChild4ForRoot4);
        $paragraphChild5ForChild4->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphChild5ForChild4->setParagraphFilter($paragraphFilterByInspection);
        $paragraphChild5ForChild4->setHeaderType($paragraphHeaderDeviceCard);
        $manager->persist($paragraphChild5ForChild4);
        $this->addReference(self::PARAGRAPH_CHILD_5_REFERENCE, $paragraphChild5ForChild4);

        /** @var Paragraph $paragraphChild6ForChild4 */
        $paragraphChild6ForChild4 = new Paragraph();
        $paragraphChild6ForChild4->setId("63bea125-46f1-4d59-b6ec-13009d13ac9f");
        $paragraphChild6ForChild4->setSection($section);
        $paragraphChild6ForChild4->setTitle("Paragraph Title");
        $paragraphChild6ForChild4->setPosition(2);
        $paragraphChild6ForChild4->setPrintable(1);
        $paragraphChild6ForChild4->setCreatedAt(new DateTime("@1574085977"));
        $paragraphChild6ForChild4->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphChild6ForChild4->setLevel(3);
        $paragraphChild6ForChild4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild6ForChild4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild6ForChild4->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphChild6ForChild4->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphChild6ForChild4->setParagraphFilter($paragraphFilterByInspection);
        $paragraphChild6ForChild4->setParent($paragraphChild4ForRoot4);
        $paragraphChild6ForChild4->setHeaderType($paragraphHeaderDeviceCard);
        $manager->persist($paragraphChild6ForChild4);
        $this->addReference(self::PARAGRAPH_CHILD_6_REFERENCE, $paragraphChild6ForChild4);

        /** @var Paragraph $paragraphChild7ForChild4 */
        $paragraphChild7ForChild4 = new Paragraph();
        $paragraphChild7ForChild4->setId("63bea125-46f1-4d59-b6ec-13010d13ac9f");
        $paragraphChild7ForChild4->setSection($section);
        $paragraphChild7ForChild4->setTitle("Paragraph Title");
        $paragraphChild7ForChild4->setPosition(3);
        $paragraphChild7ForChild4->setPrintable(1);
        $paragraphChild7ForChild4->setCreatedAt(new DateTime("@1574085977"));
        $paragraphChild7ForChild4->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphChild7ForChild4->setLevel(3);
        $paragraphChild7ForChild4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild7ForChild4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphChild7ForChild4->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphChild7ForChild4->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphChild7ForChild4->setParagraphFilter($paragraphFilterByInspection);
        $paragraphChild7ForChild4->setParent($paragraphChild4ForRoot4);
        $paragraphChild7ForChild4->setHeaderType($paragraphHeaderCustom);
        $manager->persist($paragraphChild7ForChild4);
        $this->addReference(self::PARAGRAPH_CHILD_7_REFERENCE, $paragraphChild7ForChild4);


        /** @var ReportTemplate $reportTemplateSecond */
        $reportTemplateSecond = new ReportTemplate();
        $reportTemplateSecond->setId("63bea125-46f1-4d59-b6ec-65000d13ac35");
        $reportTemplateSecond->setName("Test");
        $reportTemplateSecond->setDescription("Fire Alarm System desciption");
        $reportTemplateSecond->setCreatedAt(new DateTime("@1573837077"));
        $reportTemplateSecond->setService($this->getReference(ServiceFixtures::SERVICE_TEST_REFERENCE));
        $reportTemplateSecond->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $manager->persist($reportTemplateSecond);
        $this->addReference(self::REPORT_TEMPLATE_TEST_SECOND_REFERENCE, $reportTemplateSecond);


        /** @var ReportTemplateVersion $reportTemplateVersionSecond */
        $reportTemplateVersionSecond = new ReportTemplateVersion();
        $reportTemplateVersionSecond->setId("6647e03a-4f98-4a25-acc7-0ebad8fba231");
        $reportTemplateVersionSecond->setVersionNumber(1);
        $reportTemplateVersionSecond->setCreatedAt(new DateTime("@1573837077"));
        $reportTemplateVersionSecond->setUpdatedAt(new DateTime("@1573837077"));
        $reportTemplateVersionSecond->setReportTemplate($reportTemplateSecond);
        $reportTemplateVersionSecond->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $reportTemplateVersionSecond->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $reportTemplateVersionSecond->setReportTemplateVersionStatus($draftStatus);
        $manager->persist($reportTemplateVersionSecond);
        $this->addReference(self::REPORT_TEMPLATE_VERSION_TEST_SECOND_REFERENCE, $reportTemplateVersionSecond);

        /** @var Section $sectionSeven */
        $sectionSeven = new Section();
        $sectionSeven->setId("6647e03a-4f98-4a25-acc7-0ebad8fba222");
        $sectionSeven->setReportTemplateVersion($reportTemplateVersionSecond);
        $sectionSeven->setCreatedAt(new DateTime("@1573837077"));
        $sectionSeven->setUpdatedAt(new DateTime("@1573837077"));
        $sectionSeven->setPrintable(1);
        $sectionSeven->setPosition(2);
        $sectionSeven->setTitle('test');
        $manager->persist($sectionSeven);
        $this->addReference(self::SECTION_SEVEN_TEST_REFERENCE, $sectionSeven);

        /** @var Paragraph $paragraphSecond */
        $paragraphSecond = new Paragraph();
        $paragraphSecond->setId("ac0cec75-b17d-4509-b15a-29621c41b17d");
        $paragraphSecond->setSection($sectionSeven);
        $paragraphSecond->setTitle("Paragraph Title");
        $paragraphSecond->setPosition(1);
        $paragraphSecond->setPrintable(1);
        $paragraphSecond->setCreatedAt(new DateTime("@1574085977"));
        $paragraphSecond->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphSecond->setLevel(1);
        $paragraphSecond->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphSecond->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphSecond->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphSecond->setParagraphFilter($paragraphFilterByInspection);
        $paragraphSecond->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphSecond->setHeaderType($paragraphHeaderCustom);
        $manager->persist($paragraphSecond);
        $this->addReference(self::PARAGRAPH_SECOND_TEST_REFERENCE, $paragraphSecond);

        /** @var Paragraph $paragraphThird */
        $paragraphThird = new Paragraph();
        $paragraphThird->setId("ac0cec75-b17d-4509-b15a-29621c41b16d");
        $paragraphThird->setSection($sectionSeven);
        $paragraphThird->setTitle("Paragraph Title");
        $paragraphThird->setPosition(2);
        $paragraphThird->setPrintable(1);
        $paragraphThird->setCreatedAt(new DateTime("@1574085977"));
        $paragraphThird->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphThird->setLevel(2);
        $paragraphThird->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphThird->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphThird->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphThird->setParent($paragraphSecond);
        $paragraphThird->setParagraphFilter($paragraphFilterByInspection);
        $paragraphThird->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphThird->setHeaderType($paragraphHeaderCustom);
        $manager->persist($paragraphThird);
        $this->addReference(self::PARAGRAPH_THIRD_TEST_REFERENCE, $paragraphThird);

        /** @var Paragraph $paragraphFourth */
        $paragraphFourth = new Paragraph();
        $paragraphFourth->setId("ac0cec75-b17d-4509-b15a-29621c41b15d");
        $paragraphFourth->setSection($sectionSeven);
        $paragraphFourth->setTitle("Paragraph Title");
        $paragraphFourth->setPosition(3);
        $paragraphFourth->setPrintable(1);
        $paragraphFourth->setCreatedAt(new DateTime("@1574085977"));
        $paragraphFourth->setUpdatedAt(new DateTime("@1574085977"));
        $paragraphFourth->setLevel(3);
        $paragraphFourth->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphFourth->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $paragraphFourth->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $paragraphFourth->setParent($paragraphThird);
        $paragraphFourth->setParagraphFilter($paragraphFilterByInspection);
        $paragraphFourth->setStyleTemplate($this->getReference(StyleTemplateFixtures::STYLE_TEMPLATE_TEST_REFERENCE));
        $paragraphFourth->setHeaderType($paragraphHeaderCustom);
        $manager->persist($paragraphFourth);
        $this->addReference(self::PARAGRAPH_FOURTH_TEST_REFERENCE, $paragraphFourth);


        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            DeviceFixtures::class,
            ServiceFixtures::class,
            UserFixtures::class
        );
    }
}
