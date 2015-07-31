<?php
/*
The template for displaying all pages.
 */

get_header(); ?>

<div id="content" class="<?php echo get_class_of_component('content', smartadapt_option( 'smartadapt_layout' )) ?>" role="main">


    <?php while (have_posts()) : the_post();  ?>
    <?php get_template_part('content', 'page'); ?>
<!--    --><?php //comments_template('', true); ?>
    <?php endwhile; // end of the loop. ?>
    <?php
    $args = array('taxonomy' => 'catalogue_category');
    $categories = get_categories($args);  //Возвращает массив объектов содержащих информацию о категориях.

    foreach($categories as $category)
    {
//        $categories = get_categories(array('hide_empty' => 0,'exclude' => 1,'parent' => 0,'orderby' => 'ID', 'taxonomy' => 'catalogue_category'));
//
//        foreach ($categories as $cat) {
//            $id = $cat->cat_ID;
//            $link = get_category_link($id);
//            $img_arr = get_field('cat_thumbnail', 'category_'.$id);
//            var_dump($img_arr);
//            echo '<a href="'.$link.'" title="'.$cat->cat_name.'">';
//            echo '<img src="'.$img_arr['sizes']['thumbnail'].'" alt="'.$img_arr['alt'].'" />';
//            echo "$cat->cat_name";
//            echo '</a>';
//            var_dump($cat);
//        }
//        var_dump($category);
//
//        if ( has_post_thumbnail()) {
//            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
//            echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
//            the_post_thumbnail('thumbnail');
//            echo '</a>';
//        }
//        if ( has_post_thumbnail()) {
//            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
//            echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
//            the_post_thumbnail('thumbnail');
//            echo '</a>';
//        }
//        echo '<img src="1.jpg" style="float:left;" />';
        //var_dump(get_field('cat_thumbnail',$category));
        if( $img = get_field('cat_thumbnail',$category) ):
            //echo '<img src="'.$img['url'].'" />';
            echo '<img src="'.$img['sizes']['thumbnail'].'" />';
        endif;
//        the_post_thumbnail('thumbnail');

        echo "<p><a href='?catalogue_category=". $category->slug."'>" . $category->name."</a></p>";

    }
    ?>





</div><!-- #content -->
<?php
if(check_position_of_component('menu', 'right', smartadapt_option( 'smartadapt_layout' ))){
	get_template_part('section', 'menu');
}//if menu is one the right side
?>
</div><!-- #main -->

</div><!-- #page -->

<?php
//add sidebar on the right side
if(check_position_of_component('sidebar', 'right', smartadapt_option( 'smartadapt_layout' )))
	get_sidebar();
?>
</div><!-- #wrapper -->
<?php get_footer(); ?>

<?php
$args = array('taxonomy' => 'catalogue_category');
$categories = get_categories($args);

foreach($categories as $category)
{
    echo '<p>Category: <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </p> ';
    echo '<p> Description:'. $category->description . '</p>';
    echo '<p> Post Count: '. $category->count . '</p>';
}
?>