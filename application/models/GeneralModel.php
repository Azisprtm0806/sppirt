<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GeneralModel extends MY_Model 
{
    
    public function __construct($tableName = null)
    {
        parent::__construct();
        $this->tblName = $tableName;
        $this->tblId = "id";
    }

}
?>