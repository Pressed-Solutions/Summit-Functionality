<div class="speaker">
    <p><a href="<?php the_permalink(); ?>"><?php echo wp_get_attachment_image( get_field( 'speaker_image' ), array( 250, 250 ), false, array( 'class' => 'speaker-photo' ) ) ?></a></p>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p>Talk Title:</p>
    <h3><?php the_field( 'talk_title' ); ?></h3>
</div>
