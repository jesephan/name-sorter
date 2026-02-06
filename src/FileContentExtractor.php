<?php

declare(strict_types=1);

namespace App;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class FileContentExtractor
{
    public function __construct(protected $file = new Filesystem())
    {
        //
    }

    public function extract(string $filePath): array
    {
        $content = $this->file->get($filePath);

        return Str::of($content)
            ->trim()
            ->explode("\n")
            ->filter(fn ($line) => Str::of($line)->trim()->isNotEmpty())
            ->toArray();
    }
}
