jQuery(function($){

$("#esp-save-school").on(

"click",

function(e){

e.preventDefault();

$.post(

ajaxurl,

$("#esp-school-settings").serialize()+

"&action=esp_save_school_settings"+

"&_wpnonce="+ESP.nonce,

function(){

alert("School settings saved.");

}

);

});

});
