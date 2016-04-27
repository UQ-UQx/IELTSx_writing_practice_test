<?php require_once('inc/header.php'); ?>
<style type='text/css'>
	div.page {
		border:1px solid #000;
	}
	
	#ieltsLPT{
		
		font-family: Arial !important;
		
	}
</style>

</head>
<body id="ieltsLPT">
<?php
	$lti->requirevalid();
	require_once('model.php');
	require_once('quiz.php');

?>

<div class='header'>


<ul class='pagination pagination-lg'>
	<li>
      <a class='page_prev' aria-label="Previous" href="javascript:loadPage('prev')">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
<?php
	$pgnum = 1;
	foreach($quiz as $page) {
		$pgnumtext = $pgnum-1;
		if($pgnum == 1) {
			$pgnumtext = 'Start';
		}
		echo '<li><a class="page_'.$pgnum.'" href="javascript:loadPage('.$pgnum.');">'.$pgnumtext.'</a></li>';
		$pgnum += 1;
	}	
?>
	<li>
      <a class='page_next' aria-label="Next" href="javascript:loadPage('next')">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
</ul>
</div>




<div class='form'>
	<div class='pagescroller'>
	<div class='pagecontainer'>
<?php
	foreach($quiz as $page) {
		echo '<div class="page">';
		echo $page['content'];
		echo '</div>';
	}	
?>
	</div></div>
</div>



<div class='header'>
<ul class='pagination pagination-lg'>
	<li>
      <a class='page_prev' aria-label="Previous" href="javascript:loadPage('prev')">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
<?php
	$pgnum = 1;
	foreach($quiz as $page) {
		$pgnumtext = $pgnum-1;
		if($pgnum == 1) {
			$pgnumtext = 'Start';
		}
		echo '<li><a class="page_'.$pgnum.'" href="javascript:loadPage('.$pgnum.');">'.$pgnumtext.'</a></li>';
		$pgnum += 1;
	}	
?>
	<li>
      <a class='page_next' aria-label="Next" href="javascript:loadPage('next')">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
</ul>
</div>






<script type='text/javascript'>
	
	var finishedTest = false;
	var testStarted = false;

	
	$('document').ready(function() {
		$('.resetbutton').prop('disabled',true);
		$('.page_1').parent().addClass('active');
		resize();

	    setInterval(function() {
			var finishedCount = 0;
			$('.handinbutton').each(function(){
				if($(this).val() == 'Submitted'){
					finishedCount ++;
				}
			});
			if(finishedCount == 2){
				finishedTest = true;
			}else{
				finishedTest = false;
				
			}
	    },1000);
	    
	    <?php if($finished) { ?>
		$('.resetbutton').prop('disabled',false);
		startTest();
		//handIn();
		<?php } ?>

  	});
  	
	
	$( window ).resize(function() {
		resize();
	});
	
	function resize() {
		fullwidth = $('body').width()-40;
		$('div.pagescroller').width(fullwidth);
		pagewidth = fullwidth-180;
		$('div.page').width(pagewidth);
		loadPage(currentpage);
	}

  	
  	
  	
  	
  	function startTest() {
	
		loadPage(2);
		
		saveText();
		$('.pagination').css({'visibility':'visible'});
		$('.startbutton').prop('disabled',true);
		$('.startbutton').text('Test started...');
		$('.resetbutton').prop('disabled',false);
		$('.handinbutton').prop('disabled', true);

		testStarted = true;
		
		$('#task_one_word_count').text(wordCounter( $('#task_one').val() ).words);
		$('#task_two_word_count').text(wordCounter( $('#task_two').val() ).words);

		if(wordCounter( $('#task_one').val() ).words >= 150){
			$('#task_one_word_count').css({'color':'green','text-weight':'bold'});
			$('.handinbutton[data-taskid=task_one]').prop('disabled', false);

		}
		if(wordCounter( $('#task_two').val() ).words >= 250){
			$('#task_two_word_count').css({'color':'green','text-weight':'bold'});
			$('.handinbutton[data-taskid=task_two]').prop('disabled', false);

		}
		
		
	}
	
	
	function resetTest() {
		$('.form input').val('');
		$('.writing_answer_sheet').text('');
		$('.writing_answer_sheet').prop('disabled',false);
		$('.handinbutton').prop('disabled',false);
		$('.handinbutton').text('Submit');
		
		
		$('.form input').css({'background-color':'white', 'color':'black'});
		$('#showanswerbutton').css({'display':'none'});
		saveText();
		checkText();
		$('.startbutton').prop('disabled',false);
		$('.resetbutton').prop('disabled',true);
		$('.startbutton').text('START TEST');
		$('i.fa-close').removeClass('fa-close');
		$('i.fa-check').removeClass('fa-check');
		$('.form input').prop('disabled',false);
		$('.pagination').css({'visibility':'hidden'});
		loadPage(0);

	  	finishedTest = false;
	  	startedAnswer = false;
	}
	
	
	$(".writing_answer_sheet").closest("div").click(function () {
		
		if($(this).find(".writing_answer_sheet").prop("disabled")){
			$(this).find(".writing_answer_sheet").prop("disabled", false).focus();
			$('.handinbutton[data-taskid='+$(this).find(".writing_answer_sheet").attr('id')+']').text('Submit');
			$('.handinbutton[data-taskid='+$(this).find(".writing_answer_sheet").attr('id')+']').prop('disabled',false);
		}
	
		
		
   	});
	
  	
  	$('.writing_answer_sheet').keyup(function () {
	   	
	   	countWords(this);
	   	
   	});

   	function countWords(txtarea){
	   	
	   	var wordCount = 0;
	   	
	   	if($(txtarea).attr('id')=='task_one'){
		   	
		   	var wordCount = wordCounter( $(txtarea).val() ).words;
		   	saveText();
		   	
		   	$('#task_one_word_count').text(wordCounter( $('#task_one').val() ).words);

		   	if(wordCount >= 150){

				$('#task_one_word_count').css({'color':'green','text-weight':'bold'});
				$('.handinbutton[data-taskid=task_one]').prop('disabled', false);
			
		   	}else{

			   	$('#task_one_word_count').css({'color':'black','text-weight':'normal'});
			   	$('.handinbutton[data-taskid=task_one]').prop('disabled', true);

		   	}
		   	
	   	}else{
		   	var wordCount = wordCounter( $(txtarea).val() ).words;
		   	saveText();
		   	
		   	$('#task_two_word_count').text(wordCounter( $('#task_two').val() ).words);

		   	if(wordCount >= 250){
				$('#task_two_word_count').css({'color':'green','text-weight':'bold'});
				$('.handinbutton[data-taskid=task_two]').prop('disabled', false);

			
		   	}else{
			   	$('#task_two_word_count').css({'color':'black','text-weight':'normal'});
				$('.handinbutton[data-taskid=task_two]').prop('disabled', true);

		   	}
	   	}
   	}

  	function wordCounter( val ){
	  	if(!val || (val.length == 1)){
		  	return {words:0}
	  	}
	    return {
	        charactersNoSpaces : val.replace(/\s+/g, '').length,
	        characters         : val.length,
	        words              : val.match(/\S+\S+/g).length,
	        lines              : val.split(/\r*\n/).length
	    }
	}
 
  	
  	
  	
  	function saveText() {
		var data = {'data':{}};
		$('.writing_answer_sheet').each(function() {
			data['data'][$(this).attr('id')] = $(this).val();
		});
		data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
		data['user_id'] = '<?php echo $lti->user_id(); ?>';
		$.ajax({
		  type: "POST",
		  url: "savedata.php",
		  data: data,
		  success: function(response) {
		  	//console.log(response);
		  },
		  error: function(error){
			//  console.log(error);
		  }
		});
	}
	
	function checkText() {
		var data = {'data':{}};
		$('.writing_answer_sheet').each(function() {
			data['data'][$(this).attr('id')] = $(this).val();
		});
		data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
		data['user_id'] = '<?php echo $lti->user_id(); ?>';
		$.ajax({
		  type: "POST",
		  url: "checkdata.php",
		  data: data,
		  success: function(response) {
		  	//console.log(response);
		  },
		  error: function(error){
			//  console.log(error);
		  }
		});
	}
	
	
	function handIn(button) {
		
		//console.log($(button).attr('id'));
		$(button).prop('disabled',true);
		$(button).text('Submitting...');
		
		$('#'+$(button).attr('data-taskid')).prop('disabled',true);
		

		var data = {'data':{}};
		$('.writing_answer_sheet').each(function() {
			data['data'][$(this).attr('id')] = $(this).val();
		});
		data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
		data['user_id'] = '<?php echo $lti->user_id(); ?>';
		
		$.ajax({
		  type: "POST",
		  url: "savedata.php",
		  data: data,
		  success: function(response) {
			  //console.log(response);
			  data = {};
			  data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
			  data['user_id'] = '<?php echo $lti->user_id(); ?>';
			  data['lis_outcome_service_url'] = '<?php echo $lti->grade_url(); ?>';
			  data['lis_result_sourcedid'] = '<?php echo $lti->result_sourcedid(); ?>';
			  $.ajax({
			      type: "POST",
			      dataType: "json",
				  url: "checkdata.php",
					  data: data,
					  success: function(response) {
						
						$(button).text('Submitted');
						//console.log(response);
					  },
					  error: function (error){
						//console.log(response);

					  }
		  		});
		  },
		  error: function(error){
			  
			  //console.log(error);
			  
		  }
		});

	}
	
  	
	
	var currentpage = 1;
	var pages = <?php echo sizeOf($quiz); ?>;
	var fullwidth, pagewidth;
	function loadPage(page) {
		
		if(page == 'next') {
			page = currentpage + 1;
		}
		if(page == 'prev') {
			page = currentpage - 1;
		}
		if(page < 1 || page > pages) {
			return false;
		}
		$('ul.pagination li').removeClass('active');
		$('.page_'+page).parent().addClass('active');
		if(page == 1) {
			$('.page_prev').parent().addClass('disabled');
		} else {
			$('.page_prev').parent().removeClass('disabled');
		}
		if(page == pages) {
			$('.page_next').parent().addClass('disabled');
		} else {
			$('.page_next').parent().removeClass('disabled');
		}
		currentpage = page;
		var newMLeft = (pagewidth+182)*(page-1)*-1;
		$( ".pagecontainer" ).animate({
		    marginLeft: newMLeft,
		}, 400);
		
	}
	
	
	var datashown = false;
	function toggleTable(){
		if(datashown){
			$("#employedTable").hide();
			$(".showvalues_button").text('Show Values');
			datashown = false;
		}else{
			$("#employedTable").show();
			$(".showvalues_button").text('Hide Values');
			datashown = true;
		}
	}

	
	
	
/*
		var finishedTest = false;
		var startedAnswer = false;
		var showanswerInterval;
		var editedIncorrect = false;
		var activityACompleted = false;
		var activityBCompleted = false;
*/

/*

	$('document').ready(function() {
    setInterval(function() {
		if($('#handinbutton').text() == 'Thank you for your answers'){
			finishedTest = true;
			
		}else{
			finishedTest = false;
		}
		console.log('Finished Test: '+finishedTest);
    },1000);
    
  });
	
	var currentpage = 1;
	var pages = <?php echo sizeOf($quiz); ?>;
	var fullwidth, pagewidth;
	
	
			
	

	function startTest() {
							loadPage(2);
	$('.writing_answer_sheet').each(function(){
	   	
	   	countWords(this);
	   	
   	});

		$(".toggleButtons").css("display","block");
		//$('#audiofile').trigger("play");

		$('p.finishedhint').css({'display':'none'});
		$('.pagination').css({'visibility':'visible'});
		//loadPage(2);
		$('.startbutton').prop('disabled',true);
		$('.startbutton').text('Test started...');
		
		
		
	}
	
	$(".answersInputField").closest("p").click(function () {
		finishedTest = false;
		editedIncorrect = true;
		removeShowAnswers();
		$(this).find("i.fa-close").removeClass('fa-close');
		$(this).find("i.fa-check").removeClass('fa-check');
		$('#handinbutton').prop('disabled',false);
		$('#showanswerbutton').prop('disabled',true);
	  	$('#handinbutton').text('Hand In Answer Sheet');
		$(this).find(".answersInputField").prop("disabled", false).focus();
   	});
   	
   	$('.writing_answer_sheet').keyup(function () {
	   	
	   	
	   	countWords(this);
	   	
   	});

   	function countWords(txtarea){
	   	
	   	var wordCount = 0;
	   	if($(txtarea).attr('id')=='task_one'){
		   	
		   	//var wordCount = wordCounter( $(txtarea).val() ).words;
		   	saveText();
		   	
		   	$('#task_one_word_count').text(wordCount);		   	
		   	if(wordCount > 150){
				$('#task_one_word_count').css({'color':'green','text-weight':'bold'});
				activityACompleted = true;
			
		   	}else{
			   	$('#task_one_word_count').css({'color':'black','text-weight':'normal'});

		   	}
		   	
	   	}else{
		   	//var wordCount = wordCounter( $(txtarea).val() ).words;
		   	saveText();
		   	
		   	$('#task_two_word_count').text(wordCount);
		   	if(wordCount > 250){
				$('#task_two_word_count').css({'color':'green','text-weight':'bold'});
				activityBCompleted = true;
			
		   	}else{
			   	$('#task_two_word_count').css({'color':'black','text-weight':'normal'});

		   	}
	   	}
   	}
   	
   	function wordCounter( val ){
	    return {
	        charactersNoSpaces : val.replace(/\s+/g, '').length,
	        characters         : val.length,
	        words              : val.match(/\S+\S+/g).length,
	        lines              : val.split(/\r*\n/).length
	    }
	}

	function resetTest() {
		$('.form input').val('');
		$('.writing_answer_sheet').text('');
		$('.form input').css({'background-color':'white', 'color':'black'});
		$('#showanswerbutton').css({'display':'none'});
		saveText();
		saveGrades();
		$('.startbutton').prop('disabled',false);
		$('.resetbutton').prop('disabled',true);
		$('.startbutton').text('START TEST');
		$('i.fa-close').removeClass('fa-close');
		$('i.fa-check').removeClass('fa-check');
		$('#handinbutton').prop('disabled',false);
	  	$('#handinbutton').text('Hand In Answer Sheet');
	  	$('.form input').prop('disabled',false);
	  	finishedTest = false;
	  	startedAnswer = false;
	  	clearInterval(showanswerInterval);

	  	resetTimer();
	}
	function loadPage(page) {
		
		if(page == 'next') {
			page = currentpage + 1;
		}
		if(page == 'prev') {
			page = currentpage - 1;
		}
		if(page < 1 || page > pages) {
			return false;
		}
		$('ul.pagination li').removeClass('active');
		$('.page_'+page).parent().addClass('active');
		if(page == 1) {
			$('.page_prev').parent().addClass('disabled');
		} else {
			$('.page_prev').parent().removeClass('disabled');
		}
		if(page == pages) {
			$('.page_next').parent().addClass('disabled');
		} else {
			$('.page_next').parent().removeClass('disabled');
		}
		currentpage = page;
		var newMLeft = (pagewidth+182)*(page-1)*-1;
		$( ".pagecontainer" ).animate({
		    marginLeft: newMLeft,
		}, 400);
		
		console.log(finishedTest);
		if(!finishedTest){
			switch (page) {
			    case 1:
					playaudio(0);
			        break;
			    case 2:
					playaudio(36);
			        break;
			    case 3:
					playaudio(459);
			        break;
			    case 4:
					playaudio(656);
			        break;
			    case 5:
					playaudio(848);
			        break;
			    case 6:
					playaudio(1037);
			        break;
			    case 7:
					playaudio(1417);
			        break;
			    case 8:
					playaudio(1691);
					startedAnswer = true;
			        break;
			}
		}
	}
	
	function playaudio(time){
		console.log(time);
		if(!startedAnswer){
			//play('myAudioContainer');
			//skipTo('myAudioContainer',time);
		}
	}
	
	$('document').ready(function() {
		$('.resetbutton').prop('disabled',true);
		$('.page_1').parent().addClass('active');
		resize();
		$('.form input').blur(function() {
			saveGrades();
		});
		
		$('.writing_answer_sheet').blur(function(){
			
			saveText();
			console.log('I SHOULD SAVE THIS!!');
			
		});
		<?php if($finished) { ?>
		$('.resetbutton').prop('disabled',false);
		startTest();
		//handIn();
		<?php } ?>
	});
	
	$( window ).resize(function() {
		resize();
	});
	
	function resize() {
		fullwidth = $('body').width()-40;
		$('div.pagescroller').width(fullwidth);
		pagewidth = fullwidth-180;
		$('div.page').width(pagewidth);
		loadPage(currentpage);
	}
	
	function saveGrades() {
		var data = {'data':{}};
		$('.form input').each(function() {
			data['data'][$(this).attr('id')] = $(this).val();
		});
		data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
		data['user_id'] = '<?php echo $lti->user_id(); ?>';
		$.ajax({
		  type: "POST",
		  url: "savedata.php",
		  data: data,
		  success: function(response) {
		  
		  }
		});
	}
	
	function saveText() {
		var data = {'data':{}};
		$('.writing_answer_sheet').each(function() {
			data['data'][$(this).attr('id')] = $(this).val();
		});
		data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
		data['user_id'] = '<?php echo $lti->user_id(); ?>';
		$.ajax({
		  type: "POST",
		  url: "savedata.php",
		  data: data,
		  success: function(response) {
		  	console.log(response);
		  },
		  error: function(error){
			  console.log(error);
		  }
		});
	}
	
	function showanswers(){
		populateAnswers();
		if(!showanswerInterval || (editedIncorrect == true)){
			showanswerInterval = setInterval(function(){
				populateAnswers();
			}, 2000);
		}
		
	}
	
	
	function removeShowAnswers(){
		clearInterval(showanswerInterval);
		$('.answersInputField').each(function(){
			if($(this).attr('answerShown') == 'true'){
				$(this).val('');
				$(this).attr('answerShown','false');
				$(this).css({'color':'black', 'background-color':'white'});

			}
		});
	}
	
	function populateAnswers(){
		
		var answers = <?php echo json_encode($results) ?>;
		var displayAnswers = <?php echo json_encode($results) ?>;

		
		for(var key in answers){
			for(var ans in answers[key]){
				answers[key][ans] = answers[key][ans].toLowerCase();
			}
			
			//if the value of this input is wrong, display a random answer
			var input = $('#'+key);
			var inputval = input.val();
			
			
			if(!($.inArray(inputval.toLowerCase(), answers[key]) !== -1)){
				
				var random = Math.floor(Math.random() * (displayAnswers[key].length -1));
				
				input.attr('answerShown','true');
				input.val(displayAnswers[key][random]);
				input.css({'color':'white', 'background-color':'#05BA00'});
				if(key == 'a_39'){
					if($('#a_40').val().toLowerCase() === 'b'){
						input.val('d');
					}else{
						input.val('b');

					}
				}
				if(key == 'a_40'){
					if($('#a_39').val().toLowerCase() === 'b'){
						input.val('d');
					}else{
						input.val('b');

					}
				}
			}
			
			if(input.attr('answerShown') == 'true'){
				var random = Math.floor(Math.random() * (displayAnswers[key].length));
				input.val(displayAnswers[key][random]);
					if(key == 'a_39'){
						if($('#a_40').val().toLowerCase() === 'b'){
							input.val('d');
						}else{
							input.val('b');

						}
					}
					if(key == 'a_40'){
						if($('#a_39').val().toLowerCase() === 'b'){
							input.val('d');
						}else{
							input.val('b');

						}
					}
			}
		}
	}
	
	
	
	
	function handIn() {
		removeShowAnswers();
		$('#checkingAnswers').css({"display":"block"});
		$('#showanswerbutton').prop('disabled',false);

		var data = {'data':{}};
		//$('#audiofile').trigger("pause");
		//$('#audiofile').prop('currentTime','0');
		$('.form input').each(function() {
			data['data'][$(this).attr('id')] = $(this).val();
		});
		data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
		data['user_id'] = '<?php echo $lti->user_id(); ?>';
		
		$.ajax({
		  type: "POST",
		  url: "savedata.php",
		  data: data,
		  success: function(response) {
			  data = {};
			  data['lti_id'] = '<?php echo $lti->lti_id(); ?>';
			  data['user_id'] = '<?php echo $lti->user_id(); ?>';
			  data['lis_outcome_service_url'] = '<?php echo $lti->grade_url(); ?>';
			  data['lis_result_sourcedid'] = '<?php echo $lti->result_sourcedid(); ?>';
			  $.ajax({
			      type: "POST",
			      dataType: "json",
				  url: "checkdata.php",
					  data: data,
					  success: function(response) {
						
						$('#checkingAnswers').css({"display":"none"});
						console.log(response);  
					  	for(var key in response) {
						  //	console.log(key);
						  	var el = 'i.'+key;
						  	if(response[key] == 'correct') {
							  	$(el).removeClass('fa fa-close');
							  	$(el).addClass('fa fa-check').css({'color':'green'});
						  	} else if(response[key] == 'incorrect') {
							  	$(el).removeClass('fa fa-check');
							  	$(el).addClass('fa fa-close').css({'color':'red'});
						  	}
					  	}
					  	$('#handinbutton').prop('disabled',true);
					  	$('#handinbutton').text('Thank you for your answers');
					  	$('.form input').prop('disabled',true);
					  	$('.resetbutton').prop('disabled',false);
					  	$('p.finishedhint').css({'display':'block'});
					  	finishedTest = true;
					  	startedAnswer = false;
					  	$('#showanswerbutton').css({'display':'inline'});
					  	window.parent.postMessage('Hello Parent Frame!', '*');
					  },
					  error: function (error){
						$('#checkingAnswers').css({"display":"none"});
					  	for(var key in error) {
						  	if(key === 'responseText'){
						  		console.log(key+": "+error[key]);
						  	}
						  
					  	}

						  
						  console.log("ERROR: "+error);
						  
					  }
		  		});
		  }
		});
	}
	
*/

</script>
<style>
	div.header {
		text-align:center;
	}
	div.pagescroller {
		width:720px;
		overflow:hidden;
		margin-left:20px;
	}
	div.pagecontainer {
		width:99999px;
	}
	div.page {
		font-family:Arial,Times New Roman, serif;
		font-size:120%;
		padding:80px;
		margin:10px;
		height:1350px;
		width:700px;
		float:left;
	}
	div.page h2 {
		font-size:160%;
		font-weight:bold;
		text-align: center;
	}
	div.page h3 {
		font-weight:bold;
		font-size:120%;
	}
	div.page h4 {
		font-style:italic;
		font-weight:bold;
	}
	div.page table {
		border:1px solid #000;
		border-bottom:0;
		border-right:0;
	}
	div.page table td {
		min-width:100px;
		border-right:1px solid #000;
		border-bottom:1px solid #000;
		padding:3px;
	}
	div.page div.gray {
		background:#C0C0C0;
		margin:30px 0;
	}
	div.page i.tab {
		width:80px;
		display:inline-block;
	}
	.pagination {
		margin: 0 auto;
		visibility:hidden;
	}
	div.page .box {
		border:1px solid #000;
		padding:10px;
		margin-top:20px;
	}
	div.sect {
		width:50%;
		float:left;
	}
	p.finishedhint {
		display:none;
	}
	#checkingAnswers{
		display:none;
	}
	#showanswerbutton{
		display:none;
	}
	.passages{
		font-size: 14px;
	}
	.task_boxes_div{
		height:1000px;
	}
</style>

<style>
			textarea {

			   resize: none;
			   width:100%;
			   height:100%;
			   text-align:left;
			   background-image: -webkit-linear-gradient(left, white 10px, transparent 10px), -webkit-linear-gradient(right, white 10px, transparent 10px), -webkit-linear-gradient(white 30px, #ccc 30px, #ccc 31px, white 31px);
			    background-image: -moz-linear-gradient(left, white 10px, transparent 10px), -moz-linear-gradient(right, white 10px, transparent 10px), -moz-linear-gradient(white 30px, #ccc 30px, #ccc 31px, white 31px);
			    background-image: -ms-linear-gradient(left, white 10px, transparent 10px), -ms-linear-gradient(right, white 10px, transparent 10px), -ms-linear-gradient(white 30px, #ccc 30px, #ccc 31px, white 31px);
			    background-image: -o-linear-gradient(left, white 10px, transparent 10px), -o-linear-gradient(right, white 10px, transparent 10px), -o-linear-gradient(white 30px, #ccc 30px, #ccc 31px, white 31px);
			    background-image: linear-gradient(left, white 10px, transparent 10px), linear-gradient(right, white 10px, transparent 10px), linear-gradient(white 30px, #ccc 30px, #ccc 31px, white 31px);
			    background-size: 100% 100%, 100% 100%, 100% 31px;
			    border: 1px solid #ccc;
			    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
			    line-height: 31px;
			    font-family: Arial, Helvetica, Sans-serif;
			    padding: 8px;
			}
			</style>


</body>
</html>