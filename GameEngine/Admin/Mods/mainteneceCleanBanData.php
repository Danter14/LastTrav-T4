<?php
#################################################################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 ##
## --------------------------------------------------------------------------- ##
##  Filename       mainteneceCleanBanData.php                                  ##
##  Developed by:  aggenkeech                                                  ##
##  License:       TravianX Project                                            ##
##  Copyright:     TravianX (c) 2010-2012. All rights reserved.                ##
##                                                                             ##
#################################################################################

include_once("../../config.php");

mysql_connect(SQL_SERVER, SQL_USER, SQL_PASS);
mysql_select_db(SQL_DB);

$session = $_POST['admid'];

$sql = mysql_query("SELECT * FROM ".TB_PREFIX."users WHERE id = ".$session."");
$access = mysql_fetch_array($sql);
$sessionaccess = $access['access'];

if($sessionaccess != 9) die("<h1><font color=\"red\">Access Denied: You are not Admin!</font></h1>");

##mysql_query("INSERT INTO ".TB_PREFIX."banlist (`uid`, `name`, `reason`, `time`, `end`, `admin`, `active`) VALUES (".$row['id'].", '".$row['username']."' , '$reason', '$startts', '$endts', '$admin', '1')");
mysql_query("TRUNCATE ".TB_PREFIX."banlist");

header("Location: ../../../Admin/admin.php?p=ban");
?>