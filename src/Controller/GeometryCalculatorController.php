<?php

namespace App\Controller;

use App\Entity\Circle;
use App\Entity\Triangle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

class GeometryCalculatorController extends AbstractController
{
	#[Route('/triangle/{a}/{b}/{c}', name : 'app_geometry_calculator.triangle', methods : ['GET'])]
	public function calculateTriangle($a, $b, $c): Response
	{
		$constraints = new Assert\Collection([
			'a' => new Assert\Required([new Assert\PositiveOrZero()]),
			'b' => new Assert\Required([new Assert\PositiveOrZero()]),
			'c' => new Assert\Required([new Assert\PositiveOrZero()]),
		]);
		$validator = Validation::createValidator();
		$violations = $validator->validate(['a' => $a, 'b' => $b, 'c' => $c], $constraints);
		if ($violations->count() > 0) {
			/** @var ConstraintViolation $violation */
			foreach ($violations as $violation) {
				return $this->json("error " . $violation->getInvalidValue() . " " . $violation->getMessage());
			}
		}
		
		if (!is_numeric($a) or !is_numeric($b) or !is_numeric($c)) {
			return $this->json("please send numeric data for triangle");
		}
		
		if ($a + $b <= $c or $a + $c <= $b or $b + $c <= $a) {
			return $this->json("Not valid Triangle");
		}
		
		$triangle = new Triangle($a, $b, $c);
		
		return $this->json([
			"type" => "triangle",
			"a" => (float)(number_format((float)$a, 1)),
			"b" => (float)(number_format((float)$b, 1)),
			"c" => (float)(number_format((float)$c, 1)),
			"surface" => (float)number_format($triangle->sumAreas(), 2),
			"circumference" => (float)number_format($triangle->sumDiameters(), 2),
		]);
	}
	
	#[Route('/circle/{radius}', name : 'app_geometry_calculator.circle', methods : ['GET'])]
	public function calculateCircle($radius): Response
	{
		if (!is_numeric($radius)) {
			return $this->json("please send numeric data for circle radius");
		}
		
		$constraints = new Assert\Collection([
			'radius' => new Assert\Required([new Assert\Positive()]),
		]);
		$validator = Validation::createValidator();
		$violations = $validator->validate(['radius'=>$radius], $constraints);
		if ($violations->count() > 0) {
			/** @var ConstraintViolation $violation */
			foreach ($violations as $violation) {
				return $this->json("error " . $violation->getInvalidValue() . " " . $violation->getMessage());
			}
		}
		
		$circle = new Circle($radius);
		
		return $this->json([
			"type" => "circle",
			"radius" => (float)number_format((float)$radius, 2),
			"surface" => (float)number_format($circle->sumAreas(), 2),
			"circumference" => (float)number_format($circle->sumDiameters(), 2),
		]);
	}
}
