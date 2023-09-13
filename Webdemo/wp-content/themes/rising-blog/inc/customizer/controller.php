<?php
/**
 * Customizer custom controls
 */


if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class Rising_Blog_Customizer_Custom_Padding extends WP_Customize_Control {

	public $type = 'custom_padding';
	

	public function render_content() { 
			$label = $this->label ;
		?>
		
		<label class="customizer-bottom-top">
			<?php if ( ! empty( $label['main_label'] ) ) { ?>
				<span class="customize-control-title"><?php echo esc_html( $label['main_label'] ) ?></span>
			<?php } ?>
			<?php if ( !empty( $this->description ) ) { ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ) ?></span>
			<?php } ?>
			<div>
				<div class="setting_top_padding">
					<?php echo esc_html( $label['setting_top_padding_label'] ) ?><br/>
					<input  type="number"  value="<?php echo ( $this->link('setting_top_padding') ) ?>" <?php echo ( $this->link('setting_top_padding') ) ?> />
				</div>
				<div class="setting_right_padding">
					<?php echo esc_html( $label['setting_right_padding_label'] ) ?><br/>
					<input  type="number"  value="<?php echo esc_attr( $this->value('setting_right_padding') ) ?>" <?php echo ( $this->link('setting_right_padding') ) ?> />
				</div>
				<div class="setting_bottom_padding">
					<?php echo esc_html( $label['setting_bottom_padding_label'] ) ?><br/>
					<input  type="number"  value="<?php echo esc_attr( $this->value('setting_bottom_padding') ) ?>" <?php echo ( $this->link('setting_bottom_padding') ) ?> />
				</div>
				<div class="setting_left_padding">
					<?php echo esc_html( $label['setting_left_padding_label'] ) ?><br/>
					<input  type="number"  value="<?php echo esc_attr( $this->value('setting_left_padding') ) ?>" <?php echo ( $this->link('setting_left_padding') ) ?> />
				</div>
				
			</div>
		</label>
		<?php 
			if ( isset( $_POST['reset'] ) ) {
				remove_theme_mod( $label['reset_1'] ); 
				remove_theme_mod( $label['reset_2'] );
		}				
	}
}