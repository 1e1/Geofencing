<?php
/**
 * Created by PhpStorm.
 * User: AyGLR
 * Date: 10/03/16
 * Time: 17:30.
 */

namespace Hoathis\Geofencing;

class Point
{
    /**
     * @var float
     */
    public $y;

    /**
     * @var float
     */
    public $x;

    /**
     * Point constructor.
     *
     * @param float $x
     * @param float $y
     */
    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param Point Point
     * @param float $precision
     *
     * @return bool
     */
    public function almostEquals(self $point, float $precision): bool
    {
        return abs($this->x - $point->x) <= $precision
            && abs($this->y - $point->y) <= $precision
            ;
    }
}
