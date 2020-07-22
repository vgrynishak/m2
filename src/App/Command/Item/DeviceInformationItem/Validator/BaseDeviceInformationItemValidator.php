<?php

namespace App\App\Command\Item\DeviceInformationItem\Validator;

use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\DeviceInformationItem\DeviceInformationItemCommandInterface;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;
use InvalidArgumentException;

abstract class BaseDeviceInformationItemValidator
{
    /** @var LabelValidator */
    private $labelValidator;
    /** @var InfoSourceQueryRepositoryInterface */
    private $infoSourceQueryRepository;

    /**
     * BaseDeviceInformationItemValidator constructor.
     * @param LabelValidator $labelValidator
     * @param InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
     */
    public function __construct(
        LabelValidator $labelValidator,
        InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
    ) {
        $this->labelValidator = $labelValidator;
        $this->infoSourceQueryRepository = $infoSourceQueryRepository;
    }

    /**
     * @param DeviceInformationItemCommandInterface $command
     */
    public function validateByItemType(DeviceInformationItemCommandInterface $command): void
    {

        $itemTypeId = $command->getItemTypeId()->getValue();

        if ($itemTypeId === ItemType::INFORMATION_DEVICE_RELATED) {
            $this->labelValidator->checkLabelLength($command->getLabel());
            $this->checkInfoSource($command->getInfoSourceId());
        } else {
            throw new  InvalidArgumentException('Invalid itemType');
        }
    }

    /**
     * @param InfoSourceId $infoSourceId
     */
    private function checkInfoSource(InfoSourceId $infoSourceId): void
    {
        try {
            $infoSource = $this->infoSourceQueryRepository->find($infoSourceId);

            if (!$infoSource instanceof InfoSourceInterface) {
                throw new InvalidArgumentException('Not found InfoSourceId');
            }

        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
