<?php

get_header(); ?>

    <div id="content" role="main">


        <?php
//                $term = get_term( the_ID(), 'goods_category' );

        $queried_object = get_queried_object();

        $background = get_field("задний_фон", $queried_object);
        $text1 = get_field("жирный_текст", $queried_object);
        $text2 = get_field("курсивный_текст", $queried_object);

        echo '<div class="row-fluid banner" style="background: #0f1b34 url('.$background[url].') no-repeat 50% 50%; ">';
        echo '<div class="conteiner">';
        echo '<div>';
        echo '<h1>'.$text1.'</h1>';
        echo '<h3>'.$text2.'</h3>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

//        $v = $_POST["name"];
//        var_dump($v);

//if (!session_id()) session_start();
//var_dump(session_id());
$_SESSION[] = 'asdadasdad';
//echo "<pre>"; var_dump($_SESSION); echo "</pre>";
        ?>


        <?php if (have_posts()) : ?>

            <div class="content_wrapper">

                <?php

                $args = array('taxonomy' => 'goods_category');
                $categories =  get_categories($args);  //Возвращает массив объектов содержащих информацию о категориях.
                echo '<div class="row-fluid tags">';
                echo "<ul>";
                foreach($categories as $category)
                    {
                        $arr_categories[] = array("slug" => $category->slug, "name" => $category->name, "id" => $category->term_id) ;
                        $arr_cat_id[] = $category->term_id;
                    }

                array_multisort($arr_cat_id, SORT_ASC, $arr_categories);

                foreach($arr_categories as $category)
                {
                        if ($category["id"] == $queried_object->term_id) {

                            echo "<li class='current-menu-item'><a href='?goods_category=" . $category["slug"] . "'>" . $category["name"] . "</a></li>";
                        } else {
                            echo "<li><a href='?goods_category=" . $category["slug"] . "'>" . $category["name"] . "</a></li>";
                        }
                }
                echo "</ul>";
                echo '</div>';
                ?>

                <div class="product-list">

                    <?php

                    /* Start the Loop */
                    while (have_posts()) : the_post();

                        $price = get_field('цена');
                        $id = get_the_ID();

                        echo '<div>';

                        echo '<div class="pic">';
                        the_post_thumbnail(array(160, 240));
                        echo '</div>';

                        echo '<div class="description">';
                        the_title('<h2>', '</h2>');
                        the_content();

//                        echo '<a href="#product-312" data-conteiner="#modal-product" data-href="'.$id.'" data-toggle="modal" class="btn btn-large more detail-info">Детальная информация</a>';
                        echo '<a href="#" data-conteiner="#modal-product" data-href="'.$id.'" class="btn btn-large more detail-info">Детальная информация</a>';
                        echo '</div>';

                        echo '<div class="info">';
                            echo '<div class="price">'.$price.' грн.</div>';
                            echo '<a class="btn btn-danger addToCart" data-href="'.$id.'">Добавить в корзину</a>';
                        echo '</div>';

                        echo '</div>';


                    endwhile;
                    //            smartadapt_content_nav('nav-below');
                    ?>

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

        <?php else : ?>
            <?php get_template_part('content', 'none'); ?>
        <?php endif; ?>

    </div><!-- #content -->

    </div><!-- #main -->

    </div><!-- #page -->

    </div><!-- #wrapper -->

    <?php echo '<div id="goods-description"></div>'; ?>

<?php get_footer(); ?>