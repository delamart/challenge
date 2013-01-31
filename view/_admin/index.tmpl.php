admin :: <a href="<?php eurl('_admin','info'); ?>">info</a> :: <a href="<?php eurl('_admin','db'); ?>">database</a>


Select one of the above menus.

- info        General information
- database    Database management interface. Update schema, backup data etc...

<?php foreach ($this->links as $label => $url) {
	echo '<a href="' . $url . '">' . $label . '</a> ';
}?>
