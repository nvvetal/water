<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
<?php bloginfo('name'); ?>
<?php if(is_home()) { ?>
 - <?php bloginfo('description'); ?>
<?php } ?>
<?php if(is_single()) { ?>
<?php wp_title(); ?>
<?php } ?>
<?php if(is_404()) { ?>
 - 404
<?php } ?>
<?php if(is_search()) { ?>
 - Результаты поиска: <?php echo wp_specialchars($s, 1); ?>
<?php } ?>
</title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src="<?php bloginfo('template_directory'); ?>/js/heightMatch.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/topmenudynamic.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/dropdown.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/niftycube.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/niftylayout.js" type="text/javascript"></script>

<?php wp_head(); ?>

</head>
<body>

<div id="container">

<!-- header -->
<div id="header">

<!--	<div id="header_ad">-->
<!--	--><?php //include (TEMPLATEPATH . "/468_60.php"); ?>
<!--	</div>-->

<div class="clear"></div>
</div>
<!-- end -->

<!-- page menu and search -->
<div id="top">

	<ul id="pagemenu">
        <li class="page_item <?php if(is_home()) {echo "current_page_item";} ?>"><a href="http://localblog" title="Главная страница">Главная</a>
            <ul>
                <li class="page_item <?php if(is_home()) {echo "current_page_item";} ?>"><a href="http://localblog/kontakty/inner-page" title="Inner page">Inner page</a></li>
            </ul>
        </li>
	<?php wp_list_pages('sort_column=post_date&title_li=&depth=1'); ?>
	</ul>

	<div id="searchbar">
	<form method="get" action="<?php bloginfo('url'); ?>/" class="searchform" style="float: right;">
	<fieldset>
	<label class="searchlabel">Поиск</label>
	<input type="text" value="<?php the_search_query(); ?>" name="s" class="searchterm" />
	<input type="submit" value="Искать!" class="searchbutton" />
	</fieldset>
	</form>
	</div>

<div class="clear"></div>
</div>
<!-- end -->

<div class="clear"></div>

<!-- blog information -->

<div class="clear"></div>

<!-- end -->