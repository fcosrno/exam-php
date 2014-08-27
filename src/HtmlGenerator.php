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
class HtmlGenerator
{
	protected $html,$questions,$questionKey;
	function __construct($questionsArray)
	{
		$this->html = null;
		$this->questions = $questionsArray;
	}
	public function __toString()
	{
		// Define library of types to form types
		$formTypes = array(
			'multiple'=>'radio',
			'select'=>'checkbox'
		);
		foreach ($this->questions as $key => $q) {
			// If checkbox, name needs to be an array
			if($formTypes[$q['type']]=='checkbox')$name = 'answer'.($key+1).'[]';
			else $name = 'answer'.($key+1);
			// Display question
			$this->html .= '<p>'.$q['stem'].'</p>';
			// Loop through choices to display
			foreach($q['choices'] as $choice){
				$this->html .= '<div class="'.$formTypes[$q['type']].'">';
				$this->html .= '<label><input type="'.$formTypes[$q['type']].'" name="'.$name.'" value="'.$choice.'">'.$choice.'</label>';
				$this->html .= '</div>';
			}
		}
		// Return HTML string
		return $this->html;
	}
}

?>