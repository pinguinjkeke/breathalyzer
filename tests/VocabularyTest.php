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
        $path = __DIR__ . '/Stubs/vocabulary';
        $vocabulary = new Vocabulary($path);

        $data = $vocabulary->getVocabulary();

        $this->assertCount(3, $data);
        $this->assertEquals(['HELLO', 'WORLD', 'HELL'], $data);
    }
}
