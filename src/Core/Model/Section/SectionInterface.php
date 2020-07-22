<?php

namespace App\Core\Model\Section;

use App\Core\Model\ModelInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

interface SectionInterface extends ModelInterface
{
    public function getId(): SectionId;

    public function setTitle(string $title);

    public function getReportTemplateId(): ReportTemplateId;

    public function getTitle(): string;

    public function getPosition(): ?int;

    public function setPosition(?int $position): void;

    public function getCreatedAt(): ?DateTime;

    public function setCreatedAt(?DateTime $createdAt): void;

    public function getModifiedAt(): ?DateTime;

    public function setModifiedAt(?DateTime $modifiedAt): void;

    public function getCreatedBy(): ?UserInterface;

    public function setCreatedBy(?UserInterface $createdBy): void;

    public function getModifiedBy(): ?UserInterface;

    public function setModifiedBy(?UserInterface $modifiedBy): void;

    public function isPrintable(): ?bool;

    public function setPrintable(?bool $printable): void;

    public function getParagraphs(): ?CollectionInterface;

    public function setParagraphs(?CollectionInterface $paragraphs): void;
}
