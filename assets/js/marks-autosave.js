jQuery(function($){

let timer=null;

$(document).on(

"input",

".esp-mark",

function(){

clearTimeout(timer);

timer=setTimeout(function(){

$("#esp_save_marks")

.trigger("click");

},1000);

});

});