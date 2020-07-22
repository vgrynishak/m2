<?php

namespace App\Core\Model\Paragraph;

class StyleTemplate implements StyleTemplateInterface
{
    /** @var StyleTemplateId  */
    private $id;
    /** @var string */
    private $name;
    /** @var string|null */
    private $body;

    /**
     * StyleTemplate constructor.
     * @param StyleTemplateId $id
     * @param string $name
     */
    public function __construct(StyleTemplateId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return StyleTemplateId
     */
    public function getId(): StyleTemplateId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     */
    public function setBody(?string $body)
    {
        $this->body = $body;
    }
}
