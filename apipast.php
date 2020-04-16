<?php
/**
 * 
 */
	finalresult();

	function finalresult(){
		$arr = getLastNDays(7,'Y-m-d');
		$finalarr = array();
		foreach ($arr as $key => $value) {
			$date =  trim($value, '"');
			$final = getDatewiseresult($date);
			$padded = sprintf('%0.2f', $final); // 520 -> 520.00
			$finalarr[] = $padded;
		}
		$firstdate = $arr[0];
		$firstdate = str_replace('"', '', $firstdate);
		$lastdate = date_create();
		$lastdate = date_format($lastdate,"d M");
		$firstdate = date_create($firstdate);
		$firstdate = date_format($firstdate,"d M");
		$daterange = $firstdate.' - '.$lastdate;
		$finalList = '['.$finalarr[0].','.$finalarr[1].','.$finalarr[2].','.$finalarr[3].','.$finalarr[4].','.$finalarr[5].','.$finalarr[6].']';
		$finalobj = '{list:'.$finalList.',dates:'.$daterange.'}';
		print_r($finalobj);
	}

	function getDatewiseresult($date){
		// echo $date;
		$response = file_get_contents('https://api.rootnet.in/covid19-in/stats/history');
		$response = json_decode($response, true);
		$fullarr = array();
		$fullarr = $response['data'];
		$retarr = array();
		foreach ($fullarr as $key => $value) {
			if ($value['day'] == $date) {
				return $value['summary']['total'];
				// $retarr = array_merge($retarr, $value['summary']);
			}
		}
	}

	function getLastNDays($days, $format = 'd/m'){
	    $m = date("m"); $de= date("d"); $y= date("Y");
	    $dateArray = array();
	    for($i=0; $i<=$days-1; $i++){
	        $dateArray[] = '"' . date($format, mktime(0,0,0,$m,($de-$i),$y)) . '"'; 
	    }
	    return array_reverse($dateArray);
	}
?>
