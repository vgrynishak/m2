<?php

namespace App\Infrastructure\Adapter\DTO\Paragraph\Filter;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    //private $description;

    /**
     * Full constructor.
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

//    public function setDescription(?string $description)
//    {
//        $this->description = $description;
//    }
}
