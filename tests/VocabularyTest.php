<?php

namespace Tests;

use Breathalyzer\Vocabulary;
use PHPUnit\Framework\TestCase;

class VocabularyTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_if_file_is_not_found()
    {
        $this->expectException(\RuntimeException::class);

        $path = __DIR__ . '/Some$hing__THA7_N3VER_EXIST$.txt';

        new Vocabulary($path);
    }

    /** @test */
    public function it_reads_vocabulary_into_map_by_length()
    {
        $vocabulary = $this->initVocabulary();

        $data = $vocabulary->getVocabulary();

        $this->assertCount(3, $data);
        $this->assertEquals([
            5 => ['HELLO', 'WORLD'],
            4 => ['HELL'],
            6 => ['CREATE'],
        ], $data);
    }

    /** @test */
    public function it_checks_if_word_exists_in_vocabulary()
    {
        $vocabulary = $this->initVocabulary();

        $exists = $vocabulary->has('HELLO');
        $notExists = $vocabulary->has('BYE');

        $this->assertTrue($exists);
        $this->assertFalse($notExists);
    }

    /** @test */
    public function it_calculates_and_returns_minimal_length_of_vocabulary_map()
    {
        $vocabulary = $this->initVocabulary();

        $minimalLength = $vocabulary->getMinimalLength();

        $this->assertEquals(4, $minimalLength);
    }

    /** @test */
    public function it_returns_empty_array_if_map_by_length_is_not_exists()
    {
        $vocabulary = $this->initVocabulary();

        $wordsByLength = $vocabulary->getWordsOfLength(10);

        $this->assertEmpty($wordsByLength);
    }

    /** @test */
    public function it_returns_words_by_length()
    {
        $vocabulary = $this->initVocabulary();

        $wordsByLength = $vocabulary->getWordsOfLength(5);

        $this->assertCount(2, $wordsByLength);
        $this->assertEquals(['HELLO', 'WORLD'], $wordsByLength);
    }

    /** @test */
    public function it_returns_words_by_length_with_offset()
    {
        $vocabulary = $this->initVocabulary();

        $wordsByLength = $vocabulary->getWordsOfLength(5, 1);
        $this->assertCount(2, $wordsByLength);
        $this->assertEquals(['HELL', 'CREATE'], $wordsByLength);
    }

    private function initVocabulary(): Vocabulary
    {
        $path = __DIR__ . '/Stubs/vocabulary';

        return new Vocabulary($path);
    }
}
