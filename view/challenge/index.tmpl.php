        <section class="grid_2">
        <div class="with-margin">
            <a class="big button dark full-width" href="<?php eUrl('default','index'); ?>">Accueil</a>
        </div>
    </section>

    <section class="grid_4">
        <div class="with-big-margin">
            <?php if($this->mine): ?>
            <a class="big button pink full-width" href="<?php eUrl('challenge','show',$this->mine); ?>">Mon Challenge</a>
            <?php else: ?>
            <a class="big button green full-width" href="<?php eUrl('challenge','create'); ?>">Nouveau Challenge</a>
            <?php endif; ?>
        </div>
    </section>

    <section class="grid_2">
        <div class="with-margin">
            <a class="big button dark full-width" href="<?php eUrl('user','index'); ?>"><?php echo $this->user ? 'Compte' : 'Login'; ?></a>
        </div>
    </section>
    </article>

    <article class="container_8 clearfix">
    <section class="grid_8">  
    <?php if(count($this->challenges) == 0): ?>
        <h1>0 Challenges trouv&eacute;</h1>
    <?php else: ?>
    <?php foreach($this->challenges as $id => /*@var $challenge ChallengeModel*/ $challenge): ?>        
        <div class="challenge with-margin">            
            <img class="challenge-avatar" src="<?php echo $challenge->user->avatar ? $challenge->user->avatar : ufix($this->default_avatar_img); ?>" alt="avatar"/>                        
            <div class="challenge-progress"></div>
            <div class="challenge-amount"><?php echo $challenge->total ? $challenge->total : 0; ?> <small><?php echo $challenge->unit; ?></small></div>
            
            <p class="challenge-name">
                <?php if($challenge->user): ?>
                    <?php if($challenge->user->site) { printf('<a target="_parent" href="%s" title="%s">',(substr($challenge->user->site,0,7) == 'http://' ? '' : 'http://') . $challenge->user->site,$challenge->user->site); } ?>
                    <?php echo $challenge->user->getNameWithAdditionals(280); ?>
                    <?php if($challenge->user->site) { echo '</a>'; } ?>
                <?php else: ?>
                    none
                <?php endif; ?>
            </p>
            <p class="challenge-description">
                <em><?php echo $challenge->amount; ?></em> <?php echo $challenge->unit; ?> en <em><?php echo $challenge->duration; ?></em> <?php echo $challenge->duration_unit; ?>
            </p>
            <p class="challenge-rythm">
                <em><?php echo $challenge->rythm; ?></em> <?php echo $challenge->unit; ?> / <?php echo $challenge->rythm_unit; ?>
                
                <?php if($this->user && $challenge->user && $this->user->id == $challenge->user->id): ?><a class="button small pink" href="<?php eUrl('challenge','show',$id); ?>"><?php if($challenge->total < $challenge->amount) echo 'Mise &agrave; Jour'; else echo 'R&eacute;ussi'; ?></a><?php endif; ?>
            </p>            
        </div>        
    <?php endforeach; ?>
    <?php endif; ?>
    </section>
    
    
