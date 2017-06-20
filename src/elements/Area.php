<?php

namespace BD\pdf\elements;

use BD\pdf\exceptions\InvalidConfigException;

class Area
{
    public $x;
    public $y;
    public $w;
    public $h;

    public function __construct($area = [])
    {
        foreach (['x', 'y', 'w', 'h'] as $k) {
            if (!isset($area[$k])) {
                throw new InvalidConfigException(sprintf('$area[\'%s\'] must be set.', $k));
            }
        }

        $this->x = 
        $this->x = $area['x'];
        $this->y = $area['y'];
        $this->w = $area['w'];
        $this->h = $area['h'];
    }

    public function toArray()
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'w' => $this->w,
            'h' => $this->h,
        ];
    }
}