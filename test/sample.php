<?php

require_once '../lib/class.cache.php';

$cache = new Yaseek\Cache( __DIR__ . '/cache', 10);

//echo __DIR__ . '/cache' . PHP_EOL;

$key = md5('{"simple": "json string"}');

echo 'GET DATA' . PHP_EOL;
$data = $cache->getData($key);
if (!isset($data)) {
    echo 'SAVE DATA' . PHP_EOL;
    $data = new stdClass();
    $data->simple = 'data';
    $cache->saveData($key, $data);
}

var_dump($data);