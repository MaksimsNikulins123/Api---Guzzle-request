<?php

namespace app\controllers;

use App\models\ConnectToApi;

interface CacheInterface
{
    public function get(string $key);
    public function set(string $key, $value, int $duration);
    public function delete(string $key);
    public function exists(string $key);
    public function clear(string $key);
}
class Cashe implements CacheInterface
{
    public $duration;
    public $fwrite;
    public $deletetime;
    public $timeNow;
    public $response;
    public $data;
    public $cashe_file = '../cashe/cashe.txt';
    public function connect()
    {
        $ConnectToApi = new ConnectToApi();
        $this->response = $ConnectToApi->getResponse();
        $this->data = json_decode($this->response->getBody()->getContents(), true);
    }
    public function get($key)
    {
        if ($this->exists($key)) {
            $fileContents = file_get_contents($key);
            $this->data = json_decode($fileContents, true);
        }
    }
    public function set(string $key, $value, int $duration)
    {
        if (!$this->exists($key)) {
            $fp = fopen($key, "w");
            fwrite($fp, $value);
            fclose($fp);
            $this->fwrite = filectime($key);
            $this->deletetime = $this->fwrite + $duration;
            $this->timeNow = time();
            $this->duration = $duration;
        } else {
            $this->fwrite = filectime($key);
            $this->deletetime = $this->fwrite + $duration;
            $this->timeNow = time();
            $this->duration = $duration;
            if ($this->timeNow >= $this->deletetime) {
                $this->delete($key);
            }
        }
    }

    public function delete(string $key)
    {
        unlink($key);
        clearstatcache();
    }

    public function exists(string $key)
    {
        if (file_exists($key)) {
            return true;
        } else {
            return false;
        }
    }

    public function clear($key)
    {
        unlink($key);
    }
}
