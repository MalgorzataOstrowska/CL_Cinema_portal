jQuery(function(){
    console.log('HELLO WORLD :D');
    
    var LETER = jQuery('#letter'); 
    console.log(LETER);
    
    var RADIO_LETER = jQuery('#radio_letter'); 
    console.log(RADIO_LETER);    
    
    LETER.on('click',function(){
        console.log('click');
        RADIO_LETER.prop('checked', true);
    });   
    
    var RATING = jQuery('#rating'); 
    console.log(RATING);
    
    var RADIO_RATING = jQuery('#radio_rating'); 
    console.log(RADIO_RATING);    
    
    RATING.on('click',function(){
        console.log('click');
        RADIO_RATING.prop('checked', true);
    });   

});