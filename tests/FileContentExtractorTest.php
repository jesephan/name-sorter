<?php

namespace Tests;

use App\FileContentExtractor;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;

class FileContentExtractorTest extends TestCase
{
    private FileContentExtractor $extractor;

    private Filesystem $file;

    private string $testDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->file = new Filesystem();
        $this->extractor = new FileContentExtractor($this->file);
        $this->testDir = sys_get_temp_dir().'/file-extractor-tests';
        $this->file->ensureDirectoryExists($this->testDir);
    }

    protected function tearDown(): void
    {
        $this->file->deleteDirectory($this->testDir);
        parent::tearDown();
    }

    public function test_extracts_names_from_file(): void
    {
        $filePath = $this->testDir.'/names.txt';
        $this->file->put($filePath, "John Smith\nJane Doe\nBob Adams");

        $result = $this->extractor->extract($filePath);

        $this->assertEquals(['John Smith', 'Jane Doe', 'Bob Adams'], $result);
    }

    public function test_ignores_empty_lines(): void
    {
        $filePath = $this->testDir.'/names.txt';
        $this->file->put($filePath, "John Smith\n\nJane Doe\n   \nBob Adams");

        $result = $this->extractor->extract($filePath);

        // Keys may not be sequential after filtering, so use array_values
        $this->assertEquals(['John Smith', 'Jane Doe', 'Bob Adams'], array_values($result));
    }

    public function test_trims_whitespace_from_file(): void
    {
        $filePath = $this->testDir.'/names.txt';
        $this->file->put($filePath, "  \nJohn Smith\nJane Doe\n  ");

        $result = $this->extractor->extract($filePath);

        $this->assertEquals(['John Smith', 'Jane Doe'], $result);
    }
}
