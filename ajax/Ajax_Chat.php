<?php
include "../pages/check-ses.php";
include "../../inc/connectdbs.pdo.php";
        $timecheck = time()-10000;
        $sqlOnline = "select useronline.*,tb_customer.sub,tb_customer.user,tb_customer.group_mk  from useronline inner join tb_customer ON (useronline.iduser = tb_customer.id) ";
        if(!empty($_SESSION['strArea'])){
            $sqlOnline .= " WHERE tb_customer.group_mk = '".$_SESSION['strArea']."'";
        }
        $sqlOnline .= " ORDER BY statusonline DESC";
        $resultOnl = mysql_query($sqlOnline);
        $useronline = mysql_num_rows($resultOnl);
		$member_Online = "select useronline.*,tb_customer.sub,tb_customer.user,tb_customer.group_mk  from useronline inner join tb_customer ON (useronline.iduser = tb_customer.id) ";
        $member_Online .= "  WHERE statusonline = '1' ";
        if(!empty($_SESSION['strArea'])){
            $member_Online .= " AND tb_customer.group_mk = '".$_SESSION['strArea']."'";
        }
        $member_resultOnl = mysql_query($member_Online);
        $member_useronline = mysql_num_rows($member_resultOnl);
		
?>

    <div class="chatboxhead">
        <div class="chatboxtitle">MEMBER [Online <?=$member_useronline;?> คน]</div>
        <div class="chatboxoptions">
            <a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('MEMBER')">-</a> 
            <a href="javascript:void(0)" onclick="javascript:closeChatBox('MEMBER')">X</a></div><br clear="all"></div>
    <div class="chatboxcontent" id="memberOnline">
        <?php 

        while($row = mysql_fetch_array($resultOnl)){ ?>
        <div  href="#"   onclick="javascript:chatWith('<?=$row['user'];?>')" class="span12">
            <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?=$row['user'];?>">
            <span id="user_info">
                <small><?=$row['user'];?></small>
                <?=$row[sub];?></br>
				<?php if($row['statusonline']=='1')
				{
				echo "<font color='GREEN'>Online</font>"; 
				} 
				else 
				{
				echo "<font color='RED'>Offline</font>"; 
				}
				$sql_chat = "SELECT * FROM chat WHERE msgfrom = '".$row['user']."' AND recd = '0'"; 
				$query_chat = mysql_query($sql_chat); 
				$num_chat = mysql_num_rows($query_chat);
				?>
				&nbsp;&nbsp;<font color='BLUE'><?php if($num_chat!=0){echo $num_chat." <font size='4'><i class='icon-comment-alt'></i></font>"; }?></font>
            </span>
       
        </div>
		
        <?php } ?>
    </div>

<?php
mysql_close();
?>