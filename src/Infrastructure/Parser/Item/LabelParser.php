<?php

namespace App\Infrastructure\Parser\Item;

use App\App\Command\Item\BaseItemCommandInterface;

class LabelParser
{
    /**
     * @param $data
     * @param BaseItemCommandInterface $command
     */
    public function parse($data, BaseItemCommandInterface $command): void
    {
        if (!array_key_exists('label', $data)) {
            throw new \InvalidArgumentException('label is required field');
        }

        $command->setLabel($data['label']);
    }
}
