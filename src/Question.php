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
class Question
{
	private $stem,$choices,$type,$answer;

	public function argsToArray()
	{
		$args = func_get_args();
		if(is_array($args[0]))$args=array_shift($args);
		if(count($args)==1)$args = $args[0];
		return $args;
	}
	public function setStem($string)
	{
		$this->stem=$string;
		return $this;
	}
	public function setChoices()
	{
		$this->choices=$this->argsToArray(func_get_args());
		if(empty($this->type))$this->type='multiple';
		return $this;
	}
	public function setSelections()
	{
		if(empty($this->type))$this->type='select';
		$this->setChoices($this->argsToArray(func_get_args()));
		return $this;
	}
	public function setAnswer()
	{
		$this->answer=$this->argsToArray(func_get_args());
		return $this;
	}
	public function setType($type)
	{
		$this->type=$type;
		return $this;
	}
	public function truefalse($answer=null)
	{
		if(!empty($answer))$this->setChoices('True','False')->setAnswer(ucwords(strtolower($answer)));
		else $this->setChoices('True','False');
		return $this;
	}
	public function asArray()
    {
    	$array = array();
    	$keys = array_keys(get_class_vars(get_class($this)));
    	foreach($keys as $attr){
    		$array[$attr] = $this->{'get'.ucwords($attr)}();
    	}
    	return $array;
    }
	public function getStem()
	{
		return $this->stem;
	}
	public function getChoices()
	{
		return $this->choices;
	}
	public function getSelections()
	{
		return $this->choices;
	}
	public function getAnswer()
	{
		return $this->answer;
	}
	public function getType()
	{
		return $this->type;
	}
}
?>