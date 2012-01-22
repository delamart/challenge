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

        <div class="with-big-margin">
        <form action="<?php eUrl('user','index'); ?>" method="post" class="challenge-form" enctype="multipart/form-data">
            <h1>Mon Compte</h1>
            <fieldset class="with-margin">
                <div class="input-line with-margin">
                    <label for="name">Nom</label> 
                    <input id="name" type="text" name="name" value="<?php echo $this->user->name; ?>"/>
                    <span class="help">Votre nom</span>
                </div>
                <div class="input-line double with-margin">
                    <label for="additional">Chien(s)</label> 
                    <textarea id="additional" name="additional" cols="22" rows="3"><?php echo $this->user->additional; ?></textarea>
                    <span class="help">Un nom par ligne</span>
                </div>
                <div class="input-line with-margin">
                    <label for="email">E-Mail</label> 
                    <input id="email" type="text" name="email" value="<?php echo $this->user->email; ?>" placeholder="me@mail.com"/> 
                    <span class="help">Votre addresse mail</span>
                </div>
                <div class="input-line with-margin">
                    <label for="site">Site</label> 
                    <input id="site" type="text" name="site" value="<?php echo $this->user->site; ?>" size="40" placeholder="http://www.example.com" /> 
                    <span class="help">Votre site internet</span>
                </div>
                <div class="input-line double with-margin">
                    <label for="avatar">Avatar</label> 
                    <input id="avatar" type="file" name="avatar" />
                    <?php if($this->user->avatar): ?>
                    <img src="<?php echo $this->user->avatar; ?>" class="thumb lightbox" alt="avatar" data-target="avatar-image" />
                    <img id="avatar-image" style="display:none;" src="<?php echo $this->user->avatar; ?>" alt="avatar" />
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