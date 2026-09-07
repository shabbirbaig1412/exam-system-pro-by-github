jQuery(function($){

$(document).on(

"keyup change",

".esp-mark",

function(){

let row=$(this).closest("tr");

let total=0;

row.find(".esp-mark")

.each(function(){

total+=

parseFloat(

$(this).val()

)||0;

});

row.find(".esp-total")

.text(total.toFixed(2));

});

});