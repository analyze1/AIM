<?php
// include "../inc/checksession.inc.php";
include "../inc/connectdbs.pdo.php";

class DealerRenewSuzukiInfo
{
	private $_contextMitsubishi;
	private $_contextFour;

	public function __construct($con, $conf)
	{
		$this->_contextMitsubishi = $con;
		$this->_contextFour = $conf;
	}

	public function getUploadApprove()
	{
		$sqlApp = "SELECT
				t1.Id,
				t1.PatchFile,
				t1.DealerCode,
				t1.Follow,
				t1.Approve,
				t1.DateUpload,
				t1.DateApprove,
				t1.`Type`,
				t1.`Status`,
				t1.keyran,
				t1.become 
			FROM
				upload_admin_telephone AS t1
				JOIN ( SELECT MAX( Id ) AS Id2 FROM upload_admin_telephone GROUP BY DealerCode ) AS t2 ON (
				t1.Id = t2.Id2)";
		$approve = $this->_contextMitsubishi->query($sqlApp);
		$appArr = array();
		foreach ($approve->fetchAll(5) as $ap) {
			$appArr[$ap->DealerCode] = $ap;
		}

		return $appArr;
	}

	public function getBenefit()
	{
		$sql = "SELECT agent_dis,id_agent,full_name FROM tb_agent";
		$beneArr = $this->_contextFour->query($sql)->fetchAll(5);
		$r = array();
		foreach ($beneArr as $b) {
			$r[$b->id_agent] = $b;
		}

		return $r;
	}

	public function getCustomerMitsubishi()
	{
		$dealeSQL = "SELECT t.user,CONCAT(title_sub,' ',sub) AS nameSub,t.emp_namerenew,t.emp_telrenew FROM tb_customer AS t 
		WHERE t.nameuser = 'Mitsubishi'";
		$dealer_query = $this->_contextMitsubishi->query($dealeSQL);
		$dealer_array = $dealer_query->fetchAll(5);
		return $dealer_array;
	}

	public function checkApprove($customer, $approves, $bene)
	{
		$model = array();
		$value = $approves[$customer->user];
		$zAgent = 'M' . subStr($customer->user, 1, 5);
		$benefit = $bene[$zAgent] ? $bene[$zAgent] : $bene[$customer->user];
		$linkDoc = 'https://viriyah.net/mitsubishi/DocAdminTelephone';
		$linkApp = 'https://viriyah.net/mitsubishi/Share/ApproveMitsubishiNotice/src/Approve-Mitsubishi.php?id=';
		if (!empty($value)) {
			$model['doc'] = "<a href='$linkDoc/$value->PatchFile' target='_blank' class='btn btn-primary'>ดูเอกสาร</a>";

			switch ($value->Approve) {
				case 'Y': {
						if ($value->Follow == 'D') {
							$model['status'] = "<button class='btn btn-success' type='button'>อนุมัติแล้ว</button>";
							$model['nameAp'] = $customer->emp_namerenew;
							$model['telAp'] = $customer->emp_telrenew;
						} else {
							$model['status'] = "<button class='btn btn-success' type='button'>อนุมัติแล้ว</button>";
							$model['nameAp'] = 'มอบหมายให้โฟรฯ เป็นผู้ติดตาม<br>' . "ประสานงาน [$customer->emp_namerenew]";
							$model['telAp'] = $customer->emp_telrenew;
						}
						break;
					}
				case 'P': {
						$base = array();
						$base['id'] = $value->DealerCode;
						$base['key'] = $value->keyran;
						$json = json_encode($base);
						$url = $linkApp . base64_encode($json);
						$model['status'] = "<a href='$url' target='_blank' style='white-space: pre'  class = 'btn btn-warning '>ยังไม่อนุมัติ(เข้าอนุมัติได้)</a>";
						$model['nameAp'] = '-';
						$model['telAp'] = '-';
						break;
					}
				default: {
						$model['status'] = '-';
						$model['nameAp'] = '-';
						$model['telAp'] = '-';
						break;
					}
			}

			$model['nameFull'] = $customer->nameSub;
			$model['dealerID'] = $customer->user;

			switch ($value->Follow) {
				// case 'F': {
				// 		$model['benefit'] = '-';
				// 		break;
				// 	}

				default: {
						$model['benefit'] = $benefit->agent_dis ? $benefit->agent_dis : '-';
						break;
					}
			}
		} else {
			$model['doc'] = '-';
			$model['status'] = '-';
			$model['nameFull'] = $customer->nameSub;
			$model['dealerID'] = $customer->user;
			$model['nameAp'] = '-';
			$model['telAp'] = '-';
			$model['benefit'] = '-';
		}
		return (object)$model;
	}

	public function loadInfo()
	{
		$i = 0;
		$data = array();
		$datas = array();

		$appArr = $this->getUploadApprove();
		$dealers = $this->getCustomerMitsubishi();
		$benef = $this->getBenefit();

		foreach ($dealers as $dealer) {

			if (!empty($dealer)) {
				$checkAp = $this->checkApprove($dealer, $appArr, $benef);

				$datas[$i]['Status'] = "<div align='center'>$checkAp->status</div>";
				$datas[$i]['Doc'] = "<div align='center'>$checkAp->doc</div>";
				$datas[$i]['DealerID'] = "<div align='center'>$checkAp->dealerID</div>"; //'<div align='center'>' . $dealer['user'] . '</div>';
				$datas[$i]['NameDealer'] = "<div>$checkAp->nameFull</div>"; //'<div align="left">' . $dealer['nameSub'] . '</div>';
				$datas[$i]['NameAp'] = "<div align='center'>$checkAp->nameAp</div>";
				$datas[$i]['TelAp'] = "<div align='left'>$checkAp->telAp</div>";
				$datas[$i]['Benefit'] = "<div align='center'>$checkAp->benefit</div>";
				$i++;
			}
		}

		$data['data'] = $datas;

		return $data;
	}
}

$_service = new DealerRenewSuzukiInfo(
	PDO_CONNECTION::fourinsure_mitsu(),
	PDO_CONNECTION::fourinsure_insured()
);

$result = $_service->loadInfo();
echo json_encode($result);
