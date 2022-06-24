<?php


namespace App\Service;


class TriangleService extends GeometryCalculator
{
	public function __construct(
		private $a,
		private $b,
		private $c,
	){}
	
	/**
	 * @return float
	 */
	public function sumAreas(): float
	{
		$s = ceil(($this->a + $this->b + $this->c) / 2);
		
		return sqrt($s * ($s - $this->a) * ($s - $this->b) * ($s - $this->c));
	}
	
	/**
	 * @return float
	 */
	public function sumDiameters(): float
	{
		return (float)($this->a + $this->b + $this->c);
	}
}