<?php

namespace App\Core\Model\Paragraph\Header;

interface CustomHeaderInterface extends BaseHeaderInterface
{
    public const ID = 'custom_title';

    /**
     * @return string
     */
    public function getValue(): string;
}
