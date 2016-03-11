<?php
/**
 * Created by PhpStorm.
 * User: AyGLR
 * Date: 10/03/16
 * Time: 17:30.
 */

namespace Hoathis\Geofencing;

final class GeoPoint extends Point
{
    /**
     * GeoPoint constructor.
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        parent::__construct($longitude, $latitude);
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->y;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->x;
    }
}
