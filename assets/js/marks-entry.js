jQuery(function($){

const table=$("#esp_marks_table");

$(document).on(

"keydown",

".esp-mark",

function(e){

if(e.key==="Enter"){

e.preventDefault();

let td=$(this).closest("td");

let row=td.parent();

let col=td.index();

let next=row.next();

if(next.length){

next.children()

.eq(col)

.find("input")

.focus()

.select();

}

}

});

});