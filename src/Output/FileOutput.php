<?php

declare(strict_types=1);

namespace App\Output;

use App\Interfaces\OutputInterface;
use Illuminate\Filesystem\Filesystem;

final class FileOutput implements OutputInterface
{
    protected Filesystem $file;

    public function __construct(protected array $data, protected string $outputPath)
    {
        $this->file = new Filesystem();
    }

    public function process(): void
    {
        $output = implode("\n", $this->data);

        $this->file->put($this->outputPath, $output."\n");
    }
}
