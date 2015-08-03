<?php
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
echo "\n<html xmlns='http://www.w3.org/1999/xhtml'>";
echo "\n<head>";
echo "\n<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
//echo "\n<meta http-equiv='refresh' content='15' > ";
echo "\n<title>".$this->config->item('title')."</title>";
echo "\n<link rel='icon' type='". base_url()."image/ico' href='images/mds-icon.png'>";
echo "\n<link rel='shortcut icon' href='". base_url()."images/mds-icon.png'>";
echo "\n<link href='". base_url()."/css/mdstheme_navy.css' rel='stylesheet' type='text/css'>";
echo "\n<link href='". base_url()."/css/jquery-ui-1.8.9.custom.css' rel='stylesheet' type='text/css'>";
echo "\n<link href='". base_url()."/css/jquery.ui.datetimepicker.css' rel='stylesheet' type='text/css'>";

echo "\n<script type='text/javascript' src='". base_url()."js/jquery.js'></script>";
echo "\n<script type='text/javascript' src='". base_url()."/js/ui.js'></script>";
echo "\n    <script type='text/javascript' src='".base_url()."js/bootstrap/js/bootstrap.min.js' ></script>";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css' />";  
echo "\n<script type='text/javascript' src='". base_url()."/js/mdsCore.js'></script> ";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.hotkeys-0.7.9.min.js'></script>";

echo "\n</head>";