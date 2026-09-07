jQuery(function($){

$("#esp_student_search").on(

"keyup",

function(){

let value=$(this).val().toLowerCase();

$("#esp_marks_table tbody tr").each(function(){

$(this).toggle(

$(this).text().toLowerCase()

.indexOf(value)>-1

);

});

});

});