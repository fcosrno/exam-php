<?php

// Load library
require './../vendor/autoload.php';

// Create your questions
$exam = new Fcosrno\Exam\Exam();
$exam->ask('Is the sky blue?')->setChoices('Always','Never','Sometimes')->setAnswer('Sometimes');
$exam->ask('Select things you may see at nighttime')->setSelections('Stars','Sun','Moon')->setAnswer('Stars','Moon');
$exam->ask('Is this a question?')->truefalse('true');

// Generate Form and results page
if(empty($_POST)){
	// Call the HTML Generator by passing the questions (optional, you could write the HTML yourself)
	?><form action="" method="post"><?php
	echo $exam->generateHtml();
	?><br><input type='submit' value='Submit'></form><?php
}else{
	// Put the answers in one nifty array
	$answers = array_values($_POST);
	// Then display the grade
	echo "<h1>You score is ".$exam->grade($answers)."</h1>"; // returns percentage
	echo $exam->grade($answers)->asFraction()." questions were correct.";
	echo "<hr>";
	// Fun! Let's display the correct answers
	echo "Answer key: ";
	echo "<ul>";
	// Iterate through question object to get the answers
	foreach($exam->getQuestionsArray() as $n){
		$answer = $n['answer'];
		// "Select all" answers accept multiple values, so make sure to show those
		if(is_array($answer))$answer = implode(', ',$answer);
		echo "<li>".$answer."</li>";
	}
	echo "</ul>";
	echo '<a href="example.php">Try again</a>';
}
?>