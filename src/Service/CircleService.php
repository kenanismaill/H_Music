<?php


namespace App\Service;


class CircleService extends GeometryCalculator
{
	public function __construct(
		private $radius,
		// info:: there is M_PI = 3.1415926535898 in php
		private $p = 3.14,
	){}
	
	/**
	 * @return float
	 */
	public function sumAreas(): float
	{
		return $this->p * pow($this->radius, 2);
	}
	
	/**
	 * @return float
	 */
	public function sumDiameters(): float
	{
		return (float)(2 * $this->p * $this->radius);
	}
}