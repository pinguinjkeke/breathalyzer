<?php

namespace Breathalyzer;

use SplFileObject;

class Vocabulary
{
    /** @var string */
    private $path;

    /** @var array */
    private $vocabulary = [];

    /** @var int */
    private $minimalLength = PHP_INT_MAX;

    /** @var int */
    private $maximalLength = 0;

    /**
     * Vocabulary constructor.
     *
     * @param string $path
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $this->read();
    }

    /**
     * Read vocabulary from file.
     *
     * @return void
     * @throws \RuntimeException
     * @throws \LogicException
     */
    private function read(): void
    {
        $file = new SplFileObject($this->path);
        $file->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE);

        foreach ($file as $line) {
            $length = \strlen($line);

            $this->minimalLength = \min($this->minimalLength, $length);
            $this->maximalLength = \max($this->maximalLength, $length);

            if (!\array_key_exists($length, $this->vocabulary)) {
                $this->vocabulary[$length] = [];
            }

            $this->vocabulary[$length][] = $line;
        }
    }

    /**
     * Get minimal length.
     *
     * @return int
     */
    public function getMinimalLength(): int
    {
        return $this->minimalLength;
    }

    /**
     * Get maximal length.
     *
     * @return int
     */
    public function getMaximalLength(): int
    {
        return $this->maximalLength;
    }

    /**
     * Returns words of provided length.
     *
     * @param int $length
     * @param int $offset
     * @return array
     */
    public function getWordsOfLength(int $length, int $offset = 0): array
    {
        if ($offset !== 0) {
            return array_merge(
                $this->vocabulary[$length - $offset] ?? [],
                $this->vocabulary[$length + $offset] ?? []
            );
        }

        return $this->vocabulary[$length] ?? [];
    }

    /**
     * Get vocabulary.
     *
     * @return array
     */
    public function getVocabulary(): array
    {
        return $this->vocabulary;
    }

    /**
     * Check if word is exists in Vocabulary.
     *
     * @param string $word
     * @return bool
     */
    public function has(string $word): bool
    {
        $length = \strlen($word);

        if (!\array_key_exists($length, $this->vocabulary)) {
            return false;
        }

        return \in_array(\strtoupper($word), $this->vocabulary[$length], true);
    }
}
