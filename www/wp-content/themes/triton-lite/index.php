<?php get_header(); ?>
<?php $option =  get_option('trt_options'); ?>

<!--SLIDER-->
<?php //if ( is_home() ) { ?>
<!--<div id="slider_wrap">-->
<!--<!--    <div class="center">-->
<!--        <div id="slides">-->
<!--            --><?php //if( empty($option['trt_slider'])) { ?>
<!--                --><?php //get_template_part('easyslider');?>
<!--            --><?php //}?>
<!--            --><?php //if($option['trt_slider']== "Easyslider") { ?>
<!--                --><?php //get_template_part('easyslider');?>
<!--            --><?php //}?>
<!--            --><?php //if($option['trt_slider']== "Disable Slider") { ?>
<!--            --><?php //}?>
<!---->
<!--        </div>-->
<!--        <!--    </div>-->
<!--    </div>-->
<!--    	--><?php //}?>

<div class="main-slider">
    <?php $query = new WP_Query(array('post_type'=>slider_top, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 4));

    echo '<ul class="bxslider">';
    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            the_content();
            $img = get_field("картинка_слайда");
            $title = get_field("заголовок");
            $title2 = get_field("подзаголовок");
            $text = get_field("текст");
            $actions = get_field("акции");
            //var_dump($actions);

            echo '<li style="background: url('.$img[url].') 50% 50% no-repeat rgb(0, 20, 48);">';
                echo '<div class="content">';
                    echo '<h1>'.$title.'</h1>';
                    echo '<h3>'.$title2.'</h3>';
                    echo '<p>'.$text.'</p>';
                    echo '<a href="http://water/?page_id=7#modal-promotional-'.$actions[0]->ID.'" class="btn btn-danger">Узнать подробнее</a>';
                echo '</div>';
            echo '</li>';

            // здесь оформляем данные для каждого поста в цикле
        }
        wp_reset_query();
    }
    echo "</ul>";

    $query = new WP_Query(array('post_type'=>slider_top, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 4));
    $slide_index = 0;
    echo '<div id="bx-pager">';
    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            $switcher = get_field("изображение_переключателя");

            echo '<div><a data-slide-index="'.$slide_index.'"><img src="'.$switcher[url].'"></a></div>';
            $slide_index++;
//             здесь оформляем данные для каждого поста в цикле
        }

        wp_reset_query();
    }

    echo '</div>';

    ?>


<!--    <div id="bx-pager">-->
<!--        <div><a data-slide-index="0" href=""><img src="--><?php //bloginfo('template_directory'); ?><!--/images/slideshow/switch1.png" /></a></div>-->
<!--        <div><a data-slide-index="1" href=""><img src="--><?php //bloginfo('template_directory'); ?><!--/images/slideshow/switch2.png" /></a></div>-->
<!--        <div><a data-slide-index="2" href=""><img src="--><?php //bloginfo('template_directory'); ?><!--/images/slideshow/switch3.png" /></a></div>-->
<!--        <div><a data-slide-index="3" href=""><img src="--><?php //bloginfo('template_directory'); ?><!--/images/slideshow/switch4.png" /></a></div>-->
<!--    </div>-->
</div>


<!--CONTENT-->
<!--<div id="content">-->
<!---->
<!--<div class="center">-->
<!--        --><?php //if( empty($option['trt_lay'])) { ?>
<!--        --><?php //get_template_part('layout1');?>
<!--    	--><?php //}?>
<!--        --><?php //if($option['trt_lay']== "Layout 1") { ?>
<!--        --><?php //get_template_part('layout1');?>
<!--    	--><?php //}?><!-- -->
<!--</div>-->
<!--</div>-->


<div class="content_wrapper">

    <?php $query = new WP_Query(array('post_type'=>slider_content, 'orderby'=>date, 'order'=>asc, 'posts_per_page' => 4));
    $slide_index = 0;

    echo '<div class="slider-vertical-menu">';
        echo '<div class="slider-vertical-menu-wrapper">';

            echo '<div id="bx-pager-02" class="bx-pager">';
                if( $query->have_posts() ){
                    while( $query->have_posts() ){
                        $query->the_post();
                        the_content();
                        $switcher_passive = get_field("пассивное_изображение_переключателя");
                        $switcher_active = get_field("активное_изображение_переключателя");

                        echo '<a data-slide-index="'.$slide_index.'">';
                            echo '<img class="passive" src="'.$switcher_passive[url].'">';
                            echo '<img class="active" src="'.$switcher_active[url].'">';
                            echo '<span></span>';
                        echo '</a>';

                        $slide_index++;
                        // здесь оформляем данные для каждого поста в цикле
                    }
                    wp_reset_query();
                }
            echo '</div>';

            echo '<div class="bx-content">';
                echo '<ul id="bxslider-02">';
                    if( $query->have_posts() ){
                        while( $query->have_posts() ){
                            $query->the_post();
                            the_content();
                            $img = get_field("картинка_слайда");
                            $title = get_field("заголовок");
                            $text = get_field("текст");
                            $link = get_field("ссылка");
                            $link_category = get_field("ссылка_на_категорию_товаров");
                            $qq = get_term($link_category, 'goods_category');
//                            var_dump($link);
//                            var_dump($link_category);
//                            var_dump($qq);


                            echo '<li>';
                                echo '<div class="pic"><img src="'.$img[url].'"></div>';
                                echo '<div class="description">';
                                    echo '<h3>'.$title.'</h3>';
                                    echo '<p>'.$text.'</p>';

                                    if( !empty($link_category))
                                    {
                                        echo '<div><a class="btn btn-large btn-success" href="?'.$qq->taxonomy.'='.$qq->slug.'">Заказать воду</a></div>';
                                    }
                                    else
                                    {
                                        echo '<div><a class="btn btn-large btn-success" href='.$link.'>Заказать воду</a></div>';
                                    }

                                echo '</div>';
                            echo '</li>';

                            // здесь оформляем данные для каждого поста в цикле
                        }
                        wp_reset_query();
                    }
                echo '</ul>';
            echo '</div>';

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



    <div class="why_choose">
        <h2>Почему выбирают нас?</h2>
            <?php $query = new WP_Query(array('post_type'=>why_choose, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 4) );

            if( $query->have_posts() ){
                while( $query->have_posts() ){
                    $query->the_post();
                    the_content();
                    $img = get_field("добавить_картинку_критерия");
                    $text1 = get_field("добавить_заголовок_критерия");
                    $text2 = get_field("добавить_текст_критерия");

                    echo '<div class="span3">';
                        echo '<div class="pic">';
                            echo "<img src='$img[url]' />";
                        echo "</div>";
                        echo "<h2>".$text1."</h2>";
                        echo '<div class="description"><p>'.$text2.'</p></div>';
                    echo '</div>';

                    // здесь оформляем данные для каждого поста в цикле
                }
                wp_reset_query();
            }
            ?>

    </div>

    <div class="quick-order">
        <a href="#" class="btn btn-success order" >
            <div class="text">
                Заказать воду
                <br>
                <span>в пару кликов!</span>
            </div>
        </a>
    </div>


</div>

<?php get_footer(); ?>

</div>       <!-- закрытие id="wrapper из header.php -->

