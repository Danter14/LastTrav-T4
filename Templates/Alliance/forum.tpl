<?php
//////////////// made by TTMTT ////////////////
if(isset($aid)) {
$aid = $aid;
}else if($_GET['fid']){
$aid = $database->ForumCatAlliance($_GET['fid']);
}else if($_GET['fid2']){
$aid = $database->ForumCatAlliance($_GET['fid2']);
}else{
$aid = $session->alliance;
}

$allianceinfo = $database->getAlliance($aid);
$opt = $database->getAlliPermissions($session->uid, $aid);
echo "<h1>".$allianceinfo['tag']." - ".$allianceinfo['name']."</h1>";
include("alli_menu.tpl"); 
$ids = $_GET['s'];

if(isset($_POST['new'])){
	$forum_name = $_POST['u1'];
	$forum_des = $_POST['u2'];
	$forum_owner = $session->uid;
	$forum_area = $_POST['bid'];
	if($forum_name != "" && $forum_des != ""){
	$database->CreatForum($forum_owner,$aid,$forum_name,$forum_des,$forum_area);
	}
}
if(isset($_POST['edittopic'])){
	$topic_name = $_POST['thema'];
	$topic_cat = $_POST['fid'];
	$topic_id = $_POST['tid'];
	
	$database->UpdateEditTopic($topic_id,$topic_name,$topic_cat);
}
if(isset($_POST['editforum'])){
	$forum_name = $_POST['u1'];
	$$forum_name = htmlspecialchars($forum_name);
	$forum_des = $_POST['u2'];
	$forum_des = htmlspecialchars($forum_des);
	$forum_id = $_POST['fid'];
	
	$database->UpdateEditForum($forum_id,$forum_name,$forum_des);
}
if(isset($_POST['newtopic'])){
	$title = $_POST['thema'];
	$post = $_POST['text'];
	$cat = $_POST['fid'];
	$owner = $session->uid;
	$alli = $_POST['pid'];

		if(isset($_POST['umfrage_ende'])){
			$ends = "";
		}else{
			$ends = '';
		}
	if(!preg_match('/\[message\]/',$post) && !preg_match('/\[\/message\]/',$post)){
	$post = "[message]".$post."[/message]";
	$database->CreatTopic($title,$post,$cat,$owner,$alli,$ends);
	}
}
if(isset($_POST['newpost'])){
	$post = $_POST['text'];
	$post = htmlspecialchars($post);
	$tids = $_POST['tid'];
	$owner = $session->uid;
	if($post != ""){
	if(!preg_match('/\[message\]/',$post) && !preg_match('/\[\/message\]/',$post)){
	$post = "[message]".$post."[/message]";
	$database->UpdatePostDate($tids);
	$database->CreatPost($post,$tids,$owner);
	}
	}
}
if(isset($_POST['editans'])){
	$post = $_POST['text'];
	$topic_id = $_POST['tid'];

	if(!preg_match('/\[message\]/',$post) && !preg_match('/\[\/message\]/',$post)){
	$post = "[message]".$post."[/message]";
	$database->EditUpdateTopic($topic_id,$post);
	}
}
if(isset($_POST['editpost'])){
	$post = $_POST['text'];
	$posts_id = $_POST['pod'];
	if(!preg_match('/\[message\]/',$post) && !preg_match('/\[\/message\]/',$post)){
	$post = "[message]".$post."[/message]";
	$database->EditUpdatePost($posts_id,$post);
	}
}
if(!isset($_GET['admin'])) {
	$_GET['admin'] = null;
}
if($_GET['admin']== "switch_admin"){
if($opt['opt5'] == 1){
	if($database->CheckResultEdit($aid) != 1){
		$database->CreatResultEdit($aid,1);
	}else{
		if($database->CheckEditRes($aid) == 1){
			$database->UpdateResultEdit($aid,'');
		}else{
			$database->UpdateResultEdit($aid,1);
		}
	}
}
}
if($_GET['admin']== "pin"){
	$database->StickTopic($_GET[idt],1); // stick topic
}
if($_GET['admin']== "unpin"){
	$database->StickTopic($_GET[idt],''); // unstick topic
}
if($_GET['admin']== "delforum"){
	$database->DeleteCat($_GET[idf]); // delete forum
}
if($_GET['admin']== "deltopic"){
	$database->DeleteTopic($_GET[idt]); // delete topic
}
if($_GET['admin']== "delpost"){
	$database->DeletePost($_GET[pod]); // stick topic
}
if($_GET['admin']== "lock"){
	$database->LockTopic($_GET[idt],1); // lock topic
}
if($_GET['admin']== "unlock"){
	$database->LockTopic($_GET[idt],''); // unlock topic
}
if($_GET['admin']== "newforum"){
	include("Forum/forum_1.tpl");  // new forum
}elseif(isset($_GET['fid'])){
	if(isset($_GET['ac'])){
		include("Forum/forum_5.tpl"); // new topic
	}else{
		include("Forum/forum_4.tpl"); // topic cat
	}
}elseif($_GET['admin'] == "editforum"){
	include("Forum/forum_8.tpl"); // edit topic
}elseif($_GET['admin'] == "editans"){
	include("Forum/forum_9.tpl"); // edit answer
}elseif($_GET['admin'] == "editpost"){
	include("Forum/forum_10.tpl"); // edit answer
}elseif($_GET['admin'] == "edittopic"){
	include("Forum/forum_3.tpl"); // edit topic
}elseif(isset($_GET['tid'])){
	if(isset($_GET['ac'])){
		include("Forum/forum_7.tpl"); // new post
	}else{
		include("Forum/forum_6.tpl"); // showtopic 
	}
}else{
	if($database->CheckForum($aid)){
		include("Forum/forum_2.tpl"); 
	}else if($opt['opt5'] == 1){
	if($session->access==BANNED){
"<p class=\"error\">A Forum has not been created</p><p>
			<button type=\"button\" value=\"Upgrade level\" class=\"build\" onclick=\"window.location.href = 'banned.php'; return false;\">
			<div class=\"button-container\"><div class=\"button-position\"><div class=\"btl\"><div class=\"btr\"><div class=\"btc\"></div></div></div>
			<div class=\"bml\"><div class=\"bmr\"><div class=\"bmc\"></div></div></div><div class=\"bbl\"><div class=\"bbr\"><div class=\"bbc\"></div></div></div>
			</div><div class=\"button-contents\">New forum</div></div></button></p>";
			}else{
			echo "<p class=\"error\">A Forum has not been created</p><p>
			<button type=\"button\" value=\"Upgrade level\" class=\"build\" onclick=\"window.location.href = 'allianz.php?s=2&admin=newforum'; return false;\">
			<div class=\"button-container\"><div class=\"button-position\"><div class=\"btl\"><div class=\"btr\"><div class=\"btc\"></div></div></div>
			<div class=\"bml\"><div class=\"bmr\"><div class=\"bmc\"></div></div></div><div class=\"bbl\"><div class=\"bbr\"><div class=\"bbc\"></div></div></div>
			</div><div class=\"button-contents\">New forum</div></div></button></p>";
			}}else{
			echo '<p class="error">Forum is not created yet</p>';
			}
	}				
?>