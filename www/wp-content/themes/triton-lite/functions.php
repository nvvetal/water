<?php	
	add_theme_support('automatic-feed-links');
	if ( ! isset( $content_width ) )
	$content_width = 560;

//Post Thumbnail	
if(function_exists('add_theme_support')) {
   add_theme_support( 'post-thumbnails' );
}

//Register Menus
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'Triton' ),
		'footer1' => __( 'Footer1 Navigation', 'Triton' ),
        'footer2' => __( 'Footer2 Navigation', 'Triton' ),
        'goods' => __( 'Goods Navigation', 'Triton' )
	) );

//SIDEBAR
function trt_widgets_init(){
	register_sidebar(array(
	'name'          => __('Right Sidebar', 'Triton'),
	'id'            => 'sidebar',
	'description'   => __('Right Sidebar', 'Triton'),
	'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="widget_top"></div><div class="widget_wrap">',
	'after_widget'  => '</div><div class="widget_bottom"></div>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3>'
	));
	
	register_sidebar(array(
	'name'          => __('Midrow Widgets', 'Triton'),
	'id'            => 'mid_sidebar',
	'description'   => __('Widget Area for the Midrow', 'Triton'),
	'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="widget_wrap">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3>'
	));
	
	register_sidebar(array(
	'name'          => __('Footer Widgets', 'Triton'),
	'id'            => 'foot_sidebar',
	'description'   => __('Widget Area for the Footer', 'Triton'),
	'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="widget_wrap">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3>'
	));
}

add_action( 'widgets_init', 'trt_widgets_init' );


//Load Java Scripts to header
function trt_head_js() { 
if ( !is_admin() ) {
wp_enqueue_script('jquery');
wp_enqueue_script('triton_js',get_template_directory_uri().'/js/triton.js');
wp_enqueue_script('triton_other',get_template_directory_uri().'/js/other.js');
wp_enqueue_script('triton_newslider',get_template_directory_uri().'/js/featureList.js');

	$option =  get_option('trt_options');
	if($option['trt_slider']== "Easyslider") { 
    wp_enqueue_script('triton_easySlider',get_template_directory_uri().'/js/easyslider.js');
     }
    if($option["trt_diss_fbx"] == "1"){
    } else { 
	wp_enqueue_style('triton_fancybox_css',get_template_directory_uri().'/css/fancybox.css');
	wp_enqueue_script('triton_fancybox_js',get_template_directory_uri().'/js/fancybox.js');
	}


	}
}
add_action('wp_enqueue_scripts', 'trt_head_js');


add_action('wp_footer', 'trt_load_js');
 
function trt_load_js() { ?>
	<?php $option =  get_option('trt_options'); ?>
    <?php if($option['trt_slider']== "Easyslider") { ?>
    <script type="text/javascript">
		/* <![CDATA[ */
    jQuery(function(){
	jQuery("#slider").easySlider({
		auto: true,
		continuous: true,
		numeric: true,
		pause: <?php echo $option['trt_slider_speed'] ?>
		});
	});
	/* ]]> */
	</script>
    <?php } ?> 

    <?php } 

//Add Custom Slider Post
add_action('init', 'trt_slider_register');
 
function trt_slider_register() {
 
	$labels = array(
		'name' => _x('Slider', 'post type general name'),
		'singular_name' => _x('Slider Item', 'post type singular name'),
		'add_new' => _x('Add New', 'Slider item'),
		'add_new_item' => __('Add New Slide', 'Triton'),
		'edit_item' => __('Edit Slides', 'Triton'),
		'new_item' => __('New Slider', 'Triton'),
		'view_item' => __('View Sliders', 'Triton'),
		'search_items' => __('Search Sliders', 'Triton'),
		'menu_icon' => get_stylesheet_directory_uri() . 'images/article16.png',
		'not_found' =>  __('Nothing found', 'Triton'),
		'not_found_in_trash' => __('Nothing found in Trash', 'Triton'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/slider_button.png',
		'rewrite' => false,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','excerpt','thumbnail'),
		'register_meta_box_cb' => 'trt_add_meta'
	  ); 
 
	register_post_type( 'slider' , $args );
}
//Slider Link Meta Box
add_action("admin_init", "trt_add_meta");
 
function trt_add_meta(){
  add_meta_box("trt_credits_meta", "Link", "trt_credits_meta", "slider", "normal", "low");
}
 

function trt_credits_meta( $post ) {

  // Use nonce for verification
  $trtdata = get_post_meta($post->ID, 'trt_slide_link', TRUE);
  wp_nonce_field( 'trt_meta_box_nonce', 'meta_box_nonce' ); 

  // The actual fields for data entry
  echo '<input type="text" id="trt_sldurl" name="trt_sldurl" value="'.$trtdata.'" size="75" />';
}

//Save Slider Link Value
add_action('save_post', 'trt_save_details');
function trt_save_details($post_id){
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'trt_meta_box_nonce' ) ) return; 

  if ( !current_user_can( 'edit_post', $post_id ) )
        return;

$trtdata = esc_url( $_POST['trt_sldurl'] );
update_post_meta($post_id, 'trt_slide_link', $trtdata);
return $trtdata;  
}



add_action('do_meta_boxes', 'trt_slider_image_box');

function trt_slider_image_box() {
	remove_meta_box( 'postimagediv', 'slider', 'side' );
	add_meta_box('postimagediv', __('Slide Image', 'Triton'), 'post_thumbnail_meta_box', 'slider', 'normal', 'high');
}


//TRITON get the first image of the post Function
function trt_get_images($overrides = '', $exclude_thumbnail = false)
{
    return get_posts(wp_parse_args($overrides, array(
        'numberposts' => -1,
        'post_parent' => get_the_ID(),
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'order' => 'ASC',
        'exclude' => $exclude_thumbnail ? array(get_post_thumbnail_id()) : array(),
        'orderby' => 'menu_order ID'
    )));
}


//Custom Excerpt Length
function trt_excerptlength_teaser($length) {
    return 33;
}
function trt_excerptlength_index($length) {
    return 12;
}
function trt_excerptmore($more) {
    return '...';
}

function trt_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

//TRITON COMMENTS
function trt_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
      <div class="comment-body-top"></div>
     <div id="comment-<?php comment_ID(); ?>" class="comment-body">
      <div class="comment-author vcard">
      <div class="avatar"><?php echo get_avatar($comment,$size='58' ); ?></div>

         <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
      </div>
      <div class="comment-meta commentmetadata">
              <a class="comm_date"><?php printf(get_comment_date()) ?></a>
        <a class="comm_time"><?php printf( get_comment_time()) ?></a>
        </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.', 'Triton') ?></em>
         <br />
      <?php endif; ?>

      <div class="org_comment"><?php comment_text() ?>
      	<div class="comm_meta_reply">
        <div class="comm_reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
        <div class='comm_edit'><?php edit_comment_link(__('Edit', 'triton'),'  ','') ?></div></div>
     </div>
     
     </div>
<?php
        }
		
//TRITON TRACKBACKS & PINGS
function trt_ping($comment, $args, $depth) {
 
$GLOBALS['comment'] = $comment; ?>
	
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   <div class="comment-body-top"></div>
     <div id="comment-<?php comment_ID(); ?>" class="comment-body">
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.', 'Triton') ?></em>
         <br />
      <?php endif; ?>

      <div class="org_ping">
      	<?php printf(__('<cite class="citeping">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	  	<?php comment_text() ?>
            <div class="comment-meta commentmetadata">
            <a class="comm_date"><?php printf(get_comment_date()) ?></a>
            <a class="comm_time"><?php printf( get_comment_time()) ?></a>
            <div class='comm_edit'><?php edit_comment_link(__('Edit', 'triton'),'  ','') ?></div></div>
     </div>
     </div>
     
     
<?php }

if (isset($_GET['page']) && $_GET['page'] == 'trt_option') {
add_action('admin_print_scripts', 'trt_admin_scripts');
add_action('admin_print_styles', 'trt_admin_styles');
}






//function static_header()
//{
//    $labels = array(
//        'name' => _x('Настройки статического хедера', 'post type general name'),
//        'singular_name' => _x('Настройки статического хедера', 'post type singular name'),
//        'add_new' => _x('Настроить', 'book'),
//        'add_new_item' => __('Настроить'),
//        'edit_item' => __('Редактировать'),
//        'new_item' => __('Новые настройки'),
//        'all_items' => __('Все настройки'),
//        'view_item' => __('Просмотр настроек'),
//        'search_items' => __('Поиск настроек'),
//        'not_found' => __('Настройки не найдены'),
//        'not_found_in_trash' => __('Настройки не найдены в Корзине'),
//        'parent_item_colon' => '',
//        'menu_name' => 'Настройки статического хедера'
//    );
//    $args = array(
//        'labels' => $labels,
//        'description' => 'Holds our teasers and details teasers data',
//        'public' => true,
//        'menu_position' => 5,
//        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
//        'has_archive' => true,
//    );
//    register_post_type('static_header', $args);
//}
//
//add_action('init', 'static_header');
//
//
//
//function footer()
//{
//    $labels = array(
//        'name' => _x('Настройки футера', 'post type general name'),
//        'singular_name' => _x('Настройки футер', 'post type singular name'),
//        'add_new' => _x('Настроить', 'book'),
//        'add_new_item' => __('Настроить'),
//        'edit_item' => __('Редактировать'),
//        'new_item' => __('Новые настройки'),
//        'all_items' => __('Все настройки'),
//        'view_item' => __('Просмотр настроек'),
//        'search_items' => __('Поиск настроек'),
//        'not_found' => __('Настройки не найдены'),
//        'not_found_in_trash' => __('Настройки не найдены в Корзине'),
//        'parent_item_colon' => '',
//        'menu_name' => 'Настройки футера'
//    );
//    $args = array(
//        'labels' => $labels,
//        'description' => 'Holds our teasers and details teasers data',
//        'public' => true,
//        'menu_position' => 5,
//        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
//        'has_archive' => true,
//    );
//    register_post_type('footer', $args);
//}
//
//add_action('init', 'footer');


function options()
{
    $labels = array(
        'name' => _x('Настройки', 'post type general name'),
        'singular_name' => _x('Настройки', 'post type singular name'),
        'add_new' => _x('Настроить', 'book'),
        'add_new_item' => __('Настроить'),
        'edit_item' => __('Редактировать'),
        'new_item' => __('Новые настройки'),
        'all_items' => __('Все настройки'),
        'view_item' => __('Просмотр настроек'),
        'search_items' => __('Поиск настроек'),
        'not_found' => __('Настройки не найдены'),
        'not_found_in_trash' => __('Настройки не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Настройки'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('options', $args);
}

add_action('init', 'options');

function options_taxonomies() {
    $labels = array(
        'name'              => _x( 'Категории настроек', 'taxonomy general name' ),
        'singular_name'     => _x( 'Категория настроек', 'taxonomy singular name' ),
        'search_items'      => __( 'Найти категории настроек' ),
        'all_items'         => __( 'Все категории настроек' ),
        'parent_item'       => __( 'Pодительские категории настроек' ),
        'parent_item_colon' => __( 'Родительские категории настроек:' ),
        'edit_item'         => __( 'Редактировать категории настроек' ),
        'update_item'       => __( 'Обновить категории настроек' ),
        'add_new_item'      => __( 'Добавить новую категорию настроек' ),
        'new_item_name'     => __( 'Новая категория настроек' ),
        'menu_name'         => __( 'Категории настроек' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'options_category', 'options', $args );
}
add_action( 'init', 'options_taxonomies', 0 );



function goods()
{
    $labels = array(
        'name' => _x('Товары', 'post type general name'),
        'singular_name' => _x('Товары', 'post type singular name'),
        'add_new' => _x('Добавить товары', 'book'),
        'add_new_item' => __('Добавить товар'),
        'edit_item' => __('Редактировать товары'),
        'new_item' => __('Новые товары'),
        'all_items' => __('Все товары'),
        'view_item' => __('Просмотр товаров'),
        'search_items' => __('Поиск товаров'),
        'not_found' => __('Товары не найдены'),
        'not_found_in_trash' => __('Товары не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Товары'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('goods', $args);
}

add_action('init', 'goods');

function goods_taxonomies() {
    $labels = array(
        'name'              => _x( 'Категории товаров', 'taxonomy general name' ),
        'singular_name'     => _x( 'Категория товаров', 'taxonomy singular name' ),
        'search_items'      => __( 'Поиск категорий товаров' ),
        'all_items'         => __( 'Все категории товаров' ),
        'parent_item'       => __( 'Родительская категория товаров' ),
        'parent_item_colon' => __( 'Родительская категория товаров:' ),
        'edit_item'         => __( 'Редактировать категорию товаров' ),
        'update_item'       => __( 'Обновить категорию товаров' ),
        'add_new_item'      => __( 'Добавить новую категорию товаров' ),
        'new_item_name'     => __( 'Новая категория товаров' ),
        'menu_name'         => __( 'Категории товаров' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'goods_category', 'goods', $args );
}
add_action( 'init', 'goods_taxonomies', 0 );





function actions()      // АКЦИИ
{
    $labels = array(
        'name' => _x('Акции', 'post type general name'),
        'singular_name' => _x('Акции', 'post type singular name'),
        'add_new' => _x('Добавить акции', 'book'),
        'add_new_item' => __('Добавить такции'),
        'edit_item' => __('Редактировать акции'),
        'new_item' => __('Новые акции'),
        'all_items' => __('Все акции'),
        'view_item' => __('Просмотр акций'),
        'search_items' => __('Поиск акций'),
        'not_found' => __('Акции не найдены'),
        'not_found_in_trash' => __('Акции не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Акции'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('actions', $args);
}

add_action('init', 'actions');




function sale_points()
{
    $labels = array(
        'name' => _x('Точки продаж', 'post type general name'),
        'singular_name' => _x('Точки продаж', 'post type singular name'),
        'add_new' => _x('Добавить точки продаж', 'book'),
        'add_new_item' => __('Добавить точки продаж'),
        'edit_item' => __('Редактировать точки продаж'),
        'new_item' => __('Новые точки продаж'),
        'all_items' => __('Все точки продаж'),
        'view_item' => __('Просмотр точек продаж'),
        'search_items' => __('Поиск точек продаж'),
        'not_found' => __('Точки продаж не найдены'),
        'not_found_in_trash' => __('Точки продаж не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Точки продаж'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('sale_points', $args);
}

add_action('init', 'sale_points');


function facts()
{
    $labels = array(
        'name' => _x('Факты о воде', 'post type general name'),
        'singular_name' => _x('Факты о воде', 'post type singular name'),
        'add_new' => _x('Добавить факты о воде', 'book'),
        'add_new_item' => __('Добавить новые факты о воде'),
        'edit_item' => __('Редактировать факты о воде'),
        'new_item' => __('Новые факты о воде'),
        'all_items' => __('Все факты о воде'),
        'view_item' => __('Просмотр фактов о воде'),
        'search_items' => __('Поиск фактов о воде'),
        'not_found' => __('Факты о воде не найдены'),
        'not_found_in_trash' => __('Факты о воде не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Факты о воде'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('facts', $args);
}

add_action('init', 'facts');


function technology()
{
    $labels = array(
        'name' => _x('Технологии и методы очистки воды', 'post type general name'),
        'singular_name' => _x('Технологии и методы очистки воды', 'post type singular name'),
        'add_new' => _x('Добавить технологии и методы очистки воды', 'book'),
        'add_new_item' => __('Добавить новые технологии и методы очистки воды'),
        'edit_item' => __('Редактировать технологии и методы очистки воды'),
        'new_item' => __('Новые технологии и методы очистки воды'),
        'all_items' => __('Все технологии и методы очистки воды'),
        'view_item' => __('Просмотр технологий и методов очистки воды'),
        'search_items' => __('Поиск технологий и методов очистки воды'),
        'not_found' => __('Технологии и методы очистки воды не найдены'),
        'not_found_in_trash' => __('Технологии и методы очистки воды не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Технологии и методы очистки воды'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('technology', $args);
}

add_action('init', 'technology');


function priorities()
{
    $labels = array(
        'name' => _x('Наши приоритеты', 'post type general name'),
        'singular_name' => _x('Наши приоритеты', 'post type singular name'),
        'add_new' => _x('Добавить приоритеты', 'book'),
        'add_new_item' => __('Добавить приоритеты'),
        'edit_item' => __('Редактировать приоритеты'),
        'new_item' => __('Новые приоритеты'),
        'all_items' => __('Все приоритеты'),
        'view_item' => __('Просмотр приоритетов'),
        'search_items' => __('Поиск приоритетов'),
        'not_found' => __('Приоритеты не найдены'),
        'not_found_in_trash' => __('Приоритеты не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Наши приоритеты'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('priorities', $args);
}

add_action('init', 'priorities');


function service()
{
    $labels = array(
        'name' => _x('Сервис', 'post type general name'),
        'singular_name' => _x('Наши услуги', 'post type singular name'),
        'add_new' => _x('Добавить услуги', 'book'),
        'add_new_item' => __('Добавить услуги'),
        'edit_item' => __('Редактировать услуги'),
        'new_item' => __('Новые услуги'),
        'all_items' => __('Все услуги'),
        'view_item' => __('Просмотр услуг'),
        'search_items' => __('Поиск услуг'),
        'not_found' => __('Услуги не найдены'),
        'not_found_in_trash' => __('Услуги не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Сервис'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('service', $args);
}

add_action('init', 'service');


function masters_visit()
{
    $labels = array(
        'name' => _x('Причины визита мастера', 'post type general name'),
        'singular_name' => _x('Причины визита мастера', 'post type singular name'),
        'add_new' => _x('Добавить причины', 'book'),
        'add_new_item' => __('Добавить причины'),
        'edit_item' => __('Редактировать причины'),
        'new_item' => __('Новые причины'),
        'all_items' => __('Все причины'),
        'view_item' => __('Просмотр причин'),
        'search_items' => __('Поиск причины'),
        'not_found' => __('Причины не найдены'),
        'not_found_in_trash' => __('Причины не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Причины визита мастера'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('masters_visit', $args);
}

add_action('init', 'masters_visit');


function graces()
{
    $labels = array(
        'name' => _x('Наши преимущества', 'post type general name'),
        'singular_name' => _x('Наши преимущества', 'post type singular name'),
        'add_new' => _x('Добавить преимущества', 'book'),
        'add_new_item' => __('Добавить преимущества'),
        'edit_item' => __('Редактировать преимущества'),
        'new_item' => __('Новые преимущества'),
        'all_items' => __('Все преимущества'),
        'view_item' => __('Просмотр преимуществ'),
        'search_items' => __('Поиск преимуществ'),
        'not_found' => __('Преимущества не найдены'),
        'not_found_in_trash' => __('Преимущества не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Наши преимущества'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('graces', $args);
}

add_action('init', 'graces');


function quick_order()
{
    $labels = array(
        'name' => _x('Быстрый заказ', 'post type general name'),
        'singular_name' => _x('Товары', 'post type singular name'),
        'add_new' => _x('Добавить товары', 'book'),
        'add_new_item' => __('Добавить товары'),
        'edit_item' => __('Редактировать товары'),
        'new_item' => __('Новые товары'),
        'all_items' => __('Все товары'),
        'view_item' => __('Просмотр товаров'),
        'search_items' => __('Поиск товаров'),
        'not_found' => __('Товары не найдены'),
        'not_found_in_trash' => __('Товары не найдены в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Быстрый заказ'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('quick_order', $args);
}

add_action('init', 'quick_order');

function callback()
{
    $labels = array(
        'name' => _x('Обратная связь', 'post type general name'),
        'singular_name' => _x('Обратная связь', 'post type singular name'),
        'add_new' => _x('Добавить', 'book'),
        'add_new_item' => __('Добавить'),
        'edit_item' => __('Редактировать'),
        'new_item' => __('Новые'),
        'all_items' => __('Все'),
        'view_item' => __('Просмотр'),
        'search_items' => __('Поиск'),
        'not_found' => __('Не найдено'),
        'not_found_in_trash' => __('Не найдено в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Обратная связь'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('callback', $args);
}

add_action('init', 'callback');


function teasers()
{
    $labels = array(
        'name' => _x('Тизеры', 'post type general name'),
        'singular_name' => _x('Тизеры', 'post type singular name'),
        'add_new' => _x('Добавить тизеры', 'book'),
        'add_new_item' => __('Добавить новые тизеры'),
        'edit_item' => __('Редактировать тизеры'),
        'new_item' => __('Новые тизеры'),
        'all_items' => __('Все тизеры'),
        'view_item' => __('Просмотр тизеров'),
        'search_items' => __('Поиск тизеров'),
        'not_found' => __('Тизер не найден'),
        'not_found_in_trash' => __('Тизер не найден в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Тизеры'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('teasers', $args);
}

add_action('init', 'teasers');



function teasers_taxonomies() {
    $labels = array(
        'name'              => _x( 'Категории тизеров', 'taxonomy general name' ),
        'singular_name'     => _x( 'Категории тизеров', 'taxonomy singular name' ),
        'search_items'      => __( 'Найти категории тизеров' ),
        'all_items'         => __( 'Все категории тизеров' ),
        'parent_item'       => __( 'Родительская категория тизеров' ),
        'parent_item_colon' => __( 'Родительская категория тизеров:' ),
        'edit_item'         => __( 'Редактировать категории тизеров' ),
        'update_item'       => __( 'Обновить категории тизеров' ),
        'add_new_item'      => __( 'Добавить новую категорию тизеров' ),
        'new_item_name'     => __( 'Новая категория тизеров' ),
        'menu_name'         => __( 'Категории тизеров' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'teasers_category', 'teasers', $args );
}
add_action( 'init', 'teasers_taxonomies', 0 );



function why_choose()
{
    $labels = array(
        'name' => _x('Почему выбирают нас', 'post type general name'),
        'singular_name' => _x('Почему выбирают нас', 'post type singular name'),
        'add_new' => _x('Добавить критерии', 'book'),
        'add_new_item' => __('Добавить новые критерии'),
        'edit_item' => __('Редактировать критерии'),
        'new_item' => __('Новые критерии'),
        'all_items' => __('Все критерии'),
        'view_item' => __('Просмотр критериев'),
        'search_items' => __('Поиск критериев'),
        'not_found' => __('Критерий не найден'),
        'not_found_in_trash' => __('Критерий не найден в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Почему выбирают нас'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('why_choose', $args);
}

add_action('init', 'why_choose');




function slider_top()
{
    $labels = array(
        'name' => _x('Верхний слайдер', 'post type general name'),
        'singular_name' => _x('Верхний слайдер', 'post type singular name'),
        'add_new' => _x('Добавить слайд', 'book'),
        'add_new_item' => __('Добавить новые слайды'),
        'edit_item' => __('Редактировать слайды'),
        'new_item' => __('Новые слайды'),
        'all_items' => __('Все слайды'),
        'view_item' => __('Просмотр слайдов'),
        'search_items' => __('Поиск слайдов'),
        'not_found' => __('Слайд не найден'),
        'not_found_in_trash' => __('Слайд не найден в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Верхний слайдер'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('slider_top', $args);
}

add_action('init', 'slider_top');



function slider_content()
{
    $labels = array(
        'name' => _x('Контентовый слайдер', 'post type general name'),
        'singular_name' => _x('Контентовый слайдер', 'post type singular name'),
        'add_new' => _x('Добавить слайд', 'book'),
        'add_new_item' => __('Добавить новые слайды'),
        'edit_item' => __('Редактировать слайды'),
        'new_item' => __('Новые слайды'),
        'all_items' => __('Все слайды'),
        'view_item' => __('Просмотр слайдов'),
        'search_items' => __('Поиск слайдов'),
        'not_found' => __('Слайд не найден'),
        'not_found_in_trash' => __('Слайд не найден в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Контентовый слайдер'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our teasers and details teasers data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('slider_content', $args);
}

add_action('init', 'slider_content');



include(TEMPLATEPATH . '/lib/script/pagination.php');
include(TEMPLATEPATH . '/lib/includes/shortcodes.php');
include(TEMPLATEPATH . '/lib/includes/widgets.php');
include(TEMPLATEPATH . '/lib/includes/control_panel.php');


function my_scripts_method() {
    wp_deregister_script( 'my_script' );
    wp_register_script( 'my_script', 'js/my_script.js');
    wp_enqueue_script( 'my_script' );
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

?>