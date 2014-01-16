$(function() {


var beforeinput;
// validation();



$("body").on("blur",　"input", function(e) {
  realvalidation($(this));
});



$("body").on("keypress",　"input", function(e) {
  // realvalidation($(this));
  
    if (e.keyCode == 13) {
     console.log('シフト');
     realvalidation($(this));
  }

});



// $("body").on("change",　"input", function(e) {
//   realvalidation($(this));
// });


$("body").on("keyup",　"input", function(e) {

realvalidation($(this));
// alert(e.keyCode);


  // console.log(e.keyCode);


  // var inputnow=$(this).val();

  // if(inputnow.match(/^[ぁ-ん]+$/)){
  //    console.log('ひらがな');
  //   if (e.keyCode == 13) {
  //     console.log('IME確定');
  //     realvalidation($(this));
  //   }
  // }else{  
  //   if (e.keyCode == 32) {
  //   }else{
  //     realvalidation($(this));
  //   }
  // }


  // if (e.keyCode == 32) {
  //   realvalidation($(this));
  // }else{
  //   realvalidation($(this));

  // }




  // if (e.keyCode == 13) {
  //   console.log('IME確定');
  //   realvalidation($(this));
  // }

});










function realvalidation(item) {

  var inputnow=item.val()
  var strlen =inputnow.length;
  var roootselector=item.parents('.roootselector');
  var error=0;

  // roootselector.remove();
  if(roootselector.hasClass("validate_email")){
  // console.log('ok');
  }



// value.match(/[^0-9]+/))
// 数字のみのバリデーション
// validate_numbe


if(item.hasClass("validate_numbe")){
  // if(inputnow.match(/[^0-9]+/)){
  //    console.log('数字以外の文字が入力されました');
  //    item.val(beforeinput);

  //   if(strlen==0){item.val('');}
  //    error=1;
  // }
}



// アルファベットのみのバリデーション
// validate_alpha
if(item.hasClass("validate_alpha")){
  if(!inputnow.match( /^[a-zA-z¥s]+$/ )){
     console.log('アルファベット以外の文字が入力されました');
     item.val(beforeinput);

     if(strlen==1){item.val('');}
     error=1;
  }
}



// 文字数のバリデーション
// validate_number_30
if(item.hasClass("validate_number")){

    if(inputnow.match(/[^0-9]+/)){
     console.log('数字以外の文字が入力されました');
     item.val(beforeinput);

    if(strlen==0){item.val('');}
     error=1;
    }

    var validationnum=item.attr("data_num");
    if(strlen>validationnum){
       console.log('文字数がオーバーされました');
       item.val(beforeinput);
       error=1;
    }


}


if(error==0){
beforeinput=inputnow;
}

}






$("body").on("click",　".formbottomright", function(e){
  validation();
});








function validation() {

var error='';
$( "input").each(function() {

  var thisselector=$(this);
  var thisselectorinput=$(this).val();
  var thisselectorinputlength=thisselectorinput.length;
  var title=thisselector.attr('data_title');
  var limitnum=thisselector.attr('data_num');

  // 初期化
  thisselector.css("border","solid 2px #C9DBE6");


    if(thisselector.hasClass("required")){
       if(thisselectorinput == ''){
        error=error+title+'の値を入力してください \n';
        thisselector.css("border","solid 2px #EA5A4B");
       }    
    }


    if(thisselector.hasClass("validate_number_test")){
      if(thisselectorinputlength > limitnum){
        error=error+title+'は'+limitnum+'文字以内で入力してください\n';
      }
    }

    if(thisselector.hasClass("inputemail")){
      if(thisselectorinput.match(/.+@.+\..+/)==null){
        error=error+title+'に正しいメールアドレスを入力してください。\n';
      }
    }

});


console.log(error);
if(!error==""){
  alert(error);

  $("html,body").animate({scrollTop:0}, 1000);
  return false;


}

return true;
}







$(".accepttable").find(".inputitem").each(function(){

    var h = $(this).height();
    var w = $(this).width();
    var mt = h  / 3; 

    $(this).css("padding-top", mt); 
    $(this).css("padding-bottom", mt); 
});

$( ".inputitemname").each(function() {
    var inputitemlength=$(this).text().replace(/\s+/g,'').length;
      if(inputitemlength > 20){
        $(this).css("font-size",'12px'); 
      }
});








});
