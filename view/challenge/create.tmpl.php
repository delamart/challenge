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
        
        <form action="<?php eUrl('challenge','create'); ?>" method="post" class="challenge-form">
            <h1>Nouveau Challenge</h1>
            <fieldset class="with-margin">
                <div class="input-line with-margin">
                    <label for="amount">But</label> 
                    <input id="amount" type="text" name="amount" />
                    <select id="unit" name="unit"><option value="km">Km</option><option value="mile">Mile(s)</option><option value="hour">Heure(s)</option><option value="course">Entra&icirc;nement(s)</option></select>
                    <span class="help">exemple: 365 Km</span>                    
                </div>
                <div class="input-line with-margin">
                    <label for="duration">Dur&eacute;e</label> 
                    <input id="duration" type="text" name="duration" /> 
                    <select id="duration_unit" name="duration_unit"><option value="year">Ann&eacute;e(s)</option><option value="month">Mois</option><option value="week">Semaine(s)</option><option value="day">Jour(s)</option></select> 
                    <span class="help">exemple: 365 Jour(s)</span>
                </div>
                <div class="input-line with-margin">
                    <label>Rythme des <abbr title="Mise &agrave; jour">m-&agrave;-j</abbr></label>
                    <label class="inline" for="rythmM">par mois</label> <input id="rythmM" class="inline" type="radio" name="rythm_unit" value="month" /> 
                    <label class="inline" for="rythmW">par semaine</label> <input id="rythmW" class="inline" type="radio" name="rythm_unit" value="week" /> 
                    <label class="inline" for="rythmD">par jour</label> <input id="rythmD" class="inline" type="radio" name="rythm_unit" value="day" checked="checked" /> 
                </div>
            </fieldset>
            
            <button class="big button green full-width" type="submit">Cr&eacute;er ce nouveau Challenge</button>
        </form>
        
    </section>
    