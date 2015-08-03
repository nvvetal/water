<?php

require_once("../../../wp-blog-header.php");

$id = $_POST["id"];

echo '<div class="modal hide in" id="modal-product" style="top: 73.5px; display: block;">';


            $post = get_post($id);

            $price = get_field('цена', $post);
            $name = get_field('название_товара', $post);
            $description_title = get_field('описание(заглавие)', $post);
            $description = get_field('описание(текст)', $post);

            echo '<div class="modal-body">';
            echo '<table class="product-info">';
            echo '<tbody>';
            echo '<tr>';
                echo '<td class="pic">';
                    echo '<div>';
                    echo '<img class="zoom-image" src="'.the_post_thumbnail().'"  title="" Кодацкая="" вода""="">';//data-zoom-image="'.the_post_thumbnail().'"
                    echo '</div>';
                echo '</td>';
                echo '<td class="content">';
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
    //                            echo '<h2>Характеристики</h2>';
    //                            echo '<p>';
    //                            echo '</p><table>';
    //                                echo '<tbody><tr>';
    //                                    echo '<td>Объем, л</td>';
    //                                    echo '<td><b>18,9</b></td>';
    //                                echo '</tr>';
    //                                echo '<tr>';
    //                                    echo '<td>Жесткость общая, ммоль/дм3</td>';
    //                                    echo '<td><b>2,9</b></td>';
    //                                echo '</tr>';
    //                                echo '<tr>';
    //                                    echo '<td>Щелочность общая, ммоль/дм3</td>';
    //                                    echo '<td><b>2,9</b></td>';
    //                                echo '</tr>';
    //                                echo '<tr>';
    //                                    echo '<td>Сухой остаток, мг/дм3</td>';
    //                                    echo '<td><b>170</b></td>';
    //                                echo '</tr>';
    //                                echo '</tbody></table>';
    //                            echo '<p></p>';
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