<h1 class="titleInHeader">Merveilles du monde <span class="level"> Level <?php echo $village->resarray['f'.$id]; ?></span></h1>

    <div id="build" class="gid40">
    <div class="build_desc">
        <a href="#" onClick="return Travian.Game.iPopup(40,4);" class="build_logo">
        <img class="building big white g40" src="img/x.gif" alt="A világcsoda" title="La merveilles du monde"></a>
        Le Wonder World (autrement connu comme une merveille du monde) est aussi merveilleux que cela puisse para&icirc;tre. "Ce b&acirc;timent" est construit dans le but de gagner le serveur. Chaque niveau de la Merveille du monde co&ucirc;te des centaines de milliers (voire des millions) de ressources pour construire.</div>

<?php include "upgrade.tpl"; ?>
<div class="clear"></div><br />
<form action="GameEngine/Game/WorldWonderName.php" method="POST">
<input type="hidden" name="vref" value="<?php echo $_SESSION['wid']; ?>" />
<?php
$vref = $_SESSION['wid'];
$wwname = $database->getWWName($vref);

if($village->resarray['f'.$id] < 0){
echo 'Vous avez besoin de la Merveilles du monde niveau 1 pour &ecirc;tre en mesure de changer son nom.';
}
else if ($village->resarray['f'.$id] > 10)  {
echo 'Vous ne pouvez pas changer le nom de la Merveilles du monde apr&egrave;s le niveau 10.</ br>';
}
else if($village->resarray['f'.$id] > 0 and $village->resarray['f'.$id] < 11){
echo 'Nom de la Merveilles du monde. 

<center><br />Nom de la Merveilles du monde: <input class="text" name="wwname" id="wwname" value="'.$wwname.'" maxlength="20"> <button type="submit" value="ok" name="s1" id="btn_train" value="ok" class="startTraining">
                    <div class="button-container"><div class="button-position"><div class="btl"><div class="btr"><div class="btc"></div></div></div><div class="bml"><div class="bmr"><div class="bmc"></div></div></div><div class="bbl"><div class="bbr"><div class="bbc"></div></div></div></div><div class="button-contents">OK</div></div>
                    </button></center>'; 
} ?>
    </form>
	<?php
    if(isset($_GET['n'])) {
		echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="Red"><b>Merveille du Monde le nom modifi&eacute; avec succ&egrave;s</b></font>';
		  }
		  ?>

</p></div>