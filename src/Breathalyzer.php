<?php

namespace Breathalyzer;

class Breathalyzer
{
    /** @var \Breathalyzer\Input */
    private $input;

    /** @var \Breathalyzer\Vocabulary */
    private $vocabulary;

    /** @var array */
    private $cache = [];

    /**
     * Breathalyzer constructor.
     *
     * @param string $inputPath
     * @param string $vocabularyPath
     * @throws \RuntimeException
     * @throws \LogicException
     */
    public function __construct(string $inputPath, string $vocabularyPath)
    {
        $this->input = new Input($inputPath);
        $this->vocabulary = new Vocabulary($vocabularyPath);
    }

    /**
     * Get distance for all words.
     *
     * @return int
     */
    public function getDistance(): int
    {
        $distance = 0;
        $input = $this->input->getInput();

        foreach ($input as $word) {
            if (\array_key_exists($word, $this->cache)) {
                $distance += $this->cache[$word];

                continue;
            }

            $score = $this->distanceFromVocabulary($word);

            $this->cache[$word] = $score;
            $distance += $score;
        }

        return $distance;
    }

    /**
     * Get distance from Vocabulary.
     *
     * @param string $word
     * @return int
     */
    private function distanceFromVocabulary(string $word): int
    {
        // We don't need to search if word is already exists in vocabulary.
        if ($this->vocabulary->has($word)) {
            $this->cache[$word] = 0;

            return 0;
        }

        // This value stands for Infinity.
        $score = PHP_INT_MAX;

        $length = \min(
            \max(\strlen($word), $this->vocabulary->getMinimalLength()),
            $this->vocabulary->getMaximalLength()
        );
        $vocabulary = $this->vocabulary->getWordsOfLength($length);
        $offset = 0;

        while ($vocabulary) {
            foreach ($vocabulary as $vocabularyWord) {
                $levenshteinScore = \levenshtein($word, $vocabularyWord);

                $score = \min($score, $levenshteinScore);

                // Score equals 0 only if words is exists in dictionary. We can stop searching if score equals 1.
                if ($score <= $offset) {
                    break;
                }
            }

            // If score <= 1 we cannot improve it by increasing or decreasing searchable words length
            if ($score <= $offset + 1) {
                break;
            }

            $vocabulary = $this->vocabulary->getWordsOfLength($length, ++$offset);
        }

        return $score;
    }
}
