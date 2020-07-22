<?php

namespace App\Core\Model\Paragraph;

class ParagraphFilter implements ParagraphFilterInterface
{
    const FILTER_INSPECTION = 'inspection';
    const FILTER_ON_SITE = 'on_site';
    const FILTER_SAME_AS_PARENT = 'same_as_parent';
    const FILTER_BY_ANCESETOR = 'by_ancestor';

    /** @var ParagraphFilterId */
    private $id;
    /** @var string */
    private $name;
    /** @var string|null */
    private $description;

    /**
     * ParagraphFilter constructor.
     * @param ParagraphFilterId $id
     * @param string $name
     */
    public function __construct(ParagraphFilterId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return ParagraphFilterId
     */
    public function getId(): ParagraphFilterId
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }
}
