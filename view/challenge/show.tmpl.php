    <section class="grid_2">
        <div class="with-margin">
            <a class="big button dark full-width" href="<?php eUrl('default','index'); ?>">Accueil</a>
        </div>
    </section>

    <section class="grid_4">
        <div class="with-big-margin">
            <a class="big button pink full-width" href="<?php eUrl('challenge','index'); ?>">Retour aux Challenges</a>
        </div>
    </section>

    <section class="grid_2">
        <div class="with-margin">
            <a class="big button dark full-width" href="<?php eUrl('user','index'); ?>"><?php echo $this->user ? 'Compte' : 'Login'; ?></a>
        </div>
    </section>

    <section class="grid_8">
        <div class="challenge with-margin">            
            <img class="challenge-avatar" src="<?php echo $this->challenge->user->avatar; ?>" alt="avatar"/>                        
            <div class="challenge-progress with-progress"></div>
            <div class="challenge-amount"><?php echo $this->challenge->total ? $this->challenge->total : 0; ?> <small><?php echo $this->challenge->unit; ?></small></div>
            
            <p class="challenge-name">
                <?php if($this->challenge->user): ?>
                    <?php echo $this->challenge->user->name; ?> <?php echo $this->challenge->user->getAdditionals() ? '&amp; ' . $this->challenge->user->getAdditionals() : ''; ?>
                <?php else: ?>
                    none
                <?php endif; ?>
            </p>
            <p class="challenge-description">
                <em><?php echo $this->challenge->amount; ?></em> <?php echo $this->challenge->unit; ?> en <em><?php echo $this->challenge->duration; ?></em> <?php echo $this->challenge->duration_unit; ?>
            </p>
            <p class="challenge-rythm">
                <em><?php echo $this->challenge->rythm; ?></em> <?php echo $this->challenge->unit; ?> / <?php echo $this->challenge->rythm_unit; ?>
            </p>            
        </div>        
    </section>
    
    <section class="grid_8">
        <div class="with-margin">
        <?php if($this->challenge->total < $this->challenge->amount): ?>
            <form action="<?php eUrl('challenge','show',$this->id); ?>" method="post">
                <div class="challenge-result">
                    <input id="amount" type="text" name="amount" value="<?php echo $this->challenge->rythm; ?>" size="4" /> <?php echo $this->challenge->unit; ?>
                    &mdash; Aujourd'hui
                    <button class="green" type="submit">Ajouter</button>
                </div>
            </form>
        <?php else: ?>
            <h1>Challenge R&eacute;ussi</h1>
        <?php endif; ?>            
        </div>
    </section>    
    
    <section class="grid_8">
    <?php foreach($this->results as $id => $result): ?>
        <div class="with-margin challenge-result">
            <strong><?php echo $result->amount; ?></strong>
            <?php echo $this->challenge->unit; ?> &mdash;
            <em><?php echo $result->date('l d / m / Y'); ?></em>
            <a class="button red" href="<?php eUrl('result','delete',$id); ?>" onclick="return confirm('Are you sure ?');">Effacer</a>
            <a class="button dark" href="<?php eUrl('result','edit',$id); ?>" >Editer</a>
        </div>
    <?php endforeach; ?>    
    </section>
    
    <section class="grid_8">
        <div class="with-margin">
            <a class="big button red full-width" href="<?php eUrl('challenge','delete',$this->id); ?>" onclick="return confirm('Are you sure ?');">
                Effacer ce Challenge
            </a>
        </div>
    </secion>
    
