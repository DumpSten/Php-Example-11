<?php 

include_once 'baglan.php';
require 'header.php';

$_GET = array_map(function($get){
    return htmlspecialchars(trim($get));
}, $_GET );

if (!isset($_GET['sayfa'])) {
    $_GET['sayfa'] = 'index';
}

switch ($_GET['sayfa']) {
    case 'index':
        include_once 'homepage.php';
        break;
    case 'insert':
        include_once 'insert.php';
        break;
    case 'read':
        include_once 'read.php';
        break;    
    case 'update':
        include_once 'update.php';
        break;
    case 'delete':
        include_once 'delete.php';
        break;
    case 'categories':
        include_once 'categories.php';
        break; 
    case 'categories_add':
        include_once 'categories_add.php';
        break;
    case 'categorie':
        include_once 'categorie.php';
        break;        
}

?>