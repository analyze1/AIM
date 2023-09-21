<style>
.hdMain {
    color: #222;
    background: #f2f2f2;
    background-color: #f3f3f3;
    background-image: -moz-linear-gradient(top, #e2e2e2, #ececec);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#e2e2e2), to(#ececec));
    background-image: -webkit-linear-gradient(top, #e2e2e2, #ececec);
    background-image: -o-linear-gradient(top, #e2e2e2, #ececec);
    background-image: linear-gradient(to bottom, #e2e2e2, #cccccc);
    background-repeat: repeat-x;
    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#ffe2e2e2', endColorstr='#ffcccccc', GradientType=0);
    font-weight: 700;
}

.font_leftmenu_new {
    color: red;
    text-shadow: -1px 0 Yellow, 0 1px Yellow, 1px 0 Yellow, 0 -1px Yellow;
}
</style>
<ul class="nav nav-list">
    <?php if ($_GET['log'] != 'sip') { ?>
    <li>
        <!--<a href="#" onclick="load_page('<?= $actionH; ?>','หน้าแรก');">-->
        <a href="#" onclick="load_page('home.php','หน้าแรก');">
            <i class="icon-home"></i>
            <span>หน้าแรก</span>
        </a>
    </li>
    <?php } ?>
    <?php if ($_SESSION['sesClaim'] == '1') {
		if ($_SESSION["menu_prb"] == 'Y') { ?>
    <li>
        <a href="#" class="hdMain">
            <!--									<i class="icon-desktop"></i>-->
            <font>พ.ร.บ. (ออนไลน์)</font>
        </a>
    </li>

    <li>
        <a href="#" onclick="load_page('pages/load_Requisition.php','เบิก พ.ร.บ.');">
            <i class="icon-book"></i>
            <span>เบิก พ.ร.บ.</span>
        </a>
    </li>
    <!-- <li>
				<a href="#"  onclick="load_page('pages/load_Act.php','ซื้อ พ.ร.บ. (ออนไลน์)');">
					<i class="icon-desktop"></i>
					<font>ซื้อ พ.ร.บ. (ออนไลน์)</font>
				</a>
			</li> -->
    <li>
        <a href="#" onclick="load_page('pages/load_Act.php','ซื้อ พ.ร.บ. (ออนไลน์)');">
            <i class="icon-file"></i>
            พ.ร.บ. (ออนไลน์)
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/load_Police_Report.php','แบบฟอร์ม แจ้งความ');">
            <i class="icon-print"></i>
            แบบฟอร์มแจ้งความ
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/load_ACTCh.php','ตรวจ พ.ร.บ. (ออนไลน์)');">
            <i class="icon-globe"></i>
            <font>ตรวจ พ.ร.บ. (ออนไลน์)</font>
        </a>
    </li>
    <?php }
		if ($_SESSION["menu_red"] == 'Y') { ?>
    <li>
        <a href="#" class="hdMain">
            <!--									<i class="icon-desktop"></i>-->
            <font>ประกันภัยป้ายแดง Mitsubishi</font>
        </a>
    </li>
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-file"></i>
            <span>แจ้งประกันภัย</span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="#" onclick="load_page('pages/load_Insurance.php','แจ้งประกันภัยป้ายแดง');">
                    <i class="icon-double-angle-right"></i>
                    แจ้งประกันภัยป้ายแดง
                </a>
            </li>
            <!-- <li>
                <a href="downloads/confirmation_car110.pdf" target='_BLANK'>
                    <i class="icon-double-angle-right"></i>
                    <font class='color_leftmenu_color'>ใบฟรีประกันภัย</font><br>ประเภทรถเก๋ง
                </a>
            </li>
            <li>
                <a href="downloads/confirmation_car320.pdf" target='_BLANK'>
                    <i class="icon-double-angle-right"></i>
                    <font class='color_leftmenu_color'>ใบฟรีประกันภัย</font><br>ประเภทรถปิคอัพ
                </a>
            </li> -->
            <!-- <li>
                <a href="downloads/question_insure.pdf" target='_BLANK'>
                    <i class="icon-double-angle-right"></i>
                    <font class='color_leftmenu_color'>คำถาม</font><br>ใบยืนยันรับฟรีประกันภัย
                </a>
            </li> -->
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-list-alt"></i>
            <span>ตรวจสอบข้อมูล</span>
            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="#" onclick="load_page('pages/load_Individuals.php','บุคคลธรรมดา');">
                    <i class="icon-double-angle-right"></i>
                    บุคคลธรรมดา
                </a>
            </li>

            <li>
                <a href="#" onclick="load_page('pages/load_Corporation.php','นิติบุคคล');">
                    <i class="icon-double-angle-right"></i>
                    นิติบุคคล
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/load_Foreigner.php','ชาวต่างชาติ');">
                    <i class="icon-double-angle-right"></i>
                    ชาวต่างชาติ
                </a>
            </li>

        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-edit"></i>
            <span>สลักหลัง</span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="#" onclick="load_page('pages/load_Attached.php','แจ้งสลักหลัง');">
                    <i class="icon-double-angle-right"></i>
                    แจ้งสลักหลัง
                </a>
            </li>

            <li>
                <a href="#" onclick="load_page('pages/load_CheckAttached.php','ตรวจสอบสลักหลัง');">
                    <i class="icon-double-angle-right"></i>
                    ตรวจสอบสลักหลัง
                </a>
            </li>
            <!--ปิดเมนู สลักหลัง พ.ร.บ. ออนไลน์ เนื่องจากไม่มีคนใช้แล้ว-->
            <!-- <li>
						<a href="#" onclick="load_page('pages/load_Attached_Act.php','สลักหลัง พ.ร.บ. (ออนไลน์)');">
							<i class="icon-double-angle-right"></i>
							<font color="#FF0000"><b>สลักหลัง พ.ร.บ. (ออนไลน์)</b></font>
						</a>
					</li> -->
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-trash"></i>
            <span>แจ้งยกเลิกกรมธรรม์</span>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
            <li>
                <a href="#" onclick="load_page('pages/load_Cancel.php','แจ้งยกเลิกกรมธรรม์');">
                    <i class="icon-double-angle-right"></i>
                    แจ้งยกเลิกกรมธรรม์
                </a>
            </li>

            <li>
                <a href="#" onclick="load_page('pages/load_CheckCancel.php','ตรวจสอบยกเลิกกรมธรรม์');">
                    <i class="icon-double-angle-right"></i>
                    ตรวจสอบยกเลิกกรมธรรม์
                </a>
            </li>
        </ul>
    </li>

    <!-- <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-briefcase"></i>
            <span>รายละเอียด</span>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
            <li>
                <a href="#" onclick="load_page('pages/load_Manual.php','วิธีการใช้งาน');">
                    <i class="icon-double-angle-right"></i>
                    วิธีการใช้งาน
                </a>
            </li>

            <li>
                <a href="#" onclick="load_page('pages/load_Cost.php','อัตราเบี้ยอุปกรณ์ตกแต่ง');">
                    <i class="icon-double-angle-right"></i>
                    อัตราเบี้ยอุปกรณ์ตกแต่ง
                </a>
            </li>

            <li>
								<a href="#" onclick="load_page('pages/load_CostLongTerm.php','อัตราเบี้ยระยะยาว');">
									<i class="icon-double-angle-right"></i>
									อัตราเบี้ยระยะยาว
								</a>
							</li>
            <li>
                <a href="print/pre_carpassenger_new_2019.pdf" target="_BLANK"
                    onclick="load_page('','อัตราเบี้ยรถโดยสาร');">
                    <i class="icon-double-angle-right"></i>
                    อัตราเบี้ยรถโดยสาร<br>(carry)
                </a>
            </li>
            <li>
                <a href="print/pre_carpassenger_new_2019_new_carry.pdf" target="_BLANK"
                    onclick="load_page('','อัตราเบี้ยรถโดยสาร');">
                    <i class="icon-double-angle-right"></i>
                    อัตราเบี้ยรถโดยสาร<br>(new carry)
                </a>
            </li>
            <li>
                <a href="print/120_carpassenger_2019.pdf" target="_BLANK"
                    onclick="load_page('','อัตราเบี้ยรถเช่าหรือเชิงพาณิชย์');">
                    <i class="icon-double-angle-right"></i>
                    อัตราเบี้ยรถเช่าหรือเชิงพาณิชย์
                </a>
            </li>
            <li>
								<a href="#" onclick="load_page('pages/load_CostRenew.php','อัตราเบี้ยต่ออายุ');">
									<i class="icon-double-angle-right"></i>
									อัตราเบี้ยต่ออายุ
								</a>
							</li>
            <li>
								<a href="#" onclick="load_page('pages/load_Service.php','อู่ซ่อมมาตรฐาน');">
									<i class="icon-double-angle-right"></i>
									อู่ซ่อมมาตรฐาน
								</a>
							</li>
        </ul>
    </li> -->
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-briefcase"></i>
            <span>Report</span>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
            <li><a href="#" onclick="load_page('pages/form_report_suzuki.php','Report ยอดขาย');">
                    <i class="icon-arrow-down"></i>
                    <span>Report ยอดขาย</span>
                </a>
            </li>
            <!-- <li><a href="#" onclick="window.open('charts/dash-board-renew.php', '_blank');">
                    <i class="icon-bar-chart"></i>
                    <span>กราฟแสดงจำนวนยอดขาย</span>
                </a>
            </li> -->
            <!-- <li><a href="#" onclick="window.open('charts/dash-board-renew.php', '_blank');">
							<i class="icon-bar-chart"></i>
							<span>กราฟแสดงยอดขาย</span>
						</a>
					</li> -->

            <!-- 							<li><a href="#" onclick="load_page('pages/inform_my4ib.php','ค้นหาข้อมูล');">
								<i class="icon-arrow-down"></i>
								<span>ค้นหาข้อมูล</span>
								</a>
							</li> -->

        </ul>

    </li>

    <?php }
		if ($_SESSION['menu_stock'] == 'Y') { ?>
    <li>
        <a href="#" class="hdMain">
            <font>สต๊อกรถยนต์/จองรถยนต์</font>
        </a>
    </li>
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-shopping-cart"></i>
            <font><span>สต๊อกรถยนต์/จองรถยนต์</span></font>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu">
            <li>
                <a href="#" onclick="load_page('pages/form_stock_suzuki.php','สต๊อกรถยนต์/สั่งซื้อรถยนต์');">
                    <i class="icon-double-angle-right"></i>
                    สต๊อกรถยนต์/สั่งซื้อรถยนต์
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/select_order_car.php','ใบสั่งซื้อรถยนต์');">
                    <i class="icon-double-angle-right"></i>
                    ใบสั่งซื้อรถยนต์
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/select_quotation_car.php','ใบเสนอราคารถยนต์');">
                    <i class="icon-double-angle-right"></i>
                    ใบเสนอราคารถยนต์
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/form_my_suzuki.php','จองรถรถยนต์');">
                    <i class="icon-double-angle-right"></i>
                    จองรถยนต์
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/form_customer_suzuki.php','ข้อมูลลูกค้าจองรถยนต์');">
                    <i class="icon-double-angle-right"></i>
                    ข้อมูลลูกค้าจองรถยนต์
                </a>
            </li>
        </ul>
    </li>
    <?php }
		if ($_SESSION["menu_year"] == 'Y') { ?>
    <li class="open"><a href="#" class="hdMain">
            <font>ต่ออายุ Mitsubishi ( ปี 2 )</font>
        </a></li>
    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-star"></i>
            <font><span>ต่ออายุประกันภัย</span></font>
            <b class="arrow icon-angle-down"></b>
        </a>
        <ul class="submenu" style="display: block;">

            <!--new menu-->
            <li><a href="https://www.viriyah.net/mitsubishi/doc/storage_fees_mv.pdf" target="_bank"><i class="icon-double-angle-right"></i>
                    ขั้นตอนการคืนผลประโยชน์
                </a></li>
            <?php if ($_SESSION['strUser'] == 'admin' || $_SESSION['claim'] == 'ADMIN') { ?>
            <li>
                <a href="#" onclick="load_page('pages/load_select_renew_data.php','แจ้งเปลียนผู้ดูแลต่ออายุ');">
                    <i class="icon-double-angle-right"></i>
                    แจ้งเปลียนผู้ดูแลต่ออายุ
                </a>
            </li>
            <?php } else { ?>
            <li>
                <a href="#"
                    onclick="load_page('pages/load_form_renew_data.php?user=<?php echo $_SESSION['strUser']; ?>','แจ้งเปลียนผู้ดูแลต่ออายุ');">
                    <i class="icon-double-angle-right"></i>
                    แจ้งเปลียนผู้ดูแลต่ออายุ
                </a>
            </li>
            <?php } ?>
            <li>
                <a href="#" onclick="load_page('ajax/ajax_infrom_mitsu_renew.php','แจ้งงานต่ออายุ(แบบเดี่ยว)');">
                    <i class="icon-double-angle-right"></i>
                    แจ้งงานต่ออายุ(แบบเดี่ยว)
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/load_telesearch.php','ค้นหาต่ออายุ');">
                    <i class="icon-double-angle-right"></i>
                    ค้นหาต่ออายุ
                </a>
            </li>
            <?php
					$follow_sql = "SELECT `data`.id_data FROM detail_renew INNER JOIN `data` ON (data.id_data = detail_renew.id_data) WHERE detail_renew.status ='R' ";

					if ($_SESSION['strUser'] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
						$follow_sql .= "AND `data`.`login`='" . $_SESSION['strUser'] . "' AND detail_renew.userdetail = 'DEALER' ";
					}

					$follow_sql .= " GROUP BY detail_renew.id_data order by data.end_date DESC,detail_renew.id_detail DESC";

					$follow_query =  PDO_CONNECTION::fourinsure_mitsu()->query($follow_sql);

					$follow_num = $follow_query->rowCount();

					?>
            <li>
                <a href="#" onclick="load_page('pages/load_follow_renew.php','ติดตามต่ออายุ');">
                    <i class="icon-double-angle-right"></i>
                    ติดตามต่ออายุ <i
                        style='float:right; background-color:#B22222; border-radius:5px; color:#ffffff;padding:2px;margin-right:2px;'><?php echo $follow_num; ?></i>
                </a>
            </li>
            <li>

                <a href="#" onclick="load_page('pages/load_teleexpire.php','ใบเสนอราคา/แจ้งต่ออายุ');">
                    <i class="icon-double-angle-right"></i>
                    ใบเสนอราคา/แจ้งต่ออายุ
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/load_telefol3.php','ตรวจสอบ/แจ้งต่ออายุ');">
                    <i class="icon-double-angle-right"></i>
                    ตรวจสอบ/แจ้งต่ออายุ
                </a>
            </li>

            <li>
                <a href="#" onclick="load_page('pages/load_report_four.php','รายงานยอดขาย/ค้างชำระ');">
                    <i class="icon-double-angle-right"></i>
                    รายงานยอดขาย/ค้างชำระ
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/load_report_renew.php','รายงานลูกค้าหมดอายุ');">
                    <i class="icon-double-angle-right"></i>
                    รายงานลูกค้าหมดอายุ
                </a>
            </li>
            <li>
                <a href="#" onclick="load_page('pages/load_report_wrong_number.php','รายงานเบอร์ลูกค้าผิด');">
                    <i class="icon-double-angle-right"></i>
                    รายงานเบอร์ลูกค้าผิด
                </a>
            </li>
            <!--end menu-->
            <!--							<li>
								<a href="#" onclick="load_page('pages/load_Renew.php','แจ้งประกันภัยต่ออายุ');">
									<i class="icon-double-angle-right"></i>
									OLD เสนอราคาเบี้ยต่ออายุ
								</a>
							</li>

							<li>
								<a href="#" onclick="load_page('pages/load_RenewE.php','ปิดงาน');">
									<i class="icon-double-angle-right"></i>
									OLD แจ้งต่ออายุ
								</a>
							</li>-->

        </ul>
    </li>
    <?php } else {
			if ($_SESSION['menu_stock'] != 'Y') { ?>
    <li><a href="#" onclick="load_page('pages/load_permission.php?page=r','ขอสิทธิ์ แจ้งต่ออายุ mitsubishi ( ปี 2 )');"
            class="hdMain">
            <font>ขอสิทธิ์ แจ้งต่ออายุ mitsubishi ( ปี 2 )</font>
        </a></li>
    <?php }
		} ?>

    <?php if ($_SESSION["menu_new"] == 'Y') { ?>
    <li>
        <a href="#" class="hdMain">
            <!--<i class="icon-desktop"></i>-->
            <font>ประกันใหม่</font>
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/load_checkAct.php','เช็คเบี้ย');">
            <i class="icon-th"></i>
            <font>เช็คเบี้ย</font>
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/quote_four.php','ตรวจสอบใบเสนอราคา');">
            <i class="icon-book"></i>
            <font>ตรวจสอบใบเสนอราคา</font>
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/load_NewAct.php','แจ้งประกันป้ายดำ');">
            <i class="icon-signal"></i>
            <font>แจ้งประกันป้ายดำ</font>
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/load_viewACT.php','ตรวจสอบข้อมูล');">
            <i class="icon-list"></i>
            <font>ตรวจสอบข้อมูล</font>
        </a>
    </li>
    <?php } ?>

    <?php } else if ($_SESSION['sesClaim'] == '2') { ?>
    <li>
        <a href="#" class="hdMain">
            <!--<i class="icon-desktop"></i>-->
            <font>การเคลม</font>
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/load_Claim.php','รายงานเคลม');">
            <i class="icon-signal"></i>
            <font>รายงานเคลม</font>
        </a>
    </li>

    <li>
        <a href="#" onclick="load_page('pages/load_Sparepart.php','ค่าแรง+ค่าอะไหล่');">
            <i class="icon-pencil"></i>
            <font>ค่าแรง+ค่าอะไหล่</font>
        </a>
    </li>

    <li>
        <a href="#" onclick="load_page('pages/form_report_follow_claim.php','รายงานติดตามเคลม');">
            <i class="icon-inbox icon-large"></i>
            <font>รายงานติดตามเคลม</font>
        </a>
    </li>
    <?php } ?>
    <? if ($_SESSION['strUser'] == "admin") { ?>
    <li style="display:none;">
        <a href="#" onclick="load_page('pages/load_ChangePassword.php','เปลี่ยน password');">
            <i class="icon-off"></i>
            <span>เปลี่ยน password</span>
        </a>
    </li>

    <!-- <li>
        <a href="#" onclick="load_page('pages/manage_acc_new.php','จัดการอุปกรณ์ตกแต่งเพิ่มเติม');">
            <i class="icon-star"></i>
            <span>จัดการอุปกรณ์ตกแต่งเพิ่มเติม</span>
        </a>
    </li> -->
    <? } ?>
    <li>
        <a href="#" onclick="load_page('pages/load_logout.php','ออกจากระบบ');">
            <i class="icon-off"></i>
            <span>ออกจากระบบ</span>
        </a>
    </li>
    <li>
        <a href="#" onclick="load_page('pages/faq.php','คำถามที่ผมบ่อย');">
            <i class="icon-question"></i>
            <span>คำถามที่ผมบ่อย</span>
        </a>
    </li>


</ul>
<!--/.nav-list-->
<!-- <?php include "pages/send_mail_alert_prb.php"; ?> -->

<script>
function edit_new(q_auto, a, b) {
    load_page('pages/edit_load_NewAct.php?q_auto=' + q_auto + '', 'แจ้งประกันภัย');
}
if (window.location.hash == "") {}

function load_page(link, nlink) {

    if (link == "") {
        link = "home.php?nid=หน้าแรก";
    }
    $('#page-content').html(
        '<p><br><br><center><img src="img4/loadingIcon.gif"  > <img src="img4/loadingIcon.gif"  > <img src="img4/loadingIcon.gif"  ><center></p>'
    ).load(link);
    $('#txt_nlink').html(nlink);
    $.post("ajax/ajax_save_log_page.php", {
        log_page: nlink
    });

    localStorage.setItem('_linkName', nlink);
}
var inset_color = 0;
setInterval(function() {
    if (inset_color == 0) {
        $('.color_leftmenu_color').addClass('font_leftmenu_new');
        inset_color++;
    } else {
        $('.color_leftmenu_color').removeClass('font_leftmenu_new');

        inset_color--;
    }

}, 500);
</script>