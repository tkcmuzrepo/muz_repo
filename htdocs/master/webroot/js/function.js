// 多重送信フラグ
var postServerFlag=true;


$(document).ready(function(){

// urlObjOriginalの参照
try{
  var urlObj=urlObjOriginal;
}catch(e){
//  alert('urlObjOriginalが参照できませんでした');
 // return; 
}



/*------------------------------------
makenewgroup
------------------------------------*/
    
    makenewgroupinitialize();

    $("body").on("click", "#makenewgroup", function(e) {

      var postdata = {}; 
      var postPass="MuzFormGroupSetting";
      var error="";
      var inputgrouptitle=$('#inputgrouptitle').val();
      var inputgroupsubtitle=$('#inputgroupsubtitle').val();
      var wraphtml = $(this).parents("#homeright");

      if(!inputgrouptitle){
         error=error+'グループのタイトルを入力してください\n';
      }
      if(!inputgroupsubtitle){
         error=error+'グループのサブタイトルを入力してください。\n';
      }

      postdata['data['+postPass+'][group_title]'] =inputgrouptitle;
      postdata['data['+postPass+'][group_sub_title]'] =inputgroupsubtitle;

      getHiddenValue(wraphtml,postdata,postPass,function(date){
        postdata=date;
      })


      if(error==''){

            var url=urlObj.urlGroupManagementNew;
            postServer(url,postdata,function(date){

                if(date.status=='YES'){

                    var group_id=date.group_id;
                    var date_key=date.date_key;

					//★追加しました date_key,view_flg
                    data = [{ 
                        "group_id":group_id,
                        "inputgrouptitle":inputgrouptitle,
                        "inputgroupsubtitle":inputgroupsubtitle, 
						"date_key":date.date_key,
						"view_flg":date.view_flg
                      } 
                    ];

                    $.tmpl($('#managementformtmp'),data).appendTo( "#managementformwarapNew" );
                    $('#inputgrouptitle').val('');
                    $('#inputgroupsubtitle').val('');
                    alert('新しいグループを追加しました。');
                    $("html,body").animate({scrollTop:0}, 1000);

                return true;

                }

            });


      }else{
        alert(error);
        return false
      }


    });


// /admin/groupmanagement.phpの処理
function makenewgroupinitialize(){

  $(".managementformwarap").sortable({

    connectWith: ".managementformwarap",
    opacity: 0.7,
    revert: true,
    croll: true,
    stop: function( event, ui ) {

            var group_id;
            var groupArray = new Array(); 
            var postdata = {}; 
            var postdata_hidden= {};
            var showflah;
            var postPass="MuzFormGroupSetting";
            var wraphtml =ui.item;
            var wraphtmlShow = wraphtml.parents(".managementformwarap");
            var url=urlObj.urlGroupManagementSort;
			
            getHiddenValue(wraphtml,postdata,postPass,function(date){
                postdata=date;
			});
			
            if(wraphtmlShow.hasClass('show')){
                showflag=1;
            }else{
                showflag=0;
            }
			
            postdata['data['+postPass+'][view_flg]'] =showflag;
			
			postServer(url,postdata,function(date){
				
				if(date.status=='YES'){
	            	return;
				}
				
				alert("処理に失敗しました");
				location.reload();
				
			});
    }



  });

}



$("body").on("click", ".makenewgroupDelete", function(e) {

  var postdata = {}; 
  var postPass="MuzFormFieldSetting";
  var wraphtml = $(this).parents(".managementform");
  var group_id = $('.group_id',wraphtml).val();
  
     getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
      })

       var url=urlObj.urlGroupManagementDelete;
        postServer(url,postdata,function(date){

            if(date.status=='YES'){
               if(window.confirm('このグループを本当に削除しますか？')){
                  wraphtml.remove();
                }

            }
        })

});


/*------------------------------------
advertising
------------------------------------*/
    $("body").on("click", "#advertisingsubmitnew", function(e) {


      var postdata = {}; 
      var postPass="MuzPromotionSetting";
      var error="";
      var advertisingtitle=$('#advertisingtitle').val();
      var advertisingtextarea=$('#advertisingtextarea').val();


      if(!advertisingtitle){
           error=error+'広告コードのタイトルを入力してください\n';
      }
      if(!advertisingtextarea){
           error=error+'広告コードを入力してください。\n';
      }


      postdata['data['+postPass+'][name]'] =advertisingtitle;
      postdata['data['+postPass+'][promotion_code]'] =advertisingtextarea;


      if(error==''){

        var url=urlObj.urlAdvertisingSubmitNew;
        postServer(url,postdata,function(date){

          console.log(date);
        
            if(date.status=='YES'){
              var promotion_id=date.promotion_id;

                  data = [{ 
                      "promotion_id":promotion_id,
                      "advertisingtitle":advertisingtitle,
                      "advertisingtextarea":advertisingtextarea, 
                    } 
                  ];

                 $.tmpl( $('#advertisingsettemp'),data).appendTo( "#homeleft" );
                 $('#advertisingtitle').val('');
                 $('#advertisingtextarea').val('');
                 alert('新規広告コードを追加しました。');
                 return true
            }
        })

      }else{
        alert(error);
        return false
      }

    });

    $("body").on("click", ".advertisingedit", function(e) {

        var wraphtml=$(this).parents(".advertisingset");
        $('.advertisingtitleinput',wraphtml).css("display","block");
        $('.advertisingtitle',wraphtml).css("display","none");
        $('.advertisinginput',wraphtml).css("display","block");
        $('.advertisingsubclose',wraphtml).css("display","block");
        $('.advertisingstate',wraphtml).css("display","block");
        $('.advertisingsubmit',wraphtml).css("display","block");
        $('.advertisingedit',wraphtml).css("display","none");
        $('.advertisingdelete',wraphtml).css("display","none");
        $('.advertisingsethead',wraphtml).css("background","#a2c4da");
        $('.advertisingtitle',wraphtml).css("color","#ffffff");
        wraphtml.css("border","solid 2px #A2C4DA");
        $('textarea',wraphtml).toggle();
    });

    $("body").on("click", ".advertisingsubclose", function(e) {

        var wraphtml=$(this).parents(".advertisingset");    
        $('.advertisingstate',wraphtml).css("display","none");
        $('.advertisingsubmit',wraphtml).css("display","none");
        $('.advertisingsubclose',wraphtml).css("display","none");
        $('.advertisingedit',wraphtml).css("display","block");
        $('.advertisingdelete',wraphtml).css("display","block");
        $('.advertisingsethead',wraphtml).css("background","#eeeeee");
        $('.advertisingtitle',wraphtml).css("color","#000");
        $('.advertisingtitleinput',wraphtml).css("display","none");
        $('.advertisingtitle',wraphtml).css("display","block");
        $('.advertisinginput',wraphtml).css("display","none");
        wraphtml.css("border","none");

    });

    $("body").on("click", ".advertisingsubmit", function(e) {
        

        var postdata = {}; 
        var postPass="MuzPromotionSetting";
        var error="";
        var wraphtml=$(this).parents(".advertisingset");
        var name=$('.advertisingtitleinput',wraphtml).val();
        var promotion_code=$('.advertisinginput',wraphtml).val();

        if(!name){
           error=error+'広告のタイトルを入力してください。\n';
        }
        if(!promotion_code){
           error=error+'広告コードを入力してください。\n';
        }

        postdata['data['+postPass+'][name]'] =name;
        postdata['data['+postPass+'][promotion_code]'] =promotion_code;


        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
        })

        if(error==''){

            var url=urlObj.urlAdvertisingSubmitEdit;
            postServer(url,postdata,function(date){

                if(date.status=='YES'){

                    $('.advertisingstate',wraphtml).css("display","none");
                    $('.advertisingsubmit',wraphtml).css("display","none");
                    $('.advertisingsubclose',wraphtml).css("display","none");
                    $('.advertisingedit',wraphtml).css("display","block");
                    $('.advertisingdelete',wraphtml).css("display","block");
                    $('.advertisingsethead',wraphtml).css("background","#eeeeee");
                    $('.advertisingtitle',wraphtml).css("color","#000");
                    $('.advertisingtitleinput',wraphtml).css("display","none");
                    $('.advertisingtitle',wraphtml).css("display","block");
                    $('.advertisingtitleinput',wraphtml).val(name);
                    $('.advertisingtitle',wraphtml).html(name);
                    $('.advertisinginput',wraphtml).css("display","none");

                    wraphtml.css("border","none");
                    $('textarea',wraphtml).toggle();
                    alert('広告コードを編集しました。');
                return true;

                }

            });

      }else{
        alert(error);
        return false
      }

    });

  $("body").on("click", ".advertisingdelete", function(e) {

      var postdata = {}; 
      var postPass="MuzPromotionSetting";
      var wraphtml=$(this).parents(".advertisingset");

      getHiddenValue(wraphtml,postdata,postPass,function(date){
        postdata=date;
      })

      if(window.confirm('本当に削除しますか？')){

            var url=urlObj.urlAdvertisingDelete;
            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                   wraphtml.remove();
                  }
        });
      }
    });


/*------------------------------------
userlist
------------------------------------*/

    $("body").on("click", ".userlistitemshow", function(e) {

        var wraphtml=$(this).parents(".userlistitemset");

        $('.userlistitemdelete').css("display","none");
        $('.userlistitemedit').css("display","none");
        $('textarea',wraphtml).css("display","none");
        $('.userlistitemset').css("border","none");
        $('.userlistitemdownlosd').css("display","none");
        $('textarea').css("display","none");
        $('.textareashow').css("display","none");
        $('.userlistitemsethead').css("background","#eeeeee");
        $('.userlistitemsethead').css("color","#000000");
        $('.userlistitemtitle').css("color","#000000");
        $('.userlistitemeditting').css("border","none");
        $('.userlistitemsave').css("border","none");
        $('.userlistitemsave').css("display","none");
        $('.userlistitemeditting').css("display","none");

        $('.userlistitemtitle',wraphtml).css("display","block");
        $('.userlistitemdelete',wraphtml).css("display","block");
        $('.userlistitemedit',wraphtml).css("display","block");
        $('.userlistitemedit',wraphtml).css("display","block");
        $('.userlistitemedit',wraphtml).css("display","block");
        $('.userlistitemdownlosd',wraphtml).css("display","block");
        $('.userlistitemsethead',wraphtml).css("background","#A2C4DA");
        $('.userlistitemsethead',wraphtml).css("color","#ffffff");
        $('.userlistitemtitle',wraphtml).css("color","#ffffff");
        $('.textareashow',wraphtml).css("display","block");
        $('.userlistitemshow').css("display","block");
        $('.userlistitemclose').css("display","none");
        $('.userlistitemshow',wraphtml).css("display","none");
        $('.userlistitemclose',wraphtml).css("display","block");

        wraphtml.css("border","solid 2px #A2C4DA");

    });


    $("body").on("click", ".userlistitemclose", function(e) {

        var wraphtml=$(this).parents(".userlistitemset");

        $('.userlistitemdelete').css("display","none");
        $('.userlistitemedit').css("display","none");
        $('textarea',wraphtml).css("display","none");
        $('.userlistitemset').css("border","none");
        $('.userlistitemdownlosd').css("display","none");
        $('textarea').css("display","none");
        $('.textareashow').css("display","none");
        $('.userlistitemsethead').css("background","#eeeeee");
        $('.userlistitemsethead').css("color","#000000");
        $('.userlistitemtitle').css("color","#000000");
        $('.userlistitemeditting').css("border","none");
        $('.userlistitemsave').css("border","none");
        $('.userlistitemsave').css("display","none");
        $('.userlistitemeditting').css("display","none");

        $('.userlistitemshow').css("display","block");
        $('.userlistitemclose').css("display","none");

        $('.userlistitemshow',wraphtml).css("display","block");
        $('.userlistitemclose',wraphtml).css("display","none");

    });

    $("body").on("click", ".userlistitemedit", function(e) {

        var wraphtml=$(this).parents(".userlistitemset");
        $('.userlistitemdelete',wraphtml).css("display","none");
        $('.userlistitemedit',wraphtml).css("display","none");
        $('.userlistitemdownlosd',wraphtml).css("display","none");
        $('.userlistitemedit',wraphtml).css("display","none");
        $('.textareashow',wraphtml).css("display","none");
        $('textarea',wraphtml).css("display","block");
        $('.userlistitemeditting',wraphtml).css("display","block");
        $('.userlistitemsave',wraphtml).css("display","block");
    });


    $("body").on("click", ".userlistitemsave", function(e) {

        var wraphtml=$(this).parents(".userlistitemset");
        $('.userlistitemdelete').css("display","none");
        $('.userlistitemedit').css("display","none");
        $('textarea',wraphtml).css("display","none");
        $('.userlistitemset').css("border","none");
        $('.userlistitemdownlosd').css("display","none");
        $('textarea').css("display","none");
        $('.textareashow').css("display","none");
        $('.userlistitemsethead').css("background","#eeeeee");
        $('.userlistitemsethead').css("color","#000000");
        $('.userlistitemtitle').css("color","#000000");
        $('.userlistitemeditting').css("border","none");
        $('.userlistitemsave').css("border","none");
        $('.userlistitemsave').css("display","none");
        $('.userlistitemeditting').css("display","none");
        $('.userlistitemtitle',wraphtml).css("display","block");
        $('.userlistitemdelete',wraphtml).css("display","block");
        $('.userlistitemedit',wraphtml).css("display","block");
        $('.userlistitemedit',wraphtml).css("display","block");
        $('.userlistitemedit',wraphtml).css("display","block");
        $('.userlistitemdownlosd',wraphtml).css("display","block");
        $('.userlistitemsethead',wraphtml).css("background","#A2C4DA");
        $('.userlistitemsethead',wraphtml).css("color","#ffffff");
        $('.userlistitemtitle',wraphtml).css("color","#ffffff");
        $('.textareashow',wraphtml).css("display","block");

        wraphtml.css("border","solid 2px #A2C4DA");

        alert('保存しました');
    });

    
    $("body").on("click", ".userlistitemdelete", function(e) {

        var postdata = {}; 
        var postPass="MuzAcountSetting";
        var error="";
        var wraphtml=$(this).parents(".userlistitemset");

        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
        })

        var wraphtml=$(this).parents(".userlistitemset");
        if(window.confirm('本当に削除しますか？')){

            var url=urlObj.urlUserDelete;
            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                  wraphtml.remove();
                return true;

                }

            });
        }
    });


    $("body").on("click", ".cleardate", function(e){
      $('.userlist_finfdate').val("");
    });




/*------------------------------------
managementnew
------------------------------------*/

    $("body").on("click", "#managementnewformsubmit", function(e) {

      var error="";
      var managementnewtitle=$('#managementnewtitle').val();
      var managementnewgroup=$('#managementnewgroup').val();
      var managementnewurl=$('#managementnewurl').val();


        if(!managementnewtitle){
          error=error+'フォームのタイトルを入力してください\n';
        }
        if(!managementnewgroup){
          error=error+'フォーム内グループの設定を入力してください\n';
        }
        if(!managementnewurl){
          error=error+'ページURLを入力してください\n';
        }
        if(!managementnewurl.match( /^[a-zA-z\s]+$/)){
          error=error+'ページURLをアルファベットのみで入力してください\n';
        }

      if(error==''){
         alert('フォームを新規追加しました。');
        return true
      }else{
        alert(error);
        return false
      }

  });



/*------------------------------------
useredit
------------------------------------*/

    $("body").on("click", "#useredcreatnewuser", function(e) {

      var error="";
      var itemusernameinput=$('#itemusernameinput').val();
      var itemuseridinput=$('#itemuseridinput').val();
      var itemuserpassinput=$('#itemuserpassinput').val();
      var itemuserpasscommitinput=$('#itemuserpasscommitinput').val();
      var masetauthority = $('input[name="masetauthority"]:checked').val();
      var radioname='radio'+(new Date)/1000;
      var postdata = {}; 
      var master_flg;


       Validation_1(itemusernameinput,itemuseridinput,itemuserpassinput,itemuserpasscommitinput,function(date){
          error=date;
       })


       if(masetauthority=='true'){
        master_flg=1;
       }else{
        master_flg=0;
       }

       // postデータ
        postdata['data[MuzMasterAccount][name]'] =itemusernameinput;
        postdata['data[MuzMasterAccount][login_id]'] =itemuseridinput;
        postdata['data[MuzMasterAccount][login_pass]'] =itemuserpassinput;
        postdata['data[MuzMasterAccount][login_pass_conf]'] =itemuserpasscommitinput;
        postdata['data[MuzMasterAccount][master_flg]'] =master_flg;
        console.log(postdata);


      if(error==''){

        var url=urlObj.urlUserSubmit;
        postServer(url,postdata,function(date){
        
            if(date.status=='YES'){

                  var account_id=date.account_id;

                  // テンプレートデータ
                  data = [{ 
                      "itemusernameinput":itemusernameinput,
                      "itemuseridinput":itemuseridinput, 
                      "itemuserpassinput":itemuserpassinput, 
                      "itemuserpasscommitinput":itemuserpasscommitinput, 
                      "radioname" : radioname, 
                      "masetauthority":masetauthority, 
                      "account_id":account_id, 
                    } 
                  ];


                  $.tmpl( $('#useredititemtabletnp'),data).appendTo( "#homeleft" );
                  $('#itemusernameinput').val('');
                  $('#itemuseridinput').val('');
                  $('#itemuserpassinput').val('');
                  $('#itemuserpasscommitinput').val('');
                  alert('新規ユーザーを追加しました。');
                  return true
            }
        })


      }else{
        alert(error);
        return false
      }

    });

    $("body").on("click", ".homeleftboxheadedit", function(e) {

        var wraphtml=$(this).parents(".usereditset");
        $('.homeleftboxheadstate',wraphtml).css("display","block");
        $('.homeleftboxheadubmit',wraphtml).css("display","block");
        $('.homeleftboxheadedit',wraphtml).css("display","none");
        $('.homeleftboxheaddelete',wraphtml).css("display","none");
        $('.homeleftboxhead',wraphtml).css("background","#a2c4da");
        $('.homeleftboxheadtitle',wraphtml).css("color","#ffffff");
        $('.usercode',wraphtml).css("color","#748d9d");
        $('.useredititemtablewrap',wraphtml).css("border","solid 2px #A2C4DA");
        $('.useredititemtablewrap',wraphtml).toggle();

    });

    $("body").on("click", ".useritemesubmit", function(e) {

        var wraphtml=$(this).parents(".usereditset");
        var error="";
        var postPass="MuzMasterAccount";
        var itemusernameinput=$('.itemusernameinput',wraphtml).val();
        var itemuseridinput=$('.itemuseridinput',wraphtml).val();
        var itemuserpassinput=$('.itemuserpassinput',wraphtml).val();
        var masetauthority = $('input[name="masetauthority"]:checked',wraphtml).val();
        var postdata = {}; 
        var master_flg;

        Validation_1(itemusernameinput,itemuseridinput,itemuserpassinput,itemuserpassinput,function(date){
        error=date;
        })

        if(masetauthority=='true'){
        master_flg=1;
        }else{
        master_flg=0;
        }


        //postデータ
        postdata['data[MuzMasterAccount][name]'] =itemusernameinput;
        postdata['data[MuzMasterAccount][login_id]'] =itemuseridinput;
        postdata['data[MuzMasterAccount][login_pass]'] =itemuserpassinput;


        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
        })


        if(error==''){

        var url=urlObj.urlUserEdit;
        postServer(url,postdata,function(date){

            if(date.status=='YES'){

                $('.homeleftboxheadstate',wraphtml).css("display","none");
                $('.homeleftboxheadubmit',wraphtml).css("display","none");
                $('.homeleftboxheadedit',wraphtml).css("display","block");
                $('.homeleftboxheaddelete',wraphtml).css("display","block");
                $('.homeleftboxhead',wraphtml).css("background","#eeeeee");
                $('.homeleftboxheadtitle',wraphtml).css("color","#000");
                $('.usercode',wraphtml).css("color","#000");
                $('.useredititemtablewrap',wraphtml).css("border","none");
                $('.useredititemtablewrap',wraphtml).toggle();
                $('.usernametitle',wraphtml).html(itemusernameinput);
                $('.usercode',wraphtml).html(itemuseridinput);

                alert('ユーザー情報を更新しました。');
                return true
          }
        })


        }else{
        alert(error);
        return false
        }

    });

    // ユーザーデータ閉じる
    $("body").on("click", ".useritemeclose", function(e) {

          var wraphtml=$(this).parents(".usereditset");

          $('.homeleftboxheadstate',wraphtml).css("display","none");
          $('.homeleftboxheadubmit',wraphtml).css("display","none");
          $('.homeleftboxheadedit',wraphtml).css("display","block");
          $('.homeleftboxheaddelete',wraphtml).css("display","block");
          $('.homeleftboxhead',wraphtml).css("background","#eeeeee");
          $('.homeleftboxheadtitle',wraphtml).css("color","#000");
          $('.usercode',wraphtml).css("color","#000");
          $('.useredititemtablewrap',wraphtml).css("border","none");
          $('.useredititemtablewrap',wraphtml).toggle();
 
          return true

    });


    $("body").on("click", ".homeleftboxheaddelete", function(e) {
      
      var wraphtml=$(this).parents(".homeleftbox");
      var postdata = {};
	  var postPass="MuzMasterAccount";
      var url=urlObj.urlUserLoginDelete;
      

      if(window.confirm('本当に削除しますか？')){

            getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
            })

            postServer(url,postdata,function(date){
                
                if(date.status=='YES'){
                     wraphtml.remove();
                    return true
                }

            })
        }
    });




  function Validation_1(name,id,pass,passcommit,callback){

      var error="";

      if(!name){
         error=error+'ユーザー名を入力してください\n';
        }
      
      if(!id){
         error=error+'ユーザーIDを入力してください\n';
        }else if(!id.match( /^[a-zA-z\s]+$/)){
          error=error+'ユーザーIDはアルファベットのみで入力してください\n';
        }

      if(!pass){
         error=error+'パスワードを入力してください\n';
        }else if(!pass.match( /^[a-zA-z\s]+$/)){
          error=error+'パスワードはアルファベットのみで入力してください\n';
        }

      if(!passcommit){
         error=error+'パスワード(確認用)を入力してください\n';
        }else if(!passcommit.match( /^[a-zA-z\s]+$/)){
          error=error+'パスワード(確認用)はアルファベットのみで入力してください\n';
       }

      if(pass!=passcommit) {
           error=error+'パスワードが一致しましせん\n';
       }

       callback(error);
  }


/*------------------------------------
formdesign
------------------------------------*/
$("body").on("change", ".formdesign .color", function(e) {
  
    var postdata = {};
    var postPass='MuzFormColorSetting';
    var node=$(this);
    var url=urlObj.urlFormDesign;
    
 
    postdata[node.attr('name')]=node.val();
    getHiddenValue(node.parents("#homeright"),postdata,postPass,function(date){
          postdata=date;
    });
  

      postServer(url,postdata,function(date){
        
          if(date.status=='YES'){
            return true;
          }
      });
});



$("body").on("click", ".formboxdesignheaderedit_1", function(e) {
  

        var wraphtml=$(this).parents(".formboxdesign");
        var error="";
        var postPass="MuzFormHtmlSetting";
        var changetext=$('textarea',wraphtml).val();
        var postdata = {}; 
        var url=urlObj.urlHtmlHeader;


        if(changetext.length > 1000){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }else  if(10 > changetext.length ){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }
    


        if(error==''){

            //postデータ
            postdata['data[MuzFormHtmlSetting][header_html]'] =changetext;

            getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
            })

            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                    alert('文章を更新しました');
                    return true
              }
            })


        }else{
          alert(error);
        return false
        }

});

$("body").on("click", ".formboxdesignheaderedit_2", function(e) {
  

        var wraphtml=$(this).parents(".formboxdesign");
        var error="";
        var postPass="no_parameter";
        var changetext=$('textarea',wraphtml).val();
        var postdata = {}; 
        var url=urlObj.urlHtmlHeader;


        if(changetext.length > 1000){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }else  if(10 > changetext.length ){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }
    


        if(error==''){

            //postデータ
            postdata['data[MuzFormHtmlSetting][sp_header_html]'] =changetext;

            getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
            })

            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                    alert('文章を更新しました');
                    return true
              }
            })


        }else{
          alert(error);
        return false
        }

});


$("body").on("click", ".formboxdesignheaderedit_3", function(e) {
  

        var wraphtml=$(this).parents(".formboxdesign");
        var error="";
        var postPass="no_parameter";
        var changetext=$('textarea',wraphtml).val();
        var postdata = {}; 
        var url=urlObj.urlHtmlHeader;


        if(changetext.length > 1000){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }else  if(10 > changetext.length ){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }
    


        if(error==''){

            //postデータ
            postdata['data[MuzFormHtmlSetting][mb_header_html]'] =changetext;

            getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
            })

            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                    alert('文章を更新しました');
                    return true
              }
            })


        }else{
          alert(error);
        return false
        }

});



/*------------------------------------
formsetting
------------------------------------*/



$("body").on("click", "#after_page_html", function(e) {


        var wraphtml=$(this).parents(".formsettingbox");
        var error="";
        var postPass="MuzFormHtmlSetting";
        var changetext=$('textarea',wraphtml).val();
        var postdata = {}; 
        var master_flg;
        var url=urlObj.urlUserEdit;


        if(changetext.length > 1000){
            error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }else  if(10 > changetext.length ){
            error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }

  

        if(error==''){

            //postデータ
            postdata['data['+postPass+'][after_page_html]'] =changetext;

            getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
            })

            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                    alert('文章を更新しました');
                    return true
              }
            })


        }else{
          alert(error);
        return false
        }

    });


$("body").on("click", "#sp_after_page_html", function(e) {


        var wraphtml=$(this).parents(".formsettingbox");
        var error="";
        var postPass="MuzFormHtmlSetting";
        var changetext=$('textarea',wraphtml).val();
        var postdata = {}; 
        var master_flg;
        var url=urlObj.urlUserEdit;

        if(changetext.length > 1000){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }else  if(10 > changetext.length ){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }
    

        if(error==''){

            //postデータ
            postdata['data['+postPass+'][sp_after_page_html]'] =changetext;

            getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
            })

            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                    alert('文章を更新しました');
                    return true
              }
            })


        }else{
          alert(error);
        return false
        }

    });




$("body").on("click", "#mb_after_page_html", function(e) {


        var wraphtml=$(this).parents(".formsettingbox");
        var error="";
        var postPass="MuzFormHtmlSetting";
        var changetext=$('textarea',wraphtml).val();
        var postdata = {}; 
        var master_flg;
        var url=urlObj.urlHtmlEdit;

        if(changetext.length > 1000){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }else  if(10 > changetext.length ){
          error=error+'文字数は10文字以上1000文字以内にしてください。\n';
        }
    

        if(error==''){

            //postデータ
            postdata['data['+postPass+'][mb_after_page_html]'] =changetext;

            getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
            })

            postServer(url,postdata,function(date){

                if(date.status=='YES'){
                    alert('文章を更新しました');
                    return true
              }
            })


        }else{
          alert(error);
        return false
        }

    });



/*------------------------------------
formsetting note
------------------------------------*/


 $("body").on("click", "#noteNewSubmit", function(e) {


    var error="";
    var toparray=Array();
    var postdata = {}; 
    var noteNewTextarea=$('#noteNewTextarea').val();
    var wraphtml=$(this).parents("tr");
    var postPass="MuzFormMessage";
  

    if(noteNewTextarea.length > 200){
          error=error+'注意文の文字数は10文字以上200文字以内にしてください。\n';
    }else　if(10 > noteNewTextarea.length ){
          error=error+'注意文の文字数は10文字以上200文字以内にしてください。\n';
    }
    

    if(error==''){
      
        postdata['data[MuzFormMessage][name]'] =noteNewTextarea;
        getHiddenValue(wraphtml,postdata,postPass,function(date){
              postdata=date;
        });
    
        var url=urlObj.urlNoteNew;
        postServer(url,postdata,function(date){
      
            if(date.status=='YES'){
        
              // date_key , form_id を追加
              var message_id=date.message_id;
              var date_key=date.date_key;
              var form_id=date.form_id;
        
                // date_key , message_id を追加
                data = [{ 
                  "noteNewTextarea":noteNewTextarea,
                  "message_id":message_id,
                  "date_key":date_key,
                  "form_id":form_id
                }];
        
                $.tmpl($('#tempnote'),data).appendTo( "#notearea" );

                $('#noteNewTextarea').val('');
                    $("tr").each(function(thisselector) {
                        toparray.push($(this).offset().top);
                    });

                alert('注意文を作成しました。');
                $("html,body").animate({scrollTop:_.max(toparray) - 50}, 1000);
                return true

          }
        })

        }else{
          alert(error);
        return false
        }
  
  });



  $("body").on("click", ".noteedit", function(e) {

          var wraphtmlnotearea=$(this).parents("#notearea");
          var wraphtml=$(this).parents("tr");
          $('textarea',wraphtmlnotearea).attr("disabled", "disabled");
          $('.noteedit',wraphtmlnotearea).css("display","block");
          $('.noteeditsubmit',wraphtmlnotearea).css("display","none");
          $('.notedelete',wraphtmlnotearea).css("display","none");
          $('.noteeditsubmitend',wraphtmlnotearea).css("display","none");
          $('textarea',wraphtml).removeAttr("disabled");
          $('.noteedit',wraphtml).css("display","none");
          $('.noteeditsubmit',wraphtml).css("display","block");
          $('.notedelete',wraphtml).css("display","block");
          $('.noteeditsubmitend',wraphtml).css("display","block");
          $('.showhide',wraphtml).css("display","none");
  });


  $("body").on("click", ".noteeditsubmitend", function(e) {

          var wraphtml=$(this).parents("tr");
          $('textarea',wraphtml).attr("disabled", "disabled");
          $('.noteedit',wraphtml).css("display","block");
          $('.noteeditsubmit',wraphtml).css("display","none");
          $('.notedelete',wraphtml).css("display","none");
          $('.noteeditsubmitend',wraphtml).css("display","none");
          $('.showhide',wraphtml).css("display","block");
  });



  $("body").on("click", ".notedelete", function(e) {
    
    var postdata = {}; 
    var postPass='MuzFormMessage';
    var wraphtml=$(this).parents("tr");
    if(window.confirm('本当に削除しますか？')){
        
        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
        })

        var url=urlObj.urlNoteDelete;
        postServer(url,postdata,function(date){

            if(date.status=='YES'){
            
                alert('注意文を削除しました。');
                wraphtml.remove();
                return true
            
            }else{
              return false
            }
       })

    }
  });



$("body").on("click", ".noteshow", function(e) {
          
        var postdata = {}; 
        var wraphtml=$(this).parents("tr");
        var url=urlObj.urlNoteShow;
        var postPass="no_parameter";

        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
        })

        postServer(url,postdata,function(date){
            
            if(date.status=='YES'){

                 if(date.view_flg=='1'){

                      $('.noteshow',wraphtml).css("display","none");
                      $('.notehide',wraphtml).css("display","none");

                  }else{

                      $('.noteshow',wraphtml).css("display","none");
                      $('.notehide',wraphtml).css("display","block");

                  }
              
              return true
            
            }else{
              return false
            }
       })

  });



  $("body").on("click", ".notehide", function(e) {
        
        var postdata = {}; 
        var wraphtml=$(this).parents("tr");
        var url=urlObj.urlNoteShow;
        var postPass="no_parameter";
        

        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
        })


        postServer(url,postdata,function(date){
            
            if(date.status=='YES'){

                 if(date.view_flg=='1'){

                      $('.noteshow',wraphtml).css("display","block");
                      $('.notehide',wraphtml).css("display","none");

                  }else{

                      $('.noteshow',wraphtml).css("display","none");
                      $('.notehide',wraphtml).css("display","block");

                  }
              
              return true
            
            }else{
              return false
            }
       })
  });


  $("body").on("click", ".noteeditsubmit", function(e) {

    var error="";
    var postPass='MuzFormMessage';
    var toparray=Array();
    var postdata = {}; 
    var wraphtml=$(this).parents("tr");
    var noteNewTextarea=$('textarea',wraphtml).val();
    var url=urlObj.urlNoteEdit;


    if(noteNewTextarea.length > 200){
           error=error+'注意文の文字数は10文字以上200文字以内にしてください。\n';
    }else  if(10 > noteNewTextarea.length ){
          error=error+'注意文の文字数は10文字以上200文字以内にしてください。\n';
    }
    

    if(error==''){

        postdata['data['+postPass+'][name]'] =noteNewTextarea;

        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
        })

        postServer(url,postdata,function(date){

            if(date.status=='YES'){

                $('textarea',wraphtml).attr("disabled", "disabled");
                $('.noteedit',wraphtml).css("display","block");
                $('.noteeditsubmit',wraphtml).css("display","none");
                $('.notedelete',wraphtml).css("display","none");
                $('.noteeditsubmitend',wraphtml).css("display","none");
                $('.showhide',wraphtml).css("display","block");

                alert('注意文を更新しました。');
                return true
          }
        })


        }else{
        alert(error);
        return false
        }

  });




/*------------------------------------
formhtmlsave
------------------------------------*/

  $("body").on("click", "#formhtmlsave", function(e) {
	
    var error="";
    var postPass='MuzPreview';
    var toparray=Array();
    var postdata = {}; 
    var wraphtml=$(this).parents("#adminHeaderNavi");
    var url=urlObj.urlFormHtmlSave;


    if(error==''){
        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
      })

        postServer(url,postdata,function(date){

            if(date.status=='YES'){
                alert('フォームを保存しました。');
                return true
            }
        })

        }else{
          alert(error);
        return false
        }
    });


/*------------------------------------
formhtmlsave
------------------------------------*/

  $("body").on("click", "#formhtmlsave", function(e) {

    var error="";
    var postPass='MuzPreview';
    var toparray=Array();
    var postdata = {}; 
    var wraphtml=$(this).parents("#adminHeaderNaviFunction");
    var url=urlObj.urlFormHtmlSave;
	
    if(error==''){
        getHiddenValue(wraphtml,postdata,postPass,function(date){
          postdata=date;
      })
			
      postServer(url,postdata,function(date){
			
			console.log(date);
			
            if(date.status=='YES'){
                alert('フォームを保存しました。');
                return true
            }
        })
			
        }else{
          alert(error);
        return false
        }
    });

/*------------------------------------
getHiddenValue
------------------------------------*/
  function getHiddenValue(seector,postdata,postPass,callback){

          $( ".hidden_value",seector).each(function() {
              var hidden_name=$(this).attr('name');
              var hidden_valie=$(this).val();
              postdata['data['+postPass+']['+hidden_name+']'] =hidden_valie;
          });

          callback(postdata);
      }


　function getHiddenValue_2(seector,postdata,postPass,callback){

          // hidden_valueを取得
          $( ".hidden_value input",seector).each(function() {
            var hidden_name=$(this).attr('name');
            var hidden_valie=$(this).val();
            postdata_hidden['['+hidden_name+']'] =hidden_valie;
            postdata['data['+postPass+']['+hidden_name+']'] =hidden_valie;
          });

          callback(postdata);
      }


/*------------------------------------
common
------------------------------------*/

  function postServer(url,postdata,callback){

      if(postServerFlag){
		
		console.log(postdata);
        postServerFlag=false;
		
          //post
          $.ajax({
             type:'post',
             data: postdata,
             url: url,
             dataType: 'json',
             success: function(data) {
				
				console.log(data);
				
               postServerFlag=true;
               var status=data.status;
               var err_mes=data.err_mes;

                 if(status=='YES'){

                    callback(data);
                 
                 }else{
                 
                  alert(err_mes);
                 // location.reload();
                 
                 }
             },

             error:function() {
            //  location.reload();
             }

          });
        }
     }


});
