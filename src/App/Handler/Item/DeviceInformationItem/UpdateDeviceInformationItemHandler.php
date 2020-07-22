<?php

namespace App\App\Handler\Item\DeviceInformationItem;

use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\Validator\UpdateDeviceInformationItemValidatorInterface;
use App\App\UseCase\Item\DeviceInformationItem\EditDeviceInformationItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailUpdateDeviceInformationItem;

class UpdateDeviceInformationItemHandler
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var UpdateDeviceInformationItemValidatorInterface */
    private $validator;
    /** @var EditDeviceInformationItemUseCaseInterface */
    private $useCase;

    /**
     * UpdateDeviceInformationItemHandler constructor.
     * @param EditDeviceInformationItemUseCaseInterface $useCase
     * @param UpdateDeviceInformationItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditDeviceInformationItemUseCaseInterface $useCase,
        UpdateDeviceInformationItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param UpdateDeviceInformationItemCommandInterface $command
     * @throws FailUpdateDeviceInformationItem
     */
    public function __invoke(UpdateDeviceInformationItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->update($item);
        } catch (\Exception $exception) {
            throw new FailUpdateDeviceInformationItem($exception->getMessage());
        }
    }
}
