<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kavinga
 * Date: 10/27/13
 * Time: 1:50 PM
 * To change this template use File | Settings | File Templates.
 */

class Mprescribe_items extends My_Model{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'prescribe_items';
        $this->_key = 'PRS_ITEM_ID';
        $this->load->database();
    }
}