<div class="sidebar2" style="margin-right:8px">
<ul>

	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>

	<li><h2>Страницы</h2>
	<ul>
	<?php wp_list_pages('title_li='); ?>
	</ul>
	</li>


	<li><h2>Архивы</h2>
	<ul>
	<?php wp_get_archives('type=monthly&limit=12'); ?>
	</ul>
	</li>

	<?php endif; ?>

</ul>
</div>