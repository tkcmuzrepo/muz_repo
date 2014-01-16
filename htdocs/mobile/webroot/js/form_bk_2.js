$(function() {



var beforeinput;




$("input").focus( function () { 
  beforeinput='';
  console.log(beforeinput);
}); 


$("body").on("blur",　"input", function(e) {

  realvalidation($(this));

});


// $("body").on("keyup",　"input", function(e) {
$("body").on("keypress",　"input", function(e) {
// $("body").on("keydown",　"input", function(e) {

  var inputnow=$(this).val()
  var roootselector=$(this).parents('.roootselector');
  var error=0;

    // roootselector.remove();
    if(roootselector.hasClass("validate_email")){
       // console.log('ok');
     }





// value.match(/[^0-9]+/))
// 数字のみのバリデーション
// validate_numbe

// if(inputnow.match(/[^0-9]+/)){
//    console.log('数字以外の文字が入力されました');
//    $(this).val(beforeinput);
//    error=1;
// }



// アルファベットのみのバリデーション
// validate_alpha

// if(!inputnow.match( /^[a-zA-z¥s]+$/ )){
//    console.log('アルファベット以外の文字が入力されました');
//    $(this).val(beforeinput);
//    error=1;
// }


// 文字数のバリデーション
// validate_number_30
var validationnum=5;
var strlen =inputnow.length;

validationnum=$(this).attr("data_num");
// console.log(validationnum);



if(inputnow.match(/^[ぁ-ん]+$/)){
console.log('ひらがなです。');

var laststr=inputnow.charAt(strlen-1);
console.log(laststr);

}

if(strlen>validationnum){
   console.log('文字数がオーバーされました。');
   $(this).val(beforeinput);
   error=1;
}


if(error==0){
beforeinput=inputnow;
}
// console.log(beforeinput);


});



function realvalidation(item) {



    var inputnow=item.val()
    var roootselector=item.parents('.roootselector');
    var error=0;

    // roootselector.remove();
    if(roootselector.hasClass("validate_email")){
       // console.log('ok');
     }





// value.match(/[^0-9]+/))
// 数字のみのバリデーション
// validate_numbe

// if(inputnow.match(/[^0-9]+/)){
//    console.log('数字以外の文字が入力されました');
//    $(this).val(beforeinput);
//    error=1;
// }



// アルファベットのみのバリデーション
// validate_alpha

// if(!inputnow.match( /^[a-zA-z¥s]+$/ )){
//    console.log('アルファベット以外の文字が入力されました');
//    $(this).val(beforeinput);
//    error=1;
// }


// 文字数のバリデーション
// validate_number_30
var validationnum=5;
var strlen =inputnow.length;

validationnum=item.attr("data_num");
// console.log(validationnum);



if(inputnow.match(/^[ぁ-ん]+$/)){


var laststr=inputnow.charAt(strlen-1);
console.log(laststr);

}

if(strlen>validationnum){
   console.log('文字数がオーバーされました。');
   item.val(beforeinput);
   error=1;
}


if(error==0){
beforeinput=inputnow;
}
// console.log(beforeinput);
// 

}






$(".accepttable").find(".inputitem").each(function(){

    var h = $(this).height();
    var w = $(this).width();
    var mt = h  / 4; 

      $(this).css("padding-top", mt); 
      $(this).css("padding-bottom", mt); 

});







});
