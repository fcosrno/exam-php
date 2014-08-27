<?php

use Fcosrno\Exam\Exam;

class ExamTest extends PHPUnit_Framework_TestCase
{
	public function dataArrays($type)
	{
		$arrays=array(
			'truefalse'=>array(
				0=>array(
					'stem'=>'Is this a question?',
					'choices'=>array('True','False'),
					'type'=>'multiple',
					'answer'=>'True'
					)
				),
			'select'=>array(
				0=>array(
					'stem'=>'Select things you may see at nighttime',
					'choices'=>array('Stars','Sun','Moon'),
					'type'=>'select',
					'answer'=>null,
					)
				),
			'multiple'=>array(
				0=>array(
					'stem'=>'Is the sky blue?',
					'choices'=>array('Always','Never','Sometimes'),
					'type'=>'multiple',
					'answer'=>null
					)
				),
		);
		return $arrays[$type];
	}
	public function testConstructionExam() {
		$exam = new Exam();
		$this->assertEquals(get_class($exam), "Fcosrno\Exam\Exam");
	}
	public function testExamAttributeExists()
	{
		$exam = new Exam();
		// Add question
		$exam->ask('Is this a question?')->truefalse();
		// Assert
		$this->assertObjectHasAttribute('question',$exam);
	}
	public function testQuestionAttributeCount()
	{
		$exam = new Exam();
		// Add questions
		$exam->ask('One')->truefalse('true');
		$exam->ask('Two')->setChoices('1','2');
		$exam->ask('Three')->setSelections('1','2');
		$exam->ask('Four')->setType('multiple')->setSelections('1','2');
		// Assert
		$this->assertCount(4,$exam->getQuestions());
	}
	public function testTrueFalseCreation()
	{
		$exam = new Exam();
		// Add question
		$exam->ask('Is this a question?')->truefalse('true');
		// Assert
		$this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('truefalse'));
	}
	public function testTrueFalseAlternativeCreation()
	{
		$exam = new Exam();
		// Add question
		$exam->ask('Is this a question?')->truefalse()->setAnswer('True');
		// Assert
		$this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('truefalse'));
	}
	public function testTrueFalseFallbackCreation()
	{
		$exam = new Exam();
		// Add question
		$exam->ask('Is this a question?')->setChoices('True','False')->setAnswer('True');
		// Assert
		$this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('truefalse'));
	}
	public function testSelectQuickCreation(){
		$exam = new Exam();
		// Add question
		$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon');
		// Assert
		$this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('select'));
	}
	public function testSelectFallbackCreation(){
		$exam = new Exam();
		// Add question
		$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon')->setType('select');
		// Assert
		$this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('select'));
	}
	public function testSelectFallbackCreationWithChoices(){
		$exam = new Exam();
		// Add question
		$exam->ask('Select things you may see at nighttime')->setChoices('Stars','Sun','Moon')->setType('select');
		// Assert
		$this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('select'));
	}
	public function testSelectFallbackCreationFlipped(){
		$exam = new Exam();
		// Add question
		$exam->ask('Select things you may see at nighttime')->setType('select')->setSelections('Stars','Sun','Moon');
		// Assert
		$this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('select'));
	}
	public function testMultipleChoiceQuickCreation()
    {
    	$exam = new Exam();
		// Add question
		$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes');
        // Assert
        $this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('multiple'));
    }
    public function testMultipleChoiceFallbackCreation(){
    	$exam = new Exam();
		// Add question
		$exam->ask('Is the sky blue?')->setType('multiple')->setChoices('Always','Never','Sometimes');
		// Assert
        $this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('multiple'));
    }
    public function testMultipleChoiceFallbackCreationWithSelections(){
		$exam = new Exam();
		// Add question
		$exam->ask('Is the sky blue?')->setType('multiple')->setSelections('Always','Never','Sometimes');
		// Assert
        $this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('multiple'));
    }
    public function testMultipleChoiceFallbackCreationWithSelectionsFlipped(){
		$exam = new Exam();
		// Add question
		$exam->ask('Is the sky blue?')->setSelections('Always','Never','Sometimes')->setType('multiple');
		// Assert
        $this->assertEquals($exam->getQuestionsArray(),$this->dataArrays('multiple'));
    }
    public function testExamGrade()
    {
		$exam = new Exam();
		$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');
		$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon')->setAnswer('Stars','Moon');
		$exam->ask('Is this a question?')->truefalse('true');
		$answers = array('Sometimes',array('Stars','Moon'),'True');
		// Assert
		$this->assertEquals($exam->grade($answers),'100%');
    }
    public function testExamGenerate()
    {
		$exam = new Exam();
		$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');
		$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon')->setAnswer('Stars','Moon');
		$exam->ask('Is this a question?')->truefalse('true');
		// Assert
		$this->assertEquals($exam->generateHtml(),'<p>Is the sky blue?</p><div class="radio"><label><input type="radio" name="answer1" value="Always">Always</label></div><div class="radio"><label><input type="radio" name="answer1" value="Never">Never</label></div><div class="radio"><label><input type="radio" name="answer1" value="Sometimes">Sometimes</label></div><p>Select things you may see at nighttime</p><div class="checkbox"><label><input type="checkbox" name="answer2[]" value="Stars">Stars</label></div><div class="checkbox"><label><input type="checkbox" name="answer2[]" value="Sun">Sun</label></div><div class="checkbox"><label><input type="checkbox" name="answer2[]" value="Moon">Moon</label></div><p>Is this a question?</p><div class="radio"><label><input type="radio" name="answer3" value="True">True</label></div><div class="radio"><label><input type="radio" name="answer3" value="False">False</label></div>');
    }
}