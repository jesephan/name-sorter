<?php

declare(strict_types=1);

namespace App\Interfaces;

interface FileValidationInterface
{
    public function validate(string $filePath): void;
}
