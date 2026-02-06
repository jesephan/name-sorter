<?php

namespace Tests;

use App\FileValidator;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FileValidatorTest extends TestCase
{
    private FileValidator $validator;

    private Filesystem $file;

    private string $testDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->file = new Filesystem();
        $this->validator = new FileValidator($this->file);
        $this->testDir = sys_get_temp_dir().'/file-validator-tests';
        $this->file->ensureDirectoryExists($this->testDir);
    }

    protected function tearDown(): void
    {
        $this->file->deleteDirectory($this->testDir);
        parent::tearDown();
    }

    public function test_passes_validation_for_valid_file(): void
    {
        $filePath = $this->testDir.'/valid.txt';
        $this->file->put($filePath, "John Smith\nJane Doe");

        // Should not throw any exception
        $this->validator->validate($filePath);
        $this->assertTrue(true);
    }

    public function test_throws_exception_for_missing_file(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('not found');

        $this->validator->validate('/nonexistent/file.txt');
    }

    public function test_throws_exception_for_non_txt_file(): void
    {
        $filePath = $this->testDir.'/invalid.csv';
        $this->file->put($filePath, 'some content');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('not a text file');

        $this->validator->validate($filePath);
    }

    public function test_throws_exception_for_empty_file(): void
    {
        $filePath = $this->testDir.'/empty.txt';
        $this->file->put($filePath, '');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('is empty');

        $this->validator->validate($filePath);
    }
}
