<?php

namespace Folleah\Sharedder;

class MemorySegment
{
    private $identifier;
    private $segment;

    /**
     * Create memory segment instance
     * 
     * @param $identifier String
     * @param $size Integer
     */
    public function __construct($identifier, $size)
    {
        $this->identifier = $this->stringToInt($identifier);
        $this->segment = shmop_open($this->identifier, "c", 0755, $size);
    }

    /**
     * @return resource memory instance
     */
    public function get()
    {
        return $this->segment;
    }

    /**
     * Convert string to integer for valid shmop identify
     */
    private function stringToInt($str)
    {
        return crc32($str);
    }

    public function __destruct()
    {
        shmop_delete($this->segment);
        shmop_close($this->segment);
    }

    /**
     * @return Integer - size of shmop instance
     */
    public function size()
    {
        return shmop_size($this->segment);
    }
}