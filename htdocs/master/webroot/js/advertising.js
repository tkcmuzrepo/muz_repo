$(function() {


    $("body").on("click", "#advertisingsubmitnew", function(e) {

      var error="";
      var advertisingtitle=$('#advertisingtitle').val();
      var advertisingtextarea=$('#advertisingtextarea').val();

      if(!advertisingtitle){
         error=error+'広告コードのタイトルを入力してください\n';
      }else if(!advertisingtextarea){
         error=error+'広告コードを入力してください。\n';
      }

      data = [{ 
          "advertisingtitle":advertisingtitle,
          "advertisingtextarea":advertisingtextarea, 
        } 
      ];

      if(error==''){
         $.tmpl( $('#advertisingsettemp'),data).appendTo( "#homeleft" );
         $('#advertisingtitle').val('');
         $('#advertisingtextarea').val('');
         alert('新規広告コードを追加しました。');
        return true
      }else{
        alert(error);
        return false
      }

    });

    $("body").on("click", ".advertisingedit", function(e) {
       　var wraphtml=$(this).parents(".advertisingset");
        $('.advertisingstate',wraphtml).css("display","block");
        $('.advertisingsubmit',wraphtml).css("display","block");
        $('.advertisingedit',wraphtml).css("display","none");
        $('.advertisingdelete',wraphtml).css("display","none");
        $('.advertisingsethead',wraphtml).css("background","#a2c4da");
        $('.advertisingtitle',wraphtml).css("color","#ffffff");
        $('textarea',wraphtml).toggle();
    });


    $("body").on("click", ".advertisingsubmit", function(e) {
        var wraphtml=$(this).parents(".advertisingset");
        $('.advertisingstate',wraphtml).css("display","none");
        $('.advertisingsubmit',wraphtml).css("display","none");
        $('.advertisingedit',wraphtml).css("display","block");
        $('.advertisingdelete',wraphtml).css("display","block");
        $('.advertisingsethead',wraphtml).css("background","#eeeeee");
        $('.advertisingtitle',wraphtml).css("color","#000");
        $('textarea',wraphtml).toggle();
    });


    $("body").on("click", ".advertisingdelete", function(e) {

      var wraphtml=$(this).parents(".advertisingset");
      if(window.confirm('本当に削除しますか？')){
          wraphtml.remove();
      }else{

      }

    });





});
