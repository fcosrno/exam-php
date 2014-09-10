<?php
// Autoload library with Composer
require './../vendor/autoload.php';
// Use library
use Fcosrno\Exam\Exam;
// Create your exam
$exam = new Exam();
$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');
$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon')->setAnswer('Stars','Moon');
$exam->ask('Is this a question?')->truefalse('true');
// Generate HTML (optional)
?><form action="" method="post"><?php
echo $exam->generateHtml();
?><input type='submit' value='Submit'></form><?php
if(!empty($_POST)){
	?><h1>Grading</h1><?php
	// Grade the exam
	try {
		$myAnswers = array_values($_POST);
		echo $exam->grade($myAnswers); // returns percent
		echo '<br>';
		echo $exam->grade($myAnswers)->asPercentage(); // returns percentage
		echo '<br>';
		echo $exam->grade($myAnswers)->asFraction(); // returns fraction
	} catch (Exception $e) {
		echo $e;			
	}
}
?>