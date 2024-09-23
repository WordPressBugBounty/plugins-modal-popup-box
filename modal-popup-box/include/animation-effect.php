<div class="container-fluid">					
	<div class="col-md-12" >
		<div class="md-modal md-effect-1" id="modal-1">
			<div class="md-content">
				<h2 style="font-weight: bolder; color: #fff" class="text-center" ><?php esc_html_e( 'Modal Dialog', 'modal-popup-box' ); ?></h2>
				<div>
					<p style="font-weight: bolder;" ><?php esc_html_e( 'This is a modal window. You can do the following things with it:', 'modal-popup-box' ); ?></p>
					<ul>
						<li><strong><?php esc_html_e( 'Read:', 'modal-popup-box' ); ?></strong> <?php esc_html_e( 'modal windows will probably tell you something important so dont forget to read what they say', 'modal-popup-box' ); ?></li>
						<li><strong><?php esc_html_e( 'Look:', 'modal-popup-box' ); ?></strong> <?php esc_html_e( 'a modal window enjoys a certain kind of attention; just look at it and appreciate its presence', 'modal-popup-box' ); ?></li>
						<li><strong><?php esc_html_e( 'Close:', 'modal-popup-box' ); ?></strong> <?php esc_html_e( 'click on the button below to close the modal', 'modal-popup-box' ); ?></li>
					</ul>
					
					<div class="btn-default  btn-lg text-center md-close"><?php esc_html_e( 'Close me!', 'modal-popup-box' ); ?></div>
				</div>
			</div>
		</div>
		
		<div class="md-modal md-effect-2" id="modal-2">
			<div class="md-content">
				<h2 style="font-weight: bolder; color: #fff" class="text-center" ><?php esc_html_e( 'Modal Dialog', 'modal-popup-box' ); ?></h2>
				<div>
					<p style="font-weight: bolder;" ><?php esc_html_e( 'This is a modal window. You can do the following things with it:', 'modal-popup-box' ); ?></p>
					<ul>
						<li><strong><?php esc_html_e( 'Read:', 'modal-popup-box' ); ?></strong><?php esc_html_e( 'modal windows will probably tell you something important so dont forget to read what they say', 'modal-popup-box' ); ?></li>
						<li><strong><?php esc_html_e( 'Look:', 'modal-popup-box' ); ?></strong><?php esc_html_e( 'a modal window enjoys a certain kind of attention; just look at it and appreciate its presence', 'modal-popup-box' ); ?></li>
						<li><strong><?php esc_html_e( 'Close:', 'modal-popup-box' ); ?></strong><?php esc_html_e( 'click on the button below to close the modal', 'modal-popup-box' ); ?></li>
					</ul>
					<div class="btn-default  btn-lg text-center md-close"><?php esc_html_e( 'Close me!', 'modal-popup-box' ); ?></div>
				</div>
			</div>
		</div>
		
			<div class="col-md-5 md-trigger my_btn btn-default btn-lg text-center"  data-modal="modal-1"><?php esc_html_e( 'Fade in &amp; Scale', 'modal-popup-box' ); ?></div>
			<div class="col-md-5 md-trigger my_btn btn-default btn-lg text-center"  data-modal="modal-2"><?php esc_html_e( 'Slide in (right)', 'modal-popup-box' ); ?></div>
			<hr>
		<div class="md-overlay"></div><!-- the overlay element -->
	</div>	
</div><!-- /container -->
<style>
.col-md-5 {
	margin: 35px !important;
}
.my_btn{
	background-color:#0073AA !important;
	color:#FFFFFF !important;
}
#poststuff .stuffbox > h3, #poststuff h2, #poststuff h3.hndle {
	font-size : 30px;
}
.container-fluid {
	padding-left: 0px !important;
	padding-right: 0px !important;
	padding-bottom: 10px !important;
}
.btn-default{
	cursor:pointer !important;
}
</style>
