<?php

namespace App\Core\Model\ReportTemplate;

use App\Core\Model\ModelInterface;

interface ReportTemplateStatusInterface extends ModelInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getDescription(): ?string;
}
