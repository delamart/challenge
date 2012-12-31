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
        <?php if($this->user): ?>
            <a class="big button pink full-width" href="<?php eUrl('user','index'); ?>">Compte</a>
        <?php elseif($this->type == 'challenge'): ?>
            <a class="big button pink full-width" href="<?php eUrl('user','login'); ?>">Choisir</a>
        <?php else: ?>
            <a class="big button pink full-width" href="<?php eUrl('user','login'); ?>">Login</a>
        <?php endif; ?>
        </div>
    </section>
    </article>

    <article class="container_8 clearfix">
    <section class="grid_8">
        
    <?php if($this->user): ?>
        <h1>
        Login Successfull as
        <?php echo $this->user->name; ?>
        </h1>
    <?php elseif($this->type == 'challenge'): ?>
        
        <?php if(count($this->errors)): ?>
        <div class="with-margin error">
            <ul>
            <?php foreach($this->errors as $error) echo "<li>$error</li>"; ?>    
            </ul>
        </div>
        <?php endif; ?>
                
        <form action="<?php eUrl('user','login','challenge'); ?>" method="post" class="challenge-form" >            
            <h1>Login Challenge</h1>
            <fieldset class="with-margin">
                <div class="input-line with-margin">
                    <label for="email">E-Mail</label> 
                    <input id="email" type="text" name="email" value="<?php echo ePost('email'); ?>" placeholder="me@mail.com"/> 
                </div>
                <div class="input-line with-margin">
                    <label for="password">Mot de Passe</label> 
                    <input id="password" type="password" name="password" value="<?php echo ePost('password'); ?>" placeholder="******" /> 
                </div>
            </fieldset>
            
            <button class="big button pink full-width with-margin" type="submit">Login</button>
            
            <button class="big button green full-width with-margin" type="submit" onclick="this.form.action = '<?php json_encode(eUrl('user','create')); ?>'; return true;" >Cr&eacute;er un nouveau compte</button>
        </form>
        
    <?php else: ?>

        <h1>Choisissez une m&eacute;thode de login</h1>
        <!-- TODO: fix google login
        <form action="<?php eUrl('user','login','google'); ?>" method="post" class="with-margin">
            <button type="submit" class="pink big full-width">Login avec Google</button>
        </form> 
		-->
        <a href="<?php eUrl('user','login','challenge'); ?>" class="button full-width pink big with-margin">Login avec un compte Challenge</a>
        
        <a href="<?php eUrl('user','create'); ?>" class="button full-width green big with-margin">Cr&eacute;er un compte Challenge</a>
        
    <?php endif; ?>
    </section>
