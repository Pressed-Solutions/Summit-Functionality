<?php

/**
 * List speakers
 * @param  array  $attributes shortcode attributes
 * @return string HTML content string
 */
add_shortcode( 'speaker_list', 'sf_speaker_list' );
function sf_speaker_list( $attributes ) {
    // set up query
    $list_args = parse_shortcode_args( $attributes );

    $list_query = new WP_Query( $list_args );

    // loop
    ob_start();
    if ( $list_query->have_posts() ) { ?>
        <section <?php post_class( 'speaker-wrapper' ); ?>>
        <?php while ( $list_query->have_posts() ) {
            $list_query->the_post();
            include( plugin_dir_path( __FILE__ ) . '../templates/individual-speaker.php' );
        } ?>
        </section>
    <?php
    }
    $shortcode_content = ob_get_clean();
    wp_reset_postdata();

    return $shortcode_content;
}

/**
 * List downloads
 * @param  array  $attributes shortcode attributes
 * @return string HTML content string
 */
add_shortcode( 'member_downloads', 'sf_member_downloads' );
function sf_member_downloads( $attributes ) {
    // set up query
    $downloads_args = array_merge( parse_shortcode_args( $attributes ), array(
       'meta_query'    => array(
            array(
                'key'      => 'video_download_url',
                'compare'  => 'EXISTS',
            ),
            array(
                'key'      => 'video_download_url',
                'value'    => '',
                'compare'  => '!=',
            ),
        ),
    ));

    $downloads_query = new WP_Query( $downloads_args );

    // loop
    ob_start();
    if ( $downloads_query->have_posts() ) { ?>
        <section <?php post_class( 'speaker-wrapper' ); ?>>
        <?php while ( $downloads_query->have_posts() ) {
            $downloads_query->the_post();
            $download = true;
            include( plugin_dir_path( __FILE__ ) . '../templates/individual-speaker.php' );
        } ?>
        </section>
    <?php }
    $shortcode_content = ob_get_clean();
    wp_reset_postdata();

    return $shortcode_content;
}

/**
 * List today’s speakers
 * @param  array  $attributes shortcode attributes
 * @return string HTML content string
 */
add_shortcode( 'today_speakers', 'sf_today_speakers' );
function sf_today_speakers( $attributes ) {
    // get today’s category
    $category_args = array(
        'meta_query' => array(
            array(
                'key'       => 'date',
                'value'     => '',
                'compare'   => '!=',
            ),
        ),
    );
    $categories = get_categories( $category_args );

    $cat_array = array();
    $first_date = '32503680000'; /* impossibly large date: January 1, 3000 */
    $last_date = '0';
    if ( $categories ) {
        foreach ( $categories as $category ) {
            $start_date = get_field( 'start_date', $category );
            $end_date = get_field( 'end_date', $category );
            $timezone = get_field( 'timezone', $category );

            if ( get_access_permissions( $start_date, $end_date, $timezone, 'ignore', true ) === true ) {
                $cat_array[] = $category->term_id;
            }
            if ( $start_date < $first_date ) {
                $first_date = $start_date;
            }
            if ( $end_date > $last_date ) {
                $last_date = $end_date;
            }
        }
    }

    // set up query
    if ( $cat_array ) {
        $downloads_args = array_merge( parse_shortcode_args( $attributes ), array(
            'category__in'  => $cat_array,
        ));

        $downloads_query = new WP_Query( $downloads_args );

        // loop
        ob_start();
        if ( $downloads_query->have_posts() ) { ?>
            <section <?php post_class( 'speaker-wrapper' ); ?>>
            <?php while ( $downloads_query->have_posts() ) {
                $downloads_query->the_post();
                $download = true;
                include( plugin_dir_path( __FILE__ ) . '../templates/individual-speaker.php' );
            } ?>
            </section>
        <?php }
        wp_reset_postdata(); ?>

    <?php } else {
    if ( $first_date > time() ) { ?>
        <h2>Sorry, Nothing&rsquo;s Available Yet</h2>
        <p>Please come back on <?php echo date( 'l, F j, Y', $first_date ) ?>.</p>
    <?php } elseif ( $last_date < date( 'Ymd' ) ) { ?>
        <h2>Sorry, This Summit Has Ended</h2>
        <p>However, you can still purchase access!</p>
        <p><a href="<?php the_field( 'purchase_page', 'option' ); ?>" class="btn btn-primary btn-lg">Purchase Access</a></p>
    <?php }
    }

    $shortcode_content = ob_get_clean();

    return $shortcode_content;
}

/**
 * Parse shortcode attributes to WP_Query parameters
 * @param  array $attributes shortcode attributes
 * @return array WP_Query parameters
 */
function parse_shortcode_args( $attributes ) {
    $shortcode_attributes = shortcode_atts( array (
        'post_type'             => 'summit_speaker',
        'p'                     => NULL,
        'name'              => NULL,
        'post_parent'           => NULL,
        'post_parent__in'       => array(),
        'post_parent_not__in'   => array(),
        'post__in'              => NULL, // workaround for ticket 28099: https://core.trac.wordpress.org/ticket/28099
        'post__not_in'          => array(),
        'post_name__in'         => array(),
        'cat'                   => NULL,
        'category_name'         => NULL,
        'category__in'          => array(),
        'tag'                   => NULL,
        'tag_id'                => NULL,
        'tag__in'               => array(),
        'tag_slug__in'          => array(),
        'orderby'               => 'post_title',
        'order'                 => 'ASC',
        'posts_per_page'        => -1,
        'offset'                => NULL,
    ), $attributes );

    return array(
        'post_type'             => $shortcode_attributes['post_type'],
        'p'                     => $shortcode_attributes['p'],
        'name'              => $shortcode_attributes['name'],
        'post_parent'           => $shortcode_attributes['post_parent'],
        'post_parent__in'       => empty( $shortcode_attributes['post_parent__in'] ) ? NULL : explode( ',', str_replace( ' ', '', $shortcode_attributes['post_parent__in'] ) ),
        'post_parent_not__in'   => empty( $shortcode_attributes['post_parent_not__in'] ) ? NULL : explode( ',', str_replace( ' ', '', $shortcode_attributes['post_parent_not__in'] ) ),
        'post__in'              => empty( $shortcode_attributes['post__in'] ) ? NULL : explode( ',', str_replace( ' ', '', $shortcode_attributes['post__in'] ) ),
        'post__not_in'          => empty( $shortcode_attributes['post__not_in'] ) ? NULL : explode( ',', str_replace( ' ', '', $shortcode_attributes['post__not_in'] ) ),
        'post_name__in'         => $shortcode_attributes['post_name__in'],
        'cat'                   => $shortcode_attributes['cat'],
        'category_name'         => $shortcode_attributes['category_name'],
        'category__in'          => $shortcode_attributes['category__in'],
        'tag'                   => $shortcode_attributes['tag'],
        'tag_id'                => $shortcode_attributes['tag_id'],
        'tag__in'               => empty( $shortcode_attributes['tag__in'] ) ? NULL : explode( ',', str_replace( ' ', '', $shortcode_attributes['tag__in'] ) ),
        'tag_slug__in'          => empty( $shortcode_attributes['tag_slug__in'] ) ? NULL : explode( ',', str_replace( ' ', '', $shortcode_attributes['tag_slug__in'] ) ),
        'orderby'               => $shortcode_attributes['orderby'],
        'order'                 => $shortcode_attributes['order'],
        'posts_per_page'        => $shortcode_attributes['posts_per_page'],
        'offset'                => $shortcode_attributes['offset'],
    );
}
