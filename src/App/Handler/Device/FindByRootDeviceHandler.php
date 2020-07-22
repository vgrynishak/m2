<?php

namespace App\App\Handler\Device;

use App\App\Query\Device\FindByRootDeviceQueryInterface;
use App\App\Query\Device\Validator\FindByRootDeviceValidatorInterface;
use App\App\UseCase\Device\GetListByRootDeviceUseCaseInterface;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use \PhpCollection\CollectionInterface;

class FindByRootDeviceHandler implements MessageHandlerInterface
{
    /** @var GetListByRootDeviceUseCaseInterface */
    private $useCase;

    /** @var FindByRootDeviceValidatorInterface */
    private $validator;

    /**
     * FindByRootDeviceHandler constructor.
     * @param GetListByRootDeviceUseCaseInterface $useCase
     * @param FindByRootDeviceValidatorInterface $validator
     */
    public function __construct(
        GetListByRootDeviceUseCaseInterface $useCase,
        FindByRootDeviceValidatorInterface $validator
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
    }

    /**
     * @param FindByRootDeviceQueryInterface $query
     * @return CollectionInterface
     * @throws FailGetListDevice
     */
    public function __invoke(FindByRootDeviceQueryInterface $query)
    {
        try {
            $this->validator->validate($query);

            return $this->useCase->getList($query);
        } catch (\Exception $e) {
            throw new FailGetListDevice($e->getMessage());
        }
    }
}
