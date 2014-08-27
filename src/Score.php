<?php 
/**
 * This file is part of the Exam library
 *
 * Copyright (c) 2014 Francisco Serrano <fserrano@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fcosrno\Exam;
class Score
{
	private $correct,$incorrect;
	public function __construct()
	{
		$this->correct = $this->incorrect = 0;
	}
	public function add($bool)
	{
		if($bool)$this->correct++;
		else $this->incorrect++;
	}
	public function getCorrect()
	{
		return $this->correct;
	}
	public function getIncorrect()
	{
		return $this->incorrect;
	}
	public function getDecimal()
	{
		return $this->correct/($this->correct+$this->incorrect);	
	}
	public function getPercentage()
	{
		return round( (float) ($this->correct/($this->correct+$this->incorrect)) * 100);
	}
	public function getPercent()
	{
		return $this->getPercentage().'%';
	}
	public function getFraction()
	{
		return $this->correct.' / '.($this->correct+$this->incorrect);
	}
}
?>