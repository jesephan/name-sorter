<?php

namespace Tests\Output;

use App\Output\FileOutput;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;

class FileOutputTest extends TestCase
{
    private Filesystem $file;

    private string $testDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->file = new Filesystem();
        $this->testDir = sys_get_temp_dir().'/file-output-tests';
        $this->file->ensureDirectoryExists($this->testDir);
    }

    protected function tearDown(): void
    {
        $this->file->deleteDirectory($this->testDir);
        parent::tearDown();
    }

    public function test_writes_sorted_names_to_file(): void
    {
        $outputPath = $this->testDir.'/output.txt';
        $data = ['Jane Doe', 'John Smith'];

        $output = new FileOutput($data, $outputPath);
        $output->process();

        $this->assertTrue($this->file->exists($outputPath));
        $this->assertEquals("Jane Doe\nJohn Smith\n", $this->file->get($outputPath));
    }

    public function test_writes_empty_file_for_empty_data(): void
    {
        $outputPath = $this->testDir.'/output.txt';
        $data = [];

        $output = new FileOutput($data, $outputPath);
        $output->process();

        $this->assertTrue($this->file->exists($outputPath));
        $this->assertEquals("\n", $this->file->get($outputPath));
    }
}
