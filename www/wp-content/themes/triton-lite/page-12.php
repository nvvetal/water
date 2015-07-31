<?php get_header(); ?>


<?php
$queried_object = get_queried_object();

$background = get_field("баннер(изображение)", $queried_object);
$background_text1 = get_field("баннер(текст_1)", $queried_object);
$background_text2 = get_field("баннер(текст_2)", $queried_object);

$upper_text= get_field("верхняя_надпись", $queried_object);
$work_time_title = get_field("часы_работы(заглавие)", $queried_object);
$work_time_text_below_title = get_field("часы_работы(надпись_под_заглавием)", $queried_object);
$work_time_image = get_field("часы_работы(изображение)", $queried_object);
$work_conditions_text1_1 = get_field("режим_работы(надпись1_под_изображением_1)", $queried_object);
$work_conditions_text2_1 = get_field("режим_работы(надпись2_под_изображением_1)", $queried_object);
$work_conditions_text1_2 = get_field("режим_работы(надпись1_под_изображением_2)", $queried_object);
$work_conditions_text2_2 = get_field("режим_работы(надпись2_под_изображением_2)", $queried_object);
$work_conditions_text1_3 = get_field("режим_работы(надпись1_под_изображением_3)", $queried_object);
$work_conditions_text2_3 = get_field("режим_работы(надпись2_под_изображением_3)", $queried_object);
$work_conditions_text3_3 = get_field("режим_работы(надпись3_под_изображением_3)", $queried_object);
$delivery_conditions_title = get_field("условия_доставки(заглавие)", $queried_object);
$delivery_conditions_image1 = get_field("условия_доставки(изображение1)", $queried_object);
$delivery_conditions_text1_1 = get_field("условия_доставки(текст_слева_от_изображения1)", $queried_object);
$delivery_conditions_text2_1 = get_field("условия_доставки(выделенный_текст_слева_от_изображения1)", $queried_object);
$delivery_conditions_image2 = get_field("условия_доставки(изображение2)", $queried_object);
$delivery_conditions_text1_2 = get_field("условия_доставки(текст_слева_от_изображения2)", $queried_object);
$delivery_conditions_text2_2 = get_field("условия_доставки(текст_снизу_слева_от_изображения2)", $queried_object);
$delivery_conditions_text3_2 = get_field("условия_доставки(выделенный_текст_слева_снизу_от_изображения2)", $queried_object);
$delivery_conditions_image3 = get_field("условия_доставки(изображение3)", $queried_object);
$delivery_conditions_text1_3 = get_field("условия_доставки(текст_слева_от_изображения3)", $queried_object);
$delivery_conditions_text2_3 = get_field("условия_доставки(текст_снизу_слева_от_изображения3)", $queried_object);
$delivery_conditions_big_image_right = get_field("условия_доставки(большое_изображение_справа)", $queried_object);
$delivery_teaser_image = get_field("доставка_тизер(изображение)", $queried_object);
$delivery_teaser_text1_1 = get_field("доставка_тизер1(текст1)", $queried_object);
$delivery_teaser_text2_1 = get_field("доставка_тизер1(текст2)", $queried_object);
$delivery_teaser_text3_1 = get_field("доставка_тизер1(выделенный_текст)", $queried_object);
$delivery_teaser_text1_2 = get_field("доставка_тизер2(текст1)", $queried_object);
$delivery_teaser_text2_2 = get_field("доставка_тизер2(текст2)", $queried_object);
$delivery_teaser_text3_2 = get_field("доставка_тизер2(выделенный_текст)", $queried_object);
$delivery_teaser_text1_3 = get_field("доставка_тизер3(текст)", $queried_object);
$delivery_teaser_text2_3 = get_field("доставка_тизер3(выделенный_текст)", $queried_object);
$delivery_conditions_countryside_title1 = get_field("условия_доставки_за_город(заглавие_верхний_ряд)", $queried_object);
$delivery_conditions_countryside_title2 = get_field("условия_доставки_за_город(заглавие_нижний_ряд)", $queried_object);
$delivery_conditions_countryside_image = get_field("условия_доставки_за_город(изображение)", $queried_object);
$delivery_conitions_countryside_image1 = get_field("условия_доставки_за_город(изображение1)", $queried_object);
$delivery_conditions_countryside_text1 = get_field("условия_доставки_за_город(изображение1_текст)", $queried_object);
$delivery_conditions_countryside_image2 = get_field("условия_доставки_за_город(изображение2)", $queried_object);
$delivery_conditions_countryside_text2 = get_field("условия_доставки_за_город(изображение2_текст)", $queried_object);
$delivery_conditions_countryside_image3 = get_field("условия_доставки_за_город(изображение3)", $queried_object);
$delivery_conditions_countryside_text3 = get_field("условия_доставки_за_город(изображение3_текст)", $queried_object);
$delivery_conditions_countryside_image4 = get_field("условия_доставки_за_город(изображение4)", $queried_object);
$delivery_conditions_countryside_text4 = get_field("условия_доставки_за_город(изображение4_текст)", $queried_object);
$article_title = get_field("статья(заглавие)", $queried_object);
$article_paragraph1 = get_field("статья(абзац1)", $queried_object);
$article_paragraph2 = get_field("статья(абзац2)", $queried_object);


echo '<div class="row-fluid banner" style="background: #0f1b34 url('.$background[url].') no-repeat 50% 50%; ">';
    echo '<div class="conteiner">';
        echo '<div>';
            echo '<h1>'.$background_text1.'</h1>';
            echo '<h3>'.$background_text2.'</h3>';
        echo '</div>';
    echo '</div>';
echo '</div>';





echo '<div class="content_wrapper">';

    echo '<div class="row-fluid article" id="delivery-start-mes">';
        echo '<p>'.$upper_text.'</p>';
    echo '</div>';

    echo '<div class="row-fluid article" id="work-time-delivery">';
        echo '<h2>'.$work_time_title.'</h2>';
        echo '<p>'.$work_time_text_below_title.'</p>';
        echo '<img src="'.$work_time_image[url].'" alt="calendar">';
        echo '<div id="days-of-work-time">';
            echo '<div class="word-days">';
                echo '<p>'.$work_conditions_text1_1.'</p>';
                echo '<p class="time">'.$work_conditions_text2_1.'</p>';
            echo '</div>';
            echo '<div class="saturday">';
                echo '<p>'.$work_conditions_text1_2.'</p>';
                echo '<p class="time">'.$work_conditions_text2_2.'</p>';
            echo '</div>';
            echo '<div class="sunday">';
                echo '<p>'.$work_conditions_text1_3.' <br> '.$work_conditions_text2_3.'</p>';
                echo '<p class="time">'.$work_conditions_text3_3.'</p>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

echo '</div>';

echo '<div class="row-fluid promo-article" id="delivery-conditions">';
    echo '<h2>'.$delivery_conditions_title.'</h2>';
    echo '<div class="conteiner">';
        echo '<div class="delivery-conditions-left">';
            echo '<div class="address-footer-contacts">';
                echo '<div style="width:112px; text-align:center; margin-right:10px;">';
                    echo '<img src="'.$delivery_conditions_image1[url].'" alt="map-contacts">';
                echo '</div>';
                echo '<div>';
                    echo '<span>'.$delivery_conditions_text1_1.'</span><br>';
                    echo '<span class="address">'.$delivery_conditions_text2_1.'</span>';
                echo '</div>';
            echo '</div>';
            echo '<div class="address-footer-contacts">';
                echo '<div style="width:112px; text-align:center; margin-right:10px;">';
                    echo '<img src="'.$delivery_conditions_image2[url].'" alt="map-contacts">';
                echo '</div>';
                echo '<div>';
                    echo '<span>'.$delivery_conditions_text1_2.'</span><br>';
                    echo '<span>'.$delivery_conditions_text2_2.' </span><span class="address">'.$delivery_conditions_text3_2.'</span>';
                echo '</div>';
            echo '</div>';
            echo '<div class="address-footer-contacts">';
                echo '<div style="width:112px; text-align:center; margin-right:10px;">';
                    echo '<img src="'.$delivery_conditions_image3[url].'" alt="map-contacts">';
                echo '</div>';
                echo '<div>';
                    echo '<span>'.$delivery_conditions_text1_3.'</span><br>';
                    echo '<span>'.$delivery_conditions_text2_3.'</span>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<div class="delivery-conditions-right">';
        echo '<img src="http://kodacka-voda.com/wp-content/uploads/2014/05/delivery-conditions-right-image.png" alt="man-with-bottles">';
        echo '</div>';

    echo '</div>';
echo '</div>';


echo '<div class="content_wrapper">';
    echo '<div class="row-fluid article" id="extra-conditions-after-wrapper">';
    	echo '<h2></h2>';
        echo '<img src="'.$delivery_teaser_image[url].'" alt="usloviya-dostavki">';
        echo '<div id="extra-conditions">';
        	echo '<div class="first-extra-condition">';
            	echo '<span>'.$delivery_teaser_text1_1.' </span><br>';
                echo '<span>'.$delivery_teaser_text2_1.' </span><span class="cost-extra-condition">'.$delivery_teaser_text3_1.'</span>';
            echo '</div>';
        	echo '<div class="second-extra-condition">';
            	echo '<span>'.$delivery_teaser_text1_2.'</span><br>';
                echo '<span>'.$delivery_teaser_text2_2.' </span><span class="cost-extra-condition">'.$delivery_teaser_text3_2.'</span>';
			echo '</div>';
        	echo '<div class="third-extra-condition">';
            	echo '<span>'.$delivery_teaser_text1_3.'</span><br>';
	            echo '<span class="cost-extra-condition">'.$delivery_teaser_text2_3.'</span>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';


echo '<div class="row-fluid promo-article" id="block-conditions-delivery-from-kiev">';
    echo '<div class="conteiner">';
        echo '<h2 class="conditions-delivery-from-kiev">'.$delivery_conditions_countryside_title1.'<br>'.$delivery_conditions_countryside_title2.'</h2>';
        echo '<div>';
            echo '<img src="'.$delivery_conditions_countryside_image[url].'" alt="road">';
        echo '</div>';
        echo '<div class="conditions-number-of-bottles">';
            echo '<div class="number-of-bottles">';
                echo '<div class="bottles-images">';
                    echo '<img src="'.$delivery_conitions_countryside_image1[url].'" alt="bottles-1">';
                echo '</div>';
                echo '<div>';
                    echo '<span>'.$delivery_conditions_countryside_text1.'</span>';
                echo '</div>';
            echo '</div>';
            echo '<div class="number-of-bottles">';
                echo '<div class="bottles-images">';
                    echo '<img src="'.$delivery_conditions_countryside_image2[url].'" alt="bottles-2">';
                echo '</div>';
                echo '<div>';
                    echo '<span>'.$delivery_conditions_countryside_text2.'</span>';
                echo '</div>';
            echo '</div>';
            echo '<div class="number-of-bottles">';
                echo '<div class="bottles-images">';
                    echo '<img src="'.$delivery_conditions_countryside_image3[url].'" alt="bottles-3">';
                echo '</div>';
                echo '<div>';
                    echo '<span>'.$delivery_conditions_countryside_text3.'</span>';
                echo '</div>';
            echo '</div>';
            echo '<div class="number-of-bottles">';
                echo '<div class="bottles-images">';
                    echo '<img src="'.$delivery_conditions_countryside_image4[url].'" alt="bottles-4">';
                echo '</div>';
                echo '<div>';
                    echo '<span>'.$delivery_conditions_countryside_text4.'</span>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';


?>


<div class="content_wrapper">

    <?php
        echo '<div class="row-fluid article" id="delivery-start-mes">';
            echo '<h2>'.$article_title.'</h2>';
            echo '<p class="what-do-we-do">';
                echo $article_paragraph1;
                echo '<br><br>';
                echo $article_paragraph2;
                echo '<br>';
            echo '</p>';
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