<?php

$slider_posts = arouse_get_featured_posts();

?>

<div class="arouse-featured-slider">
    <section class="slider">
        <div class="flexslider">
            <ul class="slides">
                <?php

                    foreach( (array) $slider_posts as $order => $post ) :
                        setup_postdata( $post );

                ?>
                    
                    <li>
                        
                        <div class="arouse-slider-container" data-loc="<?php echo esc_url( get_permalink() ); ?>">
                        
                            <?php if ( has_post_thumbnail() ) { 

                                $thumb_id           = get_post_thumbnail_id();
                                $thumb_url_array    = wp_get_attachment_image_src( $thumb_id, 'arouse-featured-slider' );
                                $featured_image_url = $thumb_url_array[0]; 

                                ?>
                                <div class="arouse-slide-holder" style="background: url(<?php echo esc_url( $featured_image_url ); ?>);">
                            <?php } else { ?>
                                <div class="arouse-slide-holder" style="background: url(<?php echo get_template_directory_uri() . '/images/slide.jpg' ?>);">
                            <?php } ?>

                                    <div class="arouse-slide-content">
                                    <div class="overlay"></div>

                                        <div class="arouse-slider-details">
                                            <?php arouse_category_list(); ?>
                                            <a href="<?php the_permalink(); ?>" rel="bookmark"><h3 class="arouse-slider-title"><?php the_title(); ?></h3></a>
                                            <span class="divider"></span>
                                        </div><!-- .arouse-slider-details -->

                                    </div><!-- .arouse-slide-content -->

                                </div><!-- .arouse-slide-holder -->

                        </div><!-- .arouse-slider-container -->
                        
                    </li>

                <?php 

                    endforeach;
                    wp_reset_postdata();

                ?>
            </ul>
        </div><!-- .flexslider -->
    </section><!-- .slider -->
</div><!-- .arouse-slider -->