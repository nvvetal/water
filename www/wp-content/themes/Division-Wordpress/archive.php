<?php get_header(); ?>

<div id="content">

	<div id="column">

	<?php if (have_posts()) : ?>
	<div class="post_header">
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1>Архив рубрики &#8216;<?php single_cat_title(); ?>&#8217; </h1>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h1>Записи с меткой &#8216;<?php single_tag_title(); ?>&#8217;</h1>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1>Архив <?php the_time(' jS F Y'); ?></h1>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1>Архив <?php the_time('F, Y'); ?></h1>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1>Архив <?php the_time('Y'); ?></h1>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1>Архив автора</h1>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1>Архив блога</h1>
	<?php } ?>
	</div>
	
	<?php while (have_posts()) : the_post(); ?>
	<div class="post">
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="postinfo">
		<div class="info">Автор <?php the_author_posts_link(); ?> | Дата <?php the_time('j F, Y'); ?></div>
		<div class="commentnum"><?php comments_popup_link('Прокомментировать &#187;', '1 комментарий &#187;', '% коммент. &#187;'); ?></div><div class="clear"></div>
		</div>
		<div class="category">Размещено в рубрике <?php the_category(', '); ?></div>
		<div class="entry">

		<?php the_excerpt(); ?><div class="clear"></div>
		<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="more-link">Читать запись полностью</a></p>
		
		</div>
		<?php the_tags('<div class="tags">Метки: ', ', ', '</div><div class="clear"></div>'); ?>
	</div>
	<?php endwhile; ?>

	<!-- Plugin Navigation -->
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	<!-- End -->

	<?php else : ?>
	<div class="post">
	<h1>Не найдено.</h1>
	<p>Извините, но того, что Вы искали, тут нет.</p>
	<h3>Поиск</h3>
	<?php include(TEMPLATEPATH."/searchform.php"); ?>
	</div>
	<?php endif; ?>

	</div>
	
<?php get_sidebar(); ?>

<div class="clear"></div>
</div>

<?php get_footer(); ?>