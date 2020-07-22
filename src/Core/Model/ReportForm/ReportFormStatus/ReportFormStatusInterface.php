<?php

namespace App\Core\Model\ReportForm\ReportFormStatus;

use App\Core\Model\ModelInterface;

interface ReportFormStatusInterface extends ModelInterface
{
    public function getId(): ReportFormStatusId;

    public function getName(): string;

    public function setDescription(?string $description);

    public function getDescription(): ?string;
}
