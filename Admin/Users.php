<?php
$id = $_GET['uid'];
if(isset($id)){        
$user = $database->getUserArray($id,1);    
$varray = $database->getProfileVillages($id);
$varmedal = $database->getProfileMedal($id);
foreach($varray as $vil) {
	$totalpop += $vil['pop'];
}
?>
<div align="center">
	<ul class="tabs">
    <?php if(isset($_GET['Edit'])){ ?>
		<li><a id="a_title_1" href="?p=Users&uid=<?php echo $user['id'];?>">Player Profile</a></li>
		<li><a id="a_title_2" class="current" href="#">Edit Profile</a></li>
    <?php }else{ ?>
		<li><a id="a_title_1" onclick="SetCurrent(1);" class="current" href="#">Player Profile</a></li>
		<li>Edit player</li>
	<?php } ?>
	</ul>
</div>
<br>
<div id="div_1">
<?php if(isset($_GET['Edit'])){ ?>


<?php }else{ ?>
<table width="600" border="1" align="center" cellpadding="3" id="profile">
      <thead>
	    	<tr bgcolor="#E2E2E2" height="25">
				<th colspan="2">Player <a href="?p=Users&uid=<?php echo $user['id'];?>"><?php echo $user['username'];?></a></th>
    		</tr>                                       
    		<tr align="center" bgcolor="#E2E2E2" height="25">
                <td><B>Specifications</B></td>
                <td><B>Description</B></td>
       	</tr>
   	</thead>
		<tbody>
		    <tr>
                <td class="details">
              <table cellpadding="3" cellspacing="0" border="1" width="100%">
                        <tr align="right">
                            <th>Rating:</th>
                            <td><?php echo $ranking->getUserRank($user['username']); ?></td>
                        </tr>
						<tr align="right">
                            <th>نژاد</th>
                            <td><?php if($user['tribe'] == 1) {echo "Romans";}else if($user['tribe'] == 2) {echo "Teutons";}else if($user['tribe'] == 3) {echo "Gauls";} ?></td>
			            </tr>
			            <tr align="right">
                            <th>اتحاد:</th>
                            <td><?php
				if($user['alliance'] == 0) {
					echo "-";
				}
                else {
					echo "<a href=\"?p=alliance&aid=".$user['alliance']."\">".$database->getAllianceName($user['alliance'])."</a>";
                }
				?>
                			</td>
            			</tr>
            			<tr align="right">
                            <th>Village:</th>
                            <td><?php echo count($varray);?></td>
                        </tr>
			            <tr align="right">
			                <th>Population:</th>
				                <td><?php echo $totalpop;?></td>
			            </tr>
            <?php 
            if(isset($user['birthday']) && $user['birthday'] != 0) {
				$age = date("Y")-substr($user['birthday'],0,4);
				echo "<tr align='right'><th>Age: </th><td>$age</td></tr>";
            }
            if(isset($user['gender']) && $user['gender'] != 0) {
				$gender = ($user['gender']== 1)? "مرد" : "زن";
				echo "<tr align='right'><th>Gender: </th><td>".$gender."</td></tr>";
            }

            echo "<tr align='right'><th>Email: </th><td>".$user['email']."</td></tr>";
			?>
                <tr><td colspan="2" class="empty"></td></tr>
          <tr>
            	<td colspan="2" class="desc2">
                	<div class="desc2div" style="height:200"><center><?php echo nl2br($user['desc1']); ?></center></div>
                </td>
            </tr>
        </table>
        </td>
        <td class="desc1" width="285">
        <table cellpadding="3" cellspacing="0" border="1" width="100%">
        
	<?php
		if($_SESSION['access'] == ADMIN){
			echo '<tr align="right"><td colspan="2"><a href="?p=Users&uid='.$user['id'].'&Edit">&raquo;<b> ویرایش پروفایل</b></a></td></tr>';
		}
	?>
		<tr align="right"><td colspan="2"><a href="?p=Messages&uid=<?php echo $user['id']; ?>&Send">&raquo;<b> نوشتن نامه</b></a></td></tr>
	<?php if($_SESSION['access'] == ADMIN){ ?>
	<tr><td colspan="2"><a onclick="return (function(){
				('<b>حذف بازیکن <?php echo $user['username'];?></b><br><br>Do you want to delete this player?').dialog(
				{
					onOkay: function(dialog, contentElement)
					{
						window.location.href = '?p=Users&uid=<?php echo $user['id']; ?>&Edit'}
				});
				return false;
			})()" href="#">&raquo;<b> Remove player</b></a></td></tr>
	<?php } ?>
		<tr align="right"><td colspan="2"><a href="?p=Users&uid=<?php echo $user['id']; ?>&Ban">&raquo;<b> بازداشت</b></a></td></tr>
		<tr><td colspan="2" class="empty"></td></tr>
            <tr>
            	<td colspan="2" class="desc2">
               	  <div class="desc2div" style="height:240"><center><?php echo nl2br($user['desc2']); ?></center></div>
                </td>
            </tr>
        </table>
        
        </td>
    </tr>

    </tbody>

</table>
<?php } } ?>
</div>
