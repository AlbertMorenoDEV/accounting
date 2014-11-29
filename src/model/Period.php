<?php
namespace accounting\model;

class Period
{
	private $startDate;
	private $endDate;

	public function __construct(\DateTime $startDate, \DateTime $endDate)
	{
		if ($endDate < $startDate) {
			throw new \RuntimeException("The end date of the period may not be less than the initial");
		}
		$this->startDate = $startDate;
		$this->endDate = $endDate;
	}
	
	public function getStartDate()
	{
		return $this->startDate;
	}
	
	public function getEndDate()
	{
		return $this->endDate;
	}

	public static function fromString($startDate, $endDate)
	{
		$startDate = new \DateTime($startDate);
		$endDate = new \DateTime($endDate);
		return new self($fecha_ini, $endDate);
	}
}