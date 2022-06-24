<?php


namespace App\Service;


abstract class GeometryCalculator
{
	abstract public function sumAreas();
	abstract public function sumDiameters();
}