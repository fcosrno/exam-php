<?php

use Fcosrno\Exam\Question;

class QuestionTest extends PHPUnit_Framework_TestCase
{
	protected $q;
	public function __construct()
	{
		$this->q = new Question();
		$this->q->setStem('Select things you may see at nighttime');
		$this->q->setChoices('Stars','Sun','Moon');
		$this->q->setType('select');
		$this->q->setAnswer('Stars','Moon');
	}
	public function testConstructionQuestion() {
		$this->assertEquals(get_class($this->q), "Fcosrno\Exam\Question");
	}
	public function testQuestionSetters()
	{
		$this->assertObjectHasAttribute('stem',$this->q);
		$this->assertObjectHasAttribute('choices',$this->q);
		$this->assertObjectHasAttribute('type',$this->q);
		$this->assertObjectHasAttribute('answer',$this->q);
	}
	public function testQuestionGetters()
	{
		$this->assertEquals('Select things you may see at nighttime',$this->q->getStem());
		$this->assertEquals(array('Stars','Sun','Moon'),$this->q->getChoices());
		$this->assertEquals('select',$this->q->getType());
		$this->assertEquals(array('Stars','Moon'),$this->q->getAnswer());
	}
	public function testQuestionHelpers()
	{
		$this->assertEquals('Single',$this->q->argsToArray('Single'));
		$this->assertEquals(array('Stars','Sun','Moon'),$this->q->argsToArray('Stars','Sun','Moon'));
		$this->assertEquals(array('Stars','Sun','Moon'),$this->q->argsToArray(array('Stars','Sun','Moon')));
	}
}