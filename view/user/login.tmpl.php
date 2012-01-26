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

    <section class="grid_8">
        
    <?php if($this->user): ?>
        <h1>
        Login Successfull as
        <?php echo $this->user->name; ?>
        </h1>
    <?php else: ?>

        <h1>Choisissez une m&eacute;thode de login</h1>
                
        <form action="<?php eUrl('user','login'); ?>" method="post" target="_blank">
            <button class="pink big full-width">Login avec Google</button>
        </form> 
        
    <?php endif; ?>
    </section>
