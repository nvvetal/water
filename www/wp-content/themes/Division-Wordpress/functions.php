<?php

class ControlPanel {

	/********************************************************
	Create a unique array that contains all default theme settings
	********************************************************/
	var $default_settings = Array(
	'feedburner_id' => '5555555',
	'blog_title' => 'Мой блог',
	'location' => 'ru_RU',
	'posts' => '4',
	'comments' => '6',
	'c_excerpt' => '50',
	'tags' => '30'
	);
    
	var $options;
	/********************************************************
	END
	********************************************************/
    
	/********************************************************
	Initiate new control panel function
	********************************************************/
	function ControlPanel() {
       	add_action('admin_menu', array(&$this, 'add_menu'));
	add_action('admin_head', array(&$this, 'admin_head'));
	if (!is_array(get_option('elegance')))
	add_option('elegance', $this->default_settings);
	$this->options = get_option('elegance');
	}
	/********************************************************
	END
	********************************************************/

	/********************************************************
	Create a theme settings page to edit theme settings and put its css
	********************************************************/
	function add_menu() {
	add_theme_page('Theme Settings', ' Настройки текущего шаблона', 'edit_themes', "elegance", array(&$this, 'optionsmenu'));
	}

	function admin_head() {
	print '<style type="text/css">
	.themeform {
	margin-left: 50px;
	margin-right: 50px;
	}

	.themeform h1 {
	font-weight: bold;
	font-size: 1.2em;
	color: 333;
	letter-spacing: -1px;
	padding-top: 5px;
	padding-bottom: 5px;
	margin: 20px 0px 10px 0px;
	border-top: 1px solid #ddd;
	border-bottom: 1px solid #ddd;
	}

	.themeform p {
	line-height: 1.5em;
	color: #666;
	}

	.themeform label {
	float: left;
	width: 300px;
	margin-top: 5px;
	margin-bottom: 5px;
	margin-left: 30px;
	}

	.themeform input {
	margin-top: 5px;
	margin-bottom: 5px;
	margin-left: 15px;
	}
	</style>';
	}
	/********************************************************
	END
	********************************************************/
	
	/********************************************************
	The options page in control panel. Saving and editing goes here
	********************************************************/
	function optionsmenu() {
	if ($_POST['ss_action'] == 'save') {
	$this->options["feedburner_id"] = $_POST['cp_feedburnerid'];
	$this->options["blog_title"] = $_POST['cp_blogtitle'];
	$this->options["location"] = $_POST['cp_location'];
	$this->options["posts"] = $_POST['cp_posts'];
	$this->options["comments"] = $_POST['cp_comments'];
	$this->options["c_excerpt"] = $_POST['cp_c_excerpt'];
	$this->options["tags"] = $_POST['cp_tags'];
	update_option('elegance', $this->options);
	echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 500px; margin-left: 50px"><p>Настройки <strong>сохранены</strong>.</p></div>';
	}

	echo '<form action="" method="post" class="themeform">';
	echo '<fieldset>';
	echo '<input type="hidden" id="ss_action" name="ss_action" value="save">';

	echo '<h1>Настройка FeedBurner </h1>';
	echo '<p>Здесь Вы можете настроить опции FeedBurner для подписки на фид вашего блога.</p>';
	echo '<label for="cp_feedburnerid">Ваш FeedBurner ID</label><input class="widefat" style="width:200px" name="cp_feedburnerid" id="cp_feedburnerid" type="text" value="'.$this->options["feedburner_id"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_blogtitle">Заголовок блога</label><input class="widefat" style="width:200px" name="cp_blogtitle" id="cp_blogtitle" type="text" value="'.$this->options["blog_title"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_location">Локация</label><input class="widefat" style="width:50px" name="cp_location" id="cp_location" type="text" value="'.$this->options["location"].'" /><div style="clear:both"></div>';

	echo '<h1>Настройки верхней панели блога</h1>';
	echo '<p>В верхней панели блога отображаются свежие записи, комментарии и метки.</p>';
	echo '<label for="cp_posts">Кол-во последних записей </label><input class="widefat" style="width:30px" name="cp_posts" id="cp_posts" type="text" value="'.$this->options["posts"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_comments">Кол-во последних комментариев </label><input class="widefat" style="width:30px" name="cp_comments" id="cp_comments" type="text" value="'.$this->options["comments"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_c_excerpt">Кол-во слов в комментариях </label><input class="widefat" style="width:30px" name="cp_c_excerpt" id="cp_c_excerpt" type="text" value="'.$this->options["c_excerpt"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_tags">Кол-во выводимых меток</label><input class="widefat" style="width:30px" name="cp_tags" id="cp_tags" type="text" value="'.$this->options["tags"].'" /><div style="clear:both"></div>';

	echo '<p class="submit"><input type="submit" value="ОК" name="cp_save" /></p>';
	echo '</fieldset>';
	echo '</form>';
	}
	/********************************************************
	END
	********************************************************/

}

/********************************************************
Initiate a new Control Panel function
********************************************************/
$cpanel = new ControlPanel();
$opt = get_option('elegance');

/********************************************************
Register 3 sidebars.. at last :)
********************************************************/
if (function_exists('register_sidebars')) register_sidebars(3);


//add_action('init', 'build_taxonomies');
//
//function build_taxonomies(){
//    register_taxonomy(
//        'Категории',         //название таксономии, которое будет использоваться в базе данных и файлах шаблона
//        'post',             //пределяет типы контента, к которым можно будет применить эту таксономию. Возможные значения: “post” (запись), “page” (страница), “link” (ссылка).
//        array(
//            'label' => 'Категории',      //это читаемое название, которое будет использоваться в интерфейсе сайта для обозначения этой таксономии.
//            'menu_icon' => 'f483',
//            'public' => true,
//            'publicly_queryable' => true,
//            'show_ui' => true,
//            'show_in_menu' => true,
//            'menu_position' => 4,
//            'query_var' => true,        //если значение параметра установлено в “true”, мы сможем получать записи, на основе выбранного значения этой таксономии. Например, можно найти все записи, для которых в таксономии “операционная система” указано значение “Windows”.
//            'rewrite' => true,          //сли значение установлено в “true”, при просмотре страницы с этой таксономией, WordPress будет использовать дружественные URL. Например, страница, отображающая все записи с операционной системой “Windows”, будет представлена следующим url: http://domain.com/operating_system/windows
//            'capability_type' => 'post',
//            'has_archive' => true,
//            'hierarchical' => true,         //если значение установлено в “true”, эта таксономия будет иметь возможности иерархической структуры, как у Рубрик. Если значение “false”, то таксономия по структуре будет похожа на Метки.
//            'supports' => array('title','editor','author','thumbnail','excerpt','comments')
//        )
//    );
//}



//function my_custom_post_product() {
//    $labels = array(
//        'name'               => _x( 'Книги', 'post type general name' ),
//        'singular_name'      => _x( 'Книга', 'post type singular name' ),
//        'add_new'            => _x( 'Добавить новую', 'book' ),
//        'add_new_item'       => __( 'Добавить новую книгу' ),
//        'edit_item'          => __( 'Редактировать книгу' ),
//        'new_item'           => __( 'Новая книга' ),
//        'all_items'          => __( 'Все книги' ),
//        'view_item'          => __( 'Просмотр книг' ),
//        'search_items'       => __( 'Поиск книг' ),
//        'not_found'          => __( 'Книга не найдена' ),
//        'not_found_in_trash' => __( 'Книга не найдена в Корзине' ),
//        'parent_item_colon'  => '',
//        'menu_name'          => 'Книги'
//    );
//    $args = array(
//        'labels'        => $labels,
//        'description'   => 'Holds our products and product specific data',
//        'public'        => true,
//        'menu_position' => 5,
//        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
//        'has_archive'   => true,
//    );
//    register_post_type( 'product', $args );
//}
//add_action( 'init', 'my_custom_post_product' );





function my_custom_post_product()
{
    $labels = array(
        'name' => _x('Книги', 'post type general name'),
        'singular_name' => _x('Книга', 'post type singular name'),
        'add_new' => _x('Добавить новую', 'book'),
        'add_new_item' => __('Добавить новую книгу'),
        'edit_item' => __('Редактировать книгу'),
        'new_item' => __('Новая книга'),
        'all_items' => __('Все книги'),
        'view_item' => __('Просмотр книг'),
        'search_items' => __('Поиск книг'),
        'not_found' => __('Книга не найдена'),
        'not_found_in_trash' => __('Книга не найдена в Корзине'),
        'parent_item_colon' => '',
        'menu_name' => 'Книги'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Holds our products and product specific data',
        'public' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'has_archive' => true,
    );
    register_post_type('product', $args);
}

add_action('init', 'my_custom_post_product');




function my_updated_messages( $messages ) {
    global $post, $post_ID;
    $messages['product'] = array(
        0 => '',
        1 => sprintf( __('Product updated. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Product updated.'),
        5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Product published. <a href="%s">View product</a>'), esc_url( get_permalink($post_ID) ) ),
        7 => __('Product saved.'),
        8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );
    return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );




function my_taxonomies_product() {
    $labels = array(
        'name'              => _x( 'Product Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Product Categories' ),
        'all_items'         => __( 'All Product Categories' ),
        'parent_item'       => __( 'Parent Product Category' ),
        'parent_item_colon' => __( 'Parent Product Category:' ),
        'edit_item'         => __( 'Edit Product Category' ),
        'update_item'       => __( 'Update Product Category' ),
        'add_new_item'      => __( 'Add New Product Category' ),
        'new_item_name'     => __( 'New Product Category' ),
        'menu_name'         => __( 'Product Categories' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'product_category', 'product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );



//Определение мета поля
add_action( 'add_meta_boxes', 'product_price_box' );
function product_price_box() {
    add_meta_box(                           //Добавляет дополнительные блоки (meta box) на страницы редактирования/создания постов, постоянных страниц или произвольных типов записей в админ-панели.
        'product_price_box',                //id атрибут HTML тега, контейнера блока.
        __( 'Product Price', 'myplugin_textdomain' ),       //Заголовок/название блока. Виден пользователям
        'product_price_box_content',        //Функция, которая выводит на экран HTML содержание блока.
        'product',          //Тип записи для к которой добавляется блок ('post', 'page', 'link', 'attachment' или 'custom_post_type').
        'side',             //Место где должен показываться блок ('normal', 'advanced' или 'side').
        'high'              //Приоритет блока для показа выше или ниже остальных блоков ('high' или 'low').
    );
}


//Определение содержания мета области
function product_price_box_content( $post ) {
    wp_nonce_field( plugin_basename( __FILE__ ), 'product_price_box_content_nonce' );                        //wp_nonce_field  Выводит проверочное (защитное, одноразовое) скрытое поле для формы для проверки передаваемых данных формы, чтобы убедиться, что данные были отправлены с текущего сайта
    echo '<label for="product_price"></label>';                                                              // plugin_basename Отрезает из переданного пути до файла или папки плагина, путь до папки плагинов. Оставляет путь от папки плагина до указанного файла плагина.
    echo '<input id="product_price" name="product_price" placeholder="enter a price" type="text">';
}



//Обработка данных( сохранение пользовательских данных )
add_action( 'save_post', 'product_price_box_save' );
function product_price_box_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    if ( !wp_verify_nonce( $_POST['product_price_box_content_nonce'], plugin_basename( __FILE__ ) ) )          //Проверяет переданный проверочный код.    Параметры: 1)Название поля, которое было передано в форме для проверки;  2) Ключ, который был указан при создании проверочного значения.
        return;

    if ( 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) )
            return;
    } else {
        if ( !current_user_can( 'edit_post', $post_id ) )
            return;
    }
    $product_price = $_POST['product_price'];
    update_post_meta( $post_id, 'product_price', $product_price );                  //Обновляет произвольное поле указанного поста или добавляет новое. Параметры: 1)ID поста, произвольное поле которого нужно обновить/создать;
                                                                                    // 2) Ключ произвольного поля, которое нужно обновить/создать; 3) Новое, значение произвольного поля, которое нужно обновить/создать. Если передать массив, то значение будет серриализованно в строку.
}





$args = array(
    'post_type' => 'product',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_category',
//            'field' => 'slug',
//            'terms' => 'boardgames'
            'field' => 'slug',
            'terms' => 'Adventure'
        )
    )
);
$products = new WP_Query( $args );
if( $products->have_posts() ) {
    while( $products->have_posts() ) {
        $products->the_post();
        ?>
        <h1><?php the_title() ?></h1>
        <div class='content'>
            <?php the_content() ?>
        </div>
    <?php
    }
}
else {
    echo 'Oh ohm no products!';
}




//Вывод пользовательского типа записей на главную страницу блога
add_filter( 'pre_get_posts', 'my_get_posts' );
function my_get_posts( $query ) {
    if ( ( is_home() && false == $query->query_vars['suppress_filters'] ) || is_feed() )
        $query->set( 'post_type', array( 'post', 'product' ) );
    return $query;
}


//add_filter('pre_get_posts', 'query_post_type');
//function query_post_type($query) {
//if(is_category() || is_tag()) {
//    $post_type = get_query_var('post_type');
//    if ($post_type)
//        $post_type = $post_type;
//    else
//        $post_type = array('post', 'product');
//    $query->set('post_type', $post_type);
//    return $query;
//}}

// If we are in a loop we can get the post ID easily
//$price = get_post_meta( get_post_ID(), 'product_price', true );

// To get the price of a random product we will need to know the ID
//$price = get_post_meta( $product_id, 'product_price', true );


?>
