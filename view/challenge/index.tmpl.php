        <section class="grid_2 prefix_2">
        <div class="with-margin">
            <a class="big button dark full-width" href="<?php eUrl('default','index'); ?>">Accueil</a>
        </div>
    </section>

    <section class="grid_4">
        <div class="with-big-margin">
            <a class="big button pink full-width" href="<?php eUrl('challenge','create'); ?>">Nouveau Challenge</a>
        </div>
    </section>

    <section class="grid_2 suffix_2">
        <div class="with-margin">
            <a class="big button dark full-width" href="<?php eUrl('user','index'); ?>"><?php echo $this->user ? 'Compte' : 'Login'; ?></a>
        </div>
    </section>

    <section class="grid_8 prefix_2 suffix_2">
    <?php if(count($this->challenges) == 0): ?><h1>0 Challenges</h1><?php endif; ?>
    <?php foreach($this->challenges as $id => /*@var $challenge ChallengeModel*/ $challenge): ?>
        <div class="challenge with-margin">            
            <img class="challenge-avatar" src="<?php echo $challenge->user->avatar; ?>" alt="avatar"/>                        
            <div class="challenge-progress"></div>
            <div class="challenge-amount"><?php echo $challenge->total ? $challenge->total : 0; ?> <small><?php echo $challenge->unit; ?></small></div>
            
            <p class="challenge-name">
                <?php if($challenge->user): ?>
                    <?php if($this->user == $challenge->user) { echo '<a href="' . url('user','index') . '">'; } ?>
                    <?php echo $challenge->user->name; ?> <?php echo $challenge->user->getAdditionals() ? '&amp; ' . $challenge->user->getAdditionals() : ''; ?>
                    <?php if($this->user == $challenge->user) { echo '</a>'; } ?>
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
    </section>
    
    