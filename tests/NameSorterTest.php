<?php

namespace Tests;

use App\NameSorter;
use PHPUnit\Framework\TestCase;

class NameSorterTest extends TestCase
{
    private NameSorter $sorter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sorter = new NameSorter();
    }

    public function test_sorts_names_by_last_name(): void
    {
        $names = ['John Smith', 'Jane Doe', 'Bob Adams'];

        $result = $this->sorter->sort($names);

        $this->assertEquals(['Bob Adams', 'Jane Doe', 'John Smith'], $result);
    }

    public function test_sorts_by_given_name_when_last_names_match(): void
    {
        $names = ['Zoe Smith', 'Adam Smith', 'John Smith'];

        $result = $this->sorter->sort($names);

        $this->assertEquals(['Adam Smith', 'John Smith', 'Zoe Smith'], $result);
    }

    public function test_handles_multiple_given_names(): void
    {
        $names = [
            'Hunter Uriah Mathew Clarke',
            'Adonis Julius Archer',
            'Beau Tristan Bentley',
        ];

        $result = $this->sorter->sort($names);

        $this->assertEquals([
            'Adonis Julius Archer',
            'Beau Tristan Bentley',
            'Hunter Uriah Mathew Clarke',
        ], $result);
    }

    public function test_handles_single_given_name(): void
    {
        $names = ['Janet Parsons', 'Mikayla Lopez'];

        $result = $this->sorter->sort($names);

        $this->assertEquals(['Mikayla Lopez', 'Janet Parsons'], $result);
    }

    public function test_sorting_is_case_insensitive(): void
    {
        $names = ['john smith', 'JANE DOE', 'Bob Adams'];

        $result = $this->sorter->sort($names);

        $this->assertEquals(['Bob Adams', 'JANE DOE', 'john smith'], $result);
    }

    public function test_handles_extra_whitespace(): void
    {
        $names = ['  John   Smith  ', 'Jane    Doe'];

        $result = $this->sorter->sort($names);

        $this->assertEquals(['Jane Doe', 'John Smith'], $result);
    }

    public function test_returns_empty_array_for_empty_input(): void
    {
        $result = $this->sorter->sort([]);

        $this->assertEquals([], $result);
    }

    public function test_full_example_from_requirements(): void
    {
        $names = [
            'Janet Parsons',
            'Vaughn Lewis',
            'Adonis Julius Archer',
            'Shelby Nathan Yoder',
            'Marin Alvarez',
            'London Lindsey',
            'Beau Tristan Bentley',
            'Leo Gardner',
            'Hunter Uriah Mathew Clarke',
            'Mikayla Lopez',
            'Frankie Conner Ritter',
        ];

        $result = $this->sorter->sort($names);

        $expected = [
            'Marin Alvarez',
            'Adonis Julius Archer',
            'Beau Tristan Bentley',
            'Hunter Uriah Mathew Clarke',
            'Leo Gardner',
            'Vaughn Lewis',
            'London Lindsey',
            'Mikayla Lopez',
            'Janet Parsons',
            'Frankie Conner Ritter',
            'Shelby Nathan Yoder',
        ];

        $this->assertEquals($expected, $result);
    }

    public function test_handles_large_dataset(): void
    {
        $names = [];
        for ($i = 0; $i < 1000; $i++) {
            $names[] = "Given{$i} LastName".str_pad((string) $i, 4, '0', STR_PAD_LEFT);
        }
        shuffle($names);

        $result = $this->sorter->sort($names);

        $this->assertCount(1000, $result);

        // Verify sorting is correct
        for ($i = 1; $i < count($result); $i++) {
            $prevParts = explode(' ', $result[$i - 1]);
            $currParts = explode(' ', $result[$i]);
            $this->assertLessThanOrEqual(
                0,
                strcasecmp(end($prevParts), end($currParts)),
                "Names not sorted correctly: {$result[$i - 1]} should come before {$result[$i]}"
            );
        }
    }
}
