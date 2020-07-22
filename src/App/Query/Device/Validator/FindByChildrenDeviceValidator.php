<?php

namespace App\App\Query\Device\Validator;

use App\App\Query\Device\FindByChildrenDeviceQueryInterface;
use App\Core\Model\Device\GroupId;
use App\Core\Model\Device\GroupInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Device\GroupQueryRepositoryInterface;

class FindByChildrenDeviceValidator extends BaseGroupValidator implements FindByChildrenDeviceValidatorInterface
{
    /** @var GroupQueryRepositoryInterface */
    private $groupQueryRepository;

    /**
     * FindByChildrenDeviceValidator constructor.
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param GroupQueryRepositoryInterface $groupQueryRepository\
     */
    public function __construct(
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        GroupQueryRepositoryInterface $groupQueryRepository
    ) {
        parent::__construct($deviceQueryRepository);

        $this->groupQueryRepository = $groupQueryRepository;
    }

    /**
     * @inheritDoc
     */
    public function validate(FindByChildrenDeviceQueryInterface $query): bool
    {
        $this->baseValidate($query->getId());

        $this->validateGroupId($query->getGroupId());

        return true;
    }

    private function validateGroupId(GroupId $groupId)
    {
        $group  = $this->groupQueryRepository->find($groupId);

        if (!$group instanceof GroupInterface) {
            throw new \InvalidArgumentException('Group is not exists');
        }
    }
}
