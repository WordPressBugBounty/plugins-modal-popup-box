<?Php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// modal box js and css
wp_enqueue_script( 'mbp-bootstrap-js', MPB_PLUGIN_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), '', false );
wp_enqueue_script( 'mbp-modernizr-custom-js', MPB_PLUGIN_URL . 'assets/js/modal/modernizr.custom.js', array( 'jquery' ), '', false );    // before body load
wp_enqueue_script( 'mbp-classie-js', MPB_PLUGIN_URL . 'assets/js/modal/classie.js', array( 'jquery' ), '', true );
wp_enqueue_script( 'mbp-modalEffects-js', MPB_PLUGIN_URL . 'assets/js/modal/modalEffects.js', array( 'jquery' ), '', true );
wp_enqueue_script( 'mbp-cssParser-js', MPB_PLUGIN_URL . 'assets/js/modal/cssParser.js', array( 'jquery' ), '', true );
wp_enqueue_script( 'mbp-color-picker-js', MPB_PLUGIN_URL . 'assets/js/mb-color-picker.js', array( 'wp-color-picker' ), false, true );
wp_enqueue_style( 'wp-color-picker' );


// css
wp_enqueue_style( 'mbp-bootstrap-css', MPB_PLUGIN_URL . 'assets/css/bootstrap.css' );
wp_enqueue_style( 'mbp-component-css', MPB_PLUGIN_URL . 'assets/css/component.css' );
wp_enqueue_style( 'mbp-font-awesome-css', MPB_PLUGIN_URL . 'assets/css/font-awesome.css' );
wp_enqueue_style( 'mbp-animate-css', MPB_PLUGIN_URL . 'assets/css/animate.css' );
wp_enqueue_style( 'mbp-styles-css', MPB_PLUGIN_URL . 'assets/css/styles.css' );
wp_enqueue_style( 'mbp-toogle-button-css', MPB_PLUGIN_URL . 'assets/css/toogle-button.css' );

// load settings
$modal_popup_box_id = esc_attr($post->ID);

function is_mpb_serialized($str)
{
	return ($str == serialize(false) || @unserialize($str) !== false);
}

// Retrieve the base64 encoded data
$encodedData = get_post_meta($modal_popup_box_id, 'awl_mpb_settings_' . $modal_popup_box_id, true);

// Decode the base64 encoded data
$decodedData = base64_decode($encodedData);

// Check if the data is serialized
if (is_mpb_serialized($decodedData)) {

	// The data is serialized, so unserialize it
	$modal_popup_box_settings = unserialize($decodedData);
	// Optionally, convert the unserialized data to JSON and save it back in base64 encoding for future access
	// This step is optional but recommended to transition your data format

	$jsonEncodedData = json_encode($modal_popup_box_settings);
	update_post_meta($modal_popup_box_id, 'awl_mpb_settings_' . $modal_popup_box_id, $jsonEncodedData);

	// Now, to use the newly saved format, fetch and decode again
	$encodedData = get_post_meta($modal_popup_box_id, 'awl_mpb_settings_' . $modal_popup_box_id, true);
	$modal_popup_box_settings = json_decode(($encodedData), true);

} else {
	// Assume the data is in JSON format
	$jsonData = get_post_meta($modal_popup_box_id, 'awl_mpb_settings_' . $modal_popup_box_id, true);
	// Decode the JSON string into an associative array
	$modal_popup_box_settings = json_decode($jsonData, true); // Ensure true is passed to get an associative array
}

?>
<style>
.custom-radios div {
  display: inline-block;
  margin-left: 7px;
}
.custom-radios input[type="radio"] {
  display: none;
}
.custom-radios input[type="radio"] + label {
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
}
.custom-radios input[type="radio"] + label span {
  display: inline-block;
  width: 40px;
  height: 40px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 44px;
}
.custom-radios input[type="radio"] + label span img {
  opacity: 0;
  transition: all .3s ease;
}
.custom-radios input[type="radio"]#color-1 + label span {
  background-color: #008EC2;
}
.custom-radios input[type="radio"]#color-2 + label span {
  background-color: #FF0000;
}
.custom-radios input[type="radio"]:checked + label span {
  opacity: 1;
  background: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg) center center no-repeat;
  width: 40px;
  height: 40px;
  display: inline-block;

}
#edit-slug-box {
	display: none;
}
.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
float: left;
}
</style>
<div class="row">
	<div class="col-lg-12 bhoechie-tab-container">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu">
			<div class="list-group">
				<a href="#" class="list-group-item active text-center">
					<span class="dashicons dashicons-archive"></span><br/><?php esc_html_e( 'Modal Popup Setting', 'modal-popup-box' ); ?>
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-admin-generic"></span><br/><?php esc_html_e( 'Config', 'modal-popup-box' ); ?>
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-media-code"></span><br/><?php esc_html_e( 'Custom CSS', 'modal-popup-box' ); ?>
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-cart"></span><br/><?php esc_html_e( 'Upgrade To Pro', 'modal-popup-box' ); ?>
				</a>
			</div>
		</div>
	
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bhoechie-tab">
			<div class="bhoechie-tab-content active">
				<h1><?php esc_html_e( 'Modal Form', 'modal-popup-box' ); ?></h1>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Show Modal', 'modal-popup-box'); ?></h5>
							<p><?php esc_html_e('Display modal on page load OR on button click', 'modal-popup-box'); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4 switch-field em_size_field">
							<?php if(isset($modal_popup_box_settings['mpb_show_modal'])) $mpb_show_modal = $modal_popup_box_settings['mpb_show_modal']; else $mpb_show_modal = "onclick"; ?>	
							<input type="radio" class="form-control" id="mpb_show_modal1" name="mpb_show_modal" value="onload" <?php if($mpb_show_modal == "onload") echo "checked=checked";?>>
							<label for="mpb_show_modal1"><?php esc_html_e('On Page Load ', 'modal-popup-box'); ?></label>
							<input type="radio" class="form-control" id="mpb_show_modal2" name="mpb_show_modal" value="onclick" <?php if($mpb_show_modal == "onclick") echo "checked=checked";?>> 
							<label for="mpb_show_modal2"><?php esc_html_e('On Button Click', 'modal-popup-box'); ?></label>
						</div>
					</div>
					<!-- hide button setting on page load -->
					<div class="MPB_onclick_section">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Button Text', 'modal-popup-box'); ?></h5>
								<p><?php esc_html_e('Set any text which will appear on button like Click Me', 'modal-popup-box'); ?></p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php if(isset($modal_popup_box_settings['mpb_main_button_text'])) $mpb_main_button_text = $modal_popup_box_settings['mpb_main_button_text']; else $mpb_main_button_text = "Click Me"; ?>	
								<input type="text" class="selectbox_settings" id="mpb_main_button_text" name="mpb_main_button_text" value="<?php echo esc_html($mpb_main_button_text); ?>" placeholder="Type Button Text">
							</div>
						</div>
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Button Size', 'modal-popup-box'); ?></h5>
								<p><?php esc_html_e('You can set any button size', 'modal-popup-box'); ?></p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php if(isset($modal_popup_box_settings['mpb_main_button_size'])) $mpb_main_button_size = $modal_popup_box_settings['mpb_main_button_size']; else $mpb_main_button_size = "btn btn-lg"; ?>	
								<select class="selectbox_settings" id="mpb_main_button_size" name="mpb_main_button_size"  >
									<option value="btn btn-xs"<?php if($mpb_main_button_size == "btn btn-xs") echo "selected=selected"; ?>><?php esc_html_e('Small button', 'modal-popup-box'); ?></option>
									<option value="btn btn-sm"<?php if($mpb_main_button_size == "btn btn-sm") echo "selected=selected"; ?>><?php esc_html_e('Medium button', 'modal-popup-box'); ?></option>
									<option value="btn btn-lg"<?php if($mpb_main_button_size == "btn btn-lg") echo "selected=selected"; ?>><?php esc_html_e('Large button', 'modal-popup-box'); ?></option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Button Color', 'modal-popup-box'); ?></h5>
								<p><?php esc_html_e('You can set any button background color', 'modal-popup-box'); ?></p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php if(isset($modal_popup_box_settings['mpb_main_button_color'])) $mpb_main_button_color = $modal_popup_box_settings['mpb_main_button_color']; else $mpb_main_button_color = "#008EC2"; ?>	
								<input type="text" class="form-control" id="mpb_main_button_color" name="mpb_main_button_color" value="<?php echo esc_attr($mpb_main_button_color); ?>" default-color="<?php echo esc_attr($mpb_main_button_color); ?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Button Text Color', 'modal-popup-box'); ?></h5>
								<p><?php esc_html_e('You can set any button text color', 'modal-popup-box'); ?></p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php if(isset($modal_popup_box_settings['mpb_main_button_text_color'])) $mpb_main_button_text_color = $modal_popup_box_settings['mpb_main_button_text_color']; else $mpb_main_button_text_color = "#ffffff"; ?>	
								<input type="text" class="form-control" id="mpb_main_button_text_color" name="mpb_main_button_text_color" value="<?php echo esc_attr($mpb_main_button_text_color); ?>" default-color="<?php echo esc_attr($mpb_main_button_text_color); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="bhoechie-tab-content">
				<h1><?php esc_html_e( 'General Settings', 'modal-popup-box' ); ?></h1>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e( 'Select Modal Color', 'modal-popup-box' ); ?></h5>
							<p><?php esc_html_e( 'Select Modal Popup Variation', 'modal-popup-box' ); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<div class="custom-radios">
								<div>
									<?php
									if ( isset( $modal_popup_box_settings['modal_popup_design'] ) ) {
										$modal_popup_design = $modal_popup_box_settings['modal_popup_design'];
									} else {
										$modal_popup_design = 'color_1';
									}
									?>
									<input type="radio" id="color-1" name="modal_popup_design" value="color_1" 
									<?php
									if ( $modal_popup_design == 'color_1' ) {
										echo 'checked=checked';}
									?>
									 >
									<label for="color-1">
									  <span>
									  </span>
									</label>
								</div>
								<div>
									<?php
									if ( isset( $modal_popup_box_settings['modal_popup_design'] ) ) {
										$modal_popup_design = $modal_popup_box_settings['modal_popup_design'];
									} else {
										$modal_popup_design = 'color_2';
									}
									?>
									<input type="radio" id="color-2" name="modal_popup_design" value="color_2" 
									<?php
									if ( $modal_popup_design == 'color_2' ) {
										echo 'checked=checked';}
									?>
									 >
									<label for="color-2">
									  <span>
									  </span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e( 'Modal Box Loading Animation Effect', 'modal-popup-box' ); ?></h5>
							<p><?php esc_html_e( 'Set animation effect on modal form loading', 'modal-popup-box' ); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if ( isset( $modal_popup_box_settings['mpb_animation_effect_open_btn'] ) ) {
								$mpb_animation_effect_open_btn = $modal_popup_box_settings['mpb_animation_effect_open_btn'];
							} else {
								$mpb_animation_effect_open_btn = 'md-effect-1';
							}
							?>
								
							<select id="mpb_animation_effect_open_btn" name="mpb_animation_effect_open_btn">
								<optgroup label="Select Animation Effect">
								<option value="md-effect-1"
								<?php
								if ( $mpb_animation_effect_open_btn == 'md-effect-1' ) {
									echo 'selected=selected';}
								?>
								><?php esc_html_e( 'Fade in &amp; Scale', 'modal-popup-box' ); ?></option>
								<option value="md-effect-2"
								<?php
								if ( $mpb_animation_effect_open_btn == 'md-effect-2' ) {
									echo 'selected=selected';}
								?>
								><?php esc_html_e( 'Slide in (right)', 'modal-popup-box' ); ?></option>
							</select>	
						</div>
					</div>
					<?php require_once 'animation-effect.php'; ?>
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e( 'Button Text', 'modal-popup-box' ); ?></h5>
							<p><?php esc_html_e( 'Set any text which will appear on button like Close Me', 'modal-popup-box' ); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if ( isset( $modal_popup_box_settings['mpb_button2_text'] ) ) {
								$mpb_button2_text = $modal_popup_box_settings['mpb_button2_text'];
							} else {
								$mpb_button2_text = 'Close Me';
							}
							?>
								
							<input type="text" class="selectbox_settings " id="mpb_button2_text" name="mpb_button2_text" value="<?php echo esc_html( $mpb_button2_text ); ?>" placeholder="Type Button Text">
						</div>
					</div>
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e( 'Modal Box Width', 'modal-popup-box' ); ?></h5>
							<p><?php esc_html_e( 'Set width of modal box', 'modal-popup-box' ); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4 range-slider">
							<?php
							if ( isset( $modal_popup_box_settings['mpb_width'] ) ) {
								$mpb_width = $modal_popup_box_settings['mpb_width'];
							} else {
								$mpb_width = 35;
							}
							?>
								
							<input id="mpb_width" name="mpb_width" class="range-slider__range" type="range" value="<?php echo esc_attr( $mpb_width ); ?>" min="15" max="100" step="5" style="width: 300px !important; margin-left: 10px;" default-color="<?php echo esc_attr( $mpb_width ); ?>">
							<span class="range-slider__value">0</span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e( 'Modal Box Height', 'modal-popup-box' ); ?></h5>
							<p><?php esc_html_e( 'Set height of modal box', 'modal-popup-box' ); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4 range-slider">
							<?php
							if ( isset( $modal_popup_box_settings['mpb_height'] ) ) {
								$mpb_height = $modal_popup_box_settings['mpb_height'];
							} else {
								$mpb_height = 350;
							}
							?>
								
							<input id="mpb_height" name="mpb_height" class="range-slider__range" type="range" value="<?php echo esc_attr( $mpb_height ); ?>" min="200" max="700" step="25" style="width: 300px !important; margin-left: 10px;" default-color="<?php echo esc_attr( $mpb_height ); ?>">
							<span class="range-slider__value">0</span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Disable Bootstrap Css', 'modal-popup-box'); ?></h5>
							<p><?php esc_html_e('You can disable bootstrap css for output if you have problem with it..', 'modal-popup-box'); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php if(isset($modal_popup_box_settings['mpb_bt_ds'])) $mpb_bt_ds = $modal_popup_box_settings['mpb_bt_ds']; else $mpb_bt_ds = "false"; ?>
								<input type="radio" name="mpb_bt_ds" id="mpb_bt_ds1" value="true" <?php if($mpb_bt_ds == "true") echo "checked=checked"; ?>>
								<label for="mpb_bt_ds1"><?php esc_html_e('True', 'modal-popup-box'); ?></label>
								<input type="radio" name="mpb_bt_ds" id="mpb_bt_ds2" value="false" <?php if($mpb_bt_ds == "false") echo "checked=checked"; ?>>
								<label for="mpb_bt_ds2"><?php esc_html_e('False', 'modal-popup-box'); ?></label>
							</p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="bhoechie-tab-content">
				<h1><?php esc_html_e( 'Custom CSS', 'modal-popup-box' ); ?></h1>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e( 'Custom CSS', 'modal-popup-box' ); ?></h5>
							<p><?php esc_html_e( 'Apply own css on video gallery and dont use style tag', 'modal-popup-box' ); ?></p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if ( isset( $modal_popup_box_settings['mpb_custom_css'] ) ) {
								$mpb_custom_css = $modal_popup_box_settings['mpb_custom_css'];
							} else {
								$mpb_custom_css = '';
							}
							?>
							<textarea name="mpb_custom_css" id="mpb_custom_css" style="width: 100%; height: 120px;" placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo $mpb_custom_css; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="bhoechie-tab-content">
				<h1><?php esc_html_e( 'Upgrade To Pro', 'modal-popup-box' ); ?></h1>
				<hr>
				<!--Grid-->
				<div class="" style="padding-left: 10px;">
					<p class="ms-title"><?php esc_html_e( 'Upgrade To Premium For Unloack More Features & Settings', 'modal-popup-box' ); ?></p>
				</div>

				<div class="">
					<h1><strong><?php esc_html_e( 'Offer:', 'modal-popup-box' ); ?></strong> <?php esc_html_e( 'Upgrade To Premium Just In Half Price ', 'modal-popup-box' ); ?><strike><?php esc_html_e( '$19.99', 'modal-popup-box' ); ?></strike> <strong><?php esc_html_e( '$ 9.99', 'modal-popup-box' ); ?></strong></h1>
					<br>
					<a href="https://awplife.com/wordpress-plugins/modal-popup-box-wordpress-plugin/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize"><?php esc_html_e( 'Premium Version Details', 'modal-popup-box' ); ?></a>
					<a href="https://awplife.com/demo/model-popup-box-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize"><?php esc_html_e( 'Check Live Demo', 'modal-popup-box' ); ?></a>
					<a href="https://awplife.com/demo/model-popup-box-premium/how-to-test-premium-plugin/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize"><?php esc_html_e( 'Try Pro Version', 'modal-popup-box' ); ?></a>
				</div>

			</div>
		</div>
	</div>	
<?php
// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
wp_nonce_field( 'mpb_save_settings', 'mpb_save_nonce' );
?>
</div>
<style>
.range-slider {
	width: 100% !important;
}
.ui-sortable-handle {
	font-size:18px !important;
}
.selectbox_settings {
	width: 300px;
} 
</style>

<script>
	//hide & show
	var mpb_show_modal = jQuery('[name=mpb_show_modal]:checked').val();
		if(mpb_show_modal == "onload") {
			jQuery('.MPB_onclick_section').hide();
		}
		if(mpb_show_modal == "onclick") {
			jQuery('.MPB_onclick_section').show();
		}
		
	//color-picker
	(function( jQuery ) {
		jQuery(function() {
			// Add Color Picker to all inputs that have 'color-field' class
			//Main Button Color
			
			jQuery('#mpb_main_button_color').wpColorPicker();
			jQuery('#mpb_main_button_text_color').wpColorPicker();				
		});
	})( jQuery );
	
	jQuery(document).ajaxComplete(function() {
		jQuery('#mpb_main_button_color,#mpb_main_button_text_color').wpColorPicker();
	});

	//range slider
	var rangeSlider = function(){
	  var slider = jQuery('.range-slider'),
		  range = jQuery('.range-slider__range'),
		  value = jQuery('.range-slider__value');
		
	  slider.each(function(){

		value.each(function(){
		  var value = jQuery(this).prev().attr('value');
		  jQuery(this).html(value);
		});

		range.on('input', function(){
		  jQuery(this).next(value).html(this.value);
		});
	  });
	};
	rangeSlider();	
	
	//dropdown toggle on change effect
	jQuery(document).ready(function() {
		//hide & show
		jQuery('input[type=radio][name=mpb_show_modal]').change(function() {
		var mpb_show_modal = jQuery('[name=mpb_show_modal]:checked').val();
		if(mpb_show_modal == "onload") {
			jQuery('.MPB_onclick_section').hide();
		}
		if(mpb_show_modal == "onclick") {
			jQuery('.MPB_onclick_section').show();
	}	
	});
	//accordion icon
	jQuery(function() {
		function toggleSign(e) {
			jQuery(e.target)
			.prev('.panel-heading')
			.find('i')
			.toggleClass('fa fa-chevron-down fa fa-chevron-up');
		}
		jQuery('#accordion').on('hidden.bs.collapse', toggleSign);
		jQuery('#accordion').on('shown.bs.collapse', toggleSign);

		});
	});
	
	// tab
	jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
		e.preventDefault();
		jQuery(this).siblings('a.active').removeClass("active");
		jQuery(this).addClass("active");
		var index = jQuery(this).index();
		jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
		jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
	});
</script>
