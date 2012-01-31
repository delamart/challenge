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
        
    <?php if(count($this->errors)): ?>
    <div class="with-margin error">
        <ul>
        <?php foreach($this->errors as $error) echo "<li>$error</li>"; ?>    
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php eUrl('user','create'); ?>" method="post" class="challenge-form" >            
        <h1>Nouveau Login Challenge</h1>
        <fieldset class="with-margin">
            <div class="input-line with-margin">
                <label for="email">E-Mail</label> 
                <input id="email" type="text" name="email" value="<?php echo $_POST['email']; ?>" placeholder="me@mail.com" /> 
            </div>
            <div class="input-line with-margin">
                <label for="password">Mot de Passe</label> 
                <input id="password" type="password" name="password" value="<?php echo $_POST['password']; ?>" placeholder="******" /> 
            </div>
        </fieldset>
            
            
        <button class="big button green full-width with-margin" type="submit" >Cr&eacute;er un nouveau compte</button>
    </form>
        
    </section>
