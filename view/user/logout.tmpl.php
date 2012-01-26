    <section class="grid_2">
        <div class="with-margin">
            <a class="big button dark full-width" href="<?php eUrl('default','index'); ?>">Accueil</a>
        </div>
    </section>

    <section class="grid_4">
        <div class="with-big-margin">
            <a class="big button dark full-width" href="<?php eUrl('challenge','index'); ?>">Retour aux Challenges</a>
        </div>
    </section>

    <section class="grid_2">
        <div class="with-margin">
            <a class="big button pink full-width" href="<?php eUrl('user','index'); ?>"><?php echo $this->user ? 'Compte' : 'Login'; ?></a>
        </div>
    </section>
    </article>

    <article class="container_8 clearfix">
    <section class="grid_8">
    
    <?php if($this->user): ?>
        
        <form action="<?php eUrl('user','logout'); ?>" method="post">
            <button class="big red full-width">Logout</button>
        </form> 
        
    <?php else: ?>

        <h1>Logout Successfull</h1>
        
    <?php endif; ?>
    </section>
