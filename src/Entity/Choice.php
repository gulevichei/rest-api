<?php

namespace App\Entity;

class Choice
{

    /**
     * @var string
     */
    private $text;

    public function __construct()
    {
        $this->text = '';
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
}
