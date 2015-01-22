<?php

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if(post_password_required()) { ?>
	
<?php
	return;
}


/////////////////////////////////////// Comment Template ///////////////////////////////////////


function comment_template($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php echo get_avatar('', '60', get_template_directory_uri().'/lib/images/gravatar.png'); ?>
		
		<div class="comment-text">
			
			<p class="meta">
				
				<?php printf(__('%s', 'gp_lang'), comment_author_link()) ?> - <?php comment_time(get_option('date_format')); ?>, <?php comment_time(get_option('time_format')); ?> <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'gp_lang'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
				
			</p>	

			<?php comment_text() ?>
			
			<?php if($comment->comment_approved == '0') { ?>
				<div class="error">
					<?php _e('Your comment is awaiting moderation.', 'gp_lang'); ?>
				</div>
			<?php } ?>
			
		</div>	
		
	</div>

<?php } ?>

<?php if('open' == $post->comment_status OR have_comments()) { ?>	
	<div id="comments">
<?php } ?>

	<?php if(have_comments()) { ?>
		
		<h2><?php comments_number(__('No Comments', 'gp_lang'), __('1 Comment', 'gp_lang'), __('% Comments', 'gp_lang')); ?></h2>
		
		<ol class="commentlist">
			<?php wp_list_comments('callback=comment_template'); ?>
		</ol>
							
		<?php $total_pages = get_comment_pages_count(); if($total_pages > 1) { ?>
			<div class="wp-pagenavi comment-navi"><?php paginate_comments_links(); ?></div>
		<?php } ?>	

		<?php if('open' == $post->comment_status) {} else { ?>
		
			<h4><?php _e('Comments are now closed on this post.', 'gp_lang'); ?></h4>
	
		<?php } ?>
		
	<?php } ?>

	<?php if('open' == $post->comment_status) { comment_form(); } ?>

<?php if('open' == $post->comment_status OR have_comments()) { ?>
	</div>
<?php } ?>