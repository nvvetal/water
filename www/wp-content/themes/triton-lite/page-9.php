<?php get_header(); ?>


<?php
    $queried_object = get_queried_object();

    $background = get_field("баннер(изображение)", $queried_object);
    $background_text1 = get_field("баннер(текст_1)", $queried_object);
    $background_text2 = get_field("баннер(текст_2)", $queried_object);
    $map = get_field("карта", $queried_object);
    $work_conditions_title = get_field("режим_работы(заглавие)", $queried_object);
    $work_conditions_text_below_title = get_field("режим_работы(надпись_под_заглавием)", $queried_object);
    $work_conditions_image = get_field("режим_работы(изображение)", $queried_object);
    $work_conditions_text1 = get_field("режим_работы(надпись_под_изображением 1)", $queried_object);
    $work_conditions_text2 = get_field("режим_работы(надпись_под_изображением_2)", $queried_object);
    $work_conditions_text3 = get_field("режим_работы(надпись_под_изображением_3)", $queried_object);
    $article_title = get_field("статья(заглавие)", $queried_object);
    $article_paragraph1 = get_field("статья(абзац_1)", $queried_object);
    $article_paragraph2 = get_field("статья(абзац_2)", $queried_object);
    $article_image = get_field("изображение", $queried_object);
    $article_image_title = get_field("заглавие_изображения", $queried_object);
    $article_image_text = get_field("текст_к_изображению", $queried_object);
    $article_paragraph3 = get_field("статья(абзац_3)", $queried_object);
    $sale_points_title = get_field("заглавие_точек_продаж", $queried_object);

    echo '<div class="row-fluid banner" style="background: #0f1b34 url('.$background[url].') no-repeat 50% 50%; ">';
        echo '<div class="conteiner">';
            echo '<div>';
                echo '<h1>'.$background_text1.'</h1>';
                echo '<h3>'.$background_text2.'</h3>';
            echo '</div>';
        echo "</div>";
    echo '</div>';

//    echo '<div class="row-fluid map">';
//        echo '<div>';
//var_dump($map);
//            echo $map;
//        echo '</div>';
//    echo '</div>';

?>

<?php
$queried_object = get_queried_object();
$location = get_field('карта');
//var_dump($location);

if( !empty($location) ):
    ?>
    <div class="acf-map">
        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
    </div>
<?php endif; ?>


<div class="content_wrapper">

<?php

    echo '<div class="article" id="work-time">';

        echo '<div class="addresses">';
?>
            <?php $query = new WP_Query(array('post_type' => sale_points, 'orderby'=>date, 'order'=>asc) );

            if( $query->have_posts() ){
                while( $query->have_posts() ){
                    $query->the_post();
                    the_content();
                    $address = get_field('адрес');
                    $address_icon = get_field('иконка_адреса');

                    echo '<div class="one-address">';
                        echo '<div>';
                            echo '<img src="'.$address_icon[url].'" alt="location-icon">';
                        echo '</div>';
                        echo '<div>';
                            echo $address;
                        echo '</div>';
                    echo '</div>';
                }

                wp_reset_query();
            }

        echo '</div>';

        echo '<div class="get-orders-point-sale">';
            echo '<h2>'.$work_conditions_title.'</h2>';
            echo '<p>'.$work_conditions_text_below_title.'</p>';
            echo '<img src="'.$work_conditions_image[url].'" alt="calendar">';

            echo '<div id="days-of-work-time">';
                echo '<div class="work-days-points">';
                    echo '<p>'.$work_conditions_text1.'</p>';
                    echo '<p class="time">'.$work_conditions_text2.'</p>';
                    echo '<p>'.$work_conditions_text3.'</p>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        echo '<h2 class="comfortable-and-chip-header">'.$article_title.'</h2>';
        echo '<div class="comfortable-and-chip">';
            echo '<p>'.$article_paragraph1.'</p>';
            echo '<p>'.$article_paragraph2.'</p>';
            echo '<p>';
                echo '<img class="alignleft wp-image-1730 size-full" src="'.$article_image[url].'" alt="gold-coins" width="77" height="47">';
                echo '<strong>'.$article_image_title.'</strong>';
                echo $article_image_text;
            echo '</p>';
            echo '<p>'.$article_paragraph3.'</p>';
        echo '</div>';

        echo '<h2 class="comfortable-and-chip-header">'.$sale_points_title.'</h2>';


        $query = new WP_Query(array('post_type' => sale_points, 'orderby'=>date, 'order'=>asc, 'posts_per_page' => 6) );
        echo '<div class="points-of-sale">';

            if( $query->have_posts() ){
                while( $query->have_posts() ){
                    $query->the_post();
                    the_content();

                    $image = get_field('изображение');
                    $address = get_field('адрес');
                    $description = get_field('описание');
                    $address_icon = get_field('иконка_адреса');

                    echo '<div class="one-point-of-sale">';
                         echo '<div>';
                            echo '<img src="'.$image[url].'" alt="">';
                         echo '</div>';
                         echo '<div class="point-sale-one-address">';
                            echo '<div>';
                                echo '<img src="'.$address_icon[url].'" alt="location-icon">';
                             echo '</div>';
                             echo '<div>';
                                echo $address;
                            echo '</div>';
                         echo '</div>';
                        echo '<div class="point-sale-one-description">';
                            echo $description;
                        echo '</div>';
                     echo '</div>';
                }
                wp_reset_query();
            }

        echo '</div>';

    echo '</div>';

?>

    <!-------------------------- Teasers ----------------------------------------------------------------------->
    <div class="teasers">
        <!---------------------------- вывод пользовательского типа ----------------------------------------------------------------------------------------->
        <?php $query = new WP_Query(array('post_type'=>teasers, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 3));
        //query_posts($query);
        //    var_dump($query);
        //    echo $query->posts[0]->post_content;

        //    var_dump($query->posts[0]);
        //    var_dump($img);

        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();
                the_content();
                $img = get_field("добавить_изображение_тизера");
                $text1 = get_field("добавить_заголовок_всплывающего_тизера");
                $text2 = get_field("добавить_текст_всплывающего_тизера");
                $link = get_field("ссылка");

                echo "<div>";
                echo "<span></span>";
                echo '<a href="'.$link.'" title="ПРИЯТНАЯ НОВОСТЬ ДЛЯ ВАС">';
                echo '<div class="description"><h4>'.$text1.'</h4><p>'.$text2.'</p></div>';
                echo "<img src='$img[url]' />";
                echo "</a>";
                echo "</div>";
                // здесь оформляем данные для каждого поста в цикле
            }
            wp_reset_query();
        }
        ?>
        <!--------------------------------------------------------------------------------------------------------------------->
    </div>
    <!--------------------------- End Teasert ------------------------------------------------------------------------------------------>

</div>

<?php get_footer(); ?>

</div>       <!-- закрытие id="wrapper из header.php -->