<?php
$result = array();
foreach($volunteers as $v) 
{
	$result[] = $v['Volunteer']['firstname']." ".$v['Volunteer']['lastname'];
}
echo json_encode($result);
?>