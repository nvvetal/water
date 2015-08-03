<?php

//require_once("../../../wp-blog-header.php");

//$id = $_POST["id"];

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

//echo "<pre>"; var_dump($_SESSION); echo "</pre>";
//echo 'test';
?>
<?php

require_once("../../../wp-blog-header.php");

$id = $_POST["id"];

echo '<div class="modal hide in" id="modal-product" style="top: 73.5px; display: block;">';


$post = get_post($id);

$price = get_field('цена', $post);
$name = get_field('название_товара', $post);
$description_title = get_field('описание(заглавие)', $post);
$description = get_field('описание(текст)', $post);
echo"<div class='modal-header'>
  <h3>Список покупок</h3></div>";
echo '<div class="modal-body">';
echo '<table class="product-info">';
echo '<tbody>';
echo '<tr>';
echo '<td class="remove">';
echo '</td>';
echo '<td class="pic">';
echo '<div>';
echo '<img class="zoom-image" src="'.the_post_thumbnail().'" title="" Кодацкая="" вода""="">';//data-zoom-image="http://kodacka-voda.com/wp-content/uploads/2014/05/DSC05710-copy-683x1024.jpg"
echo '</div>';
echo '</td>';
echo '<td class="name">';
echo '<h1>'.$name.'</h1>';

echo '<div class="info">';
echo '<div class="price">'.$price.' грн.</div>';

//                                <!-- Add to cart -->
echo '<a class="btn btn-danger btn-large addToCart" data-product-id="312">Добавить в корзину</a>';

//                                <!-- Pictures -->
echo '</div>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td class="description" colspan="2">';
echo '<h2>'.$description_title.'</h2>';
echo '<p>'.$description.'</p>';
echo '<br>';
//
echo '</td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';

//        }
//        wp_reset_query();
//    }

echo '</div>';


?>