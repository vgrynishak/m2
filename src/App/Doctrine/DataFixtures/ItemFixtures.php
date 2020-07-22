<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\Answer;
use App\App\Doctrine\Entity\Item\Item;
use App\App\Doctrine\Entity\Item\ItemType;
use App\App\Doctrine\Entity\Paragraph;
use App\App\Doctrine\Repository\AnswerRepository;
use App\App\Doctrine\Repository\Item\AnswerAssessmentRepository;
use App\App\Doctrine\Repository\Item\ItemTypeRepository;
use App\App\Doctrine\Repository\ParagraphRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use App\Core\Model\Item\ItemType\ItemType as ItemTypeModel;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var AnswerAssessmentRepository */
    private $answerAssessmentRepository;

    public function __construct(AnswerAssessmentRepository $answerAssessmentRepository)
    {
        $this->answerAssessmentRepository = $answerAssessmentRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        /** @var ParagraphRepository $paragraphRepository */
        $paragraphRepository = $manager->getRepository(Paragraph::class);
        /** @var ItemTypeRepository $itemTypeRepository */
        $itemTypeRepository = $manager->getRepository(ItemType::class);
        /** @var AnswerRepository $defaultAnswerRepository */
        $defaultAnswerRepository = $manager->getRepository(Answer::class);

        $answer = new Answer();
        $answer
            ->setId("63bea125-46f1-4d59-b6ec-65000d13ac1f")
            ->setPosition(2)
            ->setText("{type: number,value: 212}")
            ->setAssessment($this->answerAssessmentRepository->find('none'))
        ;

        $answer2 = new Answer();
        $answer2
            ->setId("6e6d116e-4735-11ea-b77f-2e728ce88125")
            ->setPosition(1)
            ->setText("{type: number,value: 212}")
            ->setAssessment($this->answerAssessmentRepository->find('none'))
        ;

        $answer3 = new Answer();
        $answer3
            ->setId("756d302a-4735-11ea-b77f-2e728ce88125")
            ->setPosition(3)
            ->setText("{type: number,value: 212}")
            ->setAssessment($this->answerAssessmentRepository->find('none'))
        ;


        $item = new Item();
        $item
            ->setId("63bea125-46f1-4d59-b6ec-65000d13ac1a")
            ->setParagraphId($paragraphRepository->find("7619baa9-6ec3-4c12-92e9-45cf6b03a11d"))
            ->setItemTypeId($itemTypeRepository->find(ItemTypeModel::SHORT_TEXT_INPUT))
            ->setPosition(2)
            ->setCreatedAt(new DateTime("@1574085977"))
            ->setUpdatedAt(new DateTime("@1574085977"))
            ->setDefaultAnswer($answer)
            ->setPlaceholder('placeholder')
            ->setLabel('label')
            ->setRemembered(true)
            ->setRequired(false)
            ;

        $answer->setItem($item);
        $answer2->setItem($item);
        $answer3->setItem($item);

        $manager->persist($answer);
        $manager->persist($answer2);
        $manager->persist($answer3);
        $manager->persist($item);

        $manager->flush();


        $pictureItem = new Item();
        $pictureItem
            ->setId("b825dbb7-c20e-44ce-b029-723338c0dbe7")
            ->setParagraphId($paragraphRepository->find("7619baa9-6ec3-4c12-92e9-45cf6b03a11d"))
            ->setItemTypeId($itemTypeRepository->find(ItemTypeModel::SIGNATURE))
            ->setPosition(3)
            ->setCreatedAt(new DateTime("@1574085977"))
            ->setUpdatedAt(new DateTime("@1574085977"))
            ->setLabel('label')
            ->setRemembered(true)
            ->setRequired(false)
        ;
        $manager->persist($pictureItem);

        $signatureItem = new Item();
        $signatureItem
            ->setId("b825dbb7-c20e-44ce-b029-723338c0dbe6")
            ->setParagraphId($paragraphRepository->find("7619baa9-6ec3-4c12-92e9-45cf6b03a11d"))
            ->setItemTypeId($itemTypeRepository->find(ItemTypeModel::PHOTO))
            ->setPosition(1)
            ->setCreatedAt(new DateTime("@1574085977"))
            ->setUpdatedAt(new DateTime("@1574085977"))
            ->setLabel('label')
            ->setRemembered(true)
            ->setRequired(false)
        ;
        $manager->persist($signatureItem);
        $manager->flush();

    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            ParagraphFixtures::class,
        );
    }
}
