﻿<h1 class="titleInHeader">City Wall <span class="level">Level <?php echo $village->resarray['f'.$id]; ?></span></h1>

    <div id="build" class="gid31">
    <div class="build_desc">
        <a href="#" onClick="return Travian.Game.iPopup(31,4);" class="build_logo">
        <img class="building big white g31" src="img/x.gif" alt="Kőfal" title="Kőfal"></a>
        The city wall protects the village from attacks. The higher the level, the easier it will be for your defenders to successfully fight off the pillaging hordes of your enemies. </div>

<table cellpadding="1" cellspacing="1" id="build_value">
		<tr>
			<th>
Current defense bonus:</th>
			<td><b><?php echo $bid31[$village->resarray['f'.$id]]['attri']; ?>%</b></td>
		</tr><tr>
        <?php 
        if(!$building->isMax($village->resarray['f'.$id.'t'],$id)) {
        ?>
			<th>Defense bonus at level <?php echo $village->resarray['f'.$id]+1; ?> </th>

			<td><b><?php echo $bid31[$village->resarray['f'.$id]+1]['attri']; ?>%</b></td>
            <?php
            }
            ?>
		</tr></table>
<?php 
include("upgrade.tpl");
?>
        </p>
         </div>