<?php

namespace App\App\Factory\Group;

use App\Core\Model\Device\Group;
use App\Core\Model\Device\GroupId;
use App\Core\Model\Device\GroupInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Repository\Device\GroupQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use \App\Core\Model\Exception\InvalidParagraphFilterIdException;
use \App\Core\Model\Exception\InvalidGroupIdException;

class GroupFactory implements GroupFactoryInterface
{
    /** @var GroupQueryRepositoryInterface */
    private $groupQueryRepository;

    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;

    /**
     * GroupFactory constructor.
     * @param GroupQueryRepositoryInterface $groupQueryRepository
     * @param ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
     */
    public function __construct(
        GroupQueryRepositoryInterface $groupQueryRepository,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
    ) {
        $this->groupQueryRepository = $groupQueryRepository;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
    }

    /**
     * @param string $id
     * @param string $filterId
     * @return Group
     * @throws InvalidGroupIdException
     * @throws InvalidParagraphFilterIdException
     * @throws \InvalidArgumentException
     */
    public function make(string $id, string $filterId = null): GroupInterface
    {
        $groupRelated = $this->groupQueryRepository->find(new GroupId($id));

        if (!$groupRelated) {
            throw new \InvalidArgumentException('Invalid find Group with id'.Group::GROUP_RELATED_TO_INSPECTED_DEVICE);
        }

        if ($filterId) {
            $groupRelated->setFilter($this->paragraphFilterQueryRepository->find(new ParagraphFilterId($filterId)));
        }
        return $groupRelated;
    }
}
