<?php

use Fcosrno\Exam\HtmlGenerator;

class HtmlGeneratorTest extends PHPUnit_Framework_TestCase
{
	public function testConstructionHtmlGenerator() {
		$html = new HtmlGenerator(array(
				0=>array(
					'stem'=>'Is this a question?',
					'choices'=>array('True','False'),
					'type'=>'multiple',
					'answer'=>'True'
					)
				));
		$this->assertEquals(get_class($html), "Fcosrno\Exam\HtmlGenerator");
	}
	public function testSelectHtml() {
		$html = new HtmlGenerator(array(
				0=>array(
					'stem'=>'Select things you may see at nighttime',
					'choices'=>array('Stars','Sun','Moon'),
					'type'=>'select'
					)
				));
		$this->assertEquals($html,'<p>Select things you may see at nighttime</p><div class="checkbox"><label><input type="checkbox" name="answer1[]" value="Stars">Stars</label></div><div class="checkbox"><label><input type="checkbox" name="answer1[]" value="Sun">Sun</label></div><div class="checkbox"><label><input type="checkbox" name="answer1[]" value="Moon">Moon</label></div>');
	}
	public function testMultipleHtml() {
		$html = new HtmlGenerator(array(
				0=>array(
					'stem'=>'Is the sky blue?',
					'choices'=>array('Always','Never','Sometimes'),
					'type'=>'multiple'
					)
				));
		$this->assertEquals($html,'<p>Is the sky blue?</p><div class="radio"><label><input type="radio" name="answer1" value="Always">Always</label></div><div class="radio"><label><input type="radio" name="answer1" value="Never">Never</label></div><div class="radio"><label><input type="radio" name="answer1" value="Sometimes">Sometimes</label></div>');
	}
}