<?php

function src_simple_recent_comments($src_count=7, $src_length=60, $pre_HTML='<li><h2>Свежие комментарии</h2>', $post_HTML='</li>') {
	global $wpdb;
	
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, 
			SUBSTRING(comment_content,1,$src_length) AS com_excerpt 
		FROM $wpdb->comments 
		LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) 
		WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' 
		ORDER BY comment_date_gmt DESC 
		LIMIT $src_count";
	$comments = $wpdb->get_results($sql);

	$output = $pre_HTML;
	$output .= "<ul>";
	foreach ($comments as $comment) {
		$output .= "<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID  . "\" title=\"on " . $comment->post_title . "\">" . $comment->comment_author . ": <span>" . strip_tags($comment->com_excerpt) . "...</span></a></li>";
	}
	$output .= "</ul>";
	$output .= $post_HTML;
	
	echo $output;

}

?>