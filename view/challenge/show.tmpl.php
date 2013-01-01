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
    </article>

    <article class="container_8 clearfix">
    <section class="grid_8">
        <h1>
            Mon Challenge 
        </h1>
        <div class="challenge with-margin">            
            <img class="challenge-avatar" src="<?php eufix($this->getImage()); ?>" alt="avatar"/>            
            <div class="challenge-progress with-progress" data-percent="<?php echo min(array(100,max(array(1,round($this->challenge->total * 100 / $this->challenge->amount))))); ?>" ></div>
            <div class="challenge-amount"><?php echo $this->challenge->total ? $this->challenge->total : 0; ?> <small><?php echo $this->challenge->unit; ?></small></div>
            
            <p class="challenge-name">
                <?php if($this->challenge->user): ?>
                    <?php echo $this->challenge->user->getNameWithAdditionals(280); ?>                
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
        <div class="with-margin center">
        <?php $unit_a = $this->challenge->unit; ?>
        <?php $unit_d = $this->challenge->rythm_unit; ?>
        <button style="white-space: nowrap;" class="button left-button">
            <b>Fait</b>
            <?php echo $this->challenge->total.' '.$unit_a; ?> 
            en
            <?php echo $this->challenge->duration_done().' '.$unit_d; ?>
        </button>
        <button style="white-space: nowrap;" class="button middle-button">
            <b>Reste</b>
            <?php echo $this->challenge->amount_left().' '.$unit_a; ?>
            en
            <?php echo $this->challenge->duration_left().' '.$unit_d; ?>
        </button>
        <button style="white-space: nowrap;" class="button right-button <?php echo ($this->challenge->rythm_now() < $this->challenge->rythm) ? 'red' : 'green'; ?>">
            <b>Moyenne</b>
            <?php echo  $this->challenge->rythm_now().' '.$unit_a.'/'.$unit_d; ?>
        </button>
        </div>
    </section>

    <?php if(count($this->errors)): ?>
    <div class="with-margin grid_8 error">
        <ul>
        <?php foreach($this->errors as $error) echo "<li>$error</li>"; ?>    
        </ul>
    </div>
    <?php endif; ?>

    <section class="grid_8">
        <div class="with-margin">
        <?php if($this->challenge->total < $this->challenge->amount): ?>
            <form action="<?php eUrl('challenge','show',$this->id); ?>" method="post">
                <div class="challenge-result">
                    <input id="amount" type="text" name="amount" value="<?php ePost('amount',$this->challenge->rythm); ?>"  class="<?php eIsError('amount',$this->errors); ?> first" size="4" /> <?php echo $this->challenge->unit; ?>
                    &nbsp;&mdash;&nbsp;
                    <input id="date" type="text" name="date" value="<?php ePost('date',date('d-m-Y')); ?>"  class="<?php eIsError('date',$this->errors); ?> datepicker" size="12" data-max="+0d" />
                    <button class="green float-right" type="submit">Ajouter</button>
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
            <a class="button red float-right" href="<?php eUrl('result','delete',$id); ?>" onclick="return confirm('Are you sure ?');">Effacer</a>
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
    
