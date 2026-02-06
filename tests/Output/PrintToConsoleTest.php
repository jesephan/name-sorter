<?php

namespace Tests\Output;

use App\Interfaces\OutputInterface;
use App\Output\PrintToConsole;
use PHPUnit\Framework\TestCase;

class PrintToConsoleTest extends TestCase
{
    public function test_implements_output_interface(): void
    {
        $output = new PrintToConsole([]);

        $this->assertInstanceOf(OutputInterface::class, $output);
    }

    public function test_process_executes_without_error(): void
    {
        $data = ['Jane Doe', 'John Smith'];
        $output = new PrintToConsole($data);

        // Redirect STDOUT to suppress output during test
        $stdout = fopen('php://memory', 'w');
        $originalStdout = defined('STDOUT') ? STDOUT : fopen('php://stdout', 'w');

        $output->process();

        // If we reach here without exception, the test passes
        $this->assertTrue(true);
    }

    public function test_handles_empty_data(): void
    {
        $output = new PrintToConsole([]);

        $output->process();

        // If we reach here without exception, the test passes
        $this->assertTrue(true);
    }
}
