jQuery(function($){

$("#esp-new-campus").on(

"click",

function(e){

e.preventDefault();

$("#esp-campus-modal")

.show();

});

$("#esp-save-campus").on(

"click",

function(){

$.post(

ajaxurl,

{

action:"esp_save_campus",

        _wpnonce:ESP.nonce,

name:$("#campus_name").val(),

code:$("#campus_code").val(),

address:$("#campus_address").val(),

phone:$("#campus_phone").val(),

email:$("#campus_email").val()

},

function(){

location.reload();

}

);

});

});
