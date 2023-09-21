<?
    class ProvinceModel
    {
        public $id;
        public $nameMini;
    }
    
    class PdfQueryPrb
    {
            private $_dbname;
            private $_user;
            private $_pass;
            private $_tbProvince;
    
            public function __construct($dbname,$user,$pass)
            {
                $this->_dbname = $dbname;
                $this->_user = $user;
                $this->_pass = $pass;
                $this->_tbProvince[] = array();
            }
            public function connectTbProvince()
            {
                $sql = "SELECT * FROM tb_province";
                $conn = new PDO('mysql:host=localhost;dbname='.$this->_dbname,$this->_user,$this->_pass,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
                if(!$conn)
                {
                    echo "<script>console.log('Database Connect Failed.');</script>";
                }
                $res = $conn->query($sql);
                $ress = $res->fetchAll();
                $conn = null;
                foreach($ress as $rs)
                {
                    $inni = new ProvinceModel();
                    $inni->id = $rs['id'];
                    $inni->nameMini =  $rs['name_mini'];
                    array_push($this->_tbProvince,$inni);
                }
                
                $conn = null;
            }
    
            public function loadprovince($id)
            {
                $round = count($this->_tbProvince);
                
                for($i=0;$i<$round;$i++)
                {
                    if($this->_tbProvince[$i]->id == $id)
                    {
                        return $this->_tbProvince[$i]->nameMini;
                    }
                }
            }
    
            public function close()
            {
    
            }
    }

?>