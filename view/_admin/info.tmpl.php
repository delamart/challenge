<a href="<?php eurl('_admin','index'); ?>">admin</a> :: info


<?php echo $this->result . "\n"; ?>

<?php foreach ($this->links as $label => $url) {
	echo '<a href="' . $url . '">' . $label . '</a> ';
}?>
