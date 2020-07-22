<?php

namespace App\App\Doctrine\Mapper\Paragraph;

use App\App\Doctrine\Entity\HeaderType as HeaderTypeEntity;
use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Entity\StyleTemplate as StyleTemplateEntity;
use App\App\Doctrine\Factory\Paragraph\ParagraphEntityFactoryInterface;
use App\App\Doctrine\Repository\HeaderTypeRepository;
use App\App\Doctrine\Repository\StyleTemplateRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\App\Doctrine\Entity\User;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\User\UserInterface;
use App\App\Doctrine\Exception\NonExistentEntity;

class ParagraphModel implements ParagraphModelInterface
{
    /** @var ParagraphEntityFactoryInterface */
    private $paragraphEntityFactory;
    /** @var UserRepository */
    private $userRepository;
    /** @var StyleTemplateRepository */
    private $styleTemplateRepository;
    /** @var HeaderTypeRepository */
    private $headerTypeRepository;

    /**
     * ParagraphModel constructor.
     * @param ParagraphEntityFactoryInterface $paragraphEntityFactory
     * @param UserRepository $userRepository
     * @param StyleTemplateRepository $styleTemplateRepository
     * @param HeaderTypeRepository $headerTypeRepository
     */
    public function __construct(
        ParagraphEntityFactoryInterface $paragraphEntityFactory,
        UserRepository $userRepository,
        StyleTemplateRepository $styleTemplateRepository,
        HeaderTypeRepository $headerTypeRepository
    ) {
        $this->paragraphEntityFactory = $paragraphEntityFactory;
        $this->userRepository = $userRepository;
        $this->styleTemplateRepository = $styleTemplateRepository;
        $this->headerTypeRepository = $headerTypeRepository;
    }

    /**
     * @param BaseParagraphInterface $paragraphModel
     *
     * @return ParagraphEntity
     * @throws NonExistentEntity
     */
    public function mapNew(BaseParagraphInterface $paragraphModel): ParagraphEntity
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphEntityFactory->makeNewByModel($paragraphModel);

        $this->mapCommonFields($paragraphModel, $paragraphEntity);
        $paragraphEntity->setCreatedAt($paragraphModel->getCreatedAt());
        $paragraphEntity->setUpdatedAt($paragraphModel->getCreatedAt());

        /** @var User $createdBydEntity */
        $createdBydEntity = $this->userRepository->find($paragraphModel->getCreatedBy()->getId());
        if (!$createdBydEntity instanceof User) {
            throw new NonExistentEntity("User Entity not exist");
        }
        $paragraphEntity->setCreatedBy($createdBydEntity);
        $paragraphEntity->setModifiedBy($createdBydEntity);

        return $paragraphEntity;
    }

    /**
     * @param BaseParagraphInterface $paragraphModel
     *
     * @return ParagraphEntity
     * @throws NonExistentEntity
     */
    public function map(BaseParagraphInterface $paragraphModel): ParagraphEntity
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphEntityFactory->makeByModel($paragraphModel);

        $this->mapCommonFields($paragraphModel, $paragraphEntity);
        $paragraphEntity->setUpdatedAt($paragraphModel->getUpdatedAt());

        /** @var User $createdBydEntity */
        $ModifiedBydEntity = $this->userRepository->find($paragraphModel->getModifiedBy()->getId());
        if ($ModifiedBydEntity instanceof UserInterface) {
            throw new NonExistentEntity("User Entity not exist");
        }
        $paragraphEntity->setModifiedBy($ModifiedBydEntity);

        return $paragraphEntity;
    }

    /**
     * @param BaseParagraphInterface $paragraphModel
     * @param ParagraphEntity $paragraphEntity
     *
     * @throws NonExistentEntity
     */
    private function mapCommonFields(BaseParagraphInterface $paragraphModel, ParagraphEntity $paragraphEntity) : void
    {
        $paragraphEntity->setPosition($paragraphModel->getPosition());
        $paragraphEntity->setPrintable($paragraphModel->isPrintable());

        if ($paragraphModel instanceof ChildParagraphInterface) {
            $paragraphEntity->setLevel($paragraphModel->getLevel());
        }
        /** @var BaseHeaderInterface $headerType */
        $headerType = $paragraphModel->getHeader();
        /** @var HeaderTypeEntity $paragraphHeaderType */
        $paragraphHeaderType = $this->headerTypeRepository->find($headerType::ID);
        $paragraphEntity->setHeaderType($paragraphHeaderType);

        if ($headerType instanceof CustomHeaderInterface) {
            $paragraphEntity->setTitle($headerType->getValue());
        } else {
            $paragraphEntity->setTitle('');
        }

        /** @var StyleTemplateEntity $styleTemplateEntity */
        $styleTemplateEntity = $this->styleTemplateRepository->find($paragraphModel->getStyleTemplateId()->getValue());
        if (!$styleTemplateEntity instanceof StyleTemplateEntity) {
            throw new NonExistentEntity("StyleTemplate Entity not exist");
        }
        $paragraphEntity->setStyleTemplate($styleTemplateEntity);
    }
}
