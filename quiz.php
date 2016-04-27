<?php
$finished = false;
$answers = getAllAnswers();
function getInput($qid,$width) {
	global $answers;
	global $finished;
	$answer = "";
	if(array_key_exists($qid, $answers)) {
		$answer = $answers[$qid];
		if($answer != '') {
			$finished = true;
		}
	}
	if($width == 'line'){
		return '<input type="text" name="'.$qid.'" id="'.$qid.'" class="answersInputField" value="'.$answer.'" answerShown="false"/>';
	}else if($width == '')
	return '<input maxlength="5" size="5" type="text" name="'.$qid.'" id="'.$qid.'" class="answersInputField" value="'.$answer.'"  answerShown="false"/>';
	
	switch ($width) {
    case 'line':
        return '<input type="text" name="'.$qid.'" id="'.$qid.'" class="answersInputField" value="'.$answer.'" answerShown="false"/>';
    case 'bool':
        return '<input maxlength="9" size="9" type="text" name="'.$qid.'" id="'.$qid.'" class="answersInputField" value="'.$answer.'" answerShown="false"/>';
    case 'shortentry':
        return '<textarea id="'.$qid.'" name="test" class="writing_answer_sheet" tabindex="-1">'.$answer.'</textarea>';
    default:
        return '<input type="text" name="'.$qid.'" id="'.$qid.'" class="answersInputField" value="'.$answer.'" answerShown="false"/>';

}
	
}
$quiz = array(
	
	array(
		'content'=>'
			
			
			<br/><br/><br/>
			
			<h3>TIME<i class="tab"></i>1 Hour</h3>
			
			<h3>INSTRUCTIONS TO CANDIDATES</h3>
			<br/><br/>
			<p><b>All answers must be written on the separate answer booklet provided.</b></p>
			<p><b>Do not remove this booklet from the examination room</b></p>
			<br/>
			<p><b>INFORMATION FOR CANDIDATES</b></p>
			
			<p>There are <b>2</b> tasks on this question paper.</p>
			<p>You should do <b>both</b> tasks.</p>
			
						<br/><br/><br/>

			
			<p style="text-align:center; margin-top:30px;"><button class="btn btn-primary btn-lg startbutton" onclick="startTest();">START TEST</button></p>
			<p style="text-align:center; margin-top:30px;"><button class="btn btn-danger btn-lg resetbutton" onclick="resetTest();">RESET TEST</button></p>
					
			
		'	
	),array(
		'content'=>'
			
			<h3>WRITING TASK 1</h3>
			<br/>
			<p>You should spend about 20 minutes on this task.</p>
			<br/>

			<p style="padding-left:50px;"><b><i>&nbsp;&nbsp;The graph below shows the number of males and females of different ages, employed in a European country in 2013.</i></b></p>			
			<br/>
			<p style="padding-left:50px;"><b><i>&nbsp;&nbsp;Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</i></b></p>
			<br/>
			<p>Write at least 150 words.</p>
			<br/>
			<img src="New_graph.png" alt="Bar Graph of Number of People Employed in a European country by Age and Gender, 2013" width="100%"/>
			<br/><br/>
			
			<button class="btn btn-primary showvalues_button" onclick="toggleTable()">Show Values</button>
			<style>
			#employedTable th {
			    border: 1px solid black;
			    text-align:center;
			    
			}
			#employedTable{
				display:none;
			}
			</style>
			<br/><br/>
			<table id="employedTable" style="width:100%;text-align:center;" >
				<thead>
					<th>Age (years)</th>
					<th>Males (thousands)</th>
					<th>Females (thousands)</th>
				</thead>
				<tbody>
					<tr>
						<td>15 - 19</td>
						<td>270</td>
						<td>280</td>
					</tr>
					<tr>
						<td>20 - 24</td>
						<td>437</td>
						<td>405</td>
					</tr>
					<tr>
						<td>25 - 29</td>
						<td>514</td>
						<td>440</td>
					</tr>
					<tr>
						<td>30 - 34</td>
						<td>560</td>
						<td>439</td>
					</tr>
					<tr>
						<td>35 - 39</td>
						<td>574</td>
						<td>457</td>
					</tr>
					<tr>
						<td>40 - 44</td>
						<td>577</td>
						<td>501</td>
					</tr>
					<tr>
						<td>45 - 49</td>
						<td>527</td>
						<td>468</td>
					</tr>
					<tr>
						<td>50 - 54</td>
						<td>482</td>
						<td>395</td>
					</tr>
					<tr>
						<td>55 - 59</td>
						<td>321</td>
						<td>222</td>
					</tr>
					<tr>
						<td>60 - 64</td>
						<td>175</td>
						<td>90</td>
					</tr>
					<tr>
						<td>65 - 74</td>
						<td>89</td>
						<td>43</td>
					</tr>
					<tr>
						<td>75+</td>
						<td>20</td>
						<td>11</td>
					</tr>
				</tbody>
			</table>

					
			
		'	
	),array(
		'content'=>'
			
			
			<h3>WRITING TASK 1 - Answer Sheet</h3>
			<br/>
			
			
			
			<p><b>Word Count</b>: <span id="task_one_word_count"></span></p>

			<div class="task_boxes_div">'.getInput("task_one","shortentry").'</div>
								
								<br/>			

			<button class="btn btn-primary btn-lg handinbutton" id="task_one_handin_button" data-taskid="task_one" onclick="handIn(this);">Submit</button>
			<br/>			<br/>

			<p style="color:darkgrey"><i>The "Submit" button will be enabled once you have written at least 150 words for this activity</i></p>
			
		'	
	),array(
		'content'=>'
			
			
			<h3>WRITING TASK 1 - Sample Answer</h3>
			<br/>
			<p>The chart gives information about employment in terms of age and sex in a European country in 2013.</p>

 <p>The most striking feature is that employed men outnumber employed women in all age groups apart from the 15-19 year age group, where women (approximately 280 000) slightly outnumber men (approximately 270 000).</p>

 <p>Turning to differences in employment in terms of age group, it can be seen that the group with the highest participation in the workforce is aged between 35 and 44, with close to 1 200 000 male workers and almost 1 000 000 female workers. The age groups above and below this one, 25-34 and 45-54, are ranked second, with  between 1 000 000 and 1 100 000 men and 830 000 to 850 000 women. 
 </p><p>For female workers, next comes the 20-24 age group, followed by the group aged 55-64, and then the 15-19 year old group. For male workers, the group aged 55-64 is next, followed by the 20-24 age group and finally, the 15-19 year old group. The group with the lowest participation in the workforce is aged 65+, with around 100 000 men employed and half that number of female workers.</p>

 <p>(194 words)</p>
			
								
			
		'	
	),array(
		'content'=>'
			
			<h3>WRITING TASK 2</h3>
			<br/>
			<p>You should spend about 40 minutes on this task.</p>
			<br/>
			<p style="padding-left:20px;"><b><i>In many countries there is a widening gap between the rich and the poor.</i></b></p>			
			<br/>
			<p style="padding-left:20px;"><b><i>What do you think are the causes of this?</i></b></p>
			<br/>
			<p style="padding-left:20px;"><b><i>What solutions can you suggest?</i></b></p>
			<br/>
			<p>Give reasons for your answer and include any relevant examples from your own knowledge or experience</p>
			<br/>
			<p>Write at least 250 words.</p>
								
			
		'	
	)	,array(
		'content'=>'
			
			<h3>WRITING TASK 2 - Answer Sheet</h3>
			<br/>
			
			<p><b>Word Count</b>: <span id="task_two_word_count"></span></p>


			<div class="task_boxes_div">'.getInput("task_two","shortentry").'</div>
			<br/>			

			<button class="btn btn-primary btn-lg handinbutton" id="task_two_handin_button" data-taskid="task_two" onclick="handIn(this);">Submit</button>
			
		<br/>			<br/>

			<p style="color:darkgrey"><i>The "Submit" button will be enabled once you have written at least 250 words for this activity</i></p>
			
		'	
	),array(
		'content'=>'
			
			
			<h3>WRITING TASK 2 - Sample Answer</h3>
			<br/>
			<p>Economic prosperity has been a feature of many countries over the last half century. This has, on the whole, raised the standard of living and reduced the numbers of people who would be considered destitute, and may have led to a redefinition of poverty. However, within those countries, the difference between the poorest and wealthiest citizens has increased. This essay will outline some of the possible causes and some suggested solutions to this situation.</p>

<p>The main cause of the widening gap in personal wealth is the overriding need for companies to make ever-increasing profits. Although this has fuelled many positive developments in society, such as higher employment rates and greater national revenue, many employees are rewarded to excess for their ability to make more money for their employers. We commonly see CEOs being paid, or even paying themselves, exorbitant salaries, sometimes in the millions. This characteristic of many listed companies has a trickle-down effect to subordinate employees. Consequently, many people have too much personal wealth.</p>

<p>One solution to this would be the gradual introduction of socially responsible ethics in business where the profit motive is moderated by greater attention to philanthropy and financial support to those in need. This could be encouraged by tax incentives from government for such community support programs. Another measure could be the instigation of salary caps. There is surely no need for anyone to be paid an annual salary in the millions.</p> 

<p>Overall, society is more materialistic than ever and this need to acquire has driven the accumulation of wealth. Changing tax and employment regulations may help redistribute some of the excess wealth to those who are struggling financially.</p>

<p>(274 words)</p>
								
			
		'	
	)	
	
);

$results = array(
	'a_1'=>array('t','true'),
	'a_2'=>array('f','false'),
	'a_3'=>array('t', 'true'),
	'a_4'=>array('NG','N G','Not Given'),
	'a_5'=>array('f','false'),
	'a_6'=>array('t','true'),
	'a_7'=>array('oysters'),
	'a_8'=>array('oxygen'),
	'a_9'=>array('rain gardens'),
	'a_10'=>array('pilings'),
	'a_11'=>array('wetlands'),
	'a_12'=>array('b','c'),
	'a_13'=>array('c','b'),
	'a_14'=>array('c','e'),
	'a_15'=>array('c','e'),
	'a_16'=>array('f'),
	'a_17'=>array('c'),
	'a_18'=>array('e'),
	'a_19'=>array('d'),
	'a_20'=>array('g'),
	'a_21'=>array('b'),
	'a_22'=>array('n','no'),
	'a_23'=>array('n','no'),
	'a_24'=>array('y','yes'),
	'a_25'=>array('NG','N G','Not Given'),
	'a_26'=>array('d'),
	'a_27'=>array('vii'),
	'a_28'=>array('vi'),
	'a_29'=>array('ii'),
	'a_30'=>array('iii'),
	'a_31'=>array('target'),
	'a_32'=>array('distributed'),
	'a_33'=>array('currency'),
	'a_34'=>array('buy'),
	'a_35'=>array('d'),
	'a_36'=>array('f'),
	'a_37'=>array('a'),
	'a_38'=>array('c'),
	'a_39'=>array('B','D'),
	'a_40'=>array('B','D')
);

$questions = array(
	'a_1'=>array('type' => 'normal'),
	'a_2'=>array('type' => 'normal'),
	'a_3'=>array('type' => 'normal'),
	'a_4'=>array('type' => 'normal'),
	'a_5'=>array('type' => 'normal'),
	'a_6'=>array('type' => 'normal'),
	'a_7'=>array('type' => 'normal'),
	'a_8'=>array('type' => 'normal'),
	'a_9'=>array('type' => 'normal'),
	'a_10'=>array('type' => 'normal'),
	'a_11'=>array('type' => 'normal'),
	'a_12'=>array('type' => 'normal'),
	'a_13'=>array('type' => 'normal'),
	'a_14'=>array('type' => 'normal'),
	'a_15'=>array('type' => 'normal'),
	'a_16'=>array('type' => 'normal'),
	'a_17'=>array('type' => 'normal'),
	'a_18'=>array('type' => 'normal'),
	'a_19'=>array('type' => 'normal'),
	'a_20'=>array('type' => 'normal'),
	'a_21'=>array('type' => 'normal'),
	'a_22'=>array('type' => 'normal'),
	'a_23'=>array('type' => 'normal'),
	'a_24'=>array('type' => 'normal'),
	'a_25'=>array('type' => 'normal'),
	'a_26'=>array('type' => 'normal'),
	'a_27'=>array('type' => 'normal'),
	'a_28'=>array('type' => 'normal'),
	'a_29'=>array('type' => 'normal'),
	'a_30'=>array('type' => 'normal'),
	'a_31'=>array('type' => 'normal'),
	'a_32'=>array('type' => 'normal'),
	'a_33'=>array('type' => 'normal'),
	'a_34'=>array('type' => 'normal'),
	'a_35'=>array('type' => 'normal'),
	'a_36'=>array('type' => 'normal'),
	'a_37'=>array('type' => 'normal'),
	'a_38'=>array('type' => 'normal'),
	'a_39'=>array('type' => 'combine', 'combined_question' => array('a_39', 'a_40')),
	'a_40'=>array('type' => 'combine', 'combined_question' => array('a_39', 'a_40')),
);

?>