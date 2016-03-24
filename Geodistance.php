<?php
/**
 * Created by PhpStorm.
 * User: AyGLR
 * Date: 10/03/16
 * Time: 17:30.
 *
 *
 * source: http://assemblysys.com/php-point-in-polygon-algorithm/
 */

namespace Hoathis\Geofencing;

final class Geodistance
{
    const METER = 0;
    const MILE = 1;
    const NAUTIC = 2;

    /**
     * @var Point
     */
    private $origin;

    /**
     * @var int
     */
    private $unit;

    public function __construct()
    {
        $this->origin = null;
        $this->unit = self::METER;
    }

    /**
     * @param Point $point
     *
     * @return self
     */
    public function setOrigin(Point $point): self
    {
        $this->origin = $point;

        return $this;
    }

    /**
     * @return Point
     */
    public function getOrigin(): Point
    {
        return $this->origin;
    }

    /**
     * @param int $unit
     * @return self
     */
    public function setUnit(int $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnit(): int
    {
        return $this->unit;
    }

    /**
     * @param Point $point
     * @return float
     */
    public function getDistanceTo(Point $point): float
    {
        $theta = $this->origin->x - $point->x;
        $dist = sin(deg2rad($this->origin->y)) * sin(deg2rad($point->y)) +  cos(deg2rad($this->origin->y)) * cos(deg2rad($point->y)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);

        switch ($this->unit) {
            case self::METER:
                $dist *= 111189.57696;
                break;

            case self::MILE:
                $dist *= 69.09;
                break;

            case self::NAUTIC:
                $dist *= 59.997756;
                break;
        }

        return $dist;
    }
}
