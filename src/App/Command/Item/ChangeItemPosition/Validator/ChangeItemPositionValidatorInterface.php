<?php

namespace App\App\Command\Item\ChangeItemPosition\Validator;

use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommandInterface;

interface ChangeItemPositionValidatorInterface
{
    public function validate(ChangeItemPositionCommandInterface $command):bool;
}
