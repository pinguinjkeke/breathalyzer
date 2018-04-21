<?php

namespace Tests;

use Breathalyzer\Breathalyzer;
use PHPUnit\Framework\TestCase;

class BreathalyzerTest extends TestCase
{
    /** @test */
    public function it_throws_runtime_exception_if_input_file_is_not_found()
    {
        $this->expectException(\RuntimeException::class);

        $path = __DIR__ . '/Some$hing__THA7_N3VER_EXIST$.txt';

        new Breathalyzer($path, $path);
    }

    /** @test */
    public function it_throws_runtime_exception_if_vocabulary_file_is_not_found()
    {
        $this->expectException(\RuntimeException::class);

        $inputPath = __DIR__ . '/Stubs/input';
        $vocabularyPath = __DIR__ . '/Some$hing__THA7_N3VER_EXIST$.txt';

        new Breathalyzer($inputPath, $vocabularyPath);
    }

    /** @test */
    public function it_returns_distance_for_provided_input_by_vocabulary()
    {
        $inputPath = __DIR__ . '/Stubs/input';
        $vocabularyPath = __DIR__ . '/Stubs/vocabulary';
        $breathalyzer = new Breathalyzer($inputPath, $vocabularyPath);

        $distance = $breathalyzer->getDistance();

        $this->assertEquals(1, $distance);
    }
}
