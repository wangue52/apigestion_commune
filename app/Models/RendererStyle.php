<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class RendererStyle
{
    public $width;
    public $margin;
    public $errorCorrectionLevel;
    public $foregroundColor;
    public $backgroundColor;

    public function __construct($width, $margin, $errorCorrectionLevel, $foregroundColor, $backgroundColor)
    {
        $this->width = $width;
        $this->margin = $margin;
        $this->errorCorrectionLevel = $errorCorrectionLevel;
        $this->foregroundColor = $foregroundColor;
        $this->backgroundColor = $backgroundColor;
    }
}