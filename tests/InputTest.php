<?php

namespace Tests;

use Breathalyzer\Input;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_if_file_not_found()
    {
        $this->expectException(\RuntimeException::class);

        $path = __DIR__ . '/Some$hing__THA7_N3VER_EXIST$.txt';

        new Input($path);
    }

    /** @test */
    public function it_reads_and_normalizes_input()
    {
        $path = __DIR__ . '/Stubs/input';
        $input = new Input($path);

        $data = $input->getInput();

        $this->assertCount(2, $data);
        $this->assertEquals($data, ['HELLO', 'WOORLD']);
    }
}
