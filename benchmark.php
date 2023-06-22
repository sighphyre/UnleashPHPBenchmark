<?php

require __DIR__ . '/vendor/autoload.php';

use Unleash\Client;
use Unleash\Client\UnleashContext;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

use Unleash\Client\UnleashBuilder;

// Read the toggle name from an env var or a default value
$toggleName = getenv('TOGGLE_NAME') ?: 'another';
$apiKey = getenv('API_KEY');
$iterations = getenv('ITERATIONS') ?: 1000000;

$filesystemAdapter = new FilesystemAdapter(
    namespace: '',
    defaultLifetime: 0,
    directory: sys_get_temp_dir() . '/unleash/unleash-cache'
);


echo "Cache directory: " . sys_get_temp_dir() . "/unleash/unleash-cache\n";

$cache = new Psr16Cache($filesystemAdapter);

$unleash = UnleashBuilder::create()
    ->withAppName("app")
    ->withAppUrl("http://localhost:4242/api")
    ->withInstanceId("instance")
    ->withMetricsEnabled(false)
    ->withAutomaticRegistrationEnabled(false)
    ->withCacheHandler($cache)
    ->withCacheTimeToLive(10)
    ->withHeader('Authorization', $apiKey)
    ->build();

$startTime = microtime(true);

for ($i = 0; $i < $iterations; $i++) {
    $enabled = $unleash->isEnabled($toggleName);
}

$endTime = microtime(true);

$elapsedTime = $endTime - $startTime;

echo "Time elapsed: " . $elapsedTime . " seconds.\n";