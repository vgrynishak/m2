<?php

namespace App\App\Command\Item\DeviceInformationItem\Validator;

use App\App\Command\Item\BaseValidator\CreateBaseItemValidator;
use App\App\Command\Item\BaseValidator\LabelValidator;
use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use App\Core\Repository\InfoSource\InfoSourceQueryRepositoryInterface;

class CreateDeviceInformationItemValidator extends BaseDeviceInformationItemValidator implements
    CreateDeviceInformationItemValidatorInterface
{

    /** @var CreateBaseItemValidator */
    private $baseItemValidator;

    /**
     * CreateDeviceInformationItemValidator constructor.
     * @param LabelValidator $labelValidator
     * @param InfoSourceQueryRepositoryInterface $infoSourceQueryRepository
     * @param CreateBaseItemValidator $baseItemValidator
     */
    public function __construct(
        LabelValidator $labelValidator,
        InfoSourceQueryRepositoryInterface $infoSourceQueryRepository,
        CreateBaseItemValidator $baseItemValidator
    ) {
        parent::__construct($labelValidator, $infoSourceQueryRepository);

        $this->baseItemValidator = $baseItemValidator;
    }

    /**
     * @inheritDoc
     */
    public function validate(CreateDeviceInformationItemCommandInterface $command): bool
    {
        $this->baseItemValidator->validate($command);

        $this->validateByItemType($command);

        return true;
    }
}
