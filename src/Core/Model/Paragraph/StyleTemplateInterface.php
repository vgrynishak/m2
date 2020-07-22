<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\ModelInterface;

interface StyleTemplateInterface extends ModelInterface
{
    public function getId(): StyleTemplateId;

    public function getName(): string;

    public function getBody(): ?string;

    public function setBody(?string $body);
}
