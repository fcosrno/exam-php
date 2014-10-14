Exam
====

PHP library to create, display, and grade exams. 

Bonus: you can use it to generate surveys (just ignore the grading feature).

[![Build Status](https://travis-ci.org/fcosrno/exam-php.svg)](https://travis-ci.org/fcosrno/exam-php) [![Latest Stable Version](https://poser.pugx.org/fcosrno/exam-php/v/stable.svg)](https://packagist.org/packages/fcosrno/exam-php)

Setup
-----

	composer require fcosrno/exam-php


Quick Usage
----

	// Create instance of exam
	$exam = new Exam();
	
	// Add your questions
	$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');
	$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon')->setAnswer('Stars','Moon');
	$exam->ask('Is this a question?')->truefalse('true');
	
	// Generate the HTML form (optional)
	$view = $exam->generateHtml();
	
	// Grade the exam
	$myAnswers = array_values($_POST);
	$percent = $exam->grade($myAnswers); // returns percent


Adding questions
---------

You can create a question by asking it.

	$exam->ask('Is the sky blue?'); 
		
However, asking a question won't work by itself. Exam needs to know the question's choices or selections. You do this by method chaining `setChoices()` or `setSelections()` to the question. 

In this example we want a multiple choice question so we'll use `setChoices()`.

	$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes');
	
If you're going to be grading this exam, then you also need to define an answer.

	$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');

Now our multiple choice question is defined. Let's render it as a form input so we can send it to the browser and ask it to the user.

	echo $exam->generateHtml();
	
Our multiple choice question will be rendered as an HTML form input using radios.
	
	<p>Is the sky blue?</p>
	<div class="radio">
		<label>
			<input type="radio" name="answer1" value="Always">Always
		</label>
	</div>
	<div class="radio">
		<label>
		<input type="radio" name="answer1" value="Never">Never
		</label>
	</div>
	<div class="radio">
		<label>
		<input type="radio" name="answer1" value="Sometimes">Sometimes
		</label>
	</div>
	
### Question types

This library allows two types of questions: **multiple choice** and **select all that apply**. There is also a third type, **true or false**, which is really just a handy shortcut for a multiple choice with two options: True or False. Other types of questions are being considered but have yet to be built if requested by the community.

The question type is defined for you depending on what method you use when asking the question. For example, if you use `setChoices()` the question type will be "multiple choice", but if you use `setSelections()` the question type will be "select all that apply". You can always override this by using the `setType()` property (only useful for debugging).


#### Multiple choice (Radios)

Multiple choice (radios) uses `setChoices()` and is type `multiple`. This will probably be the most common type of question.

	// Quickest way (recommended)
	$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');
	
	// Fallback with type defined (redundant, yet consistent)
	$exam->ask('Is the sky blue?')->setType('multiple')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');

#### Select all that apply (Checkboxes)

Select all that apply (checkboxes) uses `setSelections()` and is type `select`.

	// Quickest way (recommended)
	$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon')->setAnswer('Stars','Moon');
	
	// Fallback with type defined (redundant, yet consistent)
	$exam->ask('Select things you may see at nighttime')->setChoices('Stars','Sun','Moon')->setType('select')->setAnswer('Stars','Moon');
	
Notice the order of the answers do not have to match the order of the options.

#### True or false (Radios)

This is a helpful wrapper for a multiple choice with only true or false as the options.

	// You can do this (recommended)
	$exam->ask('Is this a question?')->truefalse('true');
	
	// Which is the same as this (a little more typing)
	$exam->ask('Is this a question?')->truefalse()->setAnswer('True');
	
	// Which is also the same as this (long way, but works)
	$exam->ask('Is this a question?')->setChoices('True','False')->setAnswer('True');
	
#### Other

Other types of questions are being considered but have yet to be built if requested by the community. These are some ideas for other types of questions:

- Matching would be type `match`.
- Text (input) would have to validate exactly as the answer, with casing options considered.


Grading the exam
----
To grade the exam, pass the user's answers to the `grade()` method. It is important that you pass the same number of answers as there are questions, otherwise Exam will balk. If the user left an answer blank, make sure your POST process defines it as an empty string.

	$exam->grade($answers);
	
This will return the grade as a percent string, ie "75%". However, you can also get the grade as a decimal, fraction or percentage.

	// this will return a decimal, ie 0.66666666666666663 (numeric)
	$exam->grade($answers)->asDecimal(); 
	
	// this will return a fraction, ie 2 / 3 (string)
	$exam->grade($answers)->asFraction(); 
	
	// this will return a percentage, ie 75 (integer)
	$exam->grade($answers)->asPercentage(); 
	

**A quick note on Percentage vs Percent**

The word percent (or the symbol %) accompanies a specific number, whereas the more general word percentage is used without a number. By default, the grade function returns a percent string, but you can request the percentage instead.

	// this will return percent, ie "75%" (string)
	$exam->grade($answers);	
	
	// this will return percentage, ie 75 (integer)
	$exam->grade($answers)->asPercentage();

Working example
---
There is a working example in *./doc/example.php* that allows you take an exam and shows you the results after submitting your answers.

Testing
--------
Tests are built with PHPUnit.

Make sure you install with dev requirements.

	composer install

Go to the root of the project then run all tests by typing in the terminal:

	phpunit --bootstrap vendor/autoload.php tests/
	
With coverage report:

	phpunit --coverage-html ./tests/report --bootstrap vendor/autoload.php tests/
	
Last test run with with PHPUnit 4.1.4.
