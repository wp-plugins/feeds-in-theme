<?php
/*
 * Plugin Name: feeds-in-theme
 * Plugin URI: #
 * Description: Recreates the standard WordPress feeds to alow using theme templates in the feeds.
 * Version: 1.0.0
 * Author: Eric Le Bail
 * Author URI: #
 *
 * This plugin has been developped and tested with Wordpress Version 2.6
 *
 * Copyright 2009  Eric Le Bail (email : eric_lebail@hotmail.com)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *
 */

add_action('init', 'fit_add_feed');


/**
 * Function that creates the custom feeds and add a rewriterules to
 * call the feeds.
 * @return void.
 */
function fit_add_feed() {
    global $wp_rewrite;
    add_feed('trdf', 'fit_do_feed_rdf');
    add_feed('trss', 'fit_do_feed_rss');
    add_feed('trss2', 'fit_do_feed_rss2');
    add_feed('tatom', 'fit_do_feed_atom');
    add_action('generate_rewrite_rules', 'fit_rewrite_rules');
    $wp_rewrite->flush_rules();
}

/**
 * Function that creates the rewrite rules for custom feeds.
 * @param $wp_rewrite
 * @return void.
 */
function fit_rewrite_rules($wp_rewrite) {
    $new_rules = array(
    'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}


/**
 * Load the RDF RSS 0.91 Feed template.
 *
 * First check if a template is available in theme then uses the
 * default wordpress template.
 */
function fit_do_feed_rdf() {
    if ( file_exists(TEMPLATEPATH . '/feed-rdf.php') )
    {
        load_template( TEMPLATEPATH . '/feed-rdf.php' );
    }
    else
    {
        load_template( ABSPATH . WPINC . '/feed-rdf.php' );
    }

}

/**
 * Load the RSS 1.0 Feed Template
 *
 * First check if a template is available in theme then uses the
 * default wordpress template.
 */
function fit_do_feed_rss() {
    if ( file_exists(TEMPLATEPATH . '/feed-rss.php') )
    {
        load_template( TEMPLATEPATH . '/feed-rss.php' );
    }
    else
    {
        load_template( ABSPATH . WPINC . '/feed-rss.php' );
    }
}

/**
 * Load either the RSS2 comment feed or the RSS2 posts feed.
 *
 * First check if a template is available in theme then uses the
 * default wordpress template.
 *
 * @param bool $for_comments True for the comment feed, false for normal feed.
 */
function fit_do_feed_rss2( $for_comments ) {
    if ( $for_comments )
    if ( file_exists(TEMPLATEPATH . '/feed-rss2-comments.php') )
    {
        load_template( TEMPLATEPATH . '/feed-rss2-comments.php' );
    }
    else
    {
        load_template( ABSPATH . WPINC . '/feed-rss2-comments.php' );
    }
    else
    if ( file_exists(TEMPLATEPATH . '/feed-rss2.php') )
    {
        load_template( TEMPLATEPATH . '/feed-rss2.php' );
    }
    else
    {
        load_template( ABSPATH . WPINC . '/feed-rss2.php' );
    }
}

/**
 * Load either Atom comment feed or Atom posts feed.
 *
 * First check if a template is available in theme then uses the
 * default wordpress template.
 *
 * @param bool $for_comments True for the comment feed, false for normal feed.
 */
function fit_do_feed_atom( $for_comments ) {
    if ($for_comments)
    {
        if ( file_exists(TEMPLATEPATH . '/feed-atom-comments.php') )
        {
            load_template( TEMPLATEPATH . '/feed-atom-comments.php' );
        }
        else
        {
            load_template( ABSPATH . WPINC . '/feed-atom-comments.php' );
        }
    } else {
        if ( file_exists(TEMPLATEPATH . '/feed-atom.php') )
        {
            load_template( TEMPLATEPATH . '/feed-atom.php' );
        }
        else
        {
            load_template( ABSPATH . WPINC . '/feed-atom.php' );
        }
    }
}
?>