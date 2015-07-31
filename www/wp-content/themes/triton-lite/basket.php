<?php

//require_once("../../../wp-blog-header.php");

$id = $_POST["id"];

//$_SESSION['ordered_goods_id'][] = $id;

if (!session_id()) session_start();
//var_dump(session_id());
//echo "<pre>"; var_dump($GLOBALS); echo "</pre>"; 
if( is_null($_SESSION['ordered_goods_id_no']) )
{
    //$_SESSION['ordered_goods_id_no'] = 1;
}

//$ordered_goods_id_no = $_SESSION['ordered_goods_id_no'];
$ordered_goods_id_no++;
//var_dump($ordered_goods_id_no);
//$_SESSION['ordered_goods_id_no'] = $ordered_goods_id_no;
//var_dump($_SESSION['ordered_goods_id_no']);
//$_SESSION['ordered_goods_id'] = $id;
$_SESSION[] = $id;

echo "<pre>"; var_dump($_SESSION); echo "</pre>";

?>