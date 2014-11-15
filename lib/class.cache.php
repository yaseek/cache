<?php
namespace Yaseek;

class Cache {

    const HOUR = 3600;
    const EXT = '.json';

    private $path;
    private $duration;

    /*
    *   $abspath -- absolute path of the cache dir
    *   $duration -- expiration time in seconds
    */
    public function __construct($abspath, $duration = self::HOUR) {
        $this->path = $abspath;
        $this->duration = $duration;

        if (!is_dir($abspath)) {
            mkdir($abspath, 666, TRUE);
        }
    }

    /*
    *   $key -- various string for file name
    *
    *   function returns data portion of the cached data
    *   if no cached data or data expired it returns unset value
    */
    public function getData($key) {
        $filename = $this->path . '/' . $key . self::EXT;
        if (file_exists($filename)) {
            $dataBlock = json_decode(file_get_contents($filename));
            if ($dataBlock && $dataBlock->expiration > time()) {
                return $dataBlock->data;
            }
        }
    }

    public function saveData($key, $data) {
        $dataBlock = new \stdClass();
        $dataBlock->expiration = time() + $this->duration;
        $dataBlock->data = $data;
        return file_put_contents($this->path . '/' . $key . self::EXT, json_encode($dataBlock));
    }
}