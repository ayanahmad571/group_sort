<?php
include("include.php");
/*$sql = "SELECT * FROM `sub_stu_mapping` 
left join students_list on ssm_rel_stu_id = stu_id
left join subjects_master on ssm_rel_sub_id = sub_id" ;
*/

?>
        
        <?php
	echo '<table style="width:100%" border="1px black solid" >
		<tr><td style="background-color:yellow" colspan="5" align="center">Student List</td></tr>

		<tr>
			';
		$sub_tot = array();	
		$sub_rem = array();	
		$total_students=0;
		
$getsubs = "SELECT * FROM `subjects_master` order by sub_id asc ";
$getsubs  = $conn->query($getsubs );

if ($getsubs ->num_rows > 0) {
    // output data of each row
	echo '<th>Student</th>';
    while($getsubrw = $getsubs ->fetch_assoc()) {
		$a =getdatafromsql($conn,"SELECT count(ssm_id) as a FROM `sub_stu_mapping` where ssm_rel_sub_id=".$getsubrw["sub_id"]."  group by ssm_rel_sub_id");
		$sub_tot[$getsubrw["sub_id"]] = $a['a'];
		$sub_rem[$getsubrw["sub_id"]] = 0;
        echo '<th style="width:300px">'.$getsubrw['sub_name'].'</th>';
    }
} 
echo '</tr>';

$getstu = "SELECT * from students_list";
$getstu = $conn->query($getstu);

if ($getstu->num_rows > 0) {
    // output data of each row
    while($getsturow = $getstu->fetch_assoc()) {
				$getsubsa = "SELECT * FROM `subjects_master` order by sub_id asc ";
				$getsubsa  = $conn->query($getsubsa );
				
				if ($getsubsa ->num_rows > 0) {
					// output data of each row
					echo '<tr style="height:50px"><td>'.$getsturow['stu_name'].'</td>';
					while($getsubrwa = $getsubsa->fetch_assoc()) {
						
						$checkstu_sub = "SELECT * FROM `sub_stu_mapping` 
						
						left join students_list on ssm_rel_stu_id = stu_id
						left join subjects_master on ssm_rel_sub_id = sub_id
						where stu_id = ".$getsturow['stu_id']." and sub_id = ".$getsubrwa['sub_id'];
						$checkstu_sub = $conn->query($checkstu_sub);
						
						if ($checkstu_sub->num_rows > 0) {
							echo '<td style="background-color:green">';echo '</td>';
						} else {
							echo '<td style="background-color:red">';echo '</td>';
						}

					
						
					}
					echo '</tr>';
				}
    }
} else {
    echo "0 results";
}


	echo '
	<tr><td style="background-color:yellow" colspan="5" align="center">Duplicates</td></tr>
	<tr><th colspan="1">Name</th><th>Number of Subjects</th><th colspan="3">Subjects</th></tr>
';

$getdupes =getdatafromsql_all($conn,"select * from (select stu_name,ssm_rel_stu_id, count(ssm_id) as nos from sub_stu_mapping left join students_list on ssm_rel_stu_id = stu_id  group by ssm_rel_stu_id) as c  where nos >1");
foreach($getdupes as $dupe){
	
echo '
<tr>
	<td>'.$dupe['stu_name'].'</td>
	<td colspan="1" align="center">'.$dupe['nos'].'</td>
	<td colspan="3" align="center">
		<table border="1px black solid">
';
$total_students += 1;
$getstudentchoices = "SELECT * FROM `sub_stu_mapping` left join subjects_master on sub_id = `ssm_rel_sub_id` WHERE `ssm_rel_stu_id` = ".$dupe['ssm_rel_stu_id']."";
$getstudentchoices = $conn->query($getstudentchoices);

if ($getstudentchoices->num_rows > 0) {
    // output data of each row
    while($getstudentchoicesrow = $getstudentchoices->fetch_assoc()) {
		$sub_rem[$getstudentchoicesrow['ssm_rel_sub_id']] += 1; 
		echo '<tr><td>'.$getstudentchoicesrow['sub_name'].'</td></tr>';
    }
} else {
    echo "0 results";
}
echo'	</table>
	</td>
</tr>

';	

}

echo '	<tr><td style="background-color:yellow" colspan="5" align="center">Total</td></tr>
';

	$total_students += ($sub_tot[1] - $sub_rem[1])+($sub_tot[2] - $sub_rem[2])+($sub_tot[3] - $sub_rem[3])+($sub_tot[4] - $sub_rem[4]);		
echo '<tr style="height:50px">
<td>Total With Duplicates</td>
<td align="center">'.$sub_tot[1].'</td>
<td align="center">'.$sub_tot[2].'</td>
<td align="center">'.$sub_tot[3].'</td>
<td align="center">'.$sub_tot[4].'</td>
	</tr>
';

echo '<tr style="height:50px">
<td>Total Without Duplicates</td>
<td align="center">'.($sub_tot[1] - $sub_rem[1]).'</td>
<td align="center">'.($sub_tot[2] - $sub_rem[2]).'</td>
<td align="center">'.($sub_tot[3] - $sub_rem[3]).'</td>
<td align="center">'.($sub_tot[4] - $sub_rem[4]).'</td>
	</tr>
';
		
echo '</table>';

$groupsize =  4;
$numberofgroups = round($total_students/$groupsize,0);
$groups = array();
$notdupes = getdatafromsql_all($conn,"select *, 
	(select ssm_rel_sub_id from sub_stu_mapping where ssm_rel_stu_id = stu_id) as subject_id 
		from students_list where 
		stu_id not in (select ssm_rel_stu_id from 
					  (select stu_name,ssm_rel_stu_id, count(ssm_id) as nos from sub_stu_mapping left join students_list on ssm_rel_stu_id = stu_id  
					   group by ssm_rel_stu_id) as c  
	where nos >1)");
//$groups[group_number][subject_id] = stu_id

echo '
<hr><br>
<table border="1px solid black">
<tr style="background-color:yellow"><td colspan="5" align="center">Groups</td></tr>
<tr>
<th></th>';



for($i = 0;$i < $numberofgroups;$i++){
	echo '<th> G'.($i+1).'</th>';
	$groups[$i]=array();
		for($sn = 1; $sn<5;$sn++){
				$groups[$i][$sn]=1;
		}
}

echo '</tr>';

echo '
<tr>
';

$sub_stu_group = array();
$stu_id_used = array();
$getstudata = getdatafromsql_all($conn,"SELECT * FROM `sub_stu_mapping` order by ssm_rel_sub_id");
$getsubjects = getdatafromsql_all($conn,"SELECT * FROM `subjects_master` order by sub_id asc ");
$getstudents_temp = getdatafromsql_all($conn,"SELECT stu_id,stu_name FROM `students_list` order by stu_id asc ");

foreach($getstudents_temp as $stu_temp){
	$stus[$stu_temp['stu_id']] = $stu_temp['stu_name'];
}

foreach($getstudata as $stu){
	$sub_stu_group[$stu['ssm_rel_sub_id']][] = $stu['ssm_rel_stu_id'];
}

foreach($getsubjects as $subject){
	echo '<tr><td>'.$subject['sub_name'].'</td>';
//	for($i = 0;$i < $numberofgroups;$i++){
		/*if($subject['sub_id'] == 1){
			if(isset($sub_stu_group[$subject['sub_id']][$i])){
				echo '<td>'.$stus[$sub_stu_group[$subject['sub_id']][$i]].'</td>';
				$stu_id_used[] = $sub_stu_group[$subject['sub_id']][$i];
			}else{
				echo '<td>-</td>';
			}
			
	*///	}else{
			$found = 1;
			$counter = 0;
			while(($found < 4) and ($counter  < count($sub_stu_group[$subject['sub_id']]))){
				if(!in_array($sub_stu_group[$subject['sub_id']][$counter],$stu_id_used)){
					$found += 1;
					echo '<td>'.$stus[$sub_stu_group[$subject['sub_id']][$counter]].'</td>';
					$stu_id_used[] = (int)$sub_stu_group[$subject['sub_id']][$counter];
				}
				$counter++;
			}
			if($found < 4){
				for($fi = 0;$fi < (4-$found);$fi++){
					echo '<td>-</td>';
				}
		//	}
			
		}
	//}
	echo '</tr>';
}
echo'
</tr>';
echo '</table>';
?><br>
<table border="solid 1px black" style="width:100%">
<tr><td align="center" style="background:yellow">Unassigned</td></tr>
<?php $notused= getdatafromsql_all($conn, "select * from students_list where stu_id not in (".implode(',',$stu_id_used).")");
foreach($notused as $nu){
	echo '<td>'.$nu['stu_name'].'</td>';
}

?>
</table>




			
