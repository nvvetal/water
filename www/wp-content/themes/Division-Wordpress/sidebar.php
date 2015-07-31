<?php /* Please do not remove this line */ global $opt; ?>

<div id="sidebar">

	<h2>Подпишись на RSS!</h2>
	<div class="box">
	<p class="rssfeed"><a href="<?php bloginfo('rss2_url'); ?>">Подпишись на RSS </a> и получай обновления блога!</p>
	<p class="emailfeed"><strong>Получать обновления по электронной почте:</strong></p>
	<form class="feedform" action="http://www.feedburner.com/fb/a/emailverifySubmit?feedId=<?=$opt['feedburner_id']; ?>" method="post">
	<fieldset>
	<input type="text" name="email" class="feedemail" />
	<input type="submit" value="ок" class="feedsubmit" />
	<input type="hidden" value="http://feeds.feedburner.com/~e?ffid=<?=$opt['feedburner_id']; ?>" name="url" />
	<input type="hidden" value="<?=$opt['blog_title']; ?>" name="title" />
	<input type="hidden" name="loc" value="<?=$opt['location']; ?>" />
	</fieldset>
	</form>
	</div>

	<?php include (TEMPLATEPATH . "/sidebar_c.php"); ?>
	<?php include (TEMPLATEPATH . "/sidebar_l.php"); ?>
	<?php include (TEMPLATEPATH . "/sidebar_r.php"); ?>
	<div class="clear"></div>

</div>