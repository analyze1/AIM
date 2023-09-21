<?php
//include "../check-ses.php"; 
//include "../inc/checksession.inc.php";
//include "../inc/connectdbs.inc.php"; 


		$sqlMORE = "SELECT * FROM tb_acc";
		$objQueryMORE = PDO_CONNECTION::fourinsure_mitsu()->query($sqlMORE);
		$costOb = array();
			foreach($objQueryMORE->fetchAll(2) as $rowCost )
			{
				$costOb['name'][$rowCost['id']] = $rowCost['name'];
				$costOb['price'][$rowCost['id']] = $rowCost['price'];
				$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
				$PreProduct['PreCZ_GA'][$rowCost['price']] = $rowCost['PreCZ_GA'];
				$PreProduct['PreCZ_GL'][$rowCost['price']] = $rowCost['PreCZ_GL'];
				$PreProduct['PreCZ_GLX'][$rowCost['price']] = $rowCost['PreCZ_GLX'];
				$PreProduct['PreAS1_GA'][$rowCost['price']] = $rowCost['PreAS1_GA'];
				$PreProduct['PreAS1_GL'][$rowCost['price']] = $rowCost['PreAS1_GL'];
				$PreProduct['PreAS1_GLX'][$rowCost['price']] = $rowCost['PreAS1_GLX'];

			}
			$_SESSION["Cost"] = $costOb; //ราคาอุปกรณ์ตกแต่ง และเบี้ยเพิ่ม
			$_SESSION['PriceProduct'] = $PreProduct;

		//---------------------------รายการอุปกรณ์ตกแต่ง-------------------------------
		$sqlMOREname = "SELECT * FROM tb_acc_new";
		$objQueryMOREname = PDO_CONNECTION::fourinsure_mitsu()->query($sqlMOREname);
		$costObname = array();
			foreach($objQueryMOREname->fetchAll(2) as $rowCostname ){
				$costObname['name']['0'.$rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
			}
			$_SESSION["CostName"] = $costObname; //รายการอุปกรณ์ตกแต่ง
	
		//---------------------------ทุน เบี้ยสุทธิ อากร ภาษี เบี้ยรวม-------------------------------
		$TbCost = array();
		$queryTbCost = "SELECT id,cost,pre,stamp,tax,net FROM tb_cost";
		$objQueryTbCost = PDO_CONNECTION::fourinsure_mitsu()->query($queryTbCost);
			foreach($objQueryTbCost->fetchAll(2) as $rowTbCost) {
				$TbCost['cost'][$rowTbCost['id']]= $rowTbCost['cost'];
				$TbCost['pre'][$rowTbCost['id']]= $rowTbCost['pre'];
				$TbCost['stamp'][$rowTbCost['id']]= $rowTbCost['stamp'];
				$TbCost['tax'][$rowTbCost['id']]= $rowTbCost['tax'];
				$TbCost['net'][$rowTbCost['id']]= $rowTbCost['net'];
			}
			$_SESSION["TbCost"] = $TbCost; //ทุน เบี้ยสุทธิ อากร ภาษี เบี้ยรวม
		
		//---------------------------ชื่อรุ่น-------------------------------			
		$MoC = array();
		$queryMoC = "SELECT * FROM tb_mo_car";
		$objQueryMoC = PDO_CONNECTION::fourinsure_mitsu()->query($queryMoC);
			foreach($objQueryMoC->fetchAll(2) as $rowMoC )
			{
				$MoC['name'][$rowMoC['id']]= $rowMoC['name'];
				$MoCd[$rowMoC['id']]=$rowMoC['cost_group'];
			}
			$_SESSION["MoC"] = $MoC; //ชื่อรุ่น
			$_SESSION["MoCd"] = $MoCd;
			
		//---------------------------ยี่ห้อ-------------------------------			
		$BrC = array();
		$queryBrC = "SELECT id,cat_id,name,code_br_car FROM tb_br_car";
		$objQueryBrC = PDO_CONNECTION::fourinsure_mitsu()->query($queryBrC);
			foreach($objQueryBrC->fetchAll(2) as $rowBrC)
			{
				$BrC['name'][$rowBrC['id']]= $rowBrC['name'];
			}
			$_SESSION["BrC"] = $BrC; //ยี่ห้อ
		
		//---------------------------จังหวัด-------------------------------		
		$Pro = array();
		$queryPro = "SELECT id,name,name_mini FROM tb_province";
		$objQueryPro = PDO_CONNECTION::fourinsure_mitsu()->query($queryPro);
			foreach($objQueryPro->fetchAll(2) as $rowPro )
			{
				$Pro[$rowPro['id']]=$rowPro['name'];
				$Pro2['name'][$rowPro['id']]= $rowPro['name'];
				$Pro3['name_mini'][$rowPro['id']]= $rowPro['name_mini'];
			}
			$_SESSION["Pro"] = $Pro; //จังหวัด
			$_SESSION["Pro2"] = $Pro2; //จังหวัด
			$_SESSION["Pro3"] = $Pro3; //จังหวัด
		
		//---------------------------อำเภอ-------------------------------	
		$Amp = array();
		$queryAmp = "SELECT id,name FROM tb_amphur";
		$objQueryAmp = PDO_CONNECTION::fourinsure_mitsu()->query($queryAmp);
			foreach($objQueryAmp->fetchAll(2) as $rowAmp) 
			{
				$Amp[$rowAmp['id']]=$rowAmp['name'];
				$Amp2['name'][$rowAmp['id']]= $rowAmp['name'];
			}
			$_SESSION["Amp"] = $Amp; //อำเภอ
			$_SESSION["Amp2"] = $Amp2; //อำเภอ
		
		//---------------------------ตำบล-------------------------------	
		$Tum = array();
		$queryTum = "SELECT id,name FROM tb_tumbon";
		$objQueryTum =  PDO_CONNECTION::fourinsure_mitsu()->query($queryTum);
			foreach($objQueryTum->fetchAll(2) as $rowTum) 
			{
				$Tum[$rowTum['id']]=$rowTum['name'];
				$Tum2['name'][$rowTum['id']]= $rowTum['name'];
			}
			$_SESSION["Tum"] = $Tum; //ตำบล
			$_SESSION["Tum2"] = $Tum2; //ตำบล
		
		//---------------------------อัตราเบี้ย-------------------------------	
		$Pre = array();
		$queryPre = "SELECT id,pre,stamp,tax,cost,net FROM tb_cost";
		$objQueryPre = PDO_CONNECTION::fourinsure_mitsu()->query($queryPre);
		foreach($objQueryPre->fetchAll(2) as $rowPre)
		{
			$Pre['PreCost'][$rowPre['id']]= $rowPre['cost'];
			$Pre['pre'][$rowPre['id']]= $rowPre['pre'];
			$Pre['stamp'][$rowPre['id']]= $rowPre['stamp'];
			$Pre['tax'][$rowPre['id']]= $rowPre['tax'];
			$Pre['net'][$rowPre['id']]= $rowPre['net'];
		}
		$_SESSION["CostPre"] = $Pre; //ทุน เบี้ยสุทธิ อากร ภาษี เบี้ยรวม



//ต่ออายุ ตัดติดตามเกิน
/*		*/
				
				
?>