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
    public function it_reads_vocabulary_wo_any_new_lines()
    {
        $vocabulary = $this->initVocabulary();

        $data = $vocabulary->getVocabulary();

        $this->assertCount(3, $data);
        $this->assertEquals(['HELLO', 'WORLD', 'HELL'], $data);
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

    private function initVocabulary(): Vocabulary
    {
        $path = __DIR__ . '/Stubs/vocabulary';

        return new Vocabulary($path);
    }
}
