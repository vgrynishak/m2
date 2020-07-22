<?php

namespace App\App\Command\Paragraph\Mapper;

use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Command\Paragraph\CreateRootWithDeviceCommandInterface;
use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\App\Component\Message\MessageInterface;
use App\App\Factory\Exception\FailMakeCommandParagraphModel;
use App\Core\Model\Device\Device;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\App\Factory\Paragraph\ParagraphFactoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;

class ParagraphMapperByCommand implements ParagraphMapperByCommandInterface
{
    /** @var ParagraphFactoryInterface */
    private $paragraphFactory;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;

    /**
     * ParagraphMapperByCommand constructor.
     * @param ParagraphFactoryInterface $factory
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
     */
    public function __construct(
        ParagraphFactoryInterface $factory,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
    ) {
        $this->paragraphFactory = $factory;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
    }

    /**
     * @param MessageInterface $command
     *
     * @return BaseParagraphInterface
     * @throws FailMakeCommandParagraphModel
     */
    public function map(MessageInterface $command): BaseParagraphInterface
    {
        $paragraph = null;

        if ($command instanceof CreateRootWithoutDeviceCommandInterface) {
            /** @var RootParagraphWithoutDeviceInterface $paragraph */
            $paragraph = $this->mapRootWithoutDevice($command);
        }

        if ($command instanceof CreateChildWithDeviceCommandInterface) {
            /** @var ChildParagraphWithDeviceInterface $paragraph */
            $paragraph = $this->mapChildWithDevice($command);
        }

        if ($command instanceof CreateRootWithDeviceCommandInterface) {
            /** @var RootParagraphWithDeviceInterface $paragraph */
            $paragraph = $this->mapRootWithDevice($command);
        }

        if (!$paragraph instanceof BaseParagraphInterface) {
            throw new FailMakeCommandParagraphModel();
        }

        return $this->mapBaseFields($command, $paragraph);
    }

    /**
     * @param CreateChildWithDeviceCommandInterface $command
     *
     * @return ChildParagraphWithDeviceInterface
     */
    private function mapChildWithDevice(
        CreateChildWithDeviceCommandInterface $command
    ): ChildParagraphWithDeviceInterface {
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        /** @var ParagraphFilterInterface $filter */
        $filter = $this->paragraphFilterQueryRepository->find($command->getParagraphFilterId());

        /** @var ChildParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->paragraphFactory->makeChildWithDevice(
            $command->getId(),
            $command->getParentId(),
            $command->getSectionId(),
            $device,
            $filter,
            $command->getHeader()
        );

        return $paragraph;
    }

    /**
     * @param CreateRootWithoutDeviceCommandInterface $command
     *
     * @return RootParagraphWithoutDeviceInterface
     */
    private function mapRootWithoutDevice(
        CreateRootWithoutDeviceCommandInterface $command
    ): RootParagraphWithoutDeviceInterface {
        /** @var RootParagraphWithoutDeviceInterface $paragraph */
        $paragraph = $this->paragraphFactory->makeRootWithoutDevice(
            $command->getId(),
            $command->getSectionId(),
            $command->getHeader()
        );

        return $paragraph;
    }

    /**
     * @param CreateRootWithDeviceCommandInterface $command
     *
     * @return RootParagraphWithDeviceInterface
     */
    private function mapRootWithDevice(
        CreateRootWithDeviceCommandInterface $command
    ): RootParagraphWithDeviceInterface {
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        /** @var ParagraphFilterInterface $filter */
        $filter = $this->paragraphFilterQueryRepository->find($command->getParagraphFilterId());

        /** @var RootParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->paragraphFactory->makeRootWithDevice(
            $command->getId(),
            $command->getSectionId(),
            $device,
            $filter,
            $command->getHeader()
        );

        return $paragraph;
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @param MessageInterface $command
     *
     * @return BaseParagraphInterface
     */
    private function mapBaseFields(MessageInterface $command, BaseParagraphInterface $paragraph): BaseParagraphInterface
    {
        if ($command->getStyleTemplateId()) {
            $paragraph->setStyleTemplateId($command->getStyleTemplateId());
        }

        $paragraph->setPrintable($command->isPrintable());
        $paragraph->setCreatedBy($command->getCreatedBy());
        $paragraph->setModifiedBy($command->getCreatedBy());

        return $paragraph;
    }
}
