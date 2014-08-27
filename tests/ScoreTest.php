<?php

use Fcosrno\Exam\Score;

class ScoreTest extends PHPUnit_Framework_TestCase
{
	private $s;
	public function __construct()
	{
		$this->s = new Score();
	}
	public function testConstructionGrade() {
		$this->assertEquals(get_class($this->s), "Fcosrno\Exam\Score");
	}
	public function testConstructor() {
		$this->assertEquals(($this->s->getCorrect()+$this->s->getIncorrect()),0);
	}
	public function testAddScore()
	{
		$this->s->add(true);
		$this->assertEquals($this->s->getCorrect(),'1');
	}
	public function testAddScoreWithFalse()
	{
		$this->s->add(true);
		$this->s->add(false);
		$this->s->add(true);
		$this->assertEquals($this->s->getCorrect(),2);
	}
	public function testGetIncorrect()
	{
		$this->s->add(true);
		$this->s->add(false);
		$this->s->add(true);
		$this->assertEquals($this->s->getIncorrect(),1);
	}
	public function testGetDecimal()
	{
		$this->s->add(true);
		$this->s->add(false);
		$this->s->add(true);
		$this->assertEquals($this->s->getDecimal(),'0.66666666666666663');
	}
	public function testGetFraction()
	{
		$this->s->add(true);
		$this->s->add(false);
		$this->s->add(true);
		$this->assertEquals($this->s->getFraction(),'2 / 3');
	}
	public function testGetPercentage()
	{
		$this->s->add(true);
		$this->s->add(false);
		$this->s->add(true);
		$this->assertEquals($this->s->getPercentage(),'67');
	}
}