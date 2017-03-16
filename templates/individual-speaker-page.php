<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<div class="container">
    <!-- start content container -->
    <div class="row dmbs-content">

        <?php //left sidebar ?>
        <?php get_sidebar( 'left' ); ?>

        <div class="col-md-8 dmbs-main">

            <?php // the loop
            if ( have_posts() ) : while ( have_posts() ) : the_post();

            if ( get_field( 'video_link' ) ) {
                // check categories for the day to show video content
                $post_categories = get_the_category();
                foreach ( $post_categories as $post_category ) {
                    $active_date = get_field( 'date', $post_category );
                    if ( $active_date == date( 'Ymd' ) || ( $active_date >= date( 'Ymd' ) && is_user_logged_in() ) ) {
                        echo '<p>' . wp_oembed_get( get_field( 'video_link' ) ) . '</p>';
                        if ( get_field( 'video_download_url' ) && is_user_logged_in() ) {
                            echo '<p><a href="' . get_field( 'video_download_url' ) . '" class="btn btn-primary btn-lg btn-block">Download Video</a></p>';
                        }
                    } elseif ( $active_date < date( 'Ymd' ) && ! is_user_logged_in() ) {
                        the_field( 'sales_promo' );
                    }
                }
            }

            if ( get_field( 'talk_title' ) ) {
                echo '<h1>Talk Title: ' . get_field( 'talk_title' ) . '</h1>';
            }

            the_content();
            ?>

            <p><a href="<?php echo get_home_url(); ?>/sales/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sales.png" alt="Register now" /></a></p>
            <?php wp_link_pages(); ?>

            <h2 id="comment-both"><span>Comments</span></h2>

            <div class="fbcomment-comment">
                <div class="col-md-6">
                    <a id="fbcommentbutton" href="#fbcomment">comment with facebook</a>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-6">
                    <a id="morecommentbutton" href="#morecomment">Comment without facebook</a>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <br><br>
            <div class="fb-comment" id="fbcomment">
                <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
            </div>

            <h3 class="text-center" id="morecomment">More Comments</h3>
            <div class="clearfix"></div>
            <?php comments_template(); ?>

            <?php endwhile; ?>
            <?php else: ?>

            <?php get_404_template(); ?>

            <?php endif; ?>
            <div class="clearfix"></div>

        </div>

        <div class="col-md-4 dmbs-right speaker-info">
            <img src="<?php the_field('speaker_image'); ?>" class="img img-responsive speaker-photo" alt="<?php the_title(); ?>" />
            <h2><?php the_title(); ?></h2>
            <?php if ( get_field( 'speaker_website' ) ) : ?>
                <a href="<?php the_field( 'speaker_website' ); ?>">
                    <?php the_field( 'speaker_website' ); ?>
                </a>
            <?php endif; ?>
            <hr>
            <?php if ( get_field( 'bonus_image' ) ): ?>
                <h2 class="text-center bonus-header">Free Bonus Download</h2>
                <a href="<?php the_field( 'bonus_link' ); ?>"><img src="<?php the_field( 'bonus_image' ); ?>" class="img img-responsive" alt="Free Bonus" /></a>
            <?php endif; ?>

            <?php if ( get_field( 'bonus_offer' ) ): ?>
                <h2 class="text-center bonus-header">Bonus Offer</h2>
                <?php the_field( 'bonus_offer' ); ?>
            <?php endif; ?>
        </div>

    </div>
</div>
<!-- end content container -->

<?php get_footer(); ?>