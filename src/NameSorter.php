<?php

namespace App;

use App\Interfaces\OutputInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NameSorter
{
    /**
     * Sort names by last name, then by given names.
     */
    public function sort(array $names): array
    {
        return (new Collection($names))
            ->map(fn ($line) => $this->parseName($line))
            ->sort(fn ($a, $b) => $this->compareNames($a, $b))
            ->pluck('full')
            ->values()
            ->toArray();
    }

    public function output(OutputInterface $output): void
    {
        $output->process();
    }

    /**
     * Parse a full name into its components.
     *
     * Example: "Hunter Uriah Mathew Clarke" becomes:
     *   - full: "Hunter Uriah Mathew Clarke"
     *   - lastName: "Clarke"
     *   - givenNames: "Hunter Uriah Mathew"
     */
    private function parseName(string $line): array
    {
        // Remove extra spaces: "  John   Smith  " becomes "John Smith"
        $line = Str::squish($line);

        // Split the name into parts: ["Hunter", "Uriah", "Mathew", "Clarke"]
        $parts = Str::of($line)->explode(' ');

        return [
            'full' => $line,
            'lastName' => $parts->last(),
            'givenNames' => $parts->slice(0, -1)->implode(' '),
        ];
    }

    /**
     * Compare two names for sorting.
     *
     * Returns:
     *   -1 if $a should come before $b
     *    0 if $a and $b are equal
     *    1 if $a should come after $b
     */
    private function compareNames(array $a, array $b): int
    {
        // First, compare by last name (case-insensitive)
        $lastNameA = Str::lower($a['lastName']);
        $lastNameB = Str::lower($b['lastName']);

        if ($lastNameA !== $lastNameB) {
            return $lastNameA <=> $lastNameB;
        }

        // If last names are the same, compare by given names
        $givenNamesA = Str::lower($a['givenNames']);
        $givenNamesB = Str::lower($b['givenNames']);

        return $givenNamesA <=> $givenNamesB;
    }
}
