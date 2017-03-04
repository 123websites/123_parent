<section class="estimate popupcontainer">
	<i class="estimate-content-times fa fa-times popupcontainer-times"></i>
	<div class="estimate-content popup">
		<?php if(!empty(get_field('quickquote-image', 'option'))): ?>
		<div class="estimate-content-imagecontainer popup-imagecontainer">
			<img src="<?php echo get_field('quickquote-image', 'option'); ?>" class="estimate-content-imagecontainer-image popup-imagecontainer-image">
		</div>
		<?php endif; ?>
		<h1 class="estimate-content-header popup-header"><?php echo get_field('quickquote-header', 'option'); ?></h1>
		<div class="estimate-content-form">
			<?php echo do_shortcode('[gravityform id=2 title=false description=false ajax=true]'); ?>
		</div>
	</div>
</section>

<section class="pa popupcontainer">
	<i class="pa-content-times fa fa-times popupcontainer-times"></i>
	<div class="pa-content popup">
		<?php if(!empty(get_field('ad-image', 'option'))): ?>
		<div class="pa-content-imagecontainer popup-imagecontainer">
			<img src="<?php echo get_field('ad-image', 'option'); ?>" class="pa-content-imagecontainer-image popup-imagecontainer-image">
		</div>
		<?php endif; ?>
		<h1 class="pa-content-header popup-header"><?php echo get_field('ad-header', 'option'); ?></h1>
		<div class="pa-content-form">
			<?php echo do_shortcode('[gravityform id=3 title=false description=false ajax=true]'); ?>
		</div>
	</div>
</section>