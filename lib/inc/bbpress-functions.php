<?php

/*--------------------------------------------------------------
Load custom bbPress stylesheet
--------------------------------------------------------------*/

if ( ! function_exists( 'ghostpool_bbp_enqueue_styles' ) ) {	
	function ghostpool_bbp_enqueue_styles() {
		wp_enqueue_style( 'gp-bbp', get_template_directory_uri() . '/lib/css/bbpress.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_bbp_enqueue_styles' );


/*--------------------------------------------------------------
Add Visual Composer support to replies
--------------------------------------------------------------*/

//add_filter( 'bbp_get_reply_content', 'do_shortcode' );


/*--------------------------------------------------------------
Show bbPress content in Activity stream when site is not public
--------------------------------------------------------------*/

//add_filter( 'bbp_is_site_public', '__return_true' );


/*--------------------------------------------------------------
Forum layout
--------------------------------------------------------------*/

function ghostpool_bbp_list_forums( $gp_args = '' ) {

	global $bbp;

	// Define used variables
	$gp_output = $sub_forums = $topic_count = $reply_count = $counts = '';
	$gp_i = 0;
	$gp_count = array();

	// Defaults and arguments
	$gp_defaults = array (
		'before'            => '<ul class="bbp-forums-list">',
		'after'             => '</ul>',
		'link_before'       => '<li class="bbp-forum">',
		'link_after'        => '</li>',
		'count_before'      => ' (',
		'count_after'       => ')',
		'count_sep'         => ', ',
		'separator'         => ', ',
		'forum_id'          => '',
		'show_topic_count'  => true,
		'show_reply_count'  => false,
		'show_post_count'  => true,
		'show_freshness_link'  => true,
	);
	$r = bbp_parse_args( $gp_args, $gp_defaults, 'list_forums' );
	extract( $r, EXTR_SKIP );

	// Bail if there are no subforums
	if ( !bbp_get_forum_subforum_count( $forum_id ) )
		return;

	// Loop through forums and create a list
	$sub_forums = bbp_forum_get_subforums( $forum_id );
	if ( !empty( $sub_forums ) ) {

		// Total count (for separator)
		$total_subs = count( $sub_forums );
		foreach ( $sub_forums as $sub_forum ) {
			$gp_i++; // Separator count

			// Get forum details
			$count       = array();
			$show_sep    = $total_subs > $gp_i ? $separator : '';
			$permalink   = bbp_get_forum_permalink( $sub_forum->ID );
			$title       = bbp_get_forum_title( $sub_forum->ID );
			$description = bbp_get_forum_content( $sub_forum->ID );

			// Show topic count
			if ( ! empty( $show_topic_count ) && ! bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['topic'] = bbp_get_forum_topic_count( $sub_forum->ID );
			}

			// Show reply count
			if ( ! empty( $show_reply_count ) && ! bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['reply'] = bbp_get_forum_reply_count( $sub_forum->ID );
			}

			// Show post count
			if ( ! empty( $show_post_count ) && ! bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['post'] = bbp_get_forum_post_count( $sub_forum->ID );
			}

			// Counts to show
			if ( ! empty( $count ) ) {
				$counts = $count_before . implode( $count_sep, $count ) . $count_after;
			}

			if ( ! empty( $show_freshness_link ) ) {
				$freshness_link = "<div class='freshness-forum-link'>" . ghostpool_get_last_poster_block( $sub_forum->ID ) . "</div>";
			}
			
			// Build this sub forums link
			if ($gp_i % 2) { $class = "odd-forum-row"; } else { $class = "even-forum-row"; }
			$gp_output .= "<li class='{$class}'><ul>" . $link_before . '<div class="bbp-forum-title-container"><a href="' . $permalink . '" class="bbp-forum-link">' . $title . '</a>' . $description . '</div>' . $counts . $freshness_link . $link_after . "</ul></li>";
		}

		// Output the list
		echo apply_filters( 'bbp_list_forums', $before . $gp_output . $after, $gp_args );
	}
}

// Last poster/freshness block for forums
function ghostpool_last_poster_block( $subforum_id = "" ) {
	echo ghostpool_get_last_poster_block( $subforum_id = "" );
}

function ghostpool_get_last_poster_block( $subforum_id = "" ) {

	global $bbp;

	if ( ! empty( $subforum_id ) ) {
		// Main forum display with sub forums
		$gp_output = "<div class='last-posted-topic-title'>";
		$gp_output .= "<a href='". bbp_get_forum_last_topic_permalink( $subforum_id ) ."'>" . bbp_get_topic_last_reply_title( bbp_get_forum_last_active_id( $subforum_id ) ) . "</a>";
		$gp_output .= "</div>";
		$gp_output .= "<div class='last-posted-topic-user'>" . esc_html__( 'by', 'socialize' ) . " ";
			$author_id = bbp_get_forum_last_reply_author_id( $subforum_id );
		$gp_output .= "<span class=\"bbp-author-avatar\">" . get_avatar( $author_id, '14' ) . "&nbsp;</span>";
		$gp_output .= bbp_get_user_profile_link( $author_id );
		$gp_output .= "</div>";
		$gp_output .= "<div class='last-posted-topic-time'>";
		$gp_output .= bbp_get_forum_last_active_time( $subforum_id );
		$gp_output .= "</div>";
	} else {
		// forum category display (no sub forums list)
		$gp_output = "<div class='last-posted-topic-title'>";
		$gp_output .= "<a href='". bbp_get_forum_last_topic_permalink() ."'>" . bbp_get_topic_last_reply_title( bbp_get_forum_last_active_id() ) . "</a>";
		$gp_output .= "</div>";
		$gp_output .= "<div class='last-posted-topic-user'>" . esc_html__( 'by', 'socialize' ) . " ";
		$gp_output .= "<span class=\"bbp-author-avatar\">" . get_avatar( bbp_get_forum_last_reply_author_id(), '14' ) . "&nbsp;</span>";
		$gp_output .= bbp_get_user_profile_link( bbp_get_forum_last_reply_author_id() );
		$gp_output .= "</div>";
		$gp_output .= "<div class='last-posted-topic-time'>";
		$gp_output .= bbp_get_forum_last_active_time();
		$gp_output .= "</div>";
	}

	return $gp_output;

}

?>