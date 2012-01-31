</article>

<footer class="clearfix">
    <div class="copyright">&copy;2011-<?php echo date('Y')?> &ndash; <a href="http://www.baikasblog.com">Baika's blog</a> &ndash; <a target="_blank" href="http://challenge.baikasblog.com">Nouvelle Fen&ecirc;tre</a></div>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php eUfix('js/libs/jquery-1.7.1.min.js'); ?>"><\/script>')</script>

<script src="<?php eUfix('js/libs/jCProgress-1.0.2.js'); ?>"></script>
<script src="<?php eUfix('js/libs/jquery.lightbox_me.js'); ?>"></script>
<script src="<?php eUfix('js/libs/jquery-ui-1.8.17.custom.min.js'); ?>"></script>
<script src="<?php eUfix('js/libs/popuplib.js'); ?>"></script>

<script src="<?php eUfix('js/script.js'); ?>"></script>
<?php if($this->analytics): ?>
<script>
	var _gaq=[['_setAccount','<?php echo $this->analytics; ?>'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->

</body>
</html>