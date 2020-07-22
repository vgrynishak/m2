<?php

namespace App\App\Doctrine\Factory\Paragraph;

use App\App\Doctrine\Entity\Device;
use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Entity\ParagraphFilter as ParagraphFilterEntity;
use App\App\Doctrine\Entity\Section;
use App\App\Doctrine\Entity\Section as SectionEntity;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\App\Doctrine\Repository\SectionRepository;
use App\App\Doctrine\Repository\ParagraphRepository;
use App\App\Doctrine\Repository\DeviceRepository;
use App\App\Doctrine\Repository\ParagraphFilterRepository;
use App\App\Doctrine\Repository\StyleTemplateRepository;
use App\Core\Model\Paragraph\ChildParagraphInterface;
use App\App\Doctrine\Exception\NonExistentEntity;
use App\Core\Model\Paragraph\WithDeviceParagraphInterface;

class ParagraphEntityFactory implements ParagraphEntityFactoryInterface
{
    /** @var SectionRepository */
    private $sectionRepository;
    /** @var StyleTemplateRepository */
    private $styleTemplateRepository;
    /** @var ParagraphRepository */
    private $paragraphRepository;
    /** @var DeviceRepository */
    private $deviceRepository;
    /** @var ParagraphFilterRepository */
    private $paragraphFilterRepository;

    /**
     * ParagraphByModelFactory constructor.
     * @param SectionRepository $sectionRepository
     * @param StyleTemplateRepository $styleTemplateRepository
     * @param ParagraphRepository $paragraphRepository
     * @param DeviceRepository $deviceRepository
     * @param ParagraphFilterRepository $paragraphFilterRepository
     */
    public function __construct(
        SectionRepository $sectionRepository,
        StyleTemplateRepository $styleTemplateRepository,
        ParagraphRepository $paragraphRepository,
        DeviceRepository $deviceRepository,
        ParagraphFilterRepository $paragraphFilterRepository
    ) {
        $this->sectionRepository = $sectionRepository;
        $this->styleTemplateRepository = $styleTemplateRepository;
        $this->paragraphRepository = $paragraphRepository;
        $this->deviceRepository = $deviceRepository;
        $this->paragraphFilterRepository = $paragraphFilterRepository;
    }

    /**
     * @param BaseParagraphInterface $paragraphModel
     * @return ParagraphEntity
     * @throws NonExistentEntity
     */
    public function makeByModel(BaseParagraphInterface $paragraphModel): ParagraphEntity
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = $this->paragraphRepository->find($paragraphModel->getId()->getValue());
        if (!$paragraphEntity instanceof ParagraphEntity) {
            throw new NonExistentEntity("Paragraph Entity not exist");
        }

        return $paragraphEntity;
    }

    /**
     * @param BaseParagraphInterface $paragraphModel
     * @return ParagraphEntity
     * @throws NonExistentEntity
     */
    public function makeNewByModel(BaseParagraphInterface $paragraphModel): ParagraphEntity
    {
        /** @var ParagraphEntity $paragraphEntity */
        $paragraphEntity = new ParagraphEntity();

        $this->fillRequiredFields($paragraphModel, $paragraphEntity);

        if ($paragraphModel instanceof WithDeviceParagraphInterface) {
            $this->fillRequiredFieldsForWithDevice($paragraphModel, $paragraphEntity);
        }

        if ($paragraphModel instanceof ChildParagraphInterface) {
            $this->fillRequiredFieldsForChild($paragraphModel, $paragraphEntity);
        }

        return $paragraphEntity;
    }

    /**
     * @param BaseParagraphInterface $paragraphModel
     * @param ParagraphEntity $paragraphEntity
     *
     * @throws NonExistentEntity
     */
    private function fillRequiredFields(BaseParagraphInterface $paragraphModel, ParagraphEntity $paragraphEntity) : void
    {
        $paragraphEntity->setId($paragraphModel->getId()->getValue());

        /** @var Section $sectionEntity */
        $sectionEntity = $this->sectionRepository->find($paragraphModel->getSectionid()->getValue());
        if (!$sectionEntity instanceof SectionEntity) {
            throw new NonExistentEntity("Section Entity not exist");
        }
        $paragraphEntity->setSection($sectionEntity);
    }

    /**
     * @param WithDeviceParagraphInterface $paragraphModel
     * @param ParagraphEntity $paragraphEntity
     *
     * @throws NonExistentEntity
     */
    private function fillRequiredFieldsForWithDevice(
        WithDeviceParagraphInterface $paragraphModel,
        ParagraphEntity $paragraphEntity
    ) : void {
        /** @var Device $deviceEntity */
        $deviceEntity = $this->deviceRepository->find($paragraphModel->getDevice()->getId()->getValue());
        if (!$deviceEntity instanceof DeviceEntity) {
            throw new NonExistentEntity("Device Entity not exists");
        }
        $paragraphEntity->setDevice($deviceEntity);

        /** @var ParagraphFilterEntity $paragraphFilterEntity */
        $paragraphFilterEntity = $this->paragraphFilterRepository->find(
            $paragraphModel->getFilter()->getId()->getValue()
        );
        if (!$paragraphFilterEntity instanceof ParagraphFilterEntity) {
            throw new NonExistentEntity("ParagraphFilter Entity not exist");
        }
        $paragraphEntity->setParagraphFilter($paragraphFilterEntity);
    }

    /**
     * @param ChildParagraphInterface $paragraphModel
     * @param ParagraphEntity $paragraphEntity
     *
     * @throws NonExistentEntity
     */
    private function fillRequiredFieldsForChild(
        ChildParagraphInterface $paragraphModel,
        ParagraphEntity $paragraphEntity
    ) : void {
        /** @var ParagraphEntity $parentParagraphEntity */
        $parentParagraphEntity = $this->paragraphRepository->find($paragraphModel->getParent()->getValue());
        if (!$parentParagraphEntity instanceof ParagraphEntity) {
            throw new NonExistentEntity("Parent Paragraph Entity not exist");
        }
        $paragraphEntity->setParent($parentParagraphEntity);
    }
}
