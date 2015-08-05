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
            //$_SESSION[] = $id;
//echo "<pre>"; var_dump($_SESSION); echo "</pre>";
//echo 'test';
?>
<?php
require_once("../../../wp-blog-header.php");
$id = $_POST["id"];
if(!isset ($_POST["quantity"])) {$last_q=1;}else{
    $last_q=$_POST["quantity"];
}
$user_id=$_COOKIE["id"];
$post = get_post($id);
$price = get_field('цена', $post);
$name = get_field('название_товара', $post);
$description_title = get_field('описание(заглавие)', $post);
$description = get_field('описание(текст)', $post);
$result = $wpdb->get_var("SELECT COUNT(*) as cnt FROM wp_goods_list WHERE id_goods = ".$id." ");
//echo "<pre>"; var_dump($result); exit;
if($result<1) {
    $wpdb->show_errors();
    $wpdb->insert(wp_goods_list, array("user_id" => $user_id, "id_goods" => $id, "price_goods" => $price, "quantity" => $last_q,), array("%d", "%d", "%s", "%d"));
}
echo '<div class="modal hide in" id="modal-product" style="top: 73.5px; display: block;">';


echo"<div class='modal-header'>
  <h3>Список покупок</h3></div>";
echo '<div class="modal-body">';
echo '<table class="product-info">';
echo '<tbody>';
echo '<tr>';
echo '<td class="remove">';
echo 'X';
echo '</td>';
echo '<td class="picMini">';
echo '<div>';
echo '<img class="zoom-image1" src="'.the_post_thumbnail().'" title="" Кодацкая="" вода""="">';//data-zoom-image="http://kodacka-voda.com/wp-content/uploads/2014/05/DSC05710-copy-683x1024.jpg"
echo '</div>';
echo '</td>';
echo '<td class="name">';
echo '<h4>'.$name.'</h4>';
echo '</td>';
echo '<td>';
echo '<div class="quantity">
      <span class="minus" onClick="orderQuantityMinus1();"></span>
      <span>
      <input class="val" type="text" name="quantity" value="1" data-price="<?php echo $price; ?>" data-price-2-4="35" data-price-5-9="32" data-price-10-19="29" data-price-20-49="26" data-price-50="23">
      </span>
      <span class="plus" onClick="orderQuantityPlus1();"></span>
      </div>';
echo '</td>';
echo '<td>';
echo '<div class="info">';
echo '<div class="price">'.$price.' грн.</div>';
//                                <!-- Add to cart -->
echo '<a class="btn btn-danger btn-large addToCart" data-product-id="312">Добавить в корзину</a>';
//                                <!-- Pictures -->
echo '</div>';
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