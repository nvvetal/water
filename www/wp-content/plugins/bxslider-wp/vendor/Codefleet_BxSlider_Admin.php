<?php
/**
 * Class that handles the slideshow admin pages 
 */
class Codefleet_BxSlider_Admin {
	
	protected $version;
	protected $path;
	protected $url;
	protected $debug;
	protected $textdomain;
	protected $data;
	protected $view; // Our view manager
	protected $view_folder;
	protected $nonce_name;
	protected $nonce_action;
	
	/**
	 * Initializes the plugin
	 */
	public function __construct(){}
	
	public static function get_instance(){
		
		static $instance = null;
        if (null === $instance) {
            $instance = new self;
        }
        return $instance;
	}
	
	public function init($version, $path, $url, $debug, $textdomain, Codefleet_Common_View $view, $view_folder, Codefleet_BxSlider_Data $data ) {
		
		$this->version = $version;
		$this->path = $path;
		$this->url = $url;
		$this->debug = $debug;
		$this->textdomain = $textdomain;
		$this->view = $view;
		$this->data = $data;
		$this->view_folder = $view_folder;
		
		// Intialize properties
		$this->nonce_name = 'bxslider_builder_nonce'; //Must match with the one in class-bxslider-data.php
		$this->nonce_action = 'bxslider-save'; //Must match with the one in class-bxslider-data.php
		
		// Register admin styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'register_wp_media' ), 9);
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ), 10);
	
		// Setup bxslider custom post
		add_action( 'init', array( $this, 'create_post_types' ) );
		
		// Add builder metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		
		// Custom columns
		add_action( 'manage_bxslider_posts_custom_column', array( $this, 'custom_column' ), 10, 2);
		add_filter( 'manage_edit-bxslider_columns', array( $this, 'slideshow_columns') );
		
		// Update the messages for our custom post make it appropriate for slideshow
		add_filter('post_updated_messages', array( $this, 'post_updated_messages' ) );
		
		// Add hook for admin footer
		add_action('admin_footer', array( $this, 'admin_footer') );
		
		// Save routine
		add_action( 'save_post', array( $this, 'save_post' ) );
	}
	
	/**
	 * Add js and css for WP media manager.
	 */ 
	public function register_wp_media(){
		global $wp_version;
		
		if('bxslider' == get_post_type()){ /* Load only scripts here and not on all admin pages */
			
			if ( version_compare( $wp_version, '3.5', '<' ) ) { // Use old media manager
				
				wp_enqueue_style('thickbox');
				
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				
			} else {
				// Required media files for new media manager. Since WP 3.5+
				wp_enqueue_media();
			}
		}
	}
	
	/**
	 * Admin js and css
	 */ 
	public function register_admin_scripts() {
		global $wp_version;
		
		if('bxslider' == get_post_type()){ // Load only scripts here and not on all admin pages
			if ( version_compare( $wp_version, '3.5', '<' ) ) { // Use old media manager
				$new_media_gallery = false; 
			} else {
				$new_media_gallery = true;
			}
			
			wp_enqueue_style( 'bxslider-admin-styles', $this->url.'css/admin.css', array(), $this->version  );
			
			// Scripts
			wp_dequeue_script( 'autosave' );//disable autosave
			
			wp_enqueue_script( 'store', $this->url.'js/store-json2.min.js', array('jquery'), $this->version );
			
			wp_register_script( 'bxslider-admin-script', $this->url.'js/admin.js', array('jquery', 'jquery-ui-sortable'), $this->version  );
			wp_localize_script( 'bxslider-admin-script', 'bxslider',
				array(
					'new_media_gallery' => $new_media_gallery,
					'title'     => __( 'Select an image', 'bxslider' ), // This will be used as the default title
					'title2'     => __( 'Select Images By Ctrl + Clicking Them', 'bxslider' ),
					'button'    => __( 'Add to Slide', 'bxslider' ), // This will be used as the default button text
					'button2'    => __( 'Add Images as Slides', 'bxslider' ),
					'jquery_easing_options' => $this->to_select_options($this->data->get_jquery_easing_options()),
					'css_easing_options' => $this->to_select_options($this->data->get_css_easing_options())
				)
			);
			wp_enqueue_script( 'bxslider-admin-script');
			
		}
	}
	
	/**
	 * Create Post Types
	 *
	 * Create custom post for slideshows
	 */
	public function create_post_types() {
		
		register_post_type( 'bxslider',
			array(
				'labels' => array(
					'name' => __('BxSlider', 'bxslider'),
					'singular_name' => __('Slider', 'bxslider'),
					'add_new' => __('Add Slider', 'bxslider'),
					'add_new_item' => __('Add New Slider', 'bxslider'),
					'edit_item' => __('Edit Slider', 'bxslider'),
					'new_item' => __('New Slider', 'bxslider'),
					'view_item' => __('View Slider', 'bxslider'),
					'search_items' => __('Search Sliders', 'bxslider'),
					'not_found' => __('No sliders found', 'bxslider'),
					'not_found_in_trash' => __('No sliders found in Trash', 'bxslider')
				),
				'supports' => array('title'),
				'public' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'menu_position' => 100
			)
		);
	}
	
	/**
	 * Add Meta Boxes
	 *
	 * Add custom metaboxes to our slider custom post type
	 */
	public function add_meta_boxes(){
		add_meta_box(
			'bxslider-slides-meta-box',
			__('Slides', 'bxslider'),
			array( $this, 'render_slides_meta_box' ),
			'bxslider' ,
			'normal',
			'high'
		);
		add_meta_box(
			'bxslider-slider-codes',
			__('Get Slider Codes', 'bxslider'),
			array( $this, 'render_slider_codes' ),
			'bxslider' ,
			'side',
			'low'
		);
		add_meta_box(
			'bxslider-general-options-meta-box',
			__('General Options', 'bxslider'),
			array( $this, 'render_general_options_meta_box' ),
			'bxslider' ,
			'side',
			'low'
		);
		add_meta_box(
			'bxslider-pager-options-meta-box',
			__('Pager Options', 'bxslider'),
			array( $this, 'render_pager_options_meta_box' ),
			'bxslider' ,
			'normal',
			'low'
		);
		add_meta_box(
			'bxslider-controls-options-meta-box',
			__('Controls Options', 'bxslider'),
			array( $this, 'render_controls_options_meta_box' ),
			'bxslider' ,
			'normal',
			'low'
		);
		add_meta_box(
			'bxslider-auto-options-meta-box',
			__('Auto Options', 'bxslider'),
			array( $this, 'render_auto_options_meta_box' ),
			'bxslider' ,
			'normal',
			'low'
		);
		add_meta_box(
			'bxslider-carousel-options-meta-box',
			__('Carousel Options', 'bxslider'),
			array( $this, 'render_carousel_options_meta_box' ),
			'bxslider' ,
			'normal',
			'low'
		);
	}
	
	/**
	 * Metabox for slides
	 */
	public function render_slides_meta_box( $post ){

		$options = $this->data->get_options($post->ID);
		$slides = $this->data->get_slides($post->ID);
		
		$slides_html = '';
		
		if(is_array($slides) and count($slides)>0):
			
			$this->view->set_view_file($this->view_folder . 'slide-edit.php');
			foreach($slides as $i=>$slide):
	
				$vars = array();
				$vars['i'] = $i;
				$vars['options'] = $options;
				$vars['slide'] = wp_parse_args($slide, $this->data->get_slide_defaults());
				$vars['image_url'] = $this->get_slide_img_thumb($slide['id']);
				$vars['box_title'] = __('Slide', 'bxslider');
				
				
				$this->view->set_vars( $vars );
				$slides_html .= $this->view->get_render();
			endforeach;
		endif;
		$vars = array();
		$vars['slides'] = $slides_html;
		$vars['post_id'] = $post->ID;
		
		$this->view->set_view_file( $this->view_folder . 'slides.php' );
		$this->view->set_vars( $vars );
		$this->view->render();

		
		//$this->data->debug( $this->data->get_options( $post->ID ));
		//$this->data->debug( $this->data->get_slides( $post->ID ));
	}
	
	/**
	 * Metabox for slider codes
	 */
	public function render_slider_codes( $post ){
		
		$this->view->set_view_file( $this->view_folder . 'slider-codes.php' );
		
		$vars = array();
		$vars['post'] = $post;
		if(empty($post->post_name)){
			$vars['shortcode'] = '';
			$vars['template_code'] = '';
		} else {
			$vars['shortcode'] = '[bxslider id="'.$post->post_name.'"]';
			$vars['template_code'] = '<?php if( function_exists(\'bxslider\') ) bxslider(\''.$post->post_name.'\'); ?>';
		}
		$this->view->set_vars( $vars );
		$this->view->render();

	}
	
	/**
	 * Metabox for general options
	 */
	public function render_general_options_meta_box( $post ){
		
		$options = $this->data->get_options( $post->ID );

		$vars = array();
		$vars['options'] = $options;
		$vars['nonce_name'] = $this->nonce_name;
		$vars['nonce'] = wp_create_nonce( $this->nonce_action );
		$mode_options = array(
			array(
				'value'=>'horizontal',
				'text'=>'Horizontal',
				'selected'=>'',
			),
			array(
				'value'=>'vertical',
				'text'=>'Vertical',
				'selected'=>'',
			),
			array(
				'value'=>'fade',
				'text'=>'Fade',
				'selected'=>'',
			) 
		);
		foreach($mode_options as $i=>$mode_option){
			if($mode_option['value'] == $options['mode']){
				$mode_options[$i]['selected'] = 'selected="selected"';
			}
		}
		$vars['mode_options'] = $mode_options;
		
		// Easing
		if($options['use_css']=='true'){
			$vars['easing_options'] = $this->to_select_options($this->data->get_css_easing_options(), $options['easing']);
		} else {
			$vars['easing_options'] = $this->to_select_options($this->data->get_jquery_easing_options(), $options['easing']);
		}
		
		$preload_images_options = array(
			array(
				'value'=>'all',
				'text'=>'All',
				'selected'=>'',
			),
			array(
				'value'=>'visible',
				'text'=>'Visible',
				'selected'=>'',
			)
		);
		foreach($preload_images_options as $i=>$preload_images_option){
			if($preload_images_option['value'] == $options['preload_images']){
				$preload_images_options[$i]['selected'] = 'selected="selected"';
			}
		}
		$vars['preload_images_options'] = $preload_images_options;
		
		$this->view->set_view_file( $this->view_folder . 'general-options.php' );
		$this->view->set_vars( $vars );
		$this->view->render();

	}
	
	/**
	 * Metabox for pager options
	 */
	public function render_pager_options_meta_box( $post ){
		
		$options = $this->data->get_options( $post->ID );
		$vars = array();
		$vars['options'] = $options;
		
		$pager_type_options = array(
			array(
				'value'=>'full',
				'text'=>'Full',
				'selected'=>'',
			),
			array(
				'value'=>'short',
				'text'=>'Short',
				'selected'=>'',
			)
		);
		foreach($pager_type_options as $i=>$pager_type_option){
			if($pager_type_option['value'] == $options['pager_type']){
				$pager_type_options[$i]['selected'] = 'selected="selected"';
			}
		}
		$vars['pager_type_options'] = $pager_type_options;
		
		$this->view->set_view_file( $this->view_folder . 'pager-options.php' );
		$this->view->set_vars( $vars );
		$this->view->render();
	}
	
	/**
	 * Metabox for controls options
	 */
	public function render_controls_options_meta_box( $post ){
		
		$options = $this->data->get_options( $post->ID );
		$vars = array();
		$vars['options'] = $options;
		
		$auto_controls_options = array(
			array(
				'value'=>'full',
				'text'=>'Full',
				'selected'=>'',
			),
			array(
				'value'=>'short',
				'text'=>'Short',
				'selected'=>'',
			)
		);
		foreach($auto_controls_options as $i=>$auto_controls_option){
			if($auto_controls_option['value'] == $options['auto_controls']){
				$auto_controls_options[$i]['selected'] = 'selected="selected"';
			}
		}
		$vars['auto_controls_options'] = $auto_controls_options;
		
		$this->view->set_view_file( $this->view_folder . 'controls-options.php' );
		$this->view->set_vars( $vars );
		$this->view->render();
	}
	
	/**
	 * Metabox for auto options
	 */
	public function render_auto_options_meta_box( $post ){
		
		$options = $this->data->get_options( $post->ID );
		$vars = array();
		$vars['options'] = $options;
		
		$auto_direction_options = array(
			array(
				'value'=>'next',
				'text'=>'Next',
				'selected'=>'',
			),
			array(
				'value'=>'prev',
				'text'=>'Prev',
				'selected'=>'',
			)
		);
		foreach($auto_direction_options as $i=>$auto_direction_option){
			if($auto_direction_option['value'] == $options['auto_controls']){
				$auto_direction_options[$i]['selected'] = 'selected="selected"';
			}
		}
		$vars['auto_direction_options'] = $auto_direction_options;
		
		$this->view->set_view_file( $this->view_folder . 'auto-options.php' );
		$this->view->set_vars( $vars );
		$this->view->render();
	}
	
	/**
	 * Metabox for carousel options
	 */
	public function render_carousel_options_meta_box( $post ){
		
		$options = $this->data->get_options( $post->ID );
		$vars = array();
		$vars['options'] = $options;
		
		$auto_controls_options = array(
			array(
				'value'=>'full',
				'text'=>'Full',
				'selected'=>'',
			),
			array(
				'value'=>'short',
				'text'=>'Short',
				'selected'=>'',
			)
		);
		foreach($auto_controls_options as $i=>$auto_controls_option){
			if($auto_controls_option['value'] == $options['auto_controls']){
				$auto_controls_options[$i]['selected'] = 'selected="selected"';
			}
		}
		$vars['auto_controls_options'] = $auto_controls_options;
		
		$this->view->set_view_file( $this->view_folder . 'carousel-options.php' );
		$this->view->set_vars( $vars );
		$this->view->render();
	}
	
	/**
	 * Modify columns
	 */
	public function slideshow_columns($columns) {
		$columns = array();
		$columns['title']= __('Slider Name', 'bxslider');
		$columns['images']= __('Images', 'bxslider');
		$columns['id']= __('Slider ID', 'bxslider');
		$columns['shortcode']= __('Shortcode', 'bxslider');
		return $columns;
	}
	
	/**
	 * Add content to custom columns
	 */
	public function custom_column( $column_name, $post_id ){
		if ($column_name == 'images') {
			echo '<div style="text-align:center; max-width:40px;">' .$this->data->get_slides_count($post_id). '</div>';
		}
		if ($column_name == 'id') {
			$post = get_post($post_id);
			echo $post->post_name;
		}
		if ($column_name == 'shortcode') {  
			$post = get_post($post_id);
			echo '[bxslider id="'.$post->post_name.'"]';
		}  
	}
	
	/**
	 * Add custom messages
	 * 
	 * @return array - Messages
	 */
	public function post_updated_messages($messages){
		global $post, $post_ID;
		$messages['bxslider'] = array(
			0  => '',
			1  => __( 'Slider updated.', 'bxslider' ),
			2  => __( 'Custom field updated.', 'bxslider' ),
			3  => __( 'Custom field deleted.', 'bxslider' ),
			4  => __( 'Slider updated.', 'bxslider' ),
			5  => __( 'Slider updated.', 'bxslider' ),
			6  => __( 'Slider created.', 'bxslider' ),
			7  => __( 'Slider saved.', 'bxslider' ),
			8  => __( 'Slider updated.', 'bxslider' ),
			9  => __( 'Slider updated.', 'bxslider' ),
			10 => __( 'Slider updated.', 'bxslider' )
		);
		return $messages;
	}
	
	/**
	 * Hook to admin footer  
	 */
	public function admin_footer() {
		
		// Add our slide edit skeleton for use in JS
		if(get_post_type()=='bxslider'){

			$slide = $this->data->get_slide_defaults();
			
			$vars = array();
			
			$vars['debug'] = $this->debug;
			$vars['box_title'] = __('Slide *', 'bxslider');
			$vars['image_url'] = '';
			$vars['i'] = '{id}';
			$vars['slide'] = $slide;
			$vars['post_id'] = isset($_GET['post']) ? (int) $_GET['post'] : 0;
			
			$this->view->set_view_file( $this->view_folder . 'slide-edit.php' );
			$this->view->set_vars( $vars );
		?>
			<div class="bxslider-slide-skeleton">
				<?php
				$this->view->render();
				?>
			</div><!-- end .bxslider-box-template -->
		<?php
		}
	}
	
	 /**
	 * Get slide image thumb from id. False on fail
	 */
	private function get_slide_img_thumb($attachment_id){
		$attachment_id = (int) $attachment_id;
		if($attachment_id > 0){
			$image_url = wp_get_attachment_image_src( $attachment_id, 'medium', true );
			$image_url = (is_array($image_url)) ? $image_url[0] : '';
			return $image_url;
		}
		return false;
	}
	
	private function to_select_options($options, $current_value=''){
		$out = '';
		foreach($options as $option){
			$selected = '';
			if($current_value == $option['value']){
				$selected = 'selected="selected"';
			}
			$out .= '<option '.$selected.' value="'.$option['value'].'">'.$option['text'].'</option>';
		}
		return $out;
	}
	
	
	/**
	 * Save post hook
	 */
	public function save_post($post_id){
		
		// Verify nonce
		if (!empty( $_POST[ $this->nonce_name ] )) {
			if (!wp_verify_nonce($_POST[ $this->nonce_name ], $this->nonce_action )) {
				return $post_id;
			}
		} else {
			return $post_id; // Make sure we cancel on missing nonce!
		}
		
		// Check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		
		delete_post_meta($post_id, '_bxslider');
		update_post_meta($post_id, '_bxslider', $_POST['bxslider']);
	
	}
}