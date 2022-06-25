<?php


namespace App\Service;


abstract class GeometryCalculator
{
	abstract public function sumArea();
	abstract public function sumDiameters();
}