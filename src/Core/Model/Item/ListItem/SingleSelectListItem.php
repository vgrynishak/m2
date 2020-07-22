<?php

namespace App\Core\Model\Item\ListItem;

use App\Core\Model\Answer\AnswerInterface;
use App\Core\Model\Item\Base\BaseItem;
use PhpCollection\CollectionInterface;

class SingleSelectListItem extends BaseItem implements SingleSelectListItemInterface
{
    /** @var AnswerInterface */
    private $defaultAnswer;
    /** @var string */
    private $label;
    /** @var string */
    private $NFPA;
    /** @var bool */
    private $remember;
    /** @var bool */
    private $require;
    /** @var string */
    private $placeholder;
    /** @var CollectionInterface */
    private $options;

    /**
     * @return AnswerInterface|null
     */
    public function getDefaultAnswer(): ?AnswerInterface
    {
        return $this->defaultAnswer;
    }

    /**
     * @param AnswerInterface|null $default
     */
    public function setDefaultAnswer(?AnswerInterface $default)
    {
        $this->defaultAnswer = $default;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     */
    public function setLabel(?string $label)
    {
        $this->label = $label;
    }

    /**
     * @return string|null
     */
    public function getNFPA(): ?string
    {
        return $this->NFPA;
    }

    /**
     * @param string|null $NFPA
     */
    public function setNFPA(?string $NFPA)
    {
        $this->NFPA = $NFPA;
    }

    /**
     * @return bool|null
     */
    public function getRequire(): ?bool
    {
        return $this->require;
    }

    /**
     * @param bool|null $require
     */
    public function setRequire(?bool $require)
    {
        $this->require = $require;
    }

    /**
     * @return bool|null
     */
    public function getRemember(): ?bool
    {
        return  $this->remember;
    }

    /**
     * @param bool|null $remember
     */
    public function setRemember(?bool $remember)
    {
        $this->remember = $remember;
    }

    public function setPlaceholder(?string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @inheritDoc
     */
    public function setOptions(?CollectionInterface $options): void
    {
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): ?CollectionInterface
    {
        return $this->options;
    }
}
