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

use Fcosrno\Exam\Question;
use Fcosrno\Exam\HtmlGenerator;
use Fcosrno\Exam\Grade;

class Exam
{
	private $question,$questions;
	public function __construct() {}
	public function ask($string)
	{
		$this->question = new Question();
		$this->questions[]=$this->question;
		$this->question->setStem($string);
		return $this->question;
	}
	public function getQuestions()
	{
		return $this->questions;
	}
	public function generateHtml()
	{
		return new HtmlGenerator($this->getQuestionsArray());
	}
	public function grade($answers)
	{
		$grade = new Grade($this->getQuestionsArray());
		return $grade->answers($answers);
	}
	public function getQuestionsArray()
	{
		$array = array();
		foreach($this->getQuestions() as $n){
			$array[]=$n->asArray();
		}
		return $array;
	}
}
?>