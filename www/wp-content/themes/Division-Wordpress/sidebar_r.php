<div class="sidebar2">
<ul>

	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : ?>

	<li><h2>Ссылки</h2>
	<ul>
	<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
	</ul>
	</li>
	
	<li><h2>Свежие записи</h2>
	<ul>
	<?php wp_get_archives('type=postbypost&limit=5&format=html'); ?>
	</ul>
	</li>

	<?php endif; ?>

</ul>
</div>