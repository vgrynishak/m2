<?php

namespace App\Core\Repository\Paragraph;

use App\Core\Model\Paragraph\WithDeviceParagraphInterface;

interface RootWithDeviceRepositoryInterface
{
    public function save(WithDeviceParagraphInterface $paragraph);
}
