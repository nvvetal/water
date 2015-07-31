<?php get_header(); ?>


<?php

$queried_object = get_queried_object();

$background = get_field("баннер(изображение)", $queried_object);
$text1 = get_field("баннер(текст_1)", $queried_object);
$text2 = get_field("баннер(текст_2)", $queried_object);

echo '<div class="row-fluid banner" style="background: #0f1b34 url('.$background[url].') no-repeat 50% 50%; ">';
echo '<div class="conteiner">';
echo '<div>';
echo '<h1>'.$text1.'</h1>';
echo '<h3>'.$text2.'</h3>';
echo '</div>';
echo '</div>';
echo '</div>';

?>


<div class="content_wrapper">

    <?php
    $queried_object = get_queried_object();

    $article_below_banner1 = get_field("статья_под_баннером(абзац1)", $queried_object);
    $article_below_banner2 = get_field("статья_под_баннером(абзац2)", $queried_object);
    $article_below_banner_img = get_field("статья_под_баннером(изображение)", $queried_object);
    $services_costs_title = get_field("стоимость_услуг(заглавие)", $queried_object);
    $storage_of_water_title = get_field("как_правильно_хранить_воду(заглавие)", $queried_object);
    $storage_of_water_text1 = get_field("как_правильно_хранить_воду(абзац1)", $queried_object);
    $storage_of_water_img1 = get_field("как_правильно_хранить_воду(изображение1)", $queried_object);
    $storage_of_water_text2 = get_field("как_правильно_хранить_воду(абзац2)", $queried_object);
    $storage_of_water_img2 = get_field("как_правильно_хранить_воду(изображение2)", $queried_object);
    $storage_of_water_text3 = get_field("как_правильно_хранить_воду(абзац3)", $queried_object);
    $masters_visit_title = get_field("причины_не_пропустить_визит_мастера(заглавие)", $queried_object);

    echo '<div class="row-fluid article" id="sanitization-start-mes">';
        echo '<p>'.$article_below_banner1.'</p>';
    echo '</div>';
    echo '<div class="row-fluid article" id="how-to-save-water">';
    	echo '<div id="third-how-to-save-water">';
        	echo '<div>';
				echo '<img src="'.$article_below_banner_img[url].'" alt="map-contacts">';
            echo '</div>';
            echo '<div id="third-advice-how-to-save-water">';
            	echo '<p>'.$article_below_banner2.'</p>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    ?>


</div>


<div class="row-fluid promo-article">
    <div class="conteiner" id="services-conteiner">
        <?php
            echo '<h2 class="conditions-delivery-from-kiev">'.$services_costs_title.'</h2>';

            echo '<div class="cost-of-servecies">';
            $query = new WP_Query(array('post_type'=>service, 'orderby'=>date, 'order'=>asc));
            $num = 1;

            if( $query->have_posts() ){
                while( $query->have_posts() ){
                    $query->the_post();

                    $img = get_field("изображение");
                    $text = get_field("текст");
                    $price = get_field("цена");

                    echo '<div id="service-'.$num.'">';
                        echo '<div class="image">';
                            echo '<img src="'.$img[url].'" alt="map-contacts">';
                        echo '</div>';
                        echo '<div class="name-and-cost-services">';
                            echo '<div class="name-service">'.$text.'</div>';
                            echo '<div class="cost-service">'.$price.' грн</div>';
                        echo '</div>';
                    echo '</div>';

                    $num++;
                }
                wp_reset_query();
            }
        echo '</div>';
        ?>
    </div>
</div>


<div class="content_wrapper">

    <div class="row-fluid article" id="how-to-save-water">
        <?php
        echo '<h2>'.$storage_of_water_title.'</h2>';
        echo '<div id="first-how-to-save-water">';
            echo '<div>';
                echo '<img src="'.$storage_of_water_img1[url].'" alt="map-contacts">';
            echo '</div>';
            echo '<div id="first-advice-how-to-save-water">';
                echo '<p>'.$storage_of_water_text1.'</p>';
            echo '</div>';
        echo '</div>';
        echo '<div id="second-how-to-save-water">';
            echo '<div id="second-advice-how-to-save-water">';
            	echo '<span>';
                    echo '<p>'.$storage_of_water_text2.'</p>';
                    echo '<p>'.$storage_of_water_text3.'</p>';
                echo '</span>';
            echo '</div>';
            echo '<div>';
                echo '<img src="'.$storage_of_water_img2[url].'" alt="map-contacts">';
            echo '</div>';
        echo '</div>';

    echo '</div>';

    echo '<div class="row-fluid article" id="delivery-start-mes">';

        echo '<h2>'.$masters_visit_title.'</h2>';
        echo '<div class="master-visit-reasons">';

        $query = new WP_Query(array('post_type'=>masters_visit, 'orderby'=>date, 'order'=>asc));
        $num = 1;
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();

                $img = get_field("изображение");
                $title = get_field("заглавие");
                $text = get_field("текст");

                echo '<div class="image-number-'.$num.'">';
                    echo '<img src="'.$img[url].'" alt="map-contacts">';
                echo '</div>';
                echo '<div class="master-visit-reason-'.$num.'">';
                    echo '<span class="title-master-visit-reason">'.$title.'</span>';
                    echo '<br>';
                    echo '<span>'.$text.'</span>';
                echo '</div>';

                $num++;
            }
            wp_reset_query();
        }

        echo '</div>';
    echo '</div>';

    ?>
</div>







<div class="content_wrapper">

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