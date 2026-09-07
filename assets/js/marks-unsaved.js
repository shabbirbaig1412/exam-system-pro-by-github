jQuery(function($){

let dirty=false;

$(document).on(

"change input",

".esp-mark",

function(){

dirty=true;

});

window.addEventListener(

"beforeunload",

function(e){

if(!dirty){

return;

}

e.preventDefault();

e.returnValue='';

});

$("#esp_save_marks").on(

"click",

function(){

dirty=false;

});

});