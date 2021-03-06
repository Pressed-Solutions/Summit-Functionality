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
                    $memberium_level = get_field( 'memberium_level', 'option' );
                    $start_date = get_field( 'start_date', $post_category );
                    $end_date = get_field( 'end_date', $post_category );
                    $timezone = get_field( 'timezone', $post_category );
                    $active_access = get_access_permissions( $start_date, $end_date, $timezone, $memberium_level );

                    if ( $active_access === true ) {
                        echo '<p class="embed-container">' . get_field( 'video_link' ) . '</p>';
                        if ( get_field( 'video_download_url' ) && memb_hasMembership( $memberium_level ) ) {
                            echo '<p><a href="' . get_field( 'video_download_url' ) . '" class="btn btn-primary btn-lg btn-block">Download Video</a></p>';
                        }
                    } elseif ( date( 'Ue' ) < date( 'Ue', $start_date . $timezone ) ) {
                        the_field( 'sales_promo_before' );
                    } else {
                        the_field( 'sales_promo_after' );
                    }
                }
            }

            if ( get_field( 'talk_title' ) ) {
                echo '<h1>Talk Title: ' . get_field( 'talk_title' ) . '</h1>';
            }

            the_content();

            $promo_image_parameters = array(
                'size' => 'full',
                false,
                array(
                    'class' => 'img img-responsive',
                    'alt' => 'Register Now',
                )
            );
            ?>

            <p><a href="<?php the_field( 'purchase_page', 'option' ) ?>"><?php echo wp_get_attachment_image( get_field( 'sales_promo_image', 'option' ), apply_filters( 'sf_purchase_access_image', $promo_image_parameters ) ); ?></a></p>
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
            <?php echo wp_get_attachment_image( get_field( 'speaker_image' ), array( 250, 250 ), false, array( 'class' => 'speaker-photo' ) ) ?>
            <h2><?php the_title(); ?></h2>
            <?php if ( get_field( 'speaker_website' ) ) : ?>
                <a href="<?php the_field( 'speaker_website' ); ?>">
                    <?php the_field( 'speaker_website' ); ?>
                </a>
            <?php endif; ?>

            <hr>

            <?php if ( get_field( 'bonus_offer' ) ): ?>
                <h2 class="text-center bonus-header">Bonus Offer</h2>
                <?php the_field( 'bonus_offer' ); ?>
            <?php endif; ?>

            <?php if ( get_field( 'bonus_image' ) || get_field( 'bonuses_r' ) ): ?>
                <h2 class="text-center bonus-header">Free Bonus Download</h2>
            <?php endif; ?>

            <?php if ( get_field( 'bonus_image' ) ): ?>
                <p><a href="<?php the_field( 'bonus_link' ); ?>"><?php echo wp_get_attachment_image( get_field( 'bonus_image' ), 'full', false, array( 'class' => 'img img-responsive' ) ); ?></a></p>
            <?php endif; ?>

            <?php
            if ( get_field( 'bonuses_r' ) ) {
                foreach ( get_field( 'bonuses_r' ) as $bonus ) { ?>
                    <p><a href="<?php echo $bonus['bonus_link_r']; ?>"><?php echo wp_get_attachment_image( $bonus['bonus_image_r'], 'full', false, array( 'class' => 'img img-responsive' ) ); ?></a></p>
                <?php }
            } ?>

        </div>

    </div>
</div>
<!-- end content container -->

<?php get_footer(); ?>
