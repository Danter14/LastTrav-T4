<h1 class="titleInHeader"><?php echo B2; ?> <span class="level"> Level <?php echo $village->resarray['f'.$id]; ?></span></h1>
<div id="build" class="gid2">
<div class="build_desc">
<a href="#" onClick="return Travian.Game.iPopup(2,4);" class="build_logo">
<img class="building big white g2" src="img/x.gif" alt="<?php echo B2; ?>" title="<?php echo B2; ?>" />
</a>
<?php echo B2_DESC; ?></div>

<table cellpadding="1" cellspacing="1" id="build_value">
	<tr>
		<th><?php echo CUR_PROD; ?>:</th>
		<td><b><?php echo $bid2[$village->resarray['f'.$id]]['prod']* SPEED; ?></b> <?php echo PER_HR; ?></td>
	</tr>
	 <?php 
    if(!$building->isMax($village->resarray['f'.$id.'t'],$id)) {
    ?>
	<tr>
		<th><?php echo NEXT_PROD; echo $village->resarray['f'.$id]+1; ?>:</th>
		<td><b><?php echo $bid2[$village->resarray['f'.$id]+1]['prod']* SPEED; ?></b> <?php echo PER_HR; ?></td>
	</tr>
    <?php 
    }
    ?>
</table>

<?php 
include("upgrade.tpl");
?></p></div>

