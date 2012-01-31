
$(document).ready(function(){
    
    $('.challenge-progress.with-progress').each(function() {
        var el = $(this);        
        var percent = el.attr('data-percent');
        var opts = {
            img1: window.absolute_url + 'img/progress-parts-1.png',
            img2: window.absolute_url + 'img/progress-parts-2.png',
            speed: 1,
            stop: 0,
            limit: percent,
            PIStep : 0.01,
            showPercent : false,
            onInit: function(){console.log('init');},
            onProgress: function(p){ },
            onComplete: function(p){ }
        };
        el.cprogress(opts);
    });
    
    $('.lightbox').click(function(e) {
        var el = $(this);
        var id = el.attr('data-target');
        $('#' + id).lightbox_me({centered: true});        
        e.preventDefault();
    }).css('cursor', 'pointer');    
    
    $('.datepicker').each(function() {
        var el = $(this);
        var max = el.attr('data-max');
        var min = el.attr('data-min');
        var opts = {inline: true, dateFormat: 'dd-mm-yy'};
        if(max) { opts['maxDate'] = max; }
        if(min) { opts['minDate'] = min; }
        el.datepicker(opts);
    });
    
    var googleOpener = popupManager.createOpener({});    
    
});