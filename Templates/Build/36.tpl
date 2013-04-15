<h1 class="titleInHeader">Trapper<span class="level">Level <?php echo $village->resarray['f'.$id]; ?></span></h1>

    <div id="build" class="gid36">
    <div class="build_desc">
        <a href="#" onClick="return Travian.Game.iPopup(36,4);" class="build_logo">
        <img class="building big white g36" src="img/x.gif" alt="Csapdakészítő" title="Csapdakészítő"></a>
     The trapper protects your village with well hidden traps. This means that unwary enemies can be imprisoned and won't be able to harm your village any more.</div>

<table cellpadding="1" cellspacing="1" id="build_value">
	<tr>
		<th>Number of traps at current level</th>

		<td><b><?php echo $bid36[$village->resarray['f'.$id]]['attri']; ?></b> Traps</td>
	</tr>
	<tr>
    <?php 
        if(!$building->isMax($village->resarray['f'.$id.'t'],$id)) {
        ?>
		<th>Number of traps at the next level <?php echo $village->resarray['f'.$id]+1; ?> </th>
		<td><b><?php echo $bid36[$village->resarray['f'.$id]+1]['attri']; ?></b> Traps</td>
<?php
            }
            ?>
	</tr>
</table>
<?php 
include("upgrade.tpl");
?>
<div class="clear"></div>
<p>You have <b>0</b> Traps <br></bR> You have <b>0</b> traps filled</p>
<form method="POST" name="snd" action="build.php"><input type="hidden" name="id" value="28"> <input type="hidden" name="z" value="519"> <input type="hidden" name="a" value="2">

<div class="buildActionOverview trainUnits">
<div class="action first">
				<div class="details">
<div class="tit"><a href="#" onclick="return Travian.Game.iPopup(36,4,'gid')"><img class="unit u99" src="img/x.gif" alt="تله"></a> <a href="#" onclick="return Travian.Game.iPopup(36,4,'gid')">Traps</a>
<span class="furtherInfo">(Available: 0)</span>
</div>

			<div class="showCosts"><span class="resources r1"><img class="r1" src="img/x.gif" alt="چوب">35</span><span class="resources r2"><img class="r2" src="img/x.gif" alt="خشت">30</span><span class="resources r3"><img class="r3" src="img/x.gif" alt="آهن">10</span><span class="resources r4"><img class="r4" src="img/x.gif" alt="گندم">20</span><span class="resources r5"><img class="r5" src="img/x.gif" alt="مصرف گندم">0</span><div class="clear"></div><span class="clocks"><img class="clock" src="img/x.gif" alt="مدت زمان">0:08:06</span><div class="clear"></div></div>			<span class="value">trol</span> <input type="text" class="text" name="t99" value="0" maxlength="4"><span class="value">
/ </span> <a href="#" onclick="$(this).getParent('div.details').getElement('input').value=2; return false;">2</a>

</div>
<div class="clear"></div>
</div>
</div>

<button type="submit" value="ok" name="s1" id="s1" class="startBuild"><div class="button-container"><div class="button-position"><div class="btl"><div class="btr"><div class="btc"></div></div></div><div class="bml"><div class="bmr"><div class="bmc"></div></div></div><div class="bbl"><div class="bbr"><div class="bbc"></div></div></div></div><div class="button-contents">Make</div></div></button></form>

</p></div>