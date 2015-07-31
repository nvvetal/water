<?php get_header(); ?>

<!--CONTENT-->
<!--<div id="content">-->
<!---->
<!--<div class="center">-->
<!--    <div id="posts" class="single_page_post">-->
<!--    <div class="post_wrap">-->
<!--              THE POST-->
<!--                --><?php //if(have_posts()): ?><!----><?php //while(have_posts()): ?><!----><?php //the_post(); ?>
<!--                    <div --><?php //post_class(); ?><!-- id="post---><?php //the_ID(); ?><!--"> -->
<!--                     -->
<!--                       <div class="post_content">-->
<!--                        <h2 class="postitle"><a href="--><?php //the_permalink();?><!--" title="--><?php //the_title_attribute(); ?><!--">--><?php //the_title(); ?><!--</a></h2>-->
<!--                        -->
<!--                        --><?php //the_content(); ?>
<!--                        <div style="clear:both"></div>-->
<!--                        --><?php //wp_link_pages('<p class="pages"><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
<!--                    -->
<!--                    Post Footer-->
<!--<div class="edit">--><?php //edit_post_link(); ?><!--</div><div style="clear:both"></div>-->
<!--                    -->
<!--                    </div> -->
<!--                    -->
<!---->
<!--                       -->
<!--                    </div>-->
<!--    -->
<!--                    --><?php //endwhile ?>
<!--                    -->
<!--                   <div class="comments_template">--><?php //comments_template('',true); ?><!--</div>   -->
<!--                --><?php //endif ?>
<!--                -->
<!--            </div>-->
<!--</div>-->
<!--    --><?php //get_sidebar(); ?>
<!--</div>-->
<!--</div>-->


<!--<div class="row-fluid banner">-->
<!--    <div class="conteiner">-->
<!--        <div>-->
<!--            <h1>БУТИЛИРОВАННАЯ ВОДА</h1>-->
<!--            <h3>в каждый дом и офис</h3>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


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
        echo "</div>";
    echo '</div>';

    // здесь оформляем данные для каждого поста в цикле
$a = $_POST["iddd"];
echo $a;
//wp_reset_query();
?>


<div class="content_wrapper">

<!--     --><?php //wp_nav_menu(array('container_class' => 'row-fluid tags', 'theme_location' => 'goods' ) ); ?>

    <?php
        $args = array('taxonomy' => 'goods_category');
        $categories =  get_categories($args);  //Возвращает массив объектов содержащих информацию о категориях.

        echo '<div class="row-fluid tags">';
            echo "<ul>";
                foreach($categories as $category)
                    if($category->term_id == 11)
                    {
                        echo "<li class='current-menu-item'><a href='?goods_category=". $category->slug."'>" . $category->name."</a></li>";
                    }
                    else {
                        echo "<li><a href='?goods_category=". $category->slug."'>" . $category->name."</a></li>";
                    }
            echo "</ul>";
        echo '</div>';
    ?>

    <div class="product-list">

        <?php
            $query = new WP_Query( array('post_type' => 'goods', 'orderby'=>date, 'order'=>asc, 'posts_per_page' => 5) );

        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();

                $price = get_field('цена');
                $id = $query->post->ID;

                echo '<div>';
                    echo '<div class="pic">';
                        the_post_thumbnail(array(160, 240));
                    echo '</div>';

                    echo '<div class="description">';
                        the_title('<h2>', '</h2>');
                        the_content();

//                        echo '<a href="#" data-conteiner="#modal-product" data-href="/wp-admin/admin-ajax.php?action=get_post&amp;template=product&amp;post_id=312" data-toggle="modal" class="btn btn-large more">Детальная информация</a>';
                            echo '<a href="" data-conteiner="#modal-product" data-href="'.$id.'" data-toggle="modal" class="btn btn-large more">Детальная информация</a>';
                    echo '</div>';

                    echo '<div class="info">';
                        echo '<div class="price">'.$price.' грн.</div>';
                        echo '<a class="btn btn-danger addToCart" data-product-id="312">Добавить в корзину</a>';
                    echo '</div>';

                echo '</div>';

            }
            wp_reset_query();
        }
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

<div class="modal hide in" id="modal-product" style="top: 73.5px; display: block;">

     <?php $query = new WP_Query( array('post_type' => 'goods', 'orderby'=>date, 'order'=>asc, 'posts_per_page' => 1) );

    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();

            $price = get_field('цена');
            $name = get_field('название_товара');
            $description_title = get_field('описание(заглавие)');
            $description = get_field('описание(текст)');

            echo '<div class="modal-body">';
                echo '<table class="product-info">';
                    echo '<tbody>';
                    echo '<tr>';
                        echo '<td class="pic">';
                            echo '<div>';
                                echo '<img class="zoom-image" src="'.the_post_thumbnail(array(160, 240)).'" data-zoom-image="http://kodacka-voda.com/wp-content/uploads/2014/05/DSC05710-copy-683x1024.jpg" title="" Кодацкая="" вода""="">';
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

    }
    wp_reset_query();
    }

    ?>
</div>


<?php get_footer(); ?>

</div>       <!-- закрытие id="wrapper из header.php -->