<?php
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
echo "\n<html xmlns='http://www.w3.org/1999/xhtml'>";
echo "\n<head>";
echo "\n<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
echo "\n<title>".$this->config->item('title')."</title>";

echo "\n<link rel='icon' type='". base_url()."/image/ico' href='images/mds-icon.png'>";
echo "\n<link rel='shortcut icon' href='". base_url()."/images/mds-icon.png'>";
echo "\n<link href='". base_url()."/css/mdstheme_navy.css' rel='stylesheet' type='text/css'>";
echo "\n<link href='". base_url()."/css/jquery.alerts.css' rel='stylesheet' type='text/css'>";

echo "\n<link href='". base_url()."/css/demo.css' rel='stylesheet' type='text/css'>";
echo "\n<link href='". base_url()."/css/jquery-ui-1.8.9.custom.css' rel='stylesheet' type='text/css'>";
echo "\n<link href='". base_url()."/css/jquery.ui.datetimepicker.css' rel='stylesheet' type='text/css'>";

echo "\n<link href='". base_url()."/css/mds_k.css' rel='stylesheet' type='text/css'>";
echo "\n<link href='". base_url()."/css/layout_k.css' rel='stylesheet' type='text/css'>";


echo "\n<link rel='stylesheet' type='text/css' media='screen' href='". base_url()."/css/themes/ui.jqgrid.css' />";


echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.js'></script>";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.event.drag.min.js'></script>";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.RightClik.js'></script>";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.UI.Min.js'></script>";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.print.js'></script>";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.alerts.js'></script> ";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.cookie.js'></script> ";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.ui.datetimepicker.min.js'></script>";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.text.js'></script> ";
echo "\n<script type='text/javascript' src='". base_url()."/js/mdsCore.js'></script> ";
		echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.hotkeys-0.7.9.min.js'></script>";
        echo "\n<script type='text/javascript' language='javascript' src='". base_url()."/js/jquery.dataTables.js'></script> ";
        echo "\n<script type='text/javascript' language='javascript' src='". base_url()."/js/jquery.ui.datepicker.js'></script>"; 
		
		
echo "\n    <script type='text/javascript' src='".base_url()."js/bootstrap/js/bootstrap.min.js' ></script>";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css' />";		
        
//<!--        scripts for pager starts-->
        echo "\n<script src='". base_url()."/js/jquery.layout.js' type='text/javascript'></script>";
            echo "\n<script src='". base_url()."/js/i18n/grid.locale-en.js' type='text/javascript'></script>";
            echo "\n<script type='text/javascript'>";
                echo "\n$.jgrid.no_legacy_api = true;";
                echo "\n$.jgrid.useJSON = true;";
            echo "\n</script>";
            echo "\n<script src='". base_url()."/js/jquery.jqGrid.min.js' type='text/javascript'></script>";
            echo "\n<script src='". base_url()."/js/jquery.tablednd.js' type='text/javascript'></script>";
            echo "\n<script src='". base_url()."/js/jquery.contextmenu.js' type='text/javascript'></script>";
            echo "\n<script src='". base_url()."/js/ui.multiselect.js' type='text/javascript'></script>";
//<!--        scripts for pager ends-->



echo "\n</head>";

