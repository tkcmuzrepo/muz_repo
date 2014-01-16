$(function() {


var beforeinput;

$("body").on("click",　"input", function(e) {
   beforeinputCLear($(this));
});
$("body").on("click",　"textarea", function(e) {
   beforeinputCLear($(this));
});
$("body").on("blur",　"input", function(e) {
  realvalidation($(this));
});
$("body").on("blur",　"textarea", function(e) {
  realvalidation($(this));
});
$("body").on("click", "#formsubmit", function(e){
  validation();
});
$("body").on("blur",　".post_1", function(e) {
  postcode();
});
$("body").on("blur",　".post_2", function(e) {
  postcode();
});



function postcode() {

  var post_1=$(".post_1").val();
  var post_2=$(".post_2").val();
  var prefscode = {
    '北海道': 1,'青森県': 2,'岩手県': 3, '宮城県': 4, '秋田県': 5, '山形県': 6, '福島県': 7,
    '茨城県': 8, '栃木県': 9, '群馬県': 10, '埼玉県': 11, '千葉県': 12, '東京都': 13, '神奈川県': 14,
    '新潟県': 15, '富山県': 16, '石川県': 17, '福井県': 18, '山梨県': 19, '長野県': 20, '岐阜県': 21,
    '静岡県': 22, '愛知県': 23, '三重県': 24, '滋賀県': 25, '京都府': 26, '大阪府': 27, '兵庫県': 28,
    '奈良県': 15, '和歌山県': 15, '鳥取県': 15, '島根県': 15, '岡山県': 15, '広島県': 15, '山口県': 15,
    '徳島県': 29, '香川県': 30, '愛媛県': 31, '高知県': 32, '福岡県': 33, '佐賀県': 34, '長崎県': 35,
    '熊本県': 36, '大分県': 37, '宮崎県': 38, '鹿児島県': 39, '沖縄県':40
  };

  if(post_1){
     if(post_2){
          postcodeinput=post_1+post_2;
          zip2address(postcodeinput, function(address) {
              if (address) {
                  $(".addressinput").val(address.city); 
                  $(".addressselect").val(prefscode[address.pref]);
              }
          });
    }
  }
}



function beforeinputCLear(item) {

   var inputnow=item.val()
   if(inputnow==""){
    beforeinput="";
  }
}



function realvalidation(item) {

  var inputnow=item.val()
  var strlen =inputnow.length;
  var error=0;


    // 数字のみのバリデーション
    // validate_numbe
    if(item.hasClass("validate_number")){
      if(inputnow.match(/[^0-9]+/)){
         console.log('数字以外の文字が入力されました');
         item.val(beforeinput);

        if(strlen==0){item.val('');}
         error=1;
      }
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
    if(item.hasClass("validate_characterlimit")){

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


function validation() {


  var error='';
  var toparray=Array();

  termmchk = $(".termmchk").attr("checked");
  if(termmchk=='checked'){}else{
    alert('会員規約に同意してください');
    return
  }

  $( "input").each(function() {
    validationitem($(this));
  });

  $( "textarea").each(function() {
    validationitem($(this));
  });

  $( "select").each(function() {
    validationitem($(this));
  });

  $( ".validate_checkbox_radio").each(function() {
    validationitem($(this));
  });


    function validationitem(thisselector) {

      var thisselectorinput=thisselector.val();
      var thisselectorinputlength=thisselectorinput.length;
      var title=thisselector.attr('data_title');
      var limitnum=thisselector.attr('data_num');

      // ボーダー初期化
      thisselector.css("border","solid 2px #C9DBE6");

        if(thisselector.hasClass("validate_required")){
           if(thisselectorinput == ''){
              error=error+title+'の値を入力してください \n';
              thisselector.css("border","solid 1px #EA5A4B");
              toparray.push(thisselector.offset().top);
           } 

           // selectの場合
           if(thisselector.context.nodeName=='SELECT'){
            if(thisselectorinput == '-'){
                 thisselector.css("border","solid 1px #EA5A4B");
                 error=error+title+'の値をセレクトしてください \n';
                 toparray.push(thisselector.offset().top);
             }
           }

          }


        // checkbox
       if(thisselector.hasClass("validate_checkbox_radio")){

            thisselector.css("border","none");
            thisselector.css("color","#4794CE");

            var thisselectorName;
            var checkboxFlg=false;

                $( "input",thisselector).each(function() {
                  thisselectorName=$(this).context.name;
                }); 

                $("*[name="+thisselectorName+"]").each(function() {
                      if($(this).attr("checked")=='checked'){
                          checkboxFlg=true;
                      }
                });

                if(!checkboxFlg){
                  error=error+title+'の値をセレクトしてください \n';
                  toparray.push(thisselector.offset().top);
                  thisselector.css("color","red");
            }
         }



        if(thisselector.hasClass("validate_number")){
          if(thisselectorinputlength > limitnum){
            error=error+title+'は'+limitnum+'文字以内で入力してください\n';
            thisselector.css("border","solid 1px #EA5A4B");
            toparray.push(thisselector.offset().top);
          }
        }

        if(thisselector.hasClass("validate_alpha")){
          if(!thisselectorinput.match( /^[a-zA-z¥s]+$/ )){
            error=error+title+'は'+'アルファベットのみで入力してください\n';
            thisselector.css("border","solid 1px #EA5A4B");
            toparray.push(thisselector.offset().top);
          }
        }

        if(thisselector.hasClass("validate_characterlimit")){
          var validationnum=thisselector.attr("data_num");
          if(thisselectorinputlength>validationnum){
             error=error+title+'は'+validationnum+'文字以内で入力してください。\n';
             thisselector.css("border","solid 1px #EA5A4B");
             toparray.push(thisselector.offset().top);
            }
        }

        if(thisselector.hasClass("validate_email")){
          if(thisselectorinput.match(/.+@.+\..+/)==null){
            error=error+title+'に正しいメールアドレスを入力してください。\n';
            thisselector.css("border","solid 1px #EA5A4B");
            toparray.push(thisselector.offset().top);
          }
        }
    }




if(!error==""){
    alert(error);
    $("html,body").animate({scrollTop:_.min(toparray) - 50}, 1000);
    
    return false;
      }else{
        $('form').get(0).submit();
    }
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
