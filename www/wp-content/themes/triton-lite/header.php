<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<?php $option =  get_option('trt_options'); ?>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

<link href="<?php bloginfo('template_directory'); ?>/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<!--<link rel="stylesheet" href="--><?php //bloginfo('template_directory'); ?><!--/Google Map code/map_style.css" type="text/css" media="screen" />-->
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>-->
<!--<script type="text/javascript" src="--><?php //bloginfo('template_directory'); ?><!--/Google Map code/map_script.js"></script>-->

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-2.1.3.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/bxslider/jquery.bxslider.min.js"></script>
<!--    <link rel="stylesheet" href="--><?php //bloginfo('template_directory'); ?><!--/bxslider/jquery.bxslider.css" />-->

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/my_script.js"></script>

   <?php if($option["trt_lft_logo"] == "1"){ ?>
	<style>#logo h1 a, .desc { text-align:left;}</style>
   <?php } ?>
<?php wp_enqueue_style('triton_customfont',get_template_directory_uri().'/fonts/'.$option['trt_fonts'].'.css'); ?>
<?php get_template_part('colors');?>

	<?php //comments_popup_script(); // off by default ?>
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>

<style type="text/css">

    .acf-map {
        width: 100%;
        height: 400px;
        border: #ccc solid 1px;
        margin: 20px 0;
    }

</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
    (function($) {

        /*
         *  render_map
         *
         *  This function will render a Google Map onto the selected jQuery element
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	$el (jQuery element)
         *  @return	n/a
         */

        function render_map( $el ) {

            // var
            var $markers = $el.find('.marker');

            // vars
            var args = {
                zoom		: 16,
                center		: new google.maps.LatLng(0, 0),
                mapTypeId	: google.maps.MapTypeId.ROADMAP
            };

            // create map
            var map = new google.maps.Map( $el[0], args);

            // add a markers reference
            map.markers = [];

            // add markers
            $markers.each(function(){

                add_marker( $(this), map );

            });

            // center map
            center_map( map );

        }

        /*
         *  add_marker
         *
         *  This function will add a marker to the selected Google Map
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	$marker (jQuery element)
         *  @param	map (Google Map object)
         *  @return	n/a
         */

        function add_marker( $marker, map ) {

            // var
            var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

            // create marker
            var marker = new google.maps.Marker({
                position	: latlng,
                map			: map
            });

            // add to array
            map.markers.push( marker );

            // if marker contains HTML, add it to an infoWindow
            if( $marker.html() )
            {
                // create info window
                var infowindow = new google.maps.InfoWindow({
                    content		: $marker.html()
                });

                // show info window when marker is clicked
                google.maps.event.addListener(marker, 'click', function() {

                    infowindow.open( map, marker );

                });
            }

        }

        /*
         *  center_map
         *
         *  This function will center the map, showing all markers attached to this map
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	map (Google Map object)
         *  @return	n/a
         */

        function center_map( map ) {

            // vars
            var bounds = new google.maps.LatLngBounds();

            // loop through all markers and create bounds
            $.each( map.markers, function( i, marker ){

                var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

                bounds.extend( latlng );

            });

            // only 1 marker?
            if( map.markers.length == 1 )
            {
                // set center of map
                map.setCenter( bounds.getCenter() );
                map.setZoom( 16 );
            }
            else
            {
                // fit to bounds
                map.fitBounds( bounds );
            }

        }

        /*
         *  document ready
         *
         *  This function will render each map when the document is ready (page has loaded)
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	5.0.0
         *
         *  @param	n/a
         *  @return	n/a
         */

        $(document).ready(function(){

            $('.acf-map').each(function(){

                render_map( $(this) );

            });

        });

    })(jQuery);

</script>

</head>


<body <?php body_class(); ?>>

<div id="callback_wrap" style="display:none; position: fixed; width: 100%; height: 100%; z-index: 9000;">
</div>
<script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap.min.js"></script>

<!--[if lte IE 6]><script src="<?php get_template_directory_uri(); ?>/ie6/warning.js"></script><script>window.onload=function(){e("<?php get_template_directory_uri(); ?>/ie6/")}</script><![endif]-->
<div class="pattern">

  <?php if (!session_id())session_start(); ?>

<!--TOPMENU-->
    <?php
   ?>
    <?php $query = new WP_Query(array('options_category' => 'Static Header', 'posts_per_page' => 1));

    if( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            the_content();
            $left_top_near_bottle = get_field("надпись_слева_сверху(возле_бутыля)");
            $left_bottom_near_bottle = get_field("надпись_слева_снизу(возле_бутыля)");
            $phone = get_field("телефон");
            $below_phone = get_field("надпись_под_телефоном");
            $right_top_near_basket = get_field("надпись_справа_сверху(возле_корзины)");
            $right_bottom_near_basket = get_field("надпись_справа_снизу(возле_корзины)");
            $facebook = get_field("ссылка_на_страницу_в_facebook");
            $vk = get_field("ссылка_на_группу_вконтакте");

            echo '<div id="static_header">';
                echo '<div class="order" href="#">';
                    echo '<a href="#">';
                        echo $left_top_near_bottle;
                        echo '<span>'.$left_bottom_near_bottle.'</span>';
                    echo '</a>';
                echo '</div>';
                echo '<div class="phone">';
                    echo '<span>'.$phone.'</span>';
                    echo '<br>';
                    echo '<a href="#">'.$below_phone.'</a>';
                echo '</div>';
                echo '<div class="social_header">';
                    echo '<a href="'.$facebook.'" target="_blank" class="fb span1"></a>';
                    echo '<a href="'.$vk.'" target="_blank" class="vk span1"></a>';
                echo '</div>';
                echo '<div class="basket">';
                    echo '<a>';
                        echo $right_top_near_basket;
                        echo '<br>';
                        echo '<small>'.$right_bottom_near_basket.'</small>';
                    echo '</a>';
                echo '</div>';
            echo '</div>';

            // здесь оформляем данные для каждого поста в цикле
        }
        wp_reset_query();
    }

    ?>


<!--Модалька на покупку воды с хедера-->
    <div class="modal" id="modal-quick-order" style="display: none;">
        <!--    <div class="modal-header">-->
        <!--        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
        <!--        <h3 id="myModalLabel">Modal header</h3>-->
        <!--    </div>-->
        <div class="modal-body">
            <div id="twrapper">
                <div id="rwrapper">
                    <div class="cwrapper pic">

                        <?php $query = new WP_Query(array('post_type'=>quick_order, 'orderby'=>date, 'order'=>asc));
                        if( $query->have_posts() ){
                            while( $query->have_posts() ){
                                $query->the_post();
                                $img = get_field("изображение");

                                echo '<img src="'.$img[url].'">';
                            }
                            wp_reset_query();
                        } ?>

                    </div>
                    <div class="cwrapper content">
                        <form action="" name="order_surface" method="post">

                            <?php $query = new WP_Query(array('post_type'=>quick_order, 'orderby'=>date, 'order'=>asc));
                            if( $query->have_posts() ){
                                while( $query->have_posts() ){
                                    $query->the_post();
                                    $text1 = get_field("название_товара");
                                    $text2 = get_field("текст");

                                    echo '<h1>'.$text1.'</h1>';
                                    echo '<h3>'.$text2.'</h3>';
                                }
                                wp_reset_query();
                            } ?>

                            <div class="border">
                                <select name="product" class="selectpicker" style="display: none;">

                                    <?php $query = new WP_Query(array('post_type'=>quick_order, 'orderby'=>date, 'order'=>asc));
                                    if( $query->have_posts() ){
                                        while( $query->have_posts() ){
                                            $query->the_post();
                                            $text1 = get_field("название_товара");
                                            $text1 = str_replace('"', '&quot;', $text1);

//                                            echo '<option value="Вода очищенная \"Кодацкая\"" >'.$text1.'</option>';
                                            echo '<option value="'.$text1.'" >'.$text1.'</option>';
                                        }
                                        wp_reset_query();
                                    } ?>
<!--                                    <option value="312" selected="selected">Вода очищенная "Кодацкая вода"</option>-->

                                </select>
                                <div class="btn-group bootstrap-select">

                                    <?php $query = new WP_Query(array('post_type'=>quick_order, 'orderby'=>date, 'order'=>asc));
                                    if( $query->have_posts() ){
                                        while( $query->have_posts() ){
                                            $query->the_post();
                                            $text1 = get_field("название_товара");

                                            echo '<button type="button" class="btn dropdown-toggle selectpicker btn-default" data-toggle="dropdown" title="'.$text1.'">';
                                                echo '<span class="filter-option pull-left">'.$text1.'</span>';
                                            echo '<span class="caret"></span>';
                                            echo '</button>';
                                        }
                                        wp_reset_query();
                                    } ?>



                                    <div class="dropdown-menu open">
                                        <ul class="dropdown-menu inner selectpicker" role="menu">

                                            <?php $query = new WP_Query(array('post_type'=>quick_order, 'orderby'=>date, 'order'=>asc));
                                            $rel = 0;
                                            if( $query->have_posts() ){
                                                while( $query->have_posts() ){
                                                    $query->the_post();
                                                    $text1 = get_field("название_товара");
                                                    $price = get_field("цена");

                                                    echo '<li rel="'.$rel.'" class="selected">';
                                                        echo '<a tabindex="0" class="" style="">';
                                                            echo '<span class="text">'.$text1.'</span>';
                                                           echo '<i class="glyphicon glyphicon-ok icon-ok check-mark"></i>';
                                                        echo '</a>';
                                                    echo '</li>';

                                                    $rel++;
                                                }
                                                wp_reset_query();
                                            } ?>

                                        </ul>
                                    </div>
                                </div> <!-- конец <div class="btn-group bootstrap-select"> -->
                            </div>

                            <div class="border">
                                <div class="quantity">
                                    <span class="minus" onClick="orderQuantityMinus();"></span>
                                    <span>
                                        <input type="text" name="quantity" value="1" data-price="<?php echo $price; ?>" data-price-2-4="35" data-price-5-9="32" data-price-10-19="29" data-price-20-49="26" data-price-50="23">
                                    </span>
                                    <span class="plus" onClick="orderQuantityPlus();"></span>
                                </div>
                                <div class="price">

                                    <?php
//                                            echo '<div class="wrp">';
                                                echo '<span class="value">'.$price.'</span>';
                                                echo '<span class="value-old-price"></span>';
                                                echo '<span class="value-new-price"></span>';
                                                echo '<span class="currency">грн.</span>';
//                                            echo '</div>';
                                     ?>

                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="border">
                                <input type="tel" name="phone_qo" required="required" placeholder="Ваш номер телефона" pattern="[\-+0-9,\s]*">
                                <input type="submit" value="Подтвердить покупку" class="btn btn-danger">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--    <div class="modal-footer">-->
        <!--        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
        <!--        <button class="btn btn-primary">Save changes</button>-->
        <!--    </div>-->
    </div>

<!--    <div id="topmenu1">	--><?php //wp_nav_menu(array('container' => false, 'theme_location' => 'secondary' ) ); ?><!-- </div><br style="clear:both" />-->
    <div id="wrapper">             <!-- закрывается в index.php -->
        <div id="header_wrapper">
            <div class="logo"><a href="<?php echo get_home_url(); ?>"></a></div>
            <div id="topmenu">	<?php $primary_menu = wp_nav_menu(array('container' => false, 'theme_location' => 'primary', 'echo' => false ) ); $primary_menu = str_replace('page_id=132', 'goods_category=vse', $primary_menu);
                echo $primary_menu; ?><div id="menu-fluid" class="menu-fluid"></div> </div><br style="clear:both" />

        </div>




<!--<div id="masthead">-->
<!--	<div class="fake">-->
<!--    <div class="center">-->
<!--   	 <div id="menu_wrap"><div class="center"></div></div>-->
     
     
     <!--Social Share-->
<?php //if($option["trt_hide_social"] == "1"){ ?>
<?php //} else { ?>
<!--<div class="social_wrap">-->
<!--    <div class="social">-->
<!--        <ul>-->
<!--            --><?php //if(($option["trt_hide_fb"] == "1") || (($option["trt_fb_url"] == ""))){ ?><!----><?php //} else { ?><!--<li class="soc_fb"><a title="Facebook"  href="--><?php //echo $option['trt_fb_url'] ?><!--">Facebook</a></li>--><?php //} ?>
<!--            --><?php //if(($option["trt_hide_tw"] == "1") || (($option["trt_tw_url"] == ""))){ ?><!----><?php //} else { ?><!--<li class="soc_tw"><a title="Twitter" href="--><?php //echo $option['trt_tw_url'] ?><!--">Twitter</a></li>--><?php //} ?><!-- -->
<!--            --><?php //if(($option["trt_hide_ms"] == "1") || (($option["trt_ms_url"] == ""))){ ?><!----><?php //} else { ?><!--<li class="soc_ms"><a title="Myspace"  href="--><?php //echo $option['trt_ms_url'] ?><!--">Myspace</a></li>--><?php //} ?><!-- -->
<!--            --><?php //if(($option["trt_hide_ytb"] == "1") || (($option["trt_ytb_url"] == ""))){ ?><!----><?php //} else { ?><!--<li class="soc_ytb"><a title="Youtube"  href="--><?php //echo $option['trt_ytb_url'] ?><!--">Youtube</a></li>--><?php //} ?><!-- -->
<!--            --><?php //if(($option["trt_hide_flckr"] == "1") || (($option["trt_flckr_url"] == ""))){ ?><!----><?php //} else { ?><!--<li class="soc_flkr"><a title="Flickr"  href="--><?php //echo $option['trt_flckr_url'] ?><!--">Flickr</a></li>--><?php //} ?>
<!--            --><?php //if(($option["trt_hide_rss"] == "1") || (($option["trt_rss_url"] == ""))){ ?><!----><?php //} else { ?><!--<li class="soc_rss"><a title="Rss Feed"  href="--><?php //echo $option['trt_rss_url'] ?><!--">RSS</a></li>--><?php //} ?>
<!--            --><?php //if(($option["trt_hide_gplus"] == "1") || (($option["trt_gplus_url"] == ""))){ ?><!----><?php //} else { ?><!--<li class="soc_plus"><a title="Google Plus"  href="--><?php //echo $option['trt_gplus_url'] ?><!--">Google Plus</a></li>--><?php //} ?>
<!--        </ul>-->
<!--    </div>-->
<!--</div>-->
<?php //} ?>
<!--    </div>-->
<!--    </div>-->
<!--</div>-->

<!--HEADER-->
<!--<div id="header">-->
<!--    <div class="center">-->
    	<!--LOGO-->
       
<!--        <div id="logo">-->
<!--        <h1><a class="text_logo" href="--><?php //echo home_url(); ?><!--">--><?php //bloginfo('name'); ?><!--</a></h1>-->
<!--        --><?php //if($option["trt_description"] == "1"){ ?><!----><?php //} else { ?><!--<div class="desc">--><?php //bloginfo('description')?><!--</div>--><?php //} ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?php $query = new WP_Query(array('post_type'=>callback, 'orderby'=>date, 'order'=>asc));
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
} ?>

<!--Модалька на категории -->
<div class="modal-backdrop" style="display: none">
    <button class="closes" data-dismiss="modal"></button>
</div>

<div id="ordered_goods"></div>


<?php
    if(isset($_POST["phone_cb"])) $phone_cb = $_POST["phone_cb"];

    if(!empty($phone_cb)){
        $to = "IntelCore2Dyo@mail.ru";
        $subject = "Перезвоните";
        $message = "Телефон: $phone_cb";
        $send = mail ($to, $subject, $message);

        unset($phone_cb);
    }


    if(isset($_POST["product"]) && isset($_POST["quantity"]) && isset($_POST["phone_qo"]))
    {
        $product = $_POST["product"];
        $product = str_replace('\\', '', $product);
        $quantity = $_POST["quantity"];
        $phone_qo = $_POST["phone_qo"];
    }

    if(!empty($product) && !empty($quantity) && !empty($phone_qo)){
        $to = "IntelCore2Dyo@mail.ru";
        $subject = "Заказ";
        $message = "Товар: $product, количество: $quantity, телефон: $prone_qo";
        $send = mail ($to, $subject, $message);

        unset($product);
        unset($quantity);
        unset($prone_qo);
    }

    $ip=getRealIpAddr();
      if (!isset($_COOKIE['id'])){
          $table='wp_user_list';
         $wpdb->insert( $table, array("user_name" =>$ip), array("%s"));
         $idi = $wpdb->insert_id;
          setcookie("id", $idi, time()+3600*24*30);
      }
//var_dump($_COOKIE["id"]);


?>