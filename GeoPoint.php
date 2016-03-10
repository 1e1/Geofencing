<?php
/**
 * Created by PhpStorm.
 * User: AyGLR
 * Date: 10/03/16
 * Time: 17:30.
 */

namespace Hoathis\Geofencing;

final class GeoPoint
{
    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * GeoPoint constructor.
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @param GeoPoint $geoPoint
     *
     * @return bool
     */
    public function equals(self $geoPoint): bool
    {
        return $this->latitude === $geoPoint->latitude
            && $this->longitude === $geoPoint->longitude
            ;
    }
}
