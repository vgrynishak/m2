<?php

namespace App\App\Handler\Item\DeviceInformationItem;

use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\Validator\CreateDeviceInformationItemValidatorInterface;
use App\App\UseCase\Item\DeviceInformationItem\EditDeviceInformationItemUseCaseInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Exception\Item\FailCreateDeviceInformationItem;

class CreateDeviceInformationItemHandler
{
    /** @var ItemCommandRepositoryInterface */
    private $repository;
    /** @var CreateDeviceInformationItemValidatorInterface */
    private $validator;
    /** @var EditDeviceInformationItemUseCaseInterface */
    private $useCase;

    /**
     * CreateDeviceInformationItemHandler constructor.
     * @param EditDeviceInformationItemUseCaseInterface $useCase
     * @param CreateDeviceInformationItemValidatorInterface $validator
     * @param ItemCommandRepositoryInterface $repository
     */
    public function __construct(
        EditDeviceInformationItemUseCaseInterface $useCase,
        CreateDeviceInformationItemValidatorInterface $validator,
        ItemCommandRepositoryInterface $repository
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @param CreateDeviceInformationItemCommandInterface $command
     * @throws FailCreateDeviceInformationItem
     */
    public function __invoke(CreateDeviceInformationItemCommandInterface $command)
    {
        try {
            $this->validator->validate($command);

            $item = $this->useCase->edit($command);

            $this->repository->create($item);
        } catch (\Exception $exception) {
            throw new FailCreateDeviceInformationItem($exception->getMessage());
        }
    }
}
