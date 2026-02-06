<?php

declare(strict_types=1);

namespace App\Output;

use App\Interfaces\OutputInterface;

final class PrintToConsole implements OutputInterface
{
    public function __construct(protected array $data)
    {
        //
    }

    public function process(): void
    {
        foreach ($this->data as $item) {
            fwrite(STDOUT, $item."\n");
        }
    }
}
