jQuery(function($){

$(document).on(

"keydown",

function(e){

if(e.ctrlKey && e.key==="s"){

e.preventDefault();

$("#esp_save_marks").trigger("click");

}

if(e.ctrlKey && e.key==="l"){

e.preventDefault();

$("#esp_load_marks").trigger("click");

}

});

});