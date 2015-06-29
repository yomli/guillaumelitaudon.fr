<!--[if IE 8]><style>input[type="checkbox"]{padding:0;}</style><![endif]-->
<form action="index.php" method="post" id="login-form">
	<fieldset>
		<?php if(!empty($_['redirect'])) { echo '<input type="hidden" name="redirect_url" value="'.$_['redirect'].'" />'; } ?>
		<?php if($_['error']): ?>
			<a href="./core/lostpassword/"><?php echo $l->t('Lost your password?'); ?></a>
		<?php endif; ?>
		<p class="infield jacques">
			<label for="user" class="infield"><?php echo $l->t( 'Username' ); ?></label>
			<input type="text" name="user" id="user" class="jacques" value="<?php echo !empty($_POST['user'])?htmlentities($_POST['user']).'"':'" autofocus'; ?> autocomplete="off" required />
		</p>
		<p class="infield">
			<label for="password" class="infield jacques"><?php echo $l->t( 'Password' ); ?></label>
			<input type="password" name="password" id="password" class="jacques" value="" required <?php echo !empty($_POST['user'])?'autofocus':''; ?> />
			<input type="hidden" name="sectoken" id="sectoken" value="<?php echo($_['sectoken']); ?>"  />
		</p>
		<input type="checkbox" name="remember_login" value="1" id="remember_login" /><label for="remember_login" class="jacques" id="label_remember"><?php echo $l->t('remember'); ?></label>
		<input type="submit" id="submit"  class="login jacques" value="<?php echo $l->t( 'Log in' ); ?>" />
	</fieldset>
</form>
