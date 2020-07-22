<?php

namespace App\Core\Model\Facility;

use App\Core\Model\ModelInterface;
use DateTime;

interface FacilityInterface extends ModelInterface
{
    public function getId(): FacilityId;

    public function getName(): string;

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): DateTime;

    public function setCreatedAt(DateTime $createdAt): void;

    public function setUpdatedAt(DateTime $updatedAt): void;
}
