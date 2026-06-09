<?php
/**
 * Title: Shortcut Columns
 * Slug: efs/shortcut-columns
 * Categories: efs, featured
 */
?>
<!-- wp:group {"backgroundColor":"accent-4","textColor":"accent-1","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-accent-1-color has-accent-4-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
    <!-- wp:columns {"isStackedOnMobile":true} -->
    <div class="wp-block-columns is-stacked-on-mobile">
        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:group {"className":"is-clickable-shortcut","layout":{"type":"constrained"}} -->
            <div class="wp-block-group is-clickable-shortcut">
                <!-- wp:image {"align":"center","sizeSlug":"medium","linkDestination":"none","width":200,"height":200} -->
                <figure class="wp-block-image aligncenter size-medium"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/calendar-shortcut-v2.png" alt="Kalender"/></figure>
                <!-- /wp:image -->
                <!-- wp:paragraph {"align":"center"} -->
                <p class="has-text-align-center">Kalender</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:group {"className":"is-clickable-shortcut","layout":{"type":"constrained"}} -->
            <div class="wp-block-group is-clickable-shortcut">
                <!-- wp:image {"align":"center","sizeSlug":"medium","linkDestination":"none","width":200,"height":200} -->
                <figure class="wp-block-image aligncenter size-medium"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/support-shortcut-v2.png" alt="Stöd oss"/></figure>
                <!-- /wp:image -->
                <!-- wp:paragraph {"align":"center"} -->
                <p class="has-text-align-center">Stöd oss</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:group {"className":"is-clickable-shortcut","layout":{"type":"constrained"}} -->
            <div class="wp-block-group is-clickable-shortcut">
                <!-- wp:image {"align":"center","sizeSlug":"medium","linkDestination":"none","width":200,"height":200} -->
                <figure class="wp-block-image aligncenter size-medium"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/newsletter-shortcut-v2.png" alt="Nyhetsbrev"/></figure>
                <!-- /wp:image -->
                <!-- wp:paragraph {"align":"center"} -->
                <p class="has-text-align-center">Nyhetsbrev</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->
