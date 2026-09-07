jQuery(function($){

$(document).on("click", "#esp-new-teacher,#esp-new-student,#esp-new-exam,.esp-add-class", function(e) {
    e.preventDefault();
    $("#esp-record-form").find("input[name=id]").val("");
    $("#esp-record-form")[0].scrollIntoView({behavior:"smooth", block:"start"});
});

$(document).on(

'submit',

'.esp-ajax-form',

function(e){

e.preventDefault();

let form=$(this);

$.post(

ESP.ajax,

form.serialize(),

function(res){

if(res.success){

location.reload();

}else{

alert('Operation failed.');

}

}

);

});

$(document).on(

'click',

'.esp-delete',

function(){

if(!confirm('Delete record?')){

return;

}

$.post(

ESP.ajax,

{

action:$(this).data('action'),

id:$(this).data('id'),

_wpnonce:ESP.nonce

},

function(){

location.reload();

}

);

});

$('.esp-mark-input').keydown(function(e){

if(e.key==='Enter'){

e.preventDefault();

let inputs=$('.esp-mark-input');

let i=inputs.index(this);

inputs.eq(i+1).focus().select();

}

});

});
