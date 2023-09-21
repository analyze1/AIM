<?php
//include "pages/check-ses.php"; 
//include "../inc/connectdbs.pdo.php";
?>
<style type="text/css">
    .itemdiv.dialogdiv:before {
	position: absolute;
	display: none;
	content: "";
	top: 0;
	bottom: 0;
	left: 0px;
	width: 0px;
	max-width: 0px;
	background-color: #e1e6ed;
	border: 1px solid #d7dbdd;
	border-width: 0 1px
}

.itemdiv.dialogdiv:last-child:before {
	display: none
}
.itemdiv {
	padding-right: 3px;
	min-height: 64px; 
	position: relative;
}
.itemdiv>.body{
    margin-left:0px;
}
.itemdiv>.body>.name{padding-left:10px;}
.itemdiv.dialogdiv>.bodyR {
	border: 1px solid #62b0dc;
	padding: 3px 7px 7px;
	border-left-width: 2px;
	margin-right: 1px
}
.itemdiv>.bodyR{
    margin-left:0px;
}
.itemdiv>.bodyR>.name{padding-left:10px;text-align:right;}
.itemdiv>.bodyR>.text{text-align:right;}
.itemdiv.dialogdiv>.bodyR:after {
	content: "";
	display: block;
	position: absolute;
	right: -1px;
	top: 11px;
	width: 8px;
	height: 8px;
	border: 2px solid #62b0dc;
	border-width: 2px 0 0 2px;
	background-color: #FFF;
	-webkit-transform: rotate(140deg);
	-moz-transform: rotate(140deg);
	-ms-transform: rotate(140deg);
	-o-transform: rotate(140deg);
	transform: rotate(140deg)
}
</style>
<script type="text/javascript" src="chat/js/chat.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
           setTimeout("chatHeartbeat();",3000); 
        });
    	function play_sound() {
//        var audioElement = document.createElement('audio');
//        audioElement.setAttribute('src', 'chat/notice.mp3');
//        audioElement.setAttribute('autoplay', 'autoplay');
//	audioElement.setAttribute('id','audio-notification');
//        audioElement.load();
//        audioElement.play();
    	}
	function remove_sound() {
//        document.getElementById("audio").remove();
    	}
</script>
<?php

if($_SESSION["strUser"]=='admin'){
    
    function filter_by_value ($array, $index, $value){ 
        if(is_array($array) && count($array)>0)  
        { 
            foreach(array_keys($array) as $key){ 
                $temp[$key] = $array[$key][$index]; 
                 
                if ($temp[$key] == $value){ 
                    $newarray[$key] = $array[$key]; 
                } 
            } 
          } 
      return $newarray; 
    }
        
        $timecheck = time()-9000;
        function queryOnline(){
        $sqlOnline = " SELECT useronline.*,tb_customer.sub,tb_customer.user ,tb_customer.group_mk ";
        $sqlOnline .= " FROM useronline inner join tb_customer ON ( useronline.iduser = tb_customer.id ) ";
        $sqlOnline .= " ORDER BY statusonline DESC";
        //echo $sqlOnline;
        $resultOnl = mysql_query($sqlOnline);
        $useronline = mysql_num_rows($resultOnl);
        $arrRow = array();
	while($row = mysql_fetch_array($resultOnl)){ 
             $arrRow[] = $row;
        }
        $arronline = filter_by_value($arrRow, 'statusonline', '1');
        $arroffline = filter_by_value($arrRow, 'statusonline', '0');
        return array('arrData'=>$arrRow,'arrOnline'=>$arronline,'arroffline'=>$arroffline);
        }
        $rowonline = queryOnline();
        $uonline = $rowonline['arrOnline']; 
        $online1 = filter_by_value($uonline, 'group_mk', '1');
        $online2 = filter_by_value($uonline, 'group_mk', '2');
        $online3 = filter_by_value($uonline, 'group_mk', '3');
        $online4 = filter_by_value($uonline, 'group_mk', '4');
        $online5 = filter_by_value($uonline, 'group_mk', '5');
        $uoffline = $rowonline['arroffline']; 
        $offline1 = filter_by_value($uoffline, 'group_mk', '1');
        $offline2 = filter_by_value($uoffline, 'group_mk', '2');
        $offline3 = filter_by_value($uoffline, 'group_mk', '3');
        $offline4 = filter_by_value($uoffline, 'group_mk', '4');
        $offline5 = filter_by_value($uoffline, 'group_mk', '5');
        $conline1 = count($online1);
        $conline2 = count($online2);
        $conline3 = count($online3);
        $conline4 = count($online4);
        $conline5 = count($online5);
        $coffline1 = count($offline1);
        $coffline2 = count($offline2);
        $coffline3 = count($offline3);
        $coffline4 = count($offline4);
        $coffline5 = count($offline5);
 ?>
        <div id="chatbox_online1" class="chatbox" style="bottom: 0px; right: 10px; display: block;">
        <div class="chatboxhead">
            <div class="chatboxtitle"  onclick="javascript:toggleChatBoxGrowth('online1')">กรุงเทพและปริมณฑล [<?= $conline1; ?> คน]</div>
            <div class="chatboxoptions">
                <a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('online1')">-</a> 
                <a href="javascript:void(0)" onclick="javascript:closeChatBox('online1')">X</a></div><br clear="all"></div>
        <div class="chatboxcontent" id="memberOnline">
            <?php
            if ($conline1 > 0) {
                foreach ($online1 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

                <?php }
            } ?>

            <?php
            if ($cffline1 > 0) {
                foreach ($offline1 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

        <?php }
            } ?>
        </div>
    </div>
        <div id="chatbox_online2" class="chatbox" style="bottom: 0px; right: 238px; display: block;">
        <div class="chatboxhead">
            <div class="chatboxtitle" onclick="javascript:toggleChatBoxGrowth('online2')">ภาคกลาง/ตะวันตก [<?= $conline2; ?> คน]</div>
            <div class="chatboxoptions">
                <a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('online2')">-</a> 
                <a href="javascript:void(0)" onclick="javascript:closeChatBox('online2')">X</a></div><br clear="all"></div>
        <div class="chatboxcontent" id="memberOnline">
            <?php
            if ($conline2 > 0) {
                foreach ($online2 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

                <?php }
            } ?>

            <?php
            if ($coffline2 > 0) {
                foreach ($offline2 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

        <?php }
            } ?>
        </div>
    </div>
        <div id="chatbox_online3" class="chatbox" style="bottom: 0px; right: 466px; display: block;">
        <div class="chatboxhead">
            <div class="chatboxtitle" onclick="javascript:toggleChatBoxGrowth('online3')">ภาคอีสาน [<?= $conline3; ?> คน]</div>
            <div class="chatboxoptions">
                <a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('online3')">-</a> 
                <a href="javascript:void(0)" onclick="javascript:closeChatBox('online3')">X</a></div><br clear="all"></div>
        <div class="chatboxcontent" id="memberOnline">
            <?php
            if ($conline3 > 0) {
                foreach ($online3 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

                <?php }
            } ?>

            <?php
            if ($coffline3 > 0) {
                foreach ($offline3 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

        <?php }
            } ?>
        </div>
    </div>
        <div id="chatbox_online4" class="chatbox" style="bottom: 0px; right: 694px; display: block;">
        <div class="chatboxhead">
            <div class="chatboxtitle" onclick="javascript:toggleChatBoxGrowth('online4')">ภาคเหนือ [<?= $conline4; ?> คน]</div>
            <div class="chatboxoptions">
                <a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('online4')">-</a> 
                <a href="javascript:void(0)" onclick="javascript:closeChatBox('online4')">X</a></div><br clear="all"></div>
        <div class="chatboxcontent" id="memberOnline">
            <?php
            if ($conline4 > 0) {
                foreach ($online4 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

                <?php }
            } ?>

            <?php
            if ($coffline4 > 0) {
                foreach ($offline4 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

        <?php }
            } ?>
        </div>
    </div>
        <div id="chatbox_online5" class="chatbox" style="bottom: 0px; right: 924px; display: block;">
            <div class="chatboxhead">
            <div class="chatboxtitle" onclick="javascript:toggleChatBoxGrowth('online5')">ภาคใต้ [<?= $conline5; ?> คน]</div>
            <div class="chatboxoptions">
                <a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('online5')">-</a> 
                <a href="javascript:void(0)" onclick="javascript:closeChatBox('online5')">X</a></div><br clear="all"></div>
        <div class="chatboxcontent" id="memberOnline">
            <?php
            if ($conline5 > 0) {
                foreach ($online5 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

                <?php }
            } ?>

            <?php
            if ($coffline5 > 0) {
                foreach ($offline5 as $row) {
                    if ($row['user'] == 'admin') {
                        $usershow = $row['area'] . $row['user'];
                    } else {
                        $usershow = $row['user'];
                    }
                    ?>
                    <div  href="#"   onclick="javascript:chatWith('<?= $usershow; ?>','<?= $row['user'] ?>')" class="span12">
                        <img style="width:50px;"  class="nav-user-photo" src="themes/images/user.png" alt="<?= $row['user']; ?>">
                        <span id="user_info">
                            <small><?= $row['area']; ?><?= $row['user']; ?></small>
                            <?= $row[sub]; ?>
                            </br>
                            <?php
                            if ($row['statusonline'] == '1') {
                                echo "<font color='GREEN'>Online</font>";
                            } else {
                                echo "<font color='RED'>Offline</font>";
                            }
                            $sql_chat = "SELECT * FROM chat WHERE msgfrom = '" . $usershow . "' AND recd = '0'";
                            $query_chat = mysql_query($sql_chat);
                            $num_chat = mysql_num_rows($query_chat);
                            ?>
                            &nbsp;&nbsp;<font color='BLUE'><?php if ($num_chat != 0) {
                    echo $num_chat . " <font size='4'><i class='icon-comment-alt'></i></font>";
                } ?></font>

                        </span>

                    </div>

        <?php }
            } ?>
        </div>
    </div>
   <script type="text/javascript">
       $(document).ready(function(){
           
           toggleChatBoxGrowth('online1');
           toggleChatBoxGrowth('online2');
           toggleChatBoxGrowth('online3');
           toggleChatBoxGrowth('online4');
           toggleChatBoxGrowth('online5');
//       setInterval(function(){
//                $.post("ajax/Ajax_Chat.php?id=1",function(result){
//                    $("#chatbox_MEMBER1").html(result);
//                })
//            },20000);
});
    </script>

<?php }else{ ?>
<?php 
 if($_SESSION['strUser']=='3000079' || $_SESSION['strUser']=='3000083' || $_SESSION['strUser']=='3000022'|| $_SESSION['strUser']=='3000007'){


        $sqlADM = " SELECT statusonline ";
        $sqlADM .= " FROM useronline inner join tb_customer ON ( useronline.iduser = tb_customer.id ) ";
        $sqlADM .= " Where tb_customer.user = 'admin' AND statusonline = '1' ";
        $sqlADM .= " ORDER BY statusonline DESC";
        //echo $sqlOnline;
        $resultADM = mysql_query($sqlADM);
        $arrAdmOnline = @mysql_num_rows($resultADM);

?>
    <script type="text/javascript">
//    $(document).ready(function(){
//        chatWith('<?=$_SESSION['strArea']?>admin','<?=$_SESSION['strUser']?>');
//        toggleChatBoxGrowth('<?=$_SESSION['strArea']?>admin');
//        $('#chatbox_<?=$_SESSION['strArea']?>admin').css('right','0px');
//    });

    $(document).ready(function(){
        chatWith('admin','<?=$_SESSION['strUser']?>');
        toggleChatBoxGrowth('admin');
        
        $('#chatbox_admin').css('right','0px');
        $('#chatbox_admin').css('top','auto');
        $('#cadmin').css('display','none');
		<?php $logo_human = '<div style="width:50px;height:50px;position:fixed;margin-left:-45px;margin-top:-50px; border-radius:100px; border-style:solid; border-color:#5098c9; border-width:4px;"><img src="chat/images_chat/call_center1.png"></div>';

		if($arrAdmOnline>0){ 
		?>
            $('#chatbox_admin .chatboxtitle').html('<?=$logo_human?>Service Online');
        <?php }else{ ?>
            $('#chatbox_admin .chatboxtitle').html('<?=$logo_human?>Service Offline');
        <?php } ?>
    });
    </script>
<?php  } } ?>
<!--Start Attact file Chat-->


<!--<link href="chat/attach/style/style.css" rel="stylesheet" type="text/css">-->
<!--END file Chat-->
<?php
$timestamp = $_SESSION['stimeOnline'];
if (time() < $timestamp)
{
    // not expire
 
}
else
{
      //expire
  
}
//

//echo date('Y-m-d',$timestamp);
?>
<?php

//$sqlO = "select * from useronline order by time_online desc";
//$resO = mysql_query($sqlO);
//while($rowO = mysql_fetch_array($resO)){
//    $onlineT = date('Y-m-d',$rowO['time_online']);
//    echo $rowO['iduser'].'=>'.$onlineT.'<br>';
//    if($onlineT=='2016-08-16'){
//        echo "update useronline set statusonline = '1' where iduser = '".$rowO['iduser']."'<br>";
//        mysql_query("update useronline set statusonline = '1' where iduser = '".$rowO['iduser']."'");
//    }
//}
?>
<input type="hidden" id="chkChatbox">
<!--
<div class="dialogs">
    <div class="itemdiv dialogdiv">
        <div class="user"> <img alt="Bob's Avatar" src="themes/images/user.png" /> </div>

        <div class="body">
            <div class="time">
                <i class="icon-time"></i>
                <span class="orange">2 min</span>
            </div>

            <div class="name">
                <a href="#">Bob</a>
                <span class="label label-info arrowed arrowed-in-right">admin</span>
            </div>
            <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</div>

            <div class="tools"> <a href="#" class="btn btn-minier btn-info"> <i class="icon-only icon-share-alt"></i> </a> </div>
        </div>
    </div>
</div>-->
