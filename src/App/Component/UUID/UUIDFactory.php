<?php

namespace App\App\Component\UUID;

class UUIDFactory
{
    /**
     * @param $id
     *
     * @return UUID
     *
     * @throws \Exception
     */
    public static function build($id): UUID
    {
        return new UUID($id);
    }
}
