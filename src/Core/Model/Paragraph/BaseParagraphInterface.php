<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\ModelInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

interface BaseParagraphInterface extends ModelInterface
{
    public function getId(): ParagraphId;

    public function getSectionId(): ?SectionId;

    public function getPosition(): ?int;

    public function setPosition(?int $position): void;

    public function isPrintable(): bool;

    public function setPrintable(bool $printable): void;

    public function getCreatedAt(): ?DateTime;

    public function getUpdatedAt(): ?DateTime;

    public function setUpdatedAt(DateTime $updatedAt): void;

    public function setCreatedAt(DateTime $createdAt): void;

    public function getItems(): ?CollectionInterface;

    public function setItems(?CollectionInterface $items): void;

    public function getStyleTemplateId(): ?StyleTemplateId;

    public function setStyleTemplateId(?StyleTemplateId $styleTemplateId);

    public function getCreatedBy(): ?UserInterface;

    public function getModifiedBy(): ?UserInterface;

    public function setCreatedBy(UserInterface $createdBy): void;

    public function setModifiedBy(UserInterface $modifiedBy): void;

    public function getHeader(): BaseHeaderInterface;

    public function setHeader(BaseHeaderInterface $header): void;
}
