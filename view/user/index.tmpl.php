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
        <div class="with-big-margin">
        <form action="<?php eUrl('user','index'); ?>" method="post" class="challenge-form" enctype="multipart/form-data">
            <h1>Mon Compte</h1>
            
            <?php if(count($this->errors)): ?>
            <div class="with-margin error">
                <ul>
                <?php foreach($this->errors as $error) echo "<li>$error</li>"; ?>    
                </ul>
            </div>
            <?php endif; ?>
            
            
            <fieldset class="with-margin">
                <div class="input-line with-margin">
                    <label for="name">Nom</label> 
                    <input id="name" type="text" name="name" value="<?php echo $this->user->name; ?>"/>
                </div>
                <div class="input-line double with-margin">
                    <label for="additional">Chien(s)</label> 
                    <textarea id="additional" name="additional" cols="22" rows="3"><?php echo $this->user->additional; ?></textarea>
                    <span class="help">Un nom par ligne</span>
                </div>
                <div class="input-line with-margin">
                    <label for="email">E-Mail</label> 
                    <input id="email" type="text" name="email" value="<?php echo $this->user->email; ?>" placeholder="me@mail.com"/> 
                </div>
                <?php if($this->user->password): ?>
                <div class="input-line with-margin">
                    <label for="password">Mot de Passe</label> 
                    <input id="password" type="password" name="password" value="" placeholder="******" /> 
                </div>
                <?php endif; ?>
                <div class="input-line with-margin">
                    <label for="site">Site</label> 
                    <input id="site" type="text" name="site" value="<?php echo $this->user->site; ?>" placeholder="http://www.example.com" /> 
                </div>
                <div class="input-line double with-margin">
                    <label for="avatar">Avatar</label> 
                    <input id="avatar" type="file" name="avatar" />
                    <?php if($this->user->avatar): ?>
                    <img src="<?php echo $this->user->avatar; ?>" class="thumb lightbox" alt="avatar" data-target="avatar-image" />
                    <img id="avatar-image" style="display:none;" src="<?php echo str_replace('-thumb', '', $this->user->avatar); ?>" alt="avatar" />
                    <?php endif; ?>
                </div>
            </fieldset>
            
            <button class="big button green full-width" type="submit">Sauvegarder les Changements</button>
        </form>
        </div>
                
        <form action="<?php eUrl('user','logout'); ?>" method="post">
            <button class="big red full-width">Logout</button>
        </form> 
        
    </section>
        
    <?php echo $this->extra ? '<script>alert('.json_encode($this->extra).');</script>' : ''; ?>
        