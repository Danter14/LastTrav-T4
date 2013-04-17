<div id="villageList" class="listing">
<div class="head">
	<a href="dorf3.php" accesskey="9" title="Village Overview"><?php echo MULTI_V_HEADER; ?>:</a> 
</div> 
<div class="list"> 
	<ul>        
<?php 
    for($i=1;$i<=count($session->villages);$i++) { 
    	if($session->plus){
        		$aantal = count($database->getMovement2(3,$session->villages[$i-1],1));
				$attack_coming = $database->getMovement2(3,$session->villages[$i-1],1);
                if($attack_coming[$i-1]['attack_type'] == 2){
					$aantal -= 1;
                }
				if($aantal > 0){
					$village_attack = "attack ";
					$village_title = "A falu támadás alatt áll: ".$aantal;
				} else {
					$village_attack = "";
					$village_title = htmlspecialchars($returnVillageArray[$i-1]['name']);
				}
         }
    if($session->villages[$i-1] == $village->wid){ $select = "active"; $sid = "currentVillage"; }else{ $select = ""; $sid = ""; }
    $coorproc = $database->getCoor($session->villages[$i-1]);
    if(isset($_GET['id'])){
    	$vill = "&id=".$_GET['id'];
    }elseif(isset($_GET['gid'])){
    	$vill = "&gid=".$_GET['gid'];
    }elseif(isset($_GET['id'])==39 && $_GET['t']){
    	$vill = "&id=39&t=".$_GET['t'];
    }else{
    	$vill = "";
    }
    $gid = $_GET['gid'];
	echo "<li class=\"entry ".$village_attack."".$select."\" title=\"".$village_title."\">
    <a id=\"".$sid."\" title=\"".$database->getVillageField($session->villages[$i-1],'name')." (".$coorproc['x']."|".$coorproc['y'].")\" href=\"?newdid=".$session->villages[$i-1]."".$vill."\" class=\"".$select."\">".$database->getVillageField($session->villages[$i-1],'name')."</a></li>";
	}
    	?>
		
	</ul>
</div>
<div class="foot"> 
</div>
</div>
<?php include("Templates/links.tpl"); ?>
