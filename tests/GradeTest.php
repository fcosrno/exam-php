<?php

use Fcosrno\Exam\Grade;

class GradeTest extends PHPUnit_Framework_TestCase
{
	private $questions,$g;
	public function __construct()
	{
		$this->questions = array( 
			array(
				'stem'=>'Select things you may see at nighttime',
				'choices'=>array('Stars','Sun','Moon'),
				'type'=>'select',
				'answer'=>array('Stars','Moon'),
				),
			array(
				'stem'=>'Is the sky blue?',
				'choices'=>array('Always','Never','Sometimes'),
				'type'=>'multiple',
				'answer'=>'Sometimes',
				),
			array(
				'stem'=>'Is this a question?',
				'choices'=>array('True','False'),
				'type'=>'multiple',
				'answer'=>'True'
				),
		);
		$this->g = new Grade($this->questions);
	}
	public function testConstructionGrade() {
		$this->assertEquals(get_class($this->g), "Fcosrno\Exam\Grade");
	}
	public function testCorrectAnswerAsPercent()
	{
		$correct = $this->g->answers(array(array('Stars','Moon'),'Sometimes','True'));
		$this->assertEquals($correct, "100%");
	}
	public function testCorrectAnswerAsPercentage()
	{
		$correct = $this->g->answers(array(array('Stars','Moon'),'Sometimes','True'))->asPercentage();
		$this->assertEquals($correct, "100");
	}
	public function testCorrectAnswerAsDecimal()
	{
		$correct = $this->g->answers(array(array('Stars'),'Sometimes','True'))->asDecimal();
		$this->assertEquals($correct, "0.66666666666666663");
	}
	public function testCorrectAnswerAsFraction()
	{
		$correct = $this->g->answers(array(array('Stars'),'Sometimes','True'))->asFraction();
		$this->assertEquals($correct, "2 / 3");
	}
	public function testIncorrectAnswer()
	{
		$correct = $this->g->answers(array(array('Stars'),'Sometimes','True'));
		$this->assertEquals($correct, "67%");
	}
	public function testGetId()
	{
		$id = $this->g->getId('Is the sky blue?');
		$this->assertEquals($id,'1');
	}
}