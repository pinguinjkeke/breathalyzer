<?php

require __DIR__ . '/vendor/autoload.php';

$inputPath = __DIR__ . '/' . $argv[1];
$vocabularyPath = __DIR__ . '/vocabulary.txt';

try {
    $breathalyzer = new \Breathalyzer\Breathalyzer($inputPath, $vocabularyPath);

    echo $breathalyzer->getDistance() . PHP_EOL;
} catch (RuntimeException $e) {
    echo 'File not found' . PHP_EOL;
}
