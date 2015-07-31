<?php get_header(); ?>



<?php $query = new WP_Query(array('post_type'=>actions, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 4));

if( $query->have_posts() ){
    while( $query->have_posts() ){
        $query->the_post();
        //the_content();
        $img = get_field("картинка_слайда");
        $title = get_field("заголовок");
        $title2 = get_field("подзаголовок");
        $text1 = get_field("подробное_описание(абзац1)");
        $text2 = get_field("подробное_описание(абзац2)");
        $text3 = get_field("подробное_описание(абзац3)");
        $text4 = get_field("подробное_описание(абзац4)");

        $ID = get_the_ID();

        echo '<div class="modal hide in" id="modal-promotional-'.$ID.'" aria-hidden="true" style="top: 75.6px; display: none;">';
        echo '<div class="modal-header">';
        echo '<h1>'.$title.'</h1>';
        echo '<h3>'.$title2.'</h3></div>';
        echo '<div class="modal-pic">';
        echo '<img src="'.$img[url].'">';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<p>'.$text1.'</p>';
        echo '<p>'.$text2.'</p>';
        echo '<p>'.$text3.'</p>';
        echo '<p>'.$text4.'</p>';
        echo '<p><a class="btn btn-danger addToCart" data-product-id="1060">Участвовать в акции</a></p>';
        echo '</div>';
        echo '</div>';
    }
    wp_reset_query();
}
?>




<div class="row-fluid promotional">
    <ul>

        <?php $query = new WP_Query(array('post_type'=>actions, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 4));

        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();

                the_content();
                $img = get_field("картинка_слайда");
                $title = get_field("заголовок");
                $title2 = get_field("подзаголовок");
                $text = get_field("текст");

                $ID = get_the_ID();

                echo '<li class="right">';
                echo '<div class="bg" style="background: url('.$img[url].')no-repeat 50% 50%; width: 100%; height:500px;">';
                echo '<div class="wrapper">';
                echo '<div class="content">';
                echo '<h1>'.$title.'</h1>';
                echo '<h3>'.$title2.'</h3>';
                echo '<p>'.$text.'</p>';
                echo '<p>';
//                                        <a href="#special-819" data-conteiner="#modal-promotional" data-href="/wp-admin/admin-ajax.php?action=get_post&amp;template=special&amp;post_id=819" data-toggle="modal" class="btn btn-danger" title="Подробнее об акции">Узнать подробнее</a>
                echo '<a href="#special-'.$ID.'" class="btn btn-danger" data-target="#modal-promotional-'.$ID.'" data-conteiner="#modal-promotional" data-href="/wp-admin/admin-ajax.php?action=get_post&amp;template=special&amp;post_id='.$ID.'" data-toggle="modal" title="Подробнее об акции">Узнать подробнее</a>';
                echo '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</li>';

                // здесь оформляем данные для каждого поста в цикле
            }
            wp_reset_query();
        }
        ?>

    </ul>
</div>




<div class="content_wrapper">

    <!-------------------------- Teasers ----------------------------------------------------------------------->
    <div class="teasers">
        <!---------------------------- вывод пользовательского типа ----------------------------------------------------------------------------------------->
        <?php $query = new WP_Query(array('post_type'=>teasers, 'orderby'=>title, 'order'=>asc, 'posts_per_page' => 3));
        //query_posts($query);
        //            var_dump($query);
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

                echo "<div>";
                echo "<span></span>";
                echo '<a href="http://kodacka-voda.com/delivery/" title="ПРИЯТНАЯ НОВОСТЬ ДЛЯ ВАС">';
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



<script>
    var hash = document.location.hash;

    if(hash){
        $(hash).css('display', 'block');
        $(".modal-backdrop").css('display', 'block');
        $('button.closes').css('display', 'block');

        $(".modal-backdrop").click(function() {
            $(".modal-backdrop").css('display', 'none');
            $(hash).css('display', 'none');
        });
    }
</script>


<!--if( is_null($_SESSION['ordered_goods_id_no']) )-->
<!--{-->
<!--echo 'sas';-->
<!--$_SESSION['ordered_goods_id_no'] = 1;-->
<!--}-->
<!---->
<!--$ordered_goods_id_no = $_SESSION['ordered_goods_id_no'];-->
<!--$ordered_goods_id_no++;-->
<!--$_SESSION['ordered_goods_id_no'] = $ordered_goods_id_no;-->
<!--//var_dump($_SESSION['ordered_goods_id_no']);-->
<!--$_SESSION['ordered_goods_id'] = $id;-->