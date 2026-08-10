<?php
///////////////////////////////////////////////////////
// Gravity Forms

// Gravity Forms - load scripts in footer
add_filter( 'gform_init_scripts_footer', '__return_true' );
    
// Gravity Forms - add hide label option
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// Gravity Forms - Hide editor button
add_filter( 'gform_display_add_form_button', function(){return false;} );


///////////////////////////////////////////////////////
// Populate ACF select field options with Gravity Forms forms

function acf_populate_gf_forms_ids( $field ) {
	if ( class_exists( 'GFFormsModel' ) ) {
		$choices = [];

		foreach ( \GFFormsModel::get_forms() as $form ) {
			$choices[ $form->id ] = $form->title;
		}

		$field['choices'] = $choices;
	}

	return $field;
}
add_filter( 'acf/load_field/name=gf_form_id', 'acf_populate_gf_forms_ids' );

///////////////////////////////////////////////////////

?>