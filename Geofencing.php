<?php
/**
 * Created by PhpStorm.
 * User: AyGLR
 * Date: 10/03/16
 * Time: 17:30.
 */

namespace Hoathis\Geofencing;

final class Geofencing
{
    /**
     * @var GeoPoint[]
     */
    private $geoPoints;

    public function __construct()
    {
        $this->geoPoints = [];
    }

    /**
     * @param GeoPoint $geoPoint
     *
     * @return self
     */
    public function addGeoPoint(GeoPoint $geoPoint): self
    {
        $this->geoPoints[] = $geoPoint;

        return $this;
    }

    /**
     * @param array $geoPoints
     * @param bool  $autoClose
     *
     * @return self
     */
    public function setGeoPoints(array $geoPoints, bool $autoClose = true): self
    {
        $this->geoPoints = $geoPoints;

        if (true === $autoClose) {
            $this->close();
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        $firstGeoPoint = reset($this->geoPoints);
        $lastGeoPoint = end($this->geoPoints);

        return isset($this->geoPoints[2])
            && $firstGeoPoint->equals($lastGeoPoint);
    }

    /**
     * @return self
     */
    public function close(): self
    {
        if (!$this->isClosed()) {
            $this->geoPoints[] = reset($this->geoPoints);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): integer
    {
        return count($this->geoPoints) - 1;
    }

    /**
     * @param GeoPoint $geoPoint
     *
     * @return bool
     */
    public function isInclude(GeoPoint $geoPoint): bool
    {
        $isInclude = false;
        $nbPoints = count($this->geoPoints);

        for ($i = 0, $j = $nbPoints; $i < $nbPoints; $j = $i++) {
            $p = $i;

            if ($nbPoints === $p) {
                $p = 0;
            }

            $cornerA = $this->geoPoints[$p];
            $cornerB = $this->geoPoints[$j];

            if (($cornerA->latitude  >  $geoPoint->latitude) !== ($cornerB->latitude > $geoPoint->latitude)) {
                $tg = ($cornerB->longitude - $cornerA->longitude)
                    * ($geoPoint->latitude - $cornerA->latitude)
                    / ($cornerB->latitude - $cornerA->latitude)
                    + $cornerA->longitude
                ;

                if ($geoPoint->longitude < $tg) {
                    $isInclude = !$isInclude;
                }
            }
        }

        return $isInclude;
    }
}
