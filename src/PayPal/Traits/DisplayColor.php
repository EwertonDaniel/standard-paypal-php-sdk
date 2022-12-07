<?php

namespace EwertonDaniel\PayPal\Traits;

trait DisplayColor
{
    private array $color = [
        'information' => "\e[44;97m",
        'success' => "\e[102;97m",
        'attention' => "\e[103;97m",
        'error' => "\e[101;97m"
    ];

    private string $clear = "\e[0m";

    public function information($text, $break_line = false): string
    {
        $text = "$this->clear {$this->color['information']} $text $this->clear\n";
        $text .= $break_line ? "\n" : "";
        return $text;
    }

    public function success($text, $break_line = false): string
    {
        $text = "$this->clear {$this->color['success']} $text $this->clear\n";
        $text .= $break_line ? "\n" : "";
        return $text;
    }

    public function attention($text, $break_line = false): string
    {
        $text = "$this->clear {$this->color['attention']} $text $this->clear\n";
        $text .= $break_line ? "\n" : "";
        return $text;

    }

    public function error($text, $break_line = false): string
    {
        $text = "$this->clear {$this->color['error']} $text $this->clear";
        $text .= $break_line ? "\n" : "";
        return $text;
    }

}