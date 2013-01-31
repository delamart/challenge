<a href="<?php eurl('_admin','index'); ?>">admin</a> :: database :: <a href="<?php eurl('_admin','db','info'); ?>">info</a> :: <a href="<?php eurl('_admin','db','backup'); ?>">backup</a> :: <a href="<?php eurl('_admin','db','upgrade'); ?>">upgrade</a> :: <a href="<?php eurl('_admin','db','downgrade'); ?>">downgrade</a>


<?php echo $this->result . "\n"; ?>

<?php foreach ($this->links as $label => $url) {
	echo '<a href="' . $url . '">' . $label . '</a> ';
}?>
