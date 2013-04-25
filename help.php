<?php

include("GameEngine/Village.php");
include "Templates/html.tpl";
?>
<body class="v35 webkit chrome plus">
	<div id="wrapper">
		<img id="staticElements" src="img/x.gif" alt="" />
		<div id="logoutContainer">
			<a id="logout" href="logout.php" title="<?php echo LOGOUT; ?>">&nbsp;</a>
		</div>
		<div class="bodyWrapper">
			<img style="filter:chroma();" src="img/x.gif" id="msfilter" alt="" />
			<div id="header">
				<div id="mtop">
					<a id="logo" href="<?php echo HOMEPAGE; ?>" target="_blank" title="<?php echo SERVER_NAME ?>"></a>
					<ul id="navigation">
						<li id="n1" class="resources">
							<a class="" href="dorf1.php" accesskey="1" title="<?php echo HEADER_DORF1; ?>"></a>
						</li>
						<li id="n2" class="village">
							<a class="" href="dorf2.php" accesskey="2" title="<?php echo HEADER_DORF2; ?>"></a>
						</li>
						<li id="n3" class="map">
							<a class="" href="karte.php" accesskey="3" title="<?php echo HEADER_MAP; ?>"></a>
						</li>
						<li id="n4" class="stats">
							<a class="" href="statistiken.php" accesskey="4" title="<?php echo HEADER_STATS; ?>"></a>
						</li>
<?php
if(count($database->getMessage($session->uid)) >= 1000) {
	$unmsg = "+1000";
} else { $unmsg = count($database->getMessage($session->uid)); }

if(count($database->getNotice5($session->uid)) >= 1000) {
	$unnotice = "+1000";
} else { $unnotice = count($database->getNotice5($session->uid)); }
?>
<li id="n5" class="reports">
<a href="berichte.php" accesskey="5" title="<?php echo HEADER_NOTICES; ?><?php if($message->nunread){ echo' ('.count($database->getNotice5($session->uid)).')'; } ?>"></a>
<?php
if($message->nunread){
	echo "<div class=\"ltr bubble\" title=\"".$unnotice." ".HEADER_NOTICES_NEW."\" style=\"display:block\">
			<div class=\"bubble-background-l\"></div>
			<div class=\"bubble-background-r\"></div>
			<div class=\"bubble-content\">".$unnotice."</div></div>";
}
?>
</li>
<li id="n6" class="messages">
<a href="nachrichten.php" accesskey="6" title="<?php echo HEADER_MESSAGES; ?><?php if($message->unread){ echo' ('.count($database->getMessage($session->uid)).')'; } ?>"></a>
<?php
if($message->unread) {
	echo "<div class=\"ltr bubble\" title=\"".$unmsg." ".HEADER_MESSAGES_NEW."\" style=\"display:block\">
			<div class=\"bubble-background-l\"></div>
			<div class=\"bubble-background-r\"></div>
			<div class=\"bubble-content\">".$unmsg."</div></div>";
}
?>
</li>

</ul>
<div class="clear"></div>
</div>
</div>
					<div id="mid">
												<a id="ingameManual" href="help.php" title="Aide">
							<img src="img/x.gif" class="question" alt="Aide"/>
						</a>

												<div class="clear"></div>
						<div id="contentOuterContainer">
							<div class="contentTitle">&nbsp;</div>
							<div class="contentContainer">
								<div id="content" class="universal"><h1 class="titleInHeader">Système d'Aide</h1>

<div class="helpInfoBlock">
	<a target="_blank" href="http://t4.answers.travian.fr/" class="helpHeadLine">FAQ - Answers</a>
	<a target="_blank" href="http://t4.answers.travian.fr/" class="helpText">Ici, vous trouverez la réponse à votre question sur Travian. Si celle ci ne vous satisfait pas ou vous parait incomplète ou s'il vous manque toujours des élements, vous pourrez contacter le support de jeu.</a>
</div>

<div class="helpInfoBlock">
	<a target="_blank" href="http://www.travian.fr/spielregeln.php" class="helpHeadLine">Règles du jeu.</a>
	<a target="_blank" href="http://www.travian.fr/spielregeln.php" class="helpText">Règles du jeu</a>
</div>

<div class="helpInfoBlock">
	<a href="help.php?page=support" class="helpHeadLine">Contacter le support de jeu</a>
	<a href="help.php?page=support" class="helpText">Si vous n'avez pas trouvé votre réponse : contactez le support de jeu ici.</a>
</div>

<div class="helpInfoBlock">
	<a href="plus.php?id=8" class="helpHeadLine">Questions Plus</a>
	<a href="plus.php?id=8" class="helpText">Ici, vous pouvez poser votre question à propos des options Plus ou des systèmes de paiement.</a>
</div>

<div class="helpInfoBlock">
	<a target="_blank" href="http://forum.travian.fr" class="helpHeadLine">Forum</a>
	<a target="_blank" href="http://forum.travian.fr" class="helpText">Sur le forum, discutez avec les autres joueurs.</a>
</div>

<div class="helpInfoBlock">
	<a href="#" class="helpHeadLine" onclick="return Travian.Game.iPopup(0,0);">Information rapide</a>
	<a href="#" onclick="return Travian.Game.iPopup(0,0);" class="helpText">Ici vous pouvez trouver des informations courtes et rapides sur les troupes et les bâtiments de Travian</a>
</div>
<div class="clear"></div>
</div>
<div class="contentFooter">&nbsp;</div>
					</div></div>

<?php
include("Templates/sideinfo.tpl");
include("Templates/footer.tpl");
include("Templates/header.tpl");
include("Templates/res.tpl");
include("Templates/vname.tpl");
include("Templates/quest.tpl");
?>

<div id="ce"></div>
</div>
</body>
</html>

