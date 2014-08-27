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
class Grade
{
	private $questions,$questionKey,$score;
	function __construct($questions)
	{
		$this->questions = $questions;
		$this->score = new Score;
	}
	public function __toString()
	{
		return $this->asPercent();
	}
	public function asPercent()
	{
		return (string)$this->score->getPercent();
	}
	public function asPercentage()
	{
		return $this->score->getPercentage();
	}
	public function asDecimal()
	{
		return $this->score->getDecimal();
	}
	public function asFraction()
	{
		return $this->score->getFraction();
	}
	public function answers()
	{
		$answers = func_get_args();
		if(is_array($answers[0]))$answers=array_shift($answers);
		foreach ($this->questions as $key=>$n) {
			// If no answer submitted, default to blank
			if(empty($answers[$key]))$answers[$key]='';
			// Check if answer is correct
			$score = $this->question($n['stem'])->submittedAnswer($answers[$key]);
			// Add the score
			$this->score->add($score);
		}
		return $this;
	}
	public function question($question)
	{
		$this->questionKey=$this->getId($question);
		return $this;
	}
	public function isCorrect($questionKey,$submittedAnswer)
	{
		if(!empty($submittedAnswer)){
			// Compare arrays in the case of select all. Otherwise, compare answer as string.
			if(is_array($this->questions[$questionKey]['answer'])){
				$diff = array_diff($this->questions[$questionKey]['answer'],$submittedAnswer);
				if(empty($diff))return true;
			}else{
				if($this->questions[$questionKey]['answer']==$submittedAnswer)return true;
			}
		}
	}
	public function submittedAnswer($answer)
	{
		return $this->isCorrect($this->questionKey,$answer);
	}
	public function getId($question)
	{
		foreach ($this->questions as $key=>$n) {
			if($n['stem']==$question)return $key;
		}
	}
}
?>