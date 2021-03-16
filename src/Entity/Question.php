<?php

namespace App\Entity;

use DateTime;

/**
 * Class Question
 *
 * @package App\Entity
 */
class Question
{
    /**
     * @var Choice[]
     */
    private $choices;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $text;

    public function __construct()
    {
        $this->text      = '';
        $this->choices   = [];
        $this->createdAt = (new DateTime())->format('Y-m-d h:i:s');
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return Choice[]
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * @param Choice[] $choices
     */
    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
