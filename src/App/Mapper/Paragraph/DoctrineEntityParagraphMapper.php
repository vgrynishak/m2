<?php

namespace App\App\Mapper\Paragraph;

use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Entity\StyleTemplate;
use App\App\Factory\Exception\FailMakeEntityParagraphModel;
use App\App\Factory\Exception\FailMakeItemModel;
use App\App\Factory\Paragraph\ParagraphFactoryInterface;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\User;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;
use App\Core\Repository\Paragraph\HeaderQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class DoctrineEntityParagraphMapper implements DoctrineEntityParagraphMapperInterface
{
    /** @var ParagraphFactoryInterface */
    private $paragraphFactory;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;
    /** @var ItemQueryRepositoryInterface */
    private $itemQueryRepository;
    /** @var HeaderQueryRepositoryInterface */
    private $headerQueryRepository;

    /**
     * DoctrineEntityParagraphMapper constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ParagraphFactoryInterface $factory
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
     * @param ItemQueryRepositoryInterface $itemQueryRepository
     * @param HeaderQueryRepositoryInterface $headerQueryRepository
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ParagraphFactoryInterface $factory,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository,
        ItemQueryRepositoryInterface $itemQueryRepository,
        HeaderQueryRepositoryInterface $headerQueryRepository
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->paragraphFactory = $factory;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
        $this->itemQueryRepository = $itemQueryRepository;
        $this->headerQueryRepository = $headerQueryRepository;
    }

    /**
     * @param ParagraphEntity $paragraphEntity
     * @return BaseParagraphInterface
     * @throws FailMakeEntityParagraphModel
     * @throws FailMakeItemModel
     * @throws InvalidDeviceIdException
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     * @throws InvalidStyleTemplateIdException
     */
    public function map(ParagraphEntity $paragraphEntity): BaseParagraphInterface
    {
        if ($paragraphEntity->getParent()) {
            /** @var ChildParagraphWithDeviceInterface $paragraph */
            $paragraph = $this->mapChildWithDevice($paragraphEntity);
        }

        if (!$paragraphEntity->getParent() and $paragraphEntity->getDevice()) {
            /** @var RootParagraphWithDeviceInterface $paragraph */
            $paragraph = $this->mapRootWithDevice($paragraphEntity);
        }

        if (!$paragraphEntity->getParent() and !$paragraphEntity->getDevice()) {
            /** @var RootParagraphWithoutDeviceInterface $paragraph */
            $paragraph = $this->mapRootWithoutDevice($paragraphEntity);
        }

        if (!$paragraph instanceof BaseParagraphInterface) {
            throw new FailMakeEntityParagraphModel();
        }

        return $this->mapBase($paragraphEntity, $paragraph);
    }

    /**
     * @param ParagraphEntity $paragraphEntity
     * @return ChildParagraphWithDeviceInterface
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     */
    private function mapChildWithDevice(ParagraphEntity $paragraphEntity): ChildParagraphWithDeviceInterface
    {
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find(new DeviceId($paragraphEntity->getDevice()->getId()));
        /** @var ParagraphFilterInterface $filter */
        $filter = $this->paragraphFilterQueryRepository->find(
            new ParagraphFilterId($paragraphEntity->getParagraphFilter()->getId())
        );
        /** @var ParagraphId $paragraphId */
        $paragraphId = new ParagraphId($paragraphEntity->getId());
        /** @var BaseHeaderInterface $header */
        $header = $this->headerQueryRepository->findByParagraphId($paragraphId);

        /** @var ChildParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->paragraphFactory->makeChildWithDevice(
            $paragraphId,
            new ParagraphId($paragraphEntity->getParent()->getId()),
            new SectionId($paragraphEntity->getSection()->getId()),
            $device,
            $filter,
            $header
        );
        $paragraph->setLevel($paragraphEntity->getLevel());

        return $paragraph;
    }

    /**
     * @param ParagraphEntity $paragraphEntity
     * @return RootParagraphWithoutDeviceInterface
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     */
    private function mapRootWithoutDevice(ParagraphEntity $paragraphEntity): RootParagraphWithoutDeviceInterface
    {
        /** @var ParagraphId $paragraphId */
        $paragraphId = new ParagraphId($paragraphEntity->getId());
        /** @var BaseHeaderInterface $header */
        $header = $this->headerQueryRepository->findByParagraphId($paragraphId);

        /** @var RootParagraphWithoutDeviceInterface $paragraph */
        $paragraph = $this->paragraphFactory->makeRootWithoutDevice(
            $paragraphId,
            new SectionId($paragraphEntity->getSection()->getId()),
            $header
        );

        return $paragraph;
    }

    /**
     * @param ParagraphEntity $paragraphEntity
     * @return RootParagraphWithDeviceInterface
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     */
    private function mapRootWithDevice(ParagraphEntity $paragraphEntity): RootParagraphWithDeviceInterface
    {
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find(new DeviceId($paragraphEntity->getDevice()->getId()));
        /** @var ParagraphFilterInterface $filter */
        $filter = $this->paragraphFilterQueryRepository->find(
            new ParagraphFilterId($paragraphEntity->getParagraphFilter()->getId())
        );
        /** @var ParagraphId $paragraphId */
        $paragraphId = new ParagraphId($paragraphEntity->getId());
        /** @var BaseHeaderInterface $header */
        $header = $this->headerQueryRepository->findByParagraphId($paragraphId);

        /** @var RootParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->paragraphFactory->makeRootWithDevice(
            $paragraphId,
            new SectionId($paragraphEntity->getSection()->getId()),
            $device,
            $filter,
            $header
        );

        return $paragraph;
    }

    /**
     * @param ParagraphEntity $paragraphEntity
     * @param BaseParagraphInterface $paragraph
     * @return BaseParagraphInterface
     * @throws InvalidStyleTemplateIdException
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    private function mapBase(
        ParagraphEntity $paragraphEntity,
        BaseParagraphInterface $paragraph
    ): BaseParagraphInterface {
        /** @var User $createdBy */
        $createdBy = $this->userQueryRepository->find($paragraphEntity->getCreatedBy()->getId());
        /** @var User $modifiedBy */
        $modifiedBy = $this->userQueryRepository->find($paragraphEntity->getModifiedBy()->getId());

        $paragraph->setPosition($paragraphEntity->getPosition());
        $paragraph->setCreatedBy($createdBy);
        $paragraph->setModifiedBy($modifiedBy);
        $paragraph->setPrintable($paragraphEntity->getPrintable());
        $paragraph->setItems($this->itemQueryRepository->findListByParagraphId($paragraph->getId()));

        if ($paragraphEntity->getStyleTemplate() instanceof StyleTemplate) {
            $paragraph->setStyleTemplateId(new StyleTemplateId($paragraphEntity->getStyleTemplate()->getId()));
        }
        $paragraph->setUpdatedAt($paragraphEntity->getUpdatedAt());
        $paragraph->setCreatedAt($paragraphEntity->getCreatedAt());

        return $paragraph;
    }
}
