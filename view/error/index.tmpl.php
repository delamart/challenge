<section class="grid_8">
<h1>Sorry there was an error</h1>
<div>
    <strong><?php echo $this->message; ?></strong>
</div>

<div>
    <pre>
<?php echo $this->trace; ?>

    </pre>
</div>

<button class="big dark full-width" onclick="window.history.back()">Back</button>

</section>
