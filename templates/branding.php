<div class="row">
	<div class="col-sm-4">
		<img src="<?php print plugin_dir_url(__DIR__);?>/img/fq-logo.jpg" class="img-responsive">
	</div>
	<div class="col-sm-8">
		<h3>Contact Us</h3>
		<p>Any questions or concerns with your site? Contact us below.</p>
		
		<div class="form-group">
			
			<?php if (!empty($contact == 'tony')): ?>
				<h4>Tony Figoli</h4>
			<?php elseif ($contact == 'bob'): ?>
				<h4>Bob Passaro</h4>
			<?php elseif ($contact == 'steven'): ?>
				<h4>Steven Quinn</h4>
			<?php endif;?>
			
			<label class="control-label">E-mail</label>
			<?php if (!empty($contact == 'tony')): ?>
				<p><a href="mailto:tony@figoliquinn.com"><?php print $contact;?>@figoliquinn.com</a></p>
			<?php else: ?>
				<p><a href="mailto:info@figoliquinn.com">info@figoliquinn.com</a></p>
			<?php endif;?>
			
		</div>	

	</div>
</div>