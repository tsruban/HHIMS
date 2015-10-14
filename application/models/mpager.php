<?php
/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> or write to:
Free Software  HHIMS
C/- Lunar Technologies (PVT) Ltd,
15B Fullerton Estate II,
Gamagoda, Kalutara, Sri Lanka
---------------------------------------------------------------------------------- 
Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org
Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com
URL: http: www.hhims.org
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/

class Mpager extends CI_Model
{

    const YES_NO_FORMATTER_EL = "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}";

    public static $GENDER_SELECT_EL = array('value' => ':All;Male:Male;Female:Female');
    private $id_EL = '_mds';
    private $sql_EL = '';
    private $exec_EL = '';
    private $sidx = '';
    private $datatype = 'local';
    private $colNames_JSAR = array();
    private $colModel_JSAR = array();
    private $rowNum = 25;
    private $rowList_JS = "[10,25,50,100]";
    private $imgpath = 'css/images';
    private $pager = '';
    private $sortname = '';
    private $viewrecords = true;
    private $sortorder = 'desc';
    private $caption = 'MDSPager Example';
    private $multiselect = false;
    private $width = 'auto';
    private $height = 'auto';
    private $autowidth = true;
    private $autoheight = true;
    private $mtype = 'POST';
    private $rowid;
    private $onSelectRow_JS = 'function(rowid){}';
    private $afterInsertRow_JS = 'function(rowid, data){}';
    private $colIndexes_EL = array();
    private $showHeaderRow_EL = 1;
    private $showFilterRow_EL = 1;
    private $showPager_EL = 1;
    //TSR
    private $divid_EL = '';
    private $divstyle_EL = '';
    private $divclass_EL = '';
    //properties used in reports
    private $widths_EL = array();
    private $orientation_EL = 'P';
    private $colHeaders_EL = array();
    private $title_EL = '';
    private $save_EL = '';
    private $report_EL = 'print_pager';
    private $link_EL;
    private $navBtns_EL = array();

    //static functions use to initialize common functions
    public static function getGenderSelector($default = '', $options = array())
    {

        return array_merge(
            array('stype'         => 'select', 'editoptions' => array('value' => ':All;Male:Male;Female:Female'),
                  "searchoptions" => array("defaultValue" => $default)), $options
        );
    }

    public static function getYesNoFormatter($default = '', $options = array())
    {

        return array_merge(
            array("formatter_JS"  => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",
                  'stype'         => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),
                  "searchoptions" => array("defaultValue" => '')), $options
        );
    }

    public function getDateSelector($default = '', $options = array())
    {

        $js = "function(el){";
        $js .= "$(el).datepicker({";
        $js .= "dateFormat:'yy-mm-dd',";
        $js .= "changeMonth:true,";
        $js .= "changeYear:true,";
        $js .= "showButtonPanel:true,";
        $js .= "autoSize:true,";
        $js .= "onSelect:function(dateText,inst){";
        $js .= "{$this->getGrid()}[0].triggerToolbar();";
        $js .= "}";
        $js .= "});";
        $js .= "}";

        return array_merge(
            array("stype" => "text", "searchoptions" => array("dataInit_JS" => $js, "defaultValue" => "$default")),
            $options
        );
    }

    function __construct($sql = null)
    {

        parent::__construct();
        $this->load->helper('url');
        $this->load->library('encrypt');
    }

    private function init()
    {

        $this->link_EL = $this->db;
        $this->id_EL   = uniqid("_");
        $this->createColModel();
        $this->pager   = $this->getPager();
        $this->exec_EL = $this->encrypt($this->sql_EL);
        foreach ($this->colModel_JSAR as $column) {
            $this->rowid = $column->getIndex();
            $this->sidx  = $column->getIndex();
            continue;
        }
    }

    function encrypt($string)
    {

        $encrypted_string = $this->encrypt->encode($string);
        $output           = base64_encode($encrypted_string);

        return urlencode($output);
    }

    function createColModel()
    {

        $result = $this->db->query($this->sql_EL);

        while ($field = mysql_fetch_field($result->result_id)) {
            $this->load->model('mpagercolumn');
            $this->mpagercolumn->setIdEL($this->id_EL);

            $uid   = str_replace('.','',uniqid("_",true)); // This was the problem where it dint wokred in Windows server.
            $title = $field->name;
            $table = $field->table;


            $this->mpagercolumn->setIndex($uid);
            $this->mpagercolumn->setName($uid);
            $this->mpagercolumn->setName_EL($title);
            $this->mpagercolumn->setTable($table);
            
            $this->mpagercolumn->setWidth(0);
            $this->mpagercolumn->setSortable(true);
            $this->mpagercolumn->setAlign('left');
            array_push($this->colNames_JSAR, $title);
            $this->caption = $table;

            array_push($this->colIndexes_EL, $this->mpagercolumn->getName());
            $this->colModel_JSAR['"' . $this->mpagercolumn->getName_EL() . '"'] = clone $this->mpagercolumn;

        }
        
 //PP configuration    
 //buttons to edit and erase in configuration ans PP Mode 
        if ($this->session->UserData("Config") == 'config_admin'){
         	 
         	// Deleting is possible in config mode for the erasable_menu
            	$erasable_menu = array('visit_type','treatment','injection', 'who_drug', 'village', 'drugs_dosage',
            	'drugs_frequency','drugs_period');
              // for the delete button
            	if(in_array($table, $erasable_menu)){	
				   
		            $uid   = uniqid("_");
		            $title = 'Delete';
		           
		            $this->mpagercolumn->setName_EL($title);
		           
		            $this->mpagercolumn->setWidth(1);    
		            array_push($this->colNames_JSAR, $title);
		           
		            array_push($this->colIndexes_EL, $this->mpagercolumn->getName());
		            $this->colModel_JSAR['"' . $this->mpagercolumn->getName_EL() . '"'] = clone $this->mpagercolumn;
              }
              
            
            //for the edit button
            $not_editable = array ('complaints','patient','opd_treatment', 'lab_order', 'notification', 'opd_presciption');  
              if (!in_array($table, $not_editable)){ 
            $uid   = uniqid("_");
            $title = 'Edit';
           
            $this->mpagercolumn->setName_EL($title);
           
            $this->mpagercolumn->setWidth(1);    
            array_push($this->colNames_JSAR, $title);
           
            array_push($this->colIndexes_EL, $this->mpagercolumn->getName());
            $this->colModel_JSAR['"' . $this->mpagercolumn->getName_EL() . '"'] = clone $this->mpagercolumn;
              }
        }
    }

    public function getColModel()
    {

        $model = '';
        foreach ($this->colModel_JSAR as $value) {
            $model .= $value->getColumnModel() . ",\n";
        }
        $model = substr($model, 0, -2);
        $model .= "\n";
	
        return $model;
    }

    public function getDataModel()
    {

        $ddmodel = '';
        foreach ($this->colModel_JSAR as $column) {
            $ddmodel .= $column->getDataModel() . ',';
        }
        $ddmodel = substr($ddmodel, 0, -1);
        
        return $ddmodel;
    }

    public function render($echoEnabled = true)
    {

        $backingUrl    = site_url("table/ajaxBacking");
        $printPagerUrl = site_url("table/printPager");
        $js            = '<script type="text/javascript">';
        $js .= "\n";
        //TSR: to load the table in given DIV

        $js .= "$(\"<table id='grid{$this->getId()}' class='scroll' cellpadding='0' cellspacing='0'></table>\").appendTo($('#"
            . $this->divid_EL . "'));\n";
        $js .= "$(\"<div id='pager{$this->getId()}' class='scroll' style='text-align:center;'></div>\").appendTo($('#"
            . $this->divid_EL . "'));\n";
        $js .= "$(function(){";
        $js .= "{$this->getGrid()}.jqGrid({";
        $js .= "{$this->getPagerModel()},";
        $js .= "postData:{cell:'{$this->getEncCellModel()}',id:'{$this->id_EL}',rowid:'{$this->getRowid(
        )}',exec:\"$this->exec_EL\"}";
        $js .= "});\n";
        $js .= $this->getGrid() . ".jqGrid('navGrid','{$this->getPager(
            )}',{del:false,add:false,edit:false,search:false});\n";
        $js .= $this->getGrid() . ".jqGrid('navButtonAdd','{$this->getPager()}',{caption:'Print',title:'Print this table',buttonicon:'ui-icon-print',onClickButton:function(){
            var data={$this->getArrayModel($this->colIndexes_EL)};
            var sortname={$this->getGrid()}.jqGrid('getGridParam','sortname');
            var sortorder={$this->getGrid()}.jqGrid('getGridParam','sortorder');
            var params={};
            params._search=false;
            for (var i=0;i<data.length;i++){var val=$('#gs_'+data[i]).val();if(val!='' && val!=undefined){params[data[i]]=val;params._search=true;};};
            params.sidx=sortname;
            params.sord=sortorder;
            params.exec=\"{$this->exec_EL}\";
            params.cell=\"{$this->getEncCellModel()}\";
            params.headers=\"{$this->encrypt($this->getArrayModel($this->colNames_JSAR))}\";
            params.title='{$this->encrypt($this->getTitle_EL())}';
            params.widths=\"{$this->encrypt($this->getArrayModel($this->widths_EL))}\";
            params.colHeaders=\"{$this->encrypt($this->getArrayModel($this->getColHeaders_EL()))}\";
            params.orientation='{$this->encrypt($this->orientation_EL)}';
            params.save='{$this->encrypt($this->getSave_EL())}';
            params.report='{$this->report_EL}';
            printPager(params);
        },position:'last'});\n";

        foreach ($this->navBtns_EL as $navBtn) {
            $js .= $this->getGrid() . ".jqGrid('navButtonAdd','{$this->getPager()}',{{$navBtn}});\n";
        }


        $print = "function printPager(params) {\n";
        $print .= "var args = \"menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700\";\n";
        $print .= "var url = \"$printPagerUrl\";\n";
        $print .= "var reportWindow = window.open('', 'Print Pager', args);\n";
        $print .= "with (reportWindow.document) {\n";
        $print .= "write(\"<form id='data_form' method='POST' action='\" + url\n";
        $print .= "+ \"' enctype='application/x-www-form-urlencoded' hidden>\");\n";
        $print .= "for (param in params) {";
        $print .= "write(\"<input type='text' name='\" + param + \"' value='\"\n";
        $print .= "+ params[param] + \"' />\");\n";
        $print .= "}\n";
        $print .= "write(\"</form>\");\n";
        $print .= "getElementById(\"data_form\").submit();\n";
        $print .= "}\n";
        $print .= "}\n";

        //setGridWidth
        if(isset($this->width) && $this->width!='auto'){
            $js .= $this->getGrid() . ".jqGrid('setGridWidth',$this->width,true);\n";
        }

        if ($this->showFilterRow_EL) {
            $js .= $this->getGrid() . ".jqGrid('filterToolbar',{stringResult: true,searchOnEnter:false});\n";
            $js .= $this->getGrid() . ".jqGrid('setGridParam',{datatype:'json',url:'$backingUrl',width:'100%'});\n";
            $js .= $this->getGrid() . "[0].clearToolbar();\n";
        } else {
            $js .= $this->getGrid() . ".jqGrid('setGridParam',{datatype:'json',url:'$backingUrl'});\n";
            $js .= $this->getGrid() . ".trigger('reloadGrid');";
        }
        if (!$this->showHeaderRow_EL) {
            $js .= $this->getGrid(
                ) . ".parents('div.ui-jqgrid-view').children('div.ui-jqgrid-hdiv').find('tr.ui-jqgrid-labels').hide();\n";
        }

        $js .= $this->getGrid() . ".jqGrid('navGrid','#" . $this->id_EL . "pager',{
            'add':false,
            'del':false,
            'refresh':false,
            'edit':false,
            'search':false,
            })";
        $js .= "});\n";
        if (!$this->showPager_EL) {
            $js .= "$(\"#pager$this->id_EL\").remove(); \n";
        }

        $js .= $print;
        $js .= "</script>\n";
        if ($echoEnabled) {
            echo $js;
        } else {
            return $js;
        }
    }

    public function addNavBtn($js)
    {

        $this->navBtns_EL[] = $js;
    }

    private function getEncCellModel()
    {

        $toenc = '[' . $this->getDataModel() . ']';

        return $this->encrypt($toenc);
    }

    private function getBase64Enc($param)
    {

        return base64_encode($param);
    }

    public function getPagerModel($array = null)
    {

        if (!$array) {
            $options = $this;
        } else {
            $options = $array;
        }
        $model = '';
        foreach ($options as $property => $value) {
            $ar = explode("_", $property);
            if (count($ar) == 2) {
                $property = $ar[0];
                $sf       = $ar[1];

                switch ($sf) {
                    case 'JS':
                        $model .= "$property:";
                        $model .= $value;
                        $model .= ',';
                        continue 2;
                        break;
                    case 'JSAR':
                        $model .= "$property:";
                        $model .= $this->getArrayModel($value);
                        $model .= ',';
                        continue 2;
                        break;
                    case 'EL':
                        continue 2;
                        break;
                    default:
                        break;
                }
            }

            $model .= "$property:";
            $model .= $this->getType($value);
        }

        $model = substr($model, 0, -1);

        return $model;
    }

    private function getArrayModel($array)
    {

        $model = '[';
        foreach ($array as $value) {
            $model .= $this->getType($value);
        }
        $model = substr($model, 0, -1);
        $model .= ']';

        return $model;
    }

    private function getType($value)
    {

        $model = '';
        switch (gettype($value)) {
            case 'string':
                $model .= "'$value',";
                break;
            case 'integer':
                $model .= $value;
                $model .= ',';
                break;
            case 'boolean':
                $model .= $value ? 'true' : 'false';
                $model .= ',';
                break;
            case 'array':
                $model .= $this->getPagerModel($value);
                $model .= ',';
                break;
            case 'object':
                $model .= "$value,";
                break;
            default:
                $model .= "'D$value',";
                break;
        }

        return $model;
    }

    public function setColOption($name, $options)
    {
    	
        $column = $this->colModel_JSAR['"' . $name . '"'];
        foreach ($options as $key => $value) {
            $column->__set($key, $value);
        }
    }


    public function setDataModel($name, $model)
    {

        $this->colModel_JSAR['"' . $name . '"']->__set("ddtype", $model);
    }

    public function getColNames()
    {

        $names = '';
        foreach ($this->colNames_JSAR as $name) {
            $names .= "'$name',";
        }

        return substr($names, 0, -1);
    }

    //TSR
    public function setDivId($div_id)
    {

        $this->divid_EL = $div_id;
    }

    public function setDivClass($div_class)
    {

        $this->divclass_EL = $div_class;
    }

    public function setDivStyle($div_Style)
    {

        $this->divstyle_EL = $div_Style;
    }

    public function setColNames($colNames)
    {

        $this->colNames_JSAR = $colNames;
    }

    public function getPager()
    {

        return '#pager' . $this->id_EL;
    }

    public function setPager($pager)
    {

        $this->pager = $pager;
    }

    public function getSortname()
    {

        if ($this->sortname) {
            return $this->sortname;
        } else {
            foreach ($this->colModel_JSAR as $column) {
                return $column->getIndex();
            }
        }
    }

    public function setSortname($sortname)
    {

        $this->sortname = $sortname;
    }

    public function getViewrecords()
    {

        return $this->viewrecords ? 'true' : 'false';
    }

    public function setViewrecords($viewrecords)
    {

        $this->viewrecords = $viewrecords;
    }

    public function getMultiselect()
    {

        return $this->multiselect ? 'true' : 'false';
    }

    public function setMultiselect($multiselect)
    {

        $this->multiselect = $multiselect;
    }

    public function getSql()
    {

        return $this->sql_EL;
    }

    public function setSql($sql)
    {

        $this->sql_EL = $sql;
        $this->init();
    }

    public function getUrl()
    {

        return $this->url;
    }

    public function setUrl($url)
    {

        $this->url = $url;
    }

    public function getDatatype()
    {

        return $this->datatype;
    }

    public function setDatatype($datatype)
    {

        $this->datatype = $datatype;
    }

    public function getRowNum()
    {

        return $this->rowNum;
    }

    public function setRowNum($rowNum)
    {

        $this->rowNum = $rowNum;
    }

    public function getRowList()
    {

        return $this->rowList_JS;
    }

    public function setRowList($rowList)
    {

        $this->rowList_JS = $rowList;
    }

    public function getImgpath()
    {

        return $this->imgpath;
    }

    public function setImgpath($imgpath)
    {

        $this->imgpath = $imgpath;
    }

    public function getSortorder()
    {

        return $this->sortorder;
    }

    public function setSortorder($sortorder)
    {

        $this->sortorder = $sortorder;
    }

    public function getCaption()
    {

        return $this->caption;
    }

    public function setCaption($caption)
    {

        $this->caption = $caption;
    }

    public function getOnSelectRow()
    {

        if ($this->onSelectRow_JS) {
            return "function(rowid){" . $this->onSelectRow_JS . "}";
        } else {
            return "function(rowid){}";
        }
    }

    public function setOnSelectRow($onSelectRow)
    {

        $this->onSelectRow_JS = $onSelectRow;
    }

    public function getPagerOptions()
    {

        return $this->pagerOptions;
    }

    public function setPagerOptions($pagerOptions)
    {

        $this->pagerOptions = $pagerOptions;
    }

    public function getWidth()
    {

        return $this->width;
    }

    public function setWidth($width)
    {

        $this->width = $width;
    }

    public function getMtype()
    {

        return $this->mtype;
    }

    public function setMtype($mtype)
    {

        $this->mtype = $mtype;
    }

    public function getId()
    {

        return $this->id_EL;
    }

    public function getGrid()
    {

        return '$("#grid' . $this->id_EL . '")';
    }

    public function getHeight()
    {

        return $this->height;
    }

    public function setHeight($height)
    {

        $this->height = $height;
    }

    public function getRowid()
    {

        if ($this->rowid) {
            return $this->rowid;
        } else {
            foreach ($this->colModel_JSAR as $column) {
                return $column->getIndex();
            }
        }
    }

    public function setRowid($rowid)
    {

        $this->rowid = $rowid;
    }

    public function getAfterInsertRow()
    {

        if ($this->afterInsertRow_JS) {
            return "function(rowid, data){{$this->afterInsertRow_JS}}";
        } else {
            return "function(rowid, data){}";
        }
    }

    public function setSidx($sidx)
    {

        $this->sidx = $sidx;
    }

    public function setWidths_EL($widths_EL)
    {

        $this->widths_EL = $widths_EL;
    }

    public function setOrientation_EL($orientation_EL)
    {

        $this->orientation_EL = $orientation_EL;
    }

    public function setColHeaders_EL($colHeaders_EL)
    {

        $this->colHeaders_EL = $colHeaders_EL;
    }

    public function setTitle_EL($title_EL)
    {

        $this->title_EL = $title_EL;
    }

    public function setSave_EL($save_EL)
    {

        $this->save_EL = $save_EL;
    }

    public function getTitle_EL()
    {

        return $this->title_EL ? $this->title_EL : $this->caption;
    }

    public function getColHeaders_EL()
    {

        return count($this->colHeaders_EL) > 0 ? $this->colHeaders_EL : $this->colNames_JSAR;
    }

    public function setReport_EL($report_EL)
    {

        $this->report_EL = $report_EL;
    }

    public function getSave_EL()
    {

        return $this->save_EL ? $this->save_EL : $this->caption;
    }

    public function setShowHeaderRow($showHeaderRow_EL)
    {

        $this->showHeaderRow_EL = $showHeaderRow_EL;
    }

    public function setShowFilterRow($showFilterRow_EL)
    {

        $this->showFilterRow_EL = $showFilterRow_EL;
    }

    /**
     * set pager visibility.default to true
     */
    public function setShowPager($showPager_EL)
    {

        $this->showPager_EL = $showPager_EL;
    }


    /**
     * @param String afterInsertRow javascript code to
     *               execute after insert new row
     *               call after insert row.referances
     *               rowid, data
     */
    public function setAfterInsertRow($afterInsertRow)
    {

        $this->afterInsertRow_JS = $afterInsertRow;
    }

    function mysqlReport($pdf, $sql, $colTitles, $colWidths)
    {

        $pdf->AddPage();
        $pdf->Ln();
        $currentPageWidth = $pdf->getPageWidth();
        unset($result);
        $result    = $this->db->query($sql);
        $numOfRows = $result->num_rows();
        if ($numOfRows == 0) {
            $pdf->Write(6, 'No Result Found.');

            return;
        } else {
            if ($numOfRows > 1000) {
                $pdf->SetTextColor(255, 0, 0);
                $pdf->SetFontSize(20);
                $pdf->Write(6, "the selected table contains more than 1000 rows of data.!");

                return $pdf;
            }
        }
        $numOfFields = mysql_num_fields($result->result_id);
        $colNames    = array();


        $maxWidths = array();
        while ($row = mysql_fetch_array($result->result_id)) {
            for ($i = 0; $i < $numOfFields; $i++) {
                $name = $colTitles[$i];
                $d    = $row[$i];
                $w1   = $pdf->GetStringWidth($d);
                $w2   = isset($maxWidths[$name]) ? $maxWidths[$name] : 0;
                if ($w1 > $w2) {
                    $maxWidths[$name] = $w1;
                }
            }
        }

        $feasibleWidths = array();
        $totalLength    = array_sum($maxWidths);

        for ($i = 0; $i < $numOfFields; $i++) {
            $name      = $colTitles[$i];
            $nameWidth = $pdf->GetStringWidth($name);
            $maxWidth  = isset($maxWidths[$name])?$maxWidths[$name]:0;

            if ($nameWidth > $maxWidth) {
                $nameWidth += 2;
                $feasibleWidths[$name] = $nameWidth;
                $currentPageWidth -= $nameWidth;
                $totalLength -= $maxWidth;
            }
        }
        $aWidths = array();
        for ($i = 0; $i < $numOfFields; $i++) {

            $name      = $colTitles[$i];
            $nameWidth = $pdf->GetStringWidth($name);
            $maxWidth  = isset($maxWidths[$name])?$maxWidths[$name]:0;
            if ($nameWidth <= $maxWidth) {
                $r              = $maxWidth / $totalLength;
                $columnWidth    = $r * $currentPageWidth;
                $aWidths[$name] = $columnWidth;
            } else {
                $aWidths[$name] = isset($feasibleWidths[$name]) ? $feasibleWidths[$name] : 10;
            }


        }

        if ($colWidths && count($colWidths) == $numOfFields) {
            $pdf->SetWidths($colWidths);
        } else {
            $pdf->SetWidths(array_values($aWidths));
        }
        if ($colTitles && count($colTitles) == $numOfFields) {
            $pdf->Row($colTitles, true);
        } else {
            $pdf->Row($colNames, true);
        }

        unset($result);
        $result = $this->db->query($sql);
        foreach ($result->result_array() as $row) {
            $pdf->Row(array_values($row));
        }

        return $pdf;

    }
    public function getColModelJSAR()
    {
        return $this->colModel_JSAR;
    }
}
