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

final class Geofencing
{
    const OUTSIDE = -1;
    const BOUNDARY = 0;
    const INSIDE = 1;

    /**
     * @var Point[]
     */
    private $points;

    public function __construct()
    {
        $this->points = [];
    }

    /**
     * @param Point $point
     *
     * @return self
     */
    public function addPoint(Point $point): self
    {
        $this->points[] = $point;

        return $this;
    }

    /**
     * @param array $points
     * @param bool  $autoClose
     *
     * @return self
     */
    public function setPoints(array $points, bool $autoClose = true): self
    {
        $this->points = $points;

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
        return isset($this->points[2])
            && reset($this->points) == end($this->points)
            ;
    }

    /**
     * @return self
     */
    public function close(): self
    {
        if (!$this->isClosed()) {
            $this->points[] = reset($this->points);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return count($this->points) - 1;
    }

    /**
     * @param Point $point
     *
     * @return int
     */
    public function getPosition(Point $point): int
    {
        $intersections = 0;
        $index = 0;
        $length = $this->getSize();

        while ($index < $length) {
            $point1 = $this->points[$index];
            $point2 = $this->points[++$index];

            $x = $point->x;
            $y = $point->y;

            $x1 = $point1->x;
            $y1 = $point1->y;

            $x2 = $point2->x;
            $y2 = $point2->y;

            if ($x1 < $x2) {
                $x_min = $x1;
                $x_max = $x2;
            } else {
                $x_min = $x2;
                $x_max = $x1;
            }

            // check if point is on an horizontal polygon boundary
            if ($y1 === $y2 && $y1 === $y && $x > $x_min && $x < $x_max) {
                return self::BOUNDARY;
            }

            if ($y1 < $y2) {
                $y_min = $y1;
                $y_max = $y2;
            } else {
                $y_min = $y2;
                $y_max = $y1;
            }

            if ($y > $y_min && $y <= $y_max && $x <= $x_max && $y1 !== $y2) {
                $xi = ($y - $y1) * ($x2 - $x1) / ($y2 - $y1) + $x1;

                // check if point is on the polygon boundary (other than horizontal)
                if ($xi === $x) {
                    return self::BOUNDARY;
                }

                if ($x1 === $x2 || $x <= $xi) {
                    ++$intersections;
                }
            }
        }

        // if the number of edges we passed through is odd, then it's in the polygon.
        return (0 === $intersections % 2)
            ? self::OUTSIDE
            : self::INSIDE
            ;
    }
}
