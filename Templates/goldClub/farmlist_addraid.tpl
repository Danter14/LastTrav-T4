<?php
    
if(isset($_POST['action']) == 'addSlot' && $_POST['lid']) {

$troops = $_POST['t1']+$_POST['t2']+$_POST['t3']+$_POST['t4']+$_POST['t5']+$_POST['t6']+$_POST['t7']+$_POST['t8']+$_POST['t9']+$_POST['t10']."";
    
    if($_POST['x'] && $_POST['y']){
        $Wref = $database->getVilWref($_POST['x'], $_POST['y']);
        $type = $database->getVillageType2($Wref);
        $oasistype = $type['oasistype'];
        $vdata = $database->getVillage($Wref);
    }
    if(!$_POST['x'] && !$_POST['y']){
    	$errormsg .= "Enter coordinates.";
    }elseif(!$_POST['x'] || !$_POST['y']){
    	$errormsg .= "Enter the correct coordinates.";
    }elseif($oasistype == 0 && $vdata == 0){
    	$errormsg .= "There is no village on those coordinates.";
    }elseif($troops == 0){
     	$errormsg .= "No troops has been selected.";
    }else{
    
        $Wref = $database->getVilWref($_POST['x'], $_POST['y']);
        $coor = $database->getCoor($village->wid);
            
            function getDistance($coorx1, $coory1, $coorx2, $coory2) {
                   $max = 2 * WORLD_MAX + 1;
                   $x1 = intval($coorx1);
                   $y1 = intval($coory1);
                   $x2 = intval($coorx2);
                   $y2 = intval($coory2);
                   $distanceX = min(abs($x2 - $x1), abs($max - abs($x2 - $x1)));
                   $distanceY = min(abs($y2 - $y1), abs($max - abs($y2 - $y1)));
                   $dist = sqrt(pow($distanceX, 2) + pow($distanceY, 2));
                   return round($dist, 1);
               }
            
        $distance = getDistance($coor['x'], $coor['y'], $_POST['x'], $_POST['y']);
            
        $database->addSlotFarm($_POST['lid'], $Wref, $_POST['x'], $_POST['y'], $distance, $_POST['t1'], $_POST['t2'], $_POST['t3'], $_POST['t4'], $_POST['t5'], $_POST['t6'], $_POST['t7'], $_POST['t8'], $_POST['t9'], $_POST['t10']);
        
        header("Location: build.php?id=39&t=99");
}
}
?>

<script type="text/javascript">
    var targets = {};

    function fillTargets()
    {
        var targetId = $('target_id');

        targetId.empty();

        var option = new Element('option',
        {
            'html': 'Select village'
        });
        targetId.insert(option);

        $each(targets[lid], function(data)
        {
            var option = new Element('option',
            {
                'value': data.did,
                'html': data.name
            });
            targetId.insert(option);
        });
    }

    function getTargetsByLid()
    {
        var lidSelect = $('lid');
        lid = lidSelect.getSelected()[0].value;

        if (targets[lid])
        {
            fillTargets();
        }
        else
        {
            Travian.ajax(
            {
                data:
                {
                    cmd: 'raidListTargets',
                    'lid': lid
                },
                onSuccess: function(data)
                {
                    targets[data.lid] = data.targets;
                    fillTargets();
                }
            });

        }
    }

    function selectCoordinates()
    {
        var targetId = $('target_id');
        var did = targetId.getSelected()[0].value;

        if (did == '')
        {
            $('xCoordInput').value = '';
            $('yCoordInput').value = '';
        }
        else
        {
            var array;
            $each(targets[lid], function(data)
            {
                if (data.did == did)
                {
                    array = data;
                    return;
                }
            });


            $('xCoordInput').value = array.x;
            $('yCoordInput').value = array.y;
        }
    }

    var lid = <?php echo $_GET['lid']; ?>;targets[lid] = {};

</script>

<div id="raidListSlot">
    <h4>Add Slot</h4>
<font color="#FF0000"><b>    
<?php echo $errormsg; ?>
</b></font>
    
    <form action="build.php?id=39&t=99&action=showSlot&lid=<?php echo $_GET['lid']; ?>" method="post">
        <div class="boxes boxesColor gray"><div class="boxes-tl"></div><div class="boxes-tr"></div><div class="boxes-tc"></div><div class="boxes-ml"></div><div class="boxes-mr"></div><div class="boxes-mc"></div><div class="boxes-bl"></div><div class="boxes-br"></div><div class="boxes-bc"></div><div class="boxes-contents cf">
        
        <input type="hidden" name="action" value="addSlot">
        <input type="hidden" name="lid" value="<?php echo $_GET['lid']; ?>">
        
            
            <table cellpadding="1" cellspacing="1" class="transparent">
                <tbody><tr>
                    <th>Farm Name:</th>
                    <td>
                        <select onchange="getTargetsByLid();" id="lid" name="lid">
<?php

$sql = mysql_query("SELECT * FROM ".TB_PREFIX."farmlist WHERE owner = $session->uid ORDER BY name ASC");
while($row = mysql_fetch_array($sql)){ 
$lid = $row["id"];
$lname = $row["name"];
$lowner = $row["owner"];
$lwref = $row["wref"];
$lvname = $database->getVillageField($row["wref"], 'name');
    if($_GET['lid']==$lid){
        $selected = 'selected=""';
        }else{ $selected = ''; }
    echo '<option value="'.$lid.'" '.$selected.'>'.$lvname.' - '.$lname.'</option>';
}
?>    
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Select target:</th>
                    <td class="target">
                        
            <div class="coordinatesInput">
                <div class="xCoord">
                    <label for="xCoordInput">X:</label>
                    <input value="<?php echo $_POST['x']; ?>" name="x" id="xCoordInput" class="text coordinates x ">
                </div>
                <div class="yCoord">
                    <label for="yCoordInput">Y:</label>
                    <input value="<?php echo $_POST['y']; ?>" name="y" id="yCoordInput" class="text coordinates y ">
                </div>
                <div class="clear"></div>
            </div>
                                <div class="targetSelect">
                            <label class="lastTargets" for="last_targets">Last targets:</label>
							<select name="target_id">
<?php
$getwref = "SELECT * FROM ".TB_PREFIX."raidlist WHERE lid = ".$_GET['lid']."";
$arraywref = $database->query_return($getwref);
	echo '<option value="">Select village</option>';
if(mysql_num_rows(mysql_query($getwref)) != 0){
foreach($arraywref as $row){
$towref = $row["towref"];
$tocoor = $database->getCoor($towref);
$tooasistype = $database->getVillageType2($towref);
if($tooasistype == 0){
$tovname = $database->getVillageField($towref, 'name');
}else{
$tovname = $database->getOasisField($towref, 'name');
}
if($vill[$towref] == 0){
	echo '<option value="'.$towref.'">'.$tovname.'('.$tocoor['x'].'|'.$tocoor['y'].')</option>';
}
$vill[$towref] = 1;
}
}
?>
							</select>
                        </div>
                        <div class="clear"></div>
                    </td>
                </tr>
            </tbody></table>
            </div>
                </div>
        <?php include "Templates/goldClub/trooplist2.tpl"; ?>

        
<button type="submit" value="save" name="save" id="save"><div class="button-container"><div class="button-position"><div class="btl"><div class="btr"><div class="btc"></div></div></div><div class="bml"><div class="bmr"><div class="bmc"></div></div></div><div class="bbl"><div class="bbr"><div class="bbc"></div></div></div></div><div class="button-contents">save</div></div></button>
        
</form>
</div>