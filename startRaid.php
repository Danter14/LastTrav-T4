<?php
        include ("GameEngine/Data/unitdata.php");
		include ("GameEngine/Database.php");
		include ("GameEngine/Generator.php");
	function procDistanceTime2($coor,$thiscoor,$ref,$mode) {
		$xdistance = ABS($thiscoor['x'] - $coor['x']);
		if($xdistance > WORLD_MAX) {
			$xdistance = (2 * WORLD_MAX + 1) - $xdistance;
		}
		$ydistance = ABS($thiscoor['y'] - $coor['y']);
		if($ydistance > WORLD_MAX) {
			$ydistance = (2 * WORLD_MAX + 1) - $ydistance;
		}
		$distance = SQRT(POW($xdistance,2)+POW($ydistance,2));
		if(!$mode) {
			if($ref == 1) {
				$speed = 16;
			}
			else if($ref == 2) {
				$speed = 12;
			}
			else if($ref == 3) {
				$speed = 24; 
			}
			else if($ref == 300) {
				$speed = 5;
			}
			else {
				$speed = 1;
			}
		}
		else {
			$speed = $ref;
		}
		return round(($distance/$speed) * 3600 / INCREASE_SPEED);
	}	

	$slots = $_POST['slot'];
	$lid = $_POST['lid'];
	$tribe = $_POST['tribe'];
	$getFLData = $database->getFLData($lid);
	$sql = mysql_query("SELECT * FROM ".TB_PREFIX."raidlist WHERE lid = ".$lid."");
	while($row = mysql_fetch_array($sql)){
		$sid = $row['id'];
		$wref = $row['towref'];
		$t1 = $row['t1'];$t2 = $row['t2'];$t3 = $row['t3'];$t4 = $row['t4'];$t5 = $row['t5'];
		$t6 = $row['t6'];$t7 = $row['t7'];$t8 = $row['t8'];$t9 = $row['t9'];$t10 = $row['t10'];
		$t11 = 0;
		if($tribe == 1){ $u = ""; } elseif($tribe == 2){ $u = "1"; } elseif($tribe == 3){ $u = "2"; }elseif($tribe == 4){ $u = "3"; }else {$u = "4"; }
        if($sql[$u.'1']>=$t1 && $sql[$u.'2']>=$t2 && $sql[$u.'3']>=$t3 && $sql[$u.'4']>=$t4 && $sql[$u.'5']>=$t5 && $sql[$u.'6']>=$t6 && $sql[$u.'7']>=$t7 && $sql[$u.'8']>=$t8 && $sql[$u.'9']>=$t9 && $sql[$u.'10']>=$t10 && $sql['hero']>=$t11){
		if($slots[$sid]=='on'){
			$ckey = $generator->generateRandStr(6);
			$id = $database->addA2b($ckey,time(),$wref,$t1,$t2,$t3,$t4,$t5,$t6,$t7,$t8,$t9,$t10,$t11,4);
			
			$data = $database->getA2b($ckey, time());
			
			if($tribe == 1){ $u = ""; } elseif($tribe == 2){ $u = "1"; } elseif($tribe == 3){ $u = "2"; }elseif($tribe == 4){ $u = "3"; }else {$u = "4"; }
			
			$database->modifyUnit($getFLData['wref'],$u."1",$data['u1'],0);
			$database->modifyUnit($getFLData['wref'],$u."2",$data['u2'],0);
			$database->modifyUnit($getFLData['wref'],$u."3",$data['u3'],0);
			$database->modifyUnit($getFLData['wref'],$u."4",$data['u4'],0);
			$database->modifyUnit($getFLData['wref'],$u."5",$data['u5'],0);
			$database->modifyUnit($getFLData['wref'],$u."6",$data['u6'],0);
			$database->modifyUnit($getFLData['wref'],$u."7",$data['u7'],0);
			$database->modifyUnit($getFLData['wref'],$u."8",$data['u8'],0);
			$database->modifyUnit($getFLData['wref'],$u."9",$data['u9'],0);
			$database->modifyUnit($getFLData['wref'],$u.$tribe."0",$data['u10'],0);
			
			if($database->checkVilExist($data['to_vid'])){
				$query1 = mysql_query('SELECT * FROM `' . TB_PREFIX . 'vdata` WHERE `wref` = ' . $data['to_vid']);
			}else{
				$query1 = mysql_query('SELECT * FROM `' . TB_PREFIX . 'odata` WHERE `wref` = ' . $data['to_vid']);
			}
			$data1 = mysql_fetch_assoc($query1);
			$query2 = mysql_query('SELECT * FROM `' . TB_PREFIX . 'users` WHERE `id` = '.$data1['owner']);
			$data2 = mysql_fetch_assoc($query2);
			$query11 = mysql_query('SELECT * FROM `' . TB_PREFIX . 'vdata` WHERE `wref` = '.$getFLData['wref']);
			$data11 = mysql_fetch_assoc($query11);
			$query21 = mysql_query('SELECT * FROM `' . TB_PREFIX . 'users` WHERE `id` = '.$data11['owner']);
			$data21 = mysql_fetch_assoc($query21);
			
			$eigen = $database->getCoor($getFLData['wref']);
			$from = array('x'=>$eigen['x'], 'y'=>$eigen['y']);
			$ander = $database->getCoor($data['to_vid']);
			$to = array('x'=>$ander['x'], 'y'=>$ander['y']);
			$start = ($data21['tribe']-1)*10+1;
			$end = ($data21['tribe']*10);
			
			$speeds = array();
			$scout = 1;
	
			//find slowest unit.			
			for($i=1;$i<=10;$i++){
				if ($data['u'.$i]){
					if($data['u'.$i] != '' && $data['u'.$i] > 0){
						if($unitarray) { reset($unitarray); }
						$unitarray = $GLOBALS["u".(($tribe-1)*10+$i)];
						$speeds[] = $unitarray['speed'];
					}
				}
			}
			
			$time = procDistanceTime2($from,$to,min($speeds),1);
			
			$ctar1 = 0;
			$ctar2 = 0; 
			$abdata = $database->getABTech($getFLData['wref']);
			$reference = $database->addAttack(($getFLData['wref']),$data['u1'],$data['u2'],$data['u3'],$data['u4'],$data['u5'],$data['u6'],$data['u7'],$data['u8'],$data['u9'],$data['u10'],$data['u11'],$data['type'],$ctar1,$ctar2,0,$abdata['b1'],$abdata['b2'],$abdata['b3'],$abdata['b4'],$abdata['b5'],$abdata['b6'],$abdata['b7'],$abdata['b8']);
			
			$database->addMovement(3,$getFLData['wref'],$data['to_vid'],$reference,0,($time+time()));
		}	
	}
	}
header("Location: build.php?id=39&t=99");
?>