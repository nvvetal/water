<?php get_header(); ?>

<div id="content">

	<div id="column">

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<div class="post">
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="postinfo">
		<div class="info">Опубликовал <?php the_author_posts_link(); ?>  <?php the_time('j F, Y'); ?> <?php if(function_exists('the_views')) { the_views(); } ?></div>
		<div class="commentnum"><?php comments_popup_link('Прокомментировать &#187;', '1 комментарий &#187;', '% коммент. &#187;'); ?></div><div class="clear"></div>
		</div>
		<div class="category">Размещено в рубрике <?php the_category(', '); ?></div>
		<div class="entry">

		<?php /*the_excerpt();*/ the_content('Читать далее...'); ?><div class="clear"></div>
		
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
	<p>Страница, которую Вы ищете, не существует.</p>
	<h3>Поиск по блогу</h3>
	<?php include(TEMPLATEPATH."/searchform.php"); ?>
	</div>
	<?php endif; ?>
	
	</div>
	
<?php get_sidebar(); ?>

<div class="clear"></div>
</div>

<?php get_footer(); ?>