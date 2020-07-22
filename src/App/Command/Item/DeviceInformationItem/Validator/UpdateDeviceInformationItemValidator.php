<?php

namespace App\App\Command\Item\DeviceInformationItem\Validator;

use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\BaseValidator\UpdateBaseItemValidator;
use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;

class UpdateDeviceInformationItemValidator extends BaseDeviceInformationItemValidator implements
    UpdateDeviceInformationItemValidatorInterface
{
    /** @var UpdateBaseItemValidator */
    private $baseItemValidator;

    /**
     * UpdateDeviceInformationItemValidator constructor.
     * @param LabelValidator $labelValidator
     * @param UpdateBaseItemValidator $baseItemValidator
     * @param InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
     */
    public function __construct(
        LabelValidator $labelValidator,
        UpdateBaseItemValidator $baseItemValidator,
        InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
    ) {
        parent::__construct($labelValidator, $infoSourceQueryRepository);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(UpdateDeviceInformationItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);

        $this->validateByItemType($command);

        return true;
    }
}
