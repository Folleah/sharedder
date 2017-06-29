<?php

namespace Folleah\Sharedder;

class SharedMemory
{
    private $segments = [];

    /**
     * 
     */
    public function set($identifier = null, $value)
    {
        if(is_null($identifier)) {
            $identifier = random_bytes(10);
        }

        if(!is_string($identifier)) {
            return false;
        }

        $identifier = $this->stringToInt($identifier);

        $shmem = shmop_open($this->stringToInt($identifier), "c", 0755, 1024);
        shmop_write($shmem, $value, 0);
    }

    public function get($identifier)
    {
        $shmem = shmop_open($this->stringToInt($identifier), "c", 0755, 1024);
        $size = shmop_size($shmem);

        return shmop_read($shmem, 0, $size);
    }

    

    private function stringToInt($str)
    {
        return crc32($str);
    }
}