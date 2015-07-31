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