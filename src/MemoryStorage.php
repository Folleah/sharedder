<?php

namespace Folleah\Sharedder;

use Folleah\Sharedder\MemorySegment;

class MemoryStorage
{
    private $segments = [];

    /**
     * Set shared memory segment value
     * 
     * @param $identifier String | Null - segment identifier
     * @param $value Mixed - segment value
     */
    public function set($identifier = null, $value)
    {
        if(is_null($identifier)) {
            $identifier = random_bytes(10);
        }

        if(!is_string($identifier)) {
            return false;
        }

        unset($this->segments[$identifier]);

        $value = json_encode($value);

        $size = strlen($value);

        $this->segments[$identifier] = new MemorySegment(
            $identifier,
            $size
        );

        shmop_write($this->segments[$identifier]->get(), $value, 0);

        return true;
    }

    /**
     * Return current memory segment value
     * 
     * @param $identifier String
     * @return mixed
     */
    public function get($identifier)
    {
        return json_decode(
            shmop_read(
                $this->segments[$identifier]->get(), 
                0, 
                $this->segments[$identifier]->size()
            )
        );
    }

    /**
     * Add string value to end of current value
     * 
     * @param $identifier String
     * @param $value String
     * @return bool - true or false if success or fail
     */
    public function modify($identifier, $value)
    {
        if(!isset($this->segments[$identifier])) {
            return false;
        }

        $currentValue = $this->get($identifier);

        $currentValue .= $value;

        return $this->set($identifier, $currentValue);
    }
}