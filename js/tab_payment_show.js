jQuery(function(){
    console.log('HELLO WORLD :D');
    
    var DATE = jQuery('#date'); 
    console.log(DATE);
    
    var RADIO_DATE = jQuery('#radio_date'); 
    console.log(RADIO_DATE);    
    
    DATE.on('click',function(){
        console.log('click');
        RADIO_DATE.prop('checked', true);
    });   
 
    
    
    var BEFORE = jQuery('#before'); 
    console.log(BEFORE);
    
    var RADIO_BEFORE = jQuery('#radio_before'); 
    console.log(RADIO_BEFORE);    
    
    BEFORE.on('click',function(){
        console.log('click');
        RADIO_BEFORE.prop('checked', true);
    });   
    
    
    
    var AFTER = jQuery('#after'); 
    console.log(AFTER);
    
    var RADIO_AFTER = jQuery('#radio_after'); 
    console.log(RADIO_AFTER);    
    
    AFTER.on('click',function(){
        console.log('click');
        RADIO_AFTER.prop('checked', true);
    });   
    
    
    
    var AFTER_BETWEEN = jQuery('#after_between'); 
    console.log(AFTER_BETWEEN);
    
    var BEFORE_BETWEEN = jQuery('#before_between'); 
    console.log(AFTER_BETWEEN);
    
    var RADIO_BETWEEN = jQuery('#radio_between'); 
    console.log(RADIO_AFTER);    
    
    AFTER_BETWEEN.on('click',function(){
        console.log('click');
        RADIO_BETWEEN.prop('checked', true);
    });   
    
    BEFORE_BETWEEN.on('click',function(){
        console.log('click');
        RADIO_BETWEEN.prop('checked', true);
    });   
    
  

});