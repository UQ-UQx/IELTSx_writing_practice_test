<?php
	header('Content-Type: application/json');
	require_once('config.php');
	require_once('lib/lti.php');
	require_once('lib/grade.php');
	$lti = new Lti($config,true);
	if(isset($config['use_db']) && $config['use_db']) {
		require_once('lib/db.php');
		Db::config( 'driver',   'mysql' );
		Db::config( 'host',     $config['db']['hostname'] );
		Db::config( 'database', $config['db']['dbname'] );
		Db::config( 'user',     $config['db']['username'] );
		Db::config( 'password', $config['db']['password'] );
	}
	$vars = array('user_id'=>$_POST['user_id'],'oauth_consumer_key'=>$_POST['lti_id'], 'lis_outcome_service_url'=>$_POST['lis_outcome_service_url'], 'lis_result_sourcedid'=>$_POST['lis_result_sourcedid']);
	$lti->setltivars($vars);
	require_once('model.php');
	
	require_once('quiz.php');
	$answers = getAllAnswers();
	$numberCorrect = 0;
	
	$arr = array();
	foreach($answers as $task => $taskText){
		
		preg_match_all("/\S+\S+/", $taskText, $matches);
		$arr[$task] = count($matches[0]);
		
	}
	
	$task_one_achieved = false;
	$task_one_wordCount = 0;
	$task_two_achieved = false;
	$task_two_wordCount = 0;
	$grade = 0;

	foreach($arr as $task=>$wordCount){
		
		if(($task == 'task_one') && ($wordCount >= 150)){
			$task_one_achieved = true;
			$grade++;
		}
		if(($task == 'task_two') && ($wordCount >= 250)){
			$task_two_achieved = true;
			$grade++;
		}
		if($task == 'task_one'){
			$task_one_wordCount = $wordCount;
		}
		if($task == 'task_two'){
			$task_two_wordCount = $wordCount;

		}
	}

	$grade = $grade/2;
	if($lti->grade_url() != 'No Grade URL'){
		send_grade($grade,$lti);
	}
	
	echo '{"Grade":'.json_encode($grade).'}';


?>