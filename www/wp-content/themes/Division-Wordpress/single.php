<?php get_header(); ?>

<div id="content">

	<div id="column">

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h1><?php the_title(); ?></h1>
		<div class="postinfo">
		<div class="info">Опубликовал <?php the_author_posts_link(); ?> |  Дата <?php the_time('j F, Y'); ?></div>
		<div class="commentnum"><?php comments_number('Нет комментариев', 'Один комментарий', '% коммент.' );?></div><div class="clear"></div>
		</div>
		<div class="category">Рубрика: <?php the_category(', '); ?></div>
		<div class="entry">

            <?php
            // Эта переменная используется для вывода таксономии, если она существует
            $taxo_text = "";

            // Список переменных, для хранения списков таксономии
            // Эта строка получает данные о классификации "Операционная система"
            $category_list = get_the_term_list( $post->ID, 'Категории', '<strong>Категории:</strong> ', ', ', '' );

            if ( '' != $category_list ) {
                $taxo_text .= "$category_list<br />\n";
            }

            // Выводим пользовательскую таксономию, если она существует
            // Обратите внимание: Мы не будет открывать div, если у него не будет содержимого
            if ( '' != $taxo_text ) {
                ?>
                <div class="entry">
                    <?php
                    echo $taxo_text;
                    ?>
                </div>
            <?
            } // endif
            ?>


		<?php the_content('Читать полностью...'); ?><div class="clear"></div>
		<?php if(function_exists('the_ratings')) { echo '<div class="ratings"><strong>Рейтинг:</strong>'; the_ratings(); echo '</div>'; } ?>
		<?php if(function_exists('the_views')) { echo '<div class="views"> '; the_views(); echo '</div>'; } ?>
		<?php wp_link_pages(array('before' => '<p><strong>Страницы:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link('Редактировать', '<p class="edit">', '</p>'); ?>
		
		</div>
		<?php the_tags('<div class="tags">Метки: ', ', ', '</div><div class="clear"></div>'); ?>
	</div>
	
	<div class="post_follow">
		Если Вам интересна эта запись, Вы можете следить за ее обсуждением, подписавшись на <?php post_comments_feed_link('RSS 2.0'); ?> .
		<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
		
		<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
		
		<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
	
		<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
	Комментарии и пинг закрыты.
		<?php } ?>
	</div>

	<?php comments_template(); ?>

	<!--
	<?php trackback_rdf(); ?>
	-->

	<?php endwhile; ?>
	
	<!-- Post Navigation -->
	<div class="nav">
	<div class="nav_left"> <?php next_post_link('&laquo; <strong>%link</strong>'); ?></div>
	<div class="nav_right"> <?php previous_post_link('<strong>%link</strong> &raquo;'); ?> </div>
	<div class="clear"></div>
	</div>
	<!-- End -->
	
	<?php else : ?>
	<div class="post">
	<h1>Не найдено.</h1>
	<p>Страница, которую Вы искали, не существует.</p>
	<h3>Поиск на блоге</h3>
	<?php include(TEMPLATEPATH."/searchform.php"); ?>
	</div>
	<?php endif; ?>
	
	</div>
	
<?php get_sidebar(); ?>

<div class="clear"></div>
</div>

<?php get_footer(); ?>