<?php
/**
 * The template for displaying the footer
 * @package cdev
 */


 
$rep_headline = get_field('rep-headline','options');
$rep_text = get_field('rep-text','options');

$rep_url = get_field('rep-url','options');
?>

<?php if ($rep_headline || $rep_text || $rep_url) : ?>
    <a href="<?php echo esc_url( $rep_url ); ?>" class="cta">
        <span class="cta__inner">
            <span class="cta__lead">
                <span class="cta__icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                <span class="cta__title"><?php echo esc_html( $rep_headline ); ?></span>
            </span>
            <span class="cta__text"><?php echo esc_html( $rep_text ); ?></span>
        </span>
    </a>
<?php endif; ?>


<footer id="colophon" class="site-footer">

<div class="block_size_wide">

    <div class="footercolumns">
        
        <div class="footer-branding">
                <p class="footer-branding__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        </div>
        
        <div class="loc">
            <?php the_field('contact_1', 'options'); ?>
        </div>
        
        <div class="loc">
            <?php the_field('contact_2', 'options'); ?>
        </div>

        <div class="assoc">
            <?php if( have_rows('association_logos', 'options') ): ?>
            <ul>
            <?php while( have_rows('association_logos', 'options') ): the_row(); 
                $assoc_name = get_sub_field('name');
                $assoc_logo = get_sub_field('logo');
                $assoc_logo_url = get_sub_field('logo_url');
                $assoc_url = get_sub_field('url');

                if($assoc_logo_url){
                    $assoc_logo = $assoc_logo_url;
                }
                ?>
                <li>
                <?php if( $assoc_url ){ ?>
                <a href="<?php echo $assoc_url; ?>" target="_blank">
                <?php } ?>
                <img src="<?php echo esc_url($assoc_logo['url']); ?>" width="<?php echo esc_attr($assoc_logo['width']); ?>" height="<?php echo esc_attr($assoc_logo['height']); ?>" alt="<?php echo $assoc_name; ?>" title="<?php echo $assoc_name; ?>">
                <?php if( $assoc_url ){ ?>
                </a>
                <?php } ?>
                </li>
            <?php endwhile; ?>
            
            </ul>
            <?php endif; ?>
        </div>
        
        
    </div>
    

    <div class="site-info x-small-text">
        <p>&copy; <?php auto_copyright('2026'); ?> - <?php the_field('copyright', 'options'); ?></p>
        <p>Site by <a href="https://www.cdevision.com" target="_blank">cdeVision</a></p>
    </div><!-- .site-info -->
    
</div>

</footer><!-- #colophon -->
	
	

<?php wp_footer(); ?>



<?php // Schema /////////////////////////////////////////////////////////

$loc_count = 0;
$locations = get_field('schema_locations', 'options');
if (is_array($locations)) {
  $loc_count = count($locations);
}


if ( $loc_count &&  get_field('schema_name', 'options') ){ // if schema set
if ( $loc_count == 1 ){ // If one location

    
    // get locatrion info
    while ( have_rows('schema_locations', 'options') ) : the_row();
        $schema_telephone = get_sub_field('telephone');
        $schema_image = get_sub_field('image');
        $schema_address = get_sub_field('address');
        $schema_city = get_sub_field('city');
        $schema_state = get_sub_field('state');
        $schema_zip = get_sub_field('zip');
        $schema_hours = get_sub_field('hours');
        $schema_description = get_sub_field('description');
        $schema_map = get_sub_field('map');
    endwhile;
?>

<script type="application/ld+json">
{
"@context" : "http://schema.org",
"@type" : "<?php the_field('schema_business_type', 'options'); ?>",
"name" : "<?php the_field('schema_name', 'options'); ?>",
<?php if (!empty($schema_telephone)) { ?>"telephone" : "<?php echo $schema_telephone; ?>",
<?php } ?><?php if (!empty($schema_image)) { ?>"image":"<?php echo $schema_image; ?>",
<?php } ?>"address": {
    "@type": "PostalAddress",
    "streetAddress" : "<?php echo $schema_address; ?>",
    "addressLocality" : "<?php echo $schema_city; ?>",
    "addressRegion" : "<?php echo $schema_state; ?>",
    "postalCode" : "<?php echo $schema_zip; ?>"
},
<?php if (!empty($schema_description)) { ?>"description" : "<?php echo $schema_description; ?>",
<?php } ?>"url" : "<?php the_field('schema_website_url', 'options'); ?>",
"logo" : "<?php the_field('schema_logo', 'options'); ?>"<?php if (!empty($schema_map)) { ?>,
"hasMap": "<?php echo $schema_map; ?>"<?php } ?><?php if (!empty($schema_hours)) { ?>,
"openingHours": [ "<?php echo $schema_hours; ?>" ]<?php } ?><?php 
$social_media = get_field('schema_social_media', 'options');
if (!empty($social_media)) { ?>,
"sameAs": [ 
    <?php echo $social_media; ?>
]<?php } ?>
}
</script>

<?php } else if ( $loc_count > 1 ) { ?>

<script type="application/ld+json">
{
"@context": {
"@vocab": "http://schema.org/"
},
"@graph": [
{
"@id": "#MainOrganization",
"@type": "Organization",
"name": "<?php the_field('schema_name', 'options'); ?>",
"url" : "<?php the_field('schema_website_url', 'options'); ?>",
"logo" : "<?php the_field('schema_logo', 'options'); ?>"<?php 
$social_media = get_field('schema_social_media', 'options');
if (!empty($social_media)) { ?>,
"sameAs" : [ <?php echo $social_media; ?> ]<?php } ?>
},
<?php
// get location info - only output locations with valid data
$valid_locations = array();
while ( have_rows('schema_locations', 'options') ) : the_row();
    $schema_telephone = get_sub_field('telephone');
    $schema_image = get_sub_field('image');
    $schema_address = get_sub_field('address');
    $schema_city = get_sub_field('city');
    $schema_state = get_sub_field('state');
    $schema_zip = get_sub_field('zip');
    $schema_hours = get_sub_field('hours');
    $schema_description = get_sub_field('description');
    $schema_map = get_sub_field('map');
    
    // Only include locations with at least address and city
    if (!empty($schema_address) && !empty($schema_city)) {
        $valid_locations[] = array(
            'telephone' => $schema_telephone,
            'image' => $schema_image,
            'address' => $schema_address,
            'city' => $schema_city,
            'state' => $schema_state,
            'zip' => $schema_zip,
            'hours' => $schema_hours,
            'description' => $schema_description,
            'map' => $schema_map
        );
    }
endwhile;

$total_valid = count($valid_locations);
$location_count = 0;
foreach ($valid_locations as $location) {
    $location_count++;
?>
{
"@type": "<?php the_field('schema_business_type', 'options'); ?>",
"parentOrganization": {
"@id": "#MainOrganization"
},
"name" : "<?php the_field('schema_name', 'options'); ?>",
"address": {
"@type" : "PostalAddress",
"streetAddress": "<?php echo $location['address']; ?>",
"addressLocality": "<?php echo $location['city']; ?>",
"addressRegion": "<?php echo $location['state']; ?>",
"postalCode": "<?php echo $location['zip']; ?>"
}<?php 
if (!empty($location['telephone'])) { ?>,
"telephone" : "<?php echo $location['telephone']; ?>"<?php }
if (!empty($location['hours'])) { ?>,
"openingHours": [ "<?php echo $location['hours']; ?>" ]<?php }
if (!empty($location['image'])) { ?>,
"image" : "<?php echo $location['image']; ?>"<?php }
if (!empty($location['description'])) { ?>,
"description" : "<?php echo $location['description']; ?>"<?php }
if (!empty($location['map'])) { ?>,
"hasMap" : "<?php echo $location['map']; ?>"<?php } ?>
}<?php if($location_count < $total_valid){ echo ",";} ?>

<?php
}
?>
]
}
</script>

<?php } // end schema ?>
<?php } // end if schema set
//////////////////////////////////////////////////////////////
?>


<?php // Footer scripts
the_field('footer_scripts','options'); ?>

</body>
</html>