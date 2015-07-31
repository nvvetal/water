<?php $option =  get_option('trt_options'); ?>
<!--MIDROW-->
<?php if($option["trt_diss_ftw"] == "1"){ ?><?php } else { ?>
<!--<div id="midrow">-->
<!--<div class="center">-->
<!--<div class="widgets"><ul>          -->
<!--        --><?php //if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Midrow Widgets') ) : ?><!-- -->
<!--        --><?php //endif; ?><!--</ul>-->
<!--        </div>-->
<!--</div>-->
<!--</div>-->
<?php }?>

<!--FOOTER-->

<?php $query = new WP_Query(array('post_type'=>footer, 'posts_per_page' => 1));

if( $query->have_posts() ) {
    while ($query->have_posts()) {
        $query->the_post();
        the_content();
        $organisation = get_field("название_организации");
        $website = get_field("сайт");

        echo '<div id="footer">';
            echo '<div class="footer_wrapper">';
                echo '<div class="footer_logo">';
                    echo $organisation;
                    echo '<br>';
                    echo $website;
                echo '</div>';

        // здесь оформляем данные для каждого поста в цикле
    }
    wp_reset_query();
}

        wp_nav_menu(array('container_class' => 'footer_menu', 'theme_location' => 'footer1' ) );
        wp_nav_menu(array('container_class' => 'footer_menu', 'theme_location' => 'footer2' ) );

//$query = new WP_Query(array('post_type'=>static_header, 'posts_per_page' => 1));
//Call back form fo footer

$query = new WP_Query(array('post_type'=>callback, 'orderby'=>date, 'order'=>asc));
if( $query->have_posts() ){
    while( $query->have_posts() ){
        $query->the_post();
        $text1 = get_field("текст_вверху");
        $text2 = get_field("время_работы_текст");
        $days1 = get_field("дни1");
        $time1 = get_field("время1");
        $days2 = get_field("дни2");
        $time2 = get_field("время2");
        $days3 = get_field("дни3");
        $time3 = get_field("время3");

        echo '<div id="callbackForm" class="" style="top: 59px; left: 321px;">';
        echo '<div class="arrow"></div>';
        echo '<div class="title border">';
        echo '<strong>'.$text1.'</strong>';
        echo '</div>';
        echo '<form method="post">';
        echo '<div class="border">';
        echo '<input type="tel" name="phone_cb" placeholder="Ваш номер телефона" pattern="[\-+0-9,\s]*" required="required">';
        echo '<input type="submit" value="Отправить" class="btn btn-danger">';
        echo '</div>';
        echo '</form>';
        echo '<div class="info">';
        echo '<strong>'.$text2.'</strong>';
        echo '<table style="margin-top: 5px;">';
        echo '<tbody>';
        echo '<tr>';
        echo '<td>'.$days1.'</td>';
        echo '<td>'.$time1.'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>'.$days2.'</td>';
        echo '<td>'.$time2.'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>'.$days3.'</td>';
        echo '<td>'.$time3.'</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';

    }
    wp_reset_query();
}
//End call back form
    $query = new WP_Query(array('options_category' => 'Static Header', 'posts_per_page' => 1));

    if( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            the_content();
            $phone = get_field("телефон");
            $below_phone = get_field("надпись_под_телефоном");

            echo '<div class="footer_phone">';
                echo '<span>'.$phone.'</span>';
                echo '<a class="clickShow "  >'.$below_phone.'</a>';
                echo '<br>';

        }
        wp_reset_query();
    }
?>

<script>
    $('a.clickShow').click(function(){
        $('#callbackForm').css('display','block','bottom','40px !important','right','60px !important')
    });
</script>

  <?php  $query = new WP_Query(array('options_category' => 'Footer', 'posts_per_page' => 1));

    if( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            the_content();
            $opinion = get_field("текст-ссылка_на_страницу_отзывов");

            echo '<a href="#">'.$opinion.'</a>';

        }
        wp_reset_query();
    }

        echo '<div class="social">';
            echo '<a href="https://www.facebook.com/kodackavoda" target="_blank"  class="fb"></a>';
            echo '<a href="http://vk.com/club49587500" target="_blank" class="vk"></a>';
        echo '</div>';

    echo '</div>';  //закрытие footer_phone

    echo '</div>';  //закрытие footer_wrapper
echo '</div>';  //закрытие <div id=footer>

?>



<!--<div id="footer">-->

<!--<div class="center">-->
<!--<div class="widgets"><ul>          -->
<!--        --><?php //if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widgets') ) : ?><!-- -->
<!--        --><?php //endif; ?><!--</ul>-->
<!--        </div>-->


<!--    <div class="footer_wrapper">-->
<!--        <div class="footer_logo">-->
<!--            © 2015, ТД “Кодацкая вода”-->
<!--            <br />-->
<!--            office@kodacka-voda.com-->
<!--        </div>-->
<!--        <div class="footer_menu">-->
<!--            <ul>-->
<!--                <li><a href="#">Компания</a></li>-->
<!--                <li><a href="#">Сервис</a></li>-->
<!--                <li><a href="#">Контакты</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <div class="footer_menu">-->
<!--            <ul>-->
<!--                <li><a href="#">Пункты продажи</a></li>-->
<!--                <li><a href="#">Постоянным клиентам</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <div class="footer_phone">-->
<!--            <span>(044) 531-45-45</span>-->
<!--            <a href="#">Перезвоните мне</a>-->
<!--            <br/>-->
<!--            <a href="#">Оставить отзыв или комментарий</a>-->
<!--            <div class="social">-->
<!--                <a href="https://www.facebook.com/kodackavoda" target="_blank"  class="fb"></a>-->
<!--                <a href="http://vk.com/club49587500" target="_blank" class="vk"></a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


	<!--COPYRIGHT TEXT-->
<!--    <div id="copyright">-->
<!--    	<div class="center">-->
<!--            <div class="copytext">-->
<!--           --><?php //echo $option['trt_foot']; ?><!----><?php //_e('Theme by', 'triton');?><!-- <a class="towfiq" target="_blank" href="http://www.towfiqi.com/">Towfiq I.</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

<!--</div>-->


</div>
<?php wp_footer(); ?>
</body>
</html>

