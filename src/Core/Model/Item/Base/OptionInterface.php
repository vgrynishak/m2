<?php

namespace App\Core\Model\Item\Base;

use PhpCollection\CollectionInterface;

interface OptionInterface
{
    /**
     * @param CollectionInterface|null $options
     */
    public function setOptions(?CollectionInterface $options): void;

    /**
     * @return CollectionInterface|null
     */
    public function getOptions(): ?CollectionInterface;
}

