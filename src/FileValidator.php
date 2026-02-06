<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\FileValidationInterface;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

final class FileValidator implements FileValidationInterface
{
    public function __construct(protected $file = new Filesystem())
    {
        //
    }

    public function validate(string $filePath): void
    {
        $this->validateIfFileExists($filePath);
        $this->validateFileExtension($filePath);
        $this->validateFileNotEmpty($filePath);
    }

    private function validateIfFileExists(string $filePath): void
    {
        if (! $this->file->exists($filePath)) {
            throw new InvalidArgumentException("File '{$filePath}' not found.");
        }
    }

    private function validateFileExtension(string $filePath): void
    {
        if ($this->file->extension($filePath) !== 'txt') {
            throw new InvalidArgumentException("File '{$filePath}' is not a text file.");
        }
    }

    private function validateFileNotEmpty(string $filePath): void
    {
        if ($this->file->size($filePath) === 0) {
            throw new InvalidArgumentException("File '{$filePath}' is empty.");
        }
    }
}
