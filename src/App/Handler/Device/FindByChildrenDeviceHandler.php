<?php

namespace App\App\Handler\Device;

use App\App\Query\Device\FindByChildrenDeviceQueryInterface;
use App\App\Query\Device\Validator\FindByChildrenDeviceValidatorInterface;
use App\App\UseCase\Device\GetListByChildrenDeviceUseCaseInterface;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use \PhpCollection\CollectionInterface;

class FindByChildrenDeviceHandler implements MessageHandlerInterface
{
    /** @var GetListByChildrenDeviceUseCaseInterface */
    private $useCase;

    /** @var FindByChildrenDeviceValidatorInterface */
    private $validator;

    /**
     * FindByChildrenDeviceHandler constructor.
     * @param GetListByChildrenDeviceUseCaseInterface $useCase
     * @param FindByChildrenDeviceValidatorInterface $validator
     */
    public function __construct(
        GetListByChildrenDeviceUseCaseInterface $useCase,
        FindByChildrenDeviceValidatorInterface $validator
    ) {
        $this->useCase = $useCase;
        $this->validator = $validator;
    }

    /**
     * @param FindByChildrenDeviceQueryInterface $query
     * @return CollectionInterface
     * @throws FailGetListDevice
     */
    public function __invoke(FindByChildrenDeviceQueryInterface $query)
    {
        try {
            $this->validator->validate($query);

            return $this->useCase->getList($query);
        } catch (\Exception $e) {
            throw new FailGetListDevice($e->getMessage());
        }
    }
}
