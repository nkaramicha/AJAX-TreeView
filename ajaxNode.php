<?php

error_reporting(E_ALL);
ini_set("display_startup_errors","1");
ini_set("display_errors","1");

//Get the node's id as entry parameter from URL
$entry = $_POST['entry']; 

//Require myTreeView class
require('myTreeView.class.php');

$ajaxTree = new myTreeView();

//Call the fetchAjaxTreeNode with the node's id
$result = $ajaxTree->fetchAjaxTreeNode($entry);

//Print the results
echo $result;
  
?> 