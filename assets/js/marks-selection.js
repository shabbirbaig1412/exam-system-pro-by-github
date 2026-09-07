jQuery(function($){

let selecting=false;

$(document)

.on("mousedown",".esp-mark",function(){

selecting=true;

$(this).addClass("esp-selected");

})

.on("mouseenter",".esp-mark",function(){

if(selecting){

$(this).addClass("esp-selected");

}

});

$(document).mouseup(function(){

selecting=false;

});

});