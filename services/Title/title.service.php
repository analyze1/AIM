<?php 
class IsoInsuranceControl
{
    private $_context;
    public function __construct($conn)
    {
        $this->_context = $conn;
    }

    public function titleOption($type)
    {
        $str = "SELECT prename AS `Name` FROM tb_titlename WHERE title_person_map_four LIKE '%$type%' ORDER BY title_order ASC";
        $result = $this->_context->query($str)->fetchAll(7);
        return $result;
    }
}
?>