<?php
if(!$session->logged_in) {
?>
<a id="ingameManual" href="help.php" title="راهنما">
<img src="img/x.gif" class="question" alt="راهنما"/>
</a>
<?php
    }else {
    if($_SESSION['ok']=='1'){
?>
<div id="contentOuterContainer"> 
	<div class="contentTitle">&nbsp;</div>
		<div class="contentContainer"> 
			<div id="content" class="messages">

<?php
    
    	if($database->checkBan($session->uid)){
        ?>
				
    				<h2>سلام <?php echo $session->username; ?>,</h2>
    				<br>
                    <center><b>اکانت شما بازداشت شده است</b><br></center>
                    <div style="position:relative; right:20px; top:10px;">
                    این بازداشت ﻣﻰتواند موقتی باشد که بخاطر کلیک کردن زیاد بطور خودکار انجام ﻣﻰشود که بعد از 5 ثانیه رفع ﻣﻰشود.
                    <br><br>
                    در غیر این صورت شما به یکی از دلایل زیر بازداشت شدید: 
                    <br><br>
                    <li>استفاده از اسکریپت های غیر مجاز</li>
                    <li>استفاده از پوشینگ</li>
                    <li>استفاده از اسپم</li>
                    <li>فحاشی به بازیکنان دیگر</li>
                    <li>تلاش برای هک کردن سیستم</li>
                    <br><br>
                    برای دریافت اطلاعات بیشتر به <a href="nachrichten.php?t=1&id=0">مولتی هانتر</a> در سرور نامه بدید تا به این موضوع رسیدگی شود
                    <br>
                    و یا اینکه با ایمیل مدیر <b><?php echo ADMIN_EMAIL; ?></b> در ارتباط باشید.
                    <br><br>
                    با تشکر
                    </div>
                    
    <?php
    	
        }else{
    ?>
		
<h1 class="titleInHeader">پیام همگانی</h1>
<div id="block">
	<div style="height:390px;width:390px;margin-right:70px;"><br><br><br><br>
    <h2>سلام <?php echo $session->username; ?>,</h2>
    <br>
<?php include("Templates/text.tpl"); ?>
    </div>
	<div class="btn">
    <button type="submit" name="s1" id="btn_back" onclick="window.location.href = 'dorf1.php?ok'"><div class="button-container"><div class="button-position"><div class="btl"><div class="btr"><div class="btc"></div></div></div><div class="bml"><div class="bmr"><div class="bmc"></div></div></div><div class="bbl"><div class="bbr"><div class="bbc"></div></div></div></div><div class="button-contents">برگشت</div></div></button>
    </div>
	
</div>
<?php } ?>


<div class="clear"></div>
<div class="clear">&nbsp;</div>
</div>
<div class="clear"></div>

</div>
<div class="contentFooter">&nbsp;</div>
</div>
<?php include("Templates/sideinfo.tpl"); ?>

<div class="clear"></div>

				</div>

<?php
include("Templates/footer.tpl");
include("Templates/header.tpl");
include("Templates/res.tpl");
?>
<script type="text/javascript"> 
	resources.production = {
'l1': <?php echo $village->getProd("wood"); ?>,'l2': <?php echo $village->getProd("clay"); ?>,'l3': <?php echo $village->getProd("iron"); ?>,'l4': <?php echo $village->getProd("crop"); ?>			};
</script>

<?php
include("Templates/vname.tpl");
?>
<script type="text/javascript"> 
	Travian.Translation.add(
	{
		'close' : 'بستن'
	});
</script>
<?php
$timestamp = $database->isDeleting($session->uid);
$displayarray = $database->getUserArray($session->uid,1);
if($displayarray['protect'] > time()){
echo "<div id=\"sideInfoCountdown\"><div class=\"head\"></div>";
echo "<div class=\"content\">";
		$uurover=date('H:i:s', ($displayarray['protect'] - time()));
        echo "شما هنوز <b><span
		id=\"timer1\">".$uurover."</span></b> ساعت حمایت تازه واردین دارید.</div></div>";
} elseif($timestamp) {
echo "<div id=\"sideInfoCountdown\"><div class=\"head\"></div>";
echo "<div class=\"content\">";
		$time=$generator->getTimeFormat(($timestamp-time()));
        echo "حذف اکانت در <span id=\"timer1\">".$time."</span> .</div></div>";
}
?>
</div>
<div id="ce"></div>
</div>
</body>
</html>

    <?php
    die();
    }
  }
    ?>