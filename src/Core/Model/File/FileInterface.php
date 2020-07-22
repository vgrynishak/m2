<?php

namespace App\Core\Model\File;

interface FileInterface
{
    public function getKey(): string;

    public function getData();
}