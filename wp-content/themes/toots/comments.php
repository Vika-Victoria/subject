<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Wptoots
 * @since Wptoots 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
    return;
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h3 class="comments-title">
            <?php
            printf( _nx( 'One thought on "%2$s"', '%1$s thoughts on "%2$s"', get_comments_number(), 'comments title', 'wptoots' ),
                number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 74,
                'callback' => 'wptoots_list_comment',
            ) );
            ?>
        </ol><!-- .comment-list -->

        <?php
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'wptoots' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'wptoots' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'wptoots' ) ); ?></div>
            </nav><!-- .comment-navigation -->
        <?php endif; // Check for comment navigation ?>

        <?php if ( ! comments_open() && get_comments_number() ) : ?>
            <p class="no-comments"><?php _e( 'Comments are closed.' , 'wptoots' ); ?></p>
        <?php endif; ?>

    <?php endif; // have_comments() ?>
<div class="contact_form">
    <?php

    // Change order comment fields
    add_filter('comment_form_fields', 'wptoots_reorder_comment_fields' );
    function wptoots_reorder_comment_fields( $fields ){
        $new_fields = array();
        $myorder = array('author','email','comment');
        foreach( $myorder as $key ){
            $new_fields[ $key ] = $fields[ $key ];
            unset( $fields[ $key ] );
        }
        if( $fields )
            foreach( $fields as $key => $val )
                $new_fields[ $key ] = $val;
        return $new_fields;
    }

    $comments_args = array(
        'fields' => array(
            'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . esc_html__( 'Full name:', 'wptoots' ) . '</label> ' . ( $req ? '<span class="required ">*</span>' : '' ) .
                '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' /></div>',
            'email'  => '<div class="form-group"><label for="email">' . esc_html__( 'Email Address:' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                '<input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' /></div>',),
        'class_submit' => 'btn btn-default',
        'submit_field' => '<div class="section_sub_btn">%1$s %2$s</div>',
        'comment_field' => '<div class="form-group comment-form-comment"><label for="comment">' . esc_html_x( 'Massege', 'wptoots' ) . '</label> <textarea id="comment" class="form-textarea" name="comment" rows="3" aria-required="true"></textarea></div>'
    );
    comment_form($comments_args); ?>
</div>
</div><!-- #comments -->
