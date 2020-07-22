<?php

namespace App\App\Command\Item\BaseValidator;

use InvalidArgumentException;

class LabelValidator
{
    /**
     * @param string $label
     * @throws InvalidArgumentException
     */
    public function checkLabelLength(string $label): void
    {
        $labelLength = strlen(trim($label));

        if ($labelLength <= 0 || $labelLength > 255) {
            throw new InvalidArgumentException('Label must be >= 1 characters and <= 255 characters');
        }
    }
}
