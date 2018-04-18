<?php

namespace Breathalyzer;

use SplFileObject;

class Vocabulary
{
    /** @var string */
    private $path;

    /** @var array */
    private $vocabulary = [];

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
            $this->vocabulary[] = $line;
        }
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
}
