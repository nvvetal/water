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



<div class="row-fluid promo-article" id="why-we-for-home">
    <?php
        $queried_object = get_queried_object();

        $title = get_field("почему_мы(заглавие)", $queried_object);
        $img = get_field("почему_мы(изображение)", $queried_object);
        $text = get_field("почему_мы(текст)", $queried_object);

            echo '<h2>'.$title.'</h2>';
            echo '<div id="sub-science" class="left-water-for-home">';
                echo '<div class="image-left-water-for-home">';
                    echo '<img class="aligncenter size-full wp-image-1494" src="'.$img[url].'" alt="scientific-image" width="202" height="125">';
                echo '</div>';
                echo '<div id="science-text" class="name-water-for-home">';
                    echo '<div id="sub-science-text" class="sub-name-water-for-home">'.$text.'</div>';
                echo '</div>';
            echo '</div>';
    ?>
</div>


<div id="main-priorities-for-home" class="row-fluid promo-article">
    <?php
        $queried_object = get_queried_object();

        $priorities_title = get_field("основные_приоритеты(заглавие)", $queried_object);
        echo '<h2>'.$priorities_title.'</h2>';
    ?>


    <div id="sub-main-priorities" class="left-water-for-home">
        <?php $query = new WP_Query(array('post_type'=>priorities, 'orderby'=>title, 'order'=>asc));

        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();

                $img = get_field("изображение");

                echo '<div class="image-main-priorities-water-for-home">';
                    echo '<img class="aligncenter size-full wp-image-1494" src="'.$img[url].'" alt="scientific-image" width="202" height="125">';
                echo '</div>';
            }
            wp_reset_query();
        }
        ?>

        <?php $query = new WP_Query(array('post_type'=>priorities, 'orderby'=>title, 'order'=>asc));
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();

                $text = get_field("текст");

                echo '<div class="text-main-priorities-water-for-home">';
                    echo '<p>'.$text.'</p>';
                echo '</div>';
            }
            wp_reset_query();
        }
        ?>

    </div>
</div>



<div class="content_wrapper">

    <?php
        $queried_object = get_queried_object();

        $priorities_title = get_field("преимущества(заглавие)", $queried_object);
        $priorities_markers = get_field("преимущства(маркеры)", $queried_object);
        $article_image = get_field("статья(изображение)", $queried_object);
        $article_text = get_field("статья(текст)", $queried_object);
        $url = get_template_directory_uri().'/images/grace/icon-info.png';
        $url = str_replace('\\', '/', $url);
    ?>

    <div class="benefits-working-with-us">
        <h2 class="water-for-home-header"><?php echo $priorities_title; ?></h2>
        <div class="benefits-working-with-us">

                <?php $query = new WP_Query(array('post_type'=>graces, 'orderby'=>title, 'order'=>asc));
                    if( $query->have_posts() ){
                        while( $query->have_posts() ){
                            $query->the_post();

                            echo '<div class="one-benefit-working-with-us">';
                                echo '<div class="one-benefit-working-with-us-image">';
                                    echo '<img src="'.$priorities_markers[url].'" alt="">';
                                echo '</div>';
                                echo '<div class="one-benefit-working-with-us-text">'.get_the_content().'</div>';
                            echo '</div>';
                    }
                    wp_reset_query();
                }
                ?>
        </div>
    </div>


    <div class="last-info-block">
        <?php echo '<div class="last-info-block-img"><img src="'.$url.'" alt=""></div>'; ?>
        <div class="last-info-block-inside">
            <?php echo '<div class="last-info-block-inside-image"><img src="'.$article_image[url].'" alt=""></div>'; ?>
            <div class="last-info-block-inside-text"><p><?php echo $article_text; ?></p>
                <a class="btn btn-large btn-success" href="http://kodacka-voda.com/catalog/catalog/"> Каталог</a>        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
            </div>
        </div>
    </div>


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