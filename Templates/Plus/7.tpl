<?php

    $golds = $database->getUserArray($session->username, 0);

    $MyVilId = mysql_query("SELECT * FROM ".TB_PREFIX."bdata WHERE `wid`='".$village->wid."'") or die(mysql_error());
    $uuVilid = mysql_fetch_array($MyVilId);
    $MyVilId2 = mysql_query("SELECT * FROM ".TB_PREFIX."research WHERE `vref`='".$village->wid."'") or die(mysql_error());
    $uuVilid2 = mysql_fetch_array($MyVilId2);

    $goldlog = mysql_query("SELECT * FROM ".TB_PREFIX."gold_fin_log") or die(mysql_error());

if($session->gold >= 2) {

if (mysql_num_rows($MyVilId) || mysql_num_rows($MyVilId2)) {

mysql_query("UPDATE ".TB_PREFIX."bdata set timestamp = '1' where wid = ".$village->wid." AND type != '25' OR type != '26'") or die(mysql_error());
mysql_query("UPDATE ".TB_PREFIX."research set timestamp = '1' where vref = '".$village->wid."'") or die(mysql_error());



$done1 = "&nbsp;&nbsp; All construction orders and Researches in this village has been Completed";
    mysql_query("UPDATE ".TB_PREFIX."users set gold = ".($session->gold-2)." where `username`='".$session->username."'") or die(mysql_error());
    mysql_query("INSERT INTO ".TB_PREFIX."gold_fin_log VALUES ('".(mysql_num_rows($goldlog)+1)."', '".$village->wid."', 'Finish construction and research with gold')") or die(mysql_error());

} else {
$done1 = "&nbsp;&nbsp; Nothing has been Completed";
    mysql_query("INSERT INTO ".TB_PREFIX."gold_fin_log VALUES ('".(mysql_num_rows($goldlog)+1)."', '".$village->wid."', 'Failed construction and research with gold')") or die(mysql_error());

}
} else {
        $done1 = "&nbsp;&nbsp;You need more Gold";
}


echo $done1;

header("Location: plus.php?id=3&g");

 ?>