<?php

namespace App\Core\Model\File;

class File implements FileInterface
{
    /** @var string */
    private $key;
    /** @var resource */
    private $data;
    /** @var string */
    private $link;

    public function __construct(
        string $key,
        $data
    )
    {
        $this->key  = $key;
        $this->data = $data;
    }

    public function getData()
    {
        return  $this->data;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }
}