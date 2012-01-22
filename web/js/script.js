
$(document).ready(function(){

    options = {
           img1: window.absolute_url + 'img/progress-parts-1.png',
           img2: window.absolute_url + 'img/progress-parts-2.png',
           speed: 1,
           stop: 0,
           limit: 10,
           PIStep : 0.01,
           showPercent : false,
           onInit: function(){console.log('init');},
           onProgress: function(p){ },
           onComplete: function(p){ }

          };
    
    $('.challenge-progress.with-progress').cprogress(options);
    
    $('.lightbox').click(function(e) {
        var el = $(this);
        var id = $(this).attr('data-target');
        $('#' + id).lightbox_me({centered: true});        
        e.preventDefault();
    }).css('cursor', 'pointer');    
    
    $('.datepicker').datepicker({ inline: true });    
    
});