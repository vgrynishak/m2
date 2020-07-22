<?php

namespace App\App\Repository\Device;

use App\App\Doctrine\Repository\GroupRepository as GroupEntityRepository;
use App\App\Mapper\Device\GroupEntityMapperInterface;
use App\Core\Model\Device\Group;
use App\Core\Model\Device\GroupId;
use App\Core\Model\Device\GroupInterface;
use App\Core\Repository\Device\GroupQueryRepositoryInterface;
use App\App\Doctrine\Entity\Group as GroupEntity;
use Exception;

class GroupQueryRepository implements GroupQueryRepositoryInterface
{
    /** @var GroupEntityMapperInterface */
    private $mapper;
    /** @var GroupEntityRepository */
    private $groupEntityRepository;

    public function __construct(
        GroupEntityMapperInterface $mapper,
        GroupEntityRepository $groupEntityRepository
    ) {
        $this->mapper = $mapper;
        $this->groupEntityRepository = $groupEntityRepository;
    }

    /**
     * @param GroupId $id
     * @return Group|null
     * @return Exception
     */
    public function find(GroupId $id): ?GroupInterface
    {
        /** @var GroupEntity $groupEntity */
        $groupEntity = $this->groupEntityRepository->find($id->getValue());

        if (!$groupEntity instanceof GroupEntity) {
            return null;
        }

        return $this->mapper->map($groupEntity);
    }
}
