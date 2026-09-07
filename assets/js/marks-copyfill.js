jQuery(function($){

let copied="";

$(document).on(

"copy",

".esp-mark",

function(){

copied=$(this).val();

});

$(document).on(

"keydown",

".esp-mark",

function(e){

if(e.ctrlKey && e.key==="d"){

e.preventDefault();

let row=$(this).closest("tr");

let col=$(this).closest("td").index();

row.nextAll().each(function(){

$(this)

.children()

.eq(col)

.find(".esp-mark")

.val(copied)

.trigger("change");

});

}

});

});