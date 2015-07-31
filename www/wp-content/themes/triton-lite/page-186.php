<?php get_header(); ?>


<?php
//    $query = new WP_Query(array('post_type' => goods, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 4) );

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

// здесь оформляем данные для каждого поста в цикле

//wp_reset_query();
?>


<div class="content_wrapper">

    <div class="row-fluid category-list margin">
        <?php $query = new WP_Query(array('post_type'=>facts, 'orderby'=>title, 'order'=>asc));

        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();

                $img = get_field("изображение");
                $title = get_field("заглавие");
                $article = get_field("статья");

                echo '<div class="span4">';
                    echo '<div class="pic">';
                        echo '<a href="">';
                            echo '<img src="'.$img[url].'" style="display: inline-block; width: 300px; margin-top: 0px; margin-left: 0px;">';
                        echo '</a>';
                    echo '</div>';
                    echo '<div class="description">';
                        echo '<a href=""><h1>'.$title.'</h1></a>';
                        echo '<p>'.$article.'</p>';
                    echo '</div>';
                echo '</div>';
            }
            wp_reset_query();
        }
        ?>
    </div>

</div>


<div class="row-fluid promo-list">
    <div class="main-conteiner">

        <?php $query = new WP_Query(array('post_type'=>technology, 'orderby'=>date, 'order'=>asc));

            if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();

                $title = get_the_title(get_the_ID());
                if($title == 'Заглавие') { $text = get_field("текст_заглавия"); echo '<h1>' . $text . '</h1>'; }
            }
            wp_reset_query();
        }
        ?>

        <div class="conteiner">

            <?php $query = new WP_Query(array('post_type'=>technology, 'orderby'=>date, 'order'=>asc));

            if( $query->have_posts() ){
                while( $query->have_posts() ){
                    $query->the_post();

                    $title = get_the_title(get_the_ID());
                    if($title != 'Заглавие') {
                        $img = get_field("изображение");
                        $text = get_field("текст");

                        $url = get_template_directory().'/images/about_water/promolist-mask.png';

                        echo '<div class="span4">';
                        echo '<div class="pic " style="background: url(\'' . $url . '\') no-repeat 50% 50%, url(\'' . $img[url] . '\') no-repeat 50% 50%;" data-href=""></div>';
                        echo '<div class="description">' . $text . '</div>';
                        echo '</div>';
                    }
                }
                wp_reset_query();
            }
            ?>

        </div>
    </div>
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