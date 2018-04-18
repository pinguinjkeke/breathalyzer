<?php

namespace Breathalyzer;

use SplFileObject;

class Input
{
    /** @var string */
    private $path;

    /** @var array */
    private $words = [];

    /**
     * Input constructor.
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
     * Read input from path.
     *
     * @return void
     * @throws \RuntimeException
     * @throws \LogicException
     */
    private function read(): void
    {
        $file = new SplFileObject($this->path);

        $this->words = $this->normalizeInput($file->fgets());
    }

    /**
     * Separate input by group of spaces and remove empty elements.
     *
     * @param string $input
     * @return array
     */
    private function normalizeInput(string $input): array
    {
        return array_filter(
            preg_split('/\s+/', $input)
        );
    }

    /**
     * Get input words.
     *
     * @return array
     */
    public function getInput(): array
    {
        return $this->words;
    }
}
