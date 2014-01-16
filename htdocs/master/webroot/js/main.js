
// 多重送信フラグ
var postServerFlag=true;



$(document).ready(function(){

// urlObjOriginalの参照
try{
  var urlObj=urlObjOriginal;
}catch(e){
//  alert('urlObjOriginalが参照できませんでした');
  return; 
}


initialize();




/*------------------------------------
getHiddenValue
------------------------------------*/
if(typeof getHiddenValue!='function'){
  function getHiddenValue(seector,postdata,postPass,callback){
    $( ".hidden_value",seector).each(function() {
      var hidden_name=$(this).attr('name');
      var hidden_valie=$(this).val();
      postdata['data['+postPass+']['+hidden_name+']'] =hidden_valie;
    });
    callback(postdata);
  }
}



$("body").on("click", "#makenewinput", function(e) {

  var wraphtml=$(this).parents("#newinput");
  var inputtext=$("#inputtext").val();
  var inputtextarea=$("#inputtextarea").val();
  var textnumber=$("#textnumber").val();
  var formtype = $("input[name='radio']:checked").val();
  var requiredchk =  $('#requiredcheckbox:checked').val()
  var viewflagchk =  $('#viewflagchkbox:checked').val()
  var newinputvalidationval=$("#newinputvalidation").val();
  var multinput=Array();
  var radioname='radio'+(new Date)/1000;
  var formid;
  var formtypenumber;
  var data;
  var postdata = {};
  //★加えました
  var postPass='MuzFormFieldSetting';


  var multiSelector= $( ".multinput li",wraphtml);
  if(!validation(inputtext,inputtextarea,textnumber,formtype,multiSelector)){
    return;
  }

  $( ".multinput li").each(function() {
      var inputtext=$('input',this).val();
      if(!inputtext==''){
        multinput.push(inputtext);
      }
  });

  if(formtype == 'text'){
    formtypenumber=1;
  }else if(formtype =='textarea'){
    formtypenumber=1;
  }else{
    formtypenumber=3;
  }

  // postデータの生成
  var multiSelector= $( ".multinput li");
  postdata=postDataMake(formtype,inputtext,inputtextarea,viewflagchk,requiredchk,textnumber,newinputvalidationval,multiSelector);


  //★加えました
  getHiddenValue($("#newinput"),postdata,postPass,function(date){
    $.extend(postdata.date);
  });
  
  var url=urlObj.urlFieldNew;
  postServer(url,postdata,function(date){


    if(date.status=='YES'){
      
      var field_id=date.field_id;

      data = [{ 
        "inputtext" : inputtext,
        "inputtextarea" : inputtextarea, 
        "textnumber" : textnumber, 
        "formtype" : formtype, 
        "newinputvalidationval" : newinputvalidationval, 
        "multinput" : multinput, 
        "requiredchk" : requiredchk, 
        "viewflagchk" : viewflagchk, 
        "radioname" : radioname, 
        "formid" : field_id, 
        "formtypenumber" : formtypenumber, 
        } 
      ];


      $.tmpl( $('#template'),data).appendTo( "#makedinput .formlist" );

      clearform();
      return true
    }
  })

  function clearform() {
      requiredchk ='';
      $('#newinput #inputtext').val('');
      $('#newinput input').attr("checked", false);
      
      $('#newinput textarea').val('');
      $('#newinput .multinput li input').val('');
      $('#newinput .multinput').html('');

      $.tmpl( $('#multinputreset')).appendTo( "#newinput .multinput" );
      $('#newinput .modeselecrradio').html('');
      $.tmpl( $('#formtypeselectreset')).appendTo( "#newinput .modeselecrradio" );
      $('.switcheditshow_new_1').css("display","block");
      $('.switcheditshow_new_2').css("display","none");
      $("#textnumber").val('20');

      alert('フィードを追加しました');
      $("html,body").animate({scrollTop:0}, 1000);
    }
});



//更新処理
$("body").on("click", ".fieldeditsubmit", function(e) {

  var wraphtml=$(this).parents(".formlistitem");
  var field_id=$(".field_id",wraphtml).val();
  var inputtext=$(".inputtext",wraphtml).val();
  var inputtextarea=$(".inputtextarea",wraphtml).val();
  var textnumber=$(".textnumber",wraphtml).val();
  var formtype = $(".formmodetypehidden",wraphtml).val();
  var requiredchk =  $('.requiredcheckbox:checked',wraphtml).val()
  var viewflagchk =  $('.viewflagchkbox:checked',wraphtml).val()
  var newinputvalidationval=$(".newinputvalidation",wraphtml).val();
  var multinput=Array();
  var formid;
  var data;
  var postdata = {}; 



  var multiSelector= $( ".multinput_edit li",wraphtml);
  if(!validation(inputtext,inputtextarea,textnumber,formtype,multiSelector)){
    return;
  }


  postdata=postDataMake(formtype,inputtext,inputtextarea,viewflagchk,requiredchk,textnumber,newinputvalidationval,multiSelector,wraphtml);

  // ※field_idを追加　修正予定
  postdata['data[MuzFormFieldSetting][field_id]'] =field_id;

  var url=urlObj.urlFieldEdit;
  postServer(url,postdata,function(date){
    if(date.status=='YES'){
        
        $(".formlistitemtitle",wraphtml).html(inputtext);
        alert('フィードを更新しました。');

        $('.formedit',wraphtml).slideToggle();
      return true
    }
  })

});



$("body").on("keyup",　".multinput", function(e) {

  var count = $(".multinput li").length;
  var emptycount=0;
 
 $( ".multinput li input" ).each(function(){
      if($(this).val()==''){emptycount++;}
  });

 if(emptycount==0){
    $.tmpl( $('#multinputli')).appendTo( ".multinput" );
  }

});


$("body").on("keyup",　".multinput_edit input", function(e) {

  var wraphtml=$(this).parents(".multinput_edit");
  var count = $("li",wraphtml).length;
  var emptycount=0;
 
 $( "li input",wraphtml).each(function(){

      if($(this).val()==''){
        emptycount++;        
      }
  });

 if(emptycount==0){
    $.tmpl( $('#multinputli')).appendTo(wraphtml);
  }

});


$("body").on("click", ".multinputremove", function(e) {
  var wraphtml=$(this).parents(".multinput_edit");
  $(this).parent().remove();
  var count = $("li",wraphtml).length;
  
  if(count<2){
    $.tmpl( $('#multinputli')).appendTo(wraphtml);
  }
});


$("body").on("click", ".groupup", function(e) {
  var selector =$(this).parent(".formgroup");
  $(selector).insertBefore($(selector).prev('.formgroup'));
  // 共通ファンクション
  groupnumberpost();
});

$("body").on("click", ".groupdown", function(e) {
  var selector =$(this).parent(".formgroup");
  $(selector).insertAfter($(selector).next('.formgroup'));

   // 共通ファンクション
   groupnumberpost();
});

$("body").on("click", ".togle", function(e) {
  $(this).next().slideToggle();
});



$("body").on("click", ".fielddeltesubmit", function(e) {

  var wraphtml=$(this).parents(".formlistitem");
  var field_id=$(".field_id",wraphtml).val();
  var postdata = {}; 
  postdata['data[Form][field_id]'] =field_id;


        if(window.confirm('本当に削除しますか？')){
          
          var url=urlObj.urlFieldDelete;
          postServer(url,postdata,function(date){
          
          if(date=='YES'){
            
              wraphtml.animate({ opacity: 'hide',},{ duration:2000, easing:'swing'},function(){
                     wraphtml.remove();
                  });
              return true
            }
          })
      }
});



$("body").on("change",　".modeselecrradio input", function(e) {

  var str=$(this).val();

  console.log('run modeselecrradio');


  if(str=='text'){
    $('.switcheditshow_new_1').css("display","block");
    $('.switcheditshow_new_2').css("display","block");
    $('.switcheditshow_new_3').css("display","none");
  }else{
    $('.switcheditshow_new_1').css("display","none");
    $('.switcheditshow_new_2').css("display","none");
    $('.switcheditshow_new_3').css("display","block");
  }
  if(str=='textarea'){
    $('.switcheditshow_new_1').css("display","block");
    $('.switcheditshow_new_2').css("display","none");
    $('.switcheditshow_new_3').css("display","none");
  }
});



$("body").on("change",　".switcheditmoderadio", function(e) {

  var str=$(this).val();
  var wraphtml=$(this).parents(".formtypeselect");
  var wraphtml=$(this).parents(".formlistitem");

  if(str=='text'){
    $('.switcheditshow_1',wraphtml).css("display","block");
    $('.switcheditshow_2',wraphtml).css("display","none");
  }else{
    $('.switcheditshow_1',wraphtml).css("display","none");
    $('.switcheditshow_2',wraphtml).css("display","block");
  }
  if(str=='textarea'){
    $('.switcheditshow_1',wraphtml).css("display","none");
    $('.switcheditshow_2',wraphtml).css("display","none");
  }

});



function initialize() {

  $(".formlist").sortable({
    connectWith: ".formlist",
    opacity: 0.7,
    revert: true,
    croll: true,
    stop: function( event, ui ) {
        // console.log(event);
        // console.log(ui);
    }
  });



  //ソート時の対応
  // $( ".formlist").bind("sortupdate", function(event, ui) { 



  //             var wraphtml = $(this).parents(".formgroup");
  //             var group_id;
  //             var field_id_array = new Array(); 
  //             var postdata_hidden_array = new Array(); 
  //             var postdata = {}; 
  //             var url=urlObj.urlSortUpdate;
  //             var postdata_hidden= {};


  //                 group_id = $( ".group_id",wraphtml).val();
  //                 console.log(group_id);


  //                       $( ".formlistitem",wraphtml).each(function() {
                                
  //                             postdata_hidden= {};
  //                             postdata_hidden_array = new Array(); 

      

  //                             field_id_item=$( ".field_id",this).val();
  //                             if(field_id_item){
  //                                 field_id_array.push(field_id_item)
  //                             } 

      
  //                             // 1/14変更 
  //                             $( ".hidden_value",this).each(function() {

  //                                 var hidden_name=$(this).attr('name');
  //                                 var hidden_valie=$(this).val();
                                
  //                                 postdata_hidden['['+hidden_name+']'] =hidden_valie;
  //                                 postdata_hidden_array.push(postdata_hidden)
  //                             });

                    
  //                       });



  //                  if(field_id_array.length>0){
  //                     field_id_array=field_id_array.join("_");
  //                  }else{
  //                     field_id_array='';
  //                  }

  //                   // console.log(field_id_array);
  //                   // console.log(postdata_hidden_array);

  //                   postdata['data[Form][group_id]'] =group_id;
  //                   postdata['data[Form][sort_id]'] =field_id_array;
  //                   postdata['data[Form][postdata_hidden]'] =postdata_hidden_array;
                  


  //                 // post処理
  //                 postServer(url,postdata,function(){

  //                 });


   
  // });
	
	
	$('.formlist').bind('sortstop',function(event,ui){
		
		console.log($(event.target));
		
		
	})
	
  // //ソート時の対応
  $( ".formlist").bind("sortupdate", function(event, ui) { 



    //console.log(ui.item);



    // 1/14変更 
    $( ".hidden_value",ui.item).each(function() {

        var hidden_name=$(this).attr('name');
        var hidden_valie=$(this).val();

//        console.log(hidden_name);
  //      console.log(hidden_valie);

    });



    var wraphtml = $(this).parents(".formgroup");


        $( ".formgroup").each(function() {        

                  var group_id;
                  var field_id_array = new Array(); 
                  var postdata_hidden_array = new Array(); 
                  var postdata = {}; 
                  var url=urlObj.urlSortUpdate;
                  var postdata_hidden= {};

                  group_id = $( ".group_id",this).val();
                  // console.log(group_id);


                        $( ".formlistitem",this).each(function() {
                                
                              postdata_hidden= {};

                              field_id_item=$( ".field_id",this).val();
                              if(field_id_item){
                                  field_id_array.push(field_id_item)
                              } 

      
                              // 1/14変更 
                              $( ".hidden_value",this).each(function() {

                                  var hidden_name=$(this).attr('name');
                                  var hidden_valie=$(this).val();
                                
                                  postdata_hidden['['+hidden_name+']'] =hidden_valie;
                                  postdata_hidden_array.push(postdata_hidden)
                              });

                               // console.log(postdata_hidden_array);

                        });



                   if(field_id_array.length>0){
                      field_id_array=field_id_array.join("_");
                   }else{
                      field_id_array='';
                   }


                    // console.log(field_id_array);
                    // console.log(postdata_hidden_array);


                    postdata['data[Form][group_id]'] =group_id;
                    postdata['data[Form][sort_id]'] =field_id_array;
                    postdata['data[Form][postdata_hidden]'] =postdata_hidden;
                  

                    // data[Form][group_id]=g1
                    // data[Form][sort_id]=f1_f2 
                    // data[Form][hidden_value]=????????


                  // post処理
                  // postServer(url,postdata,function(){

                  // });


        });
  });
  



    $( ".formlist").on( "sortstart", function( event, ui ) {
      $('.formedit').css("display","none");
    });




}



function groupnumberpost() {

        var ar = new Array();
        var postdata = {}; 
        var group_sort_values_number;

        $( ".formgroup_sort").each(function() {
                var group_id;
                group_id = $( ".group_id",this).val();
                ar.push(group_id);
        });

        var group_sort_values_number = ar.join("_");
        postdata['data[Form][group_sort_values]'] = group_sort_values_number;
        console.log(postdata);

        // post処理
        var url=urlObj.urlGroupSort;
        postServer(url,postdata,function(){

        });

}



function validation(inputtext,inputtextarea,textnumber,formtype,multiSelector){
  

  console.log(formtype);


  var error="";
  var multinput=Array();
  var textcount = inputtext.length;
  var inputtextareacount = inputtextarea.length;

  if(textcount == 0){
    error=error+'タイトルを入力してください\n';
  }else if(textcount > 20){
    error=error+'タイトルは20文字以内で入力してください。\n';
  }
  if(inputtextareacount >200){
    error=error+'補足文の入力は200文字以内にしてください。\n';
  }


  if(formtype=="text"){ 

      if(!$.isNumeric(textnumber)){ 
        error=error+'最大文字数は数字のみ入力してください。\n';
      }else if(textnumber > 50){
        error=error+'最大文字数は10以上50字以内で入力してください。\n';
      }else if(textnumber <= 9){
         error=error+'最大文字数は10以上50字以内で入力してください。\n';
      }

  }else if(formtype=="textarea"){
      
      if(!$.isNumeric(textnumber)){ 
        error=error+'最大文字数は数字のみ入力してください。\n';
      }else if(textnumber > 401){
        error=error+'最大文字数は50以上400字以内で入力してください。\n';
      }else if(textnumber <=9){
         error=error+'最大文字数は10以上400字以内で入力してください。\n';
      }


  }else if(formtype=="preset"){

      // none

  }else{
    
          multiSelector.each(function() {
          var inputtext=$('input',this).val();
          if(!inputtext==''){
            multinput.push(inputtext);
          }
        });

        // 入力項目数の制限
        var multinputnum = multinput.length;
        if(multinputnum == 0){
          error=error+'入力項目を記入してください。\n';
        }else if(multinputnum > 20){
          error=error+'入力項目は20個以内にて入力してください。\n';
        }
  }


  if(error==''){
    return true
  }else{
    alert(error);
    return false
  }
}




function postDataMake(formtype,inputtext,inputtextarea,viewflagchk,requiredchk,textnumber,newinputvalidationval,multiSelector){

// 表示フラグ
if(!viewflagchk){
  viewflagchk=0;
}

// 必須フラグ
if(!requiredchk){
  requiredchk=0;
}

formtypeSubmit=formtype;

var postdata = {};   


switch (formtype) {

    case "text":
          postdata['data[MuzFormFieldSetting][title]'] =inputtext;
          postdata['data[MuzFormFieldSetting][type]'] =formtypeSubmit;
          postdata['data[MuzFormFieldSetting][sub_title]'] =inputtextarea;
          postdata['data[MuzFormFieldSetting][view_flg]'] =viewflagchk;
          postdata['data[MuzFormFieldSetting][required_flg]'] =requiredchk;
          postdata['data[MuzFormFieldSettingDetail][max_num]'] =textnumber;
          postdata['data[MuzFormFieldSetting][validation]'] =newinputvalidationval;
    break;

    case "textarea":
          postdata['data[FoMuzFormFieldSettingrm][title]'] =inputtext;
          postdata['data[MuzFormFieldSetting][type]'] =formtypeSubmit;
          postdata['data[MuzFormFieldSetting][sub_title]'] =inputtextarea;
          postdata['data[MuzFormFieldSetting][view_flg]'] =viewflagchk;
          postdata['data[MuzFormFieldSettingDetail][max_num]'] =textnumber;
          postdata['data[MuzFormFieldSetting][required_flg]'] =requiredchk;
    break;

    default :
          postdata['data[MuzFormFieldSetting][title]'] =inputtext;
          postdata['data[MuzFormFieldSetting][type]'] =formtypeSubmit;
          postdata['data[MuzFormFieldSetting][sub_title]'] =inputtextarea;
          postdata['data[MuzFormFieldSetting][view_flg]'] =viewflagchk;
          postdata['data[MuzFormFieldSetting][required_flg]'] =requiredchk;

            var i=0
            multiSelector.each(function() {
                
                    var inputtext=$('input',this).val();
                    if(!inputtext==''){
                        var parametermultinputname='data[MuzFormValueSetting][value]['+i+']';
                        postdata[parametermultinputname] =inputtext;
                        i++;      
                    }
            });
    break;

  }

  console.log(postdata);
  return postdata;
}



/*------------------------------------
common
------------------------------------*/

  function postServer(url,postdata,callback){


    console.log(postdata);

    if(postServerFlag){

        postServerFlag=false;

          //post
          $.ajax({
             type:'post',
             data: postdata,
             url: url,
             dataType: 'json',
             success: function(data) {

                postServerFlag=true;
                console.log(data);
                var status=data.status;
                var err_mes=data.err_mes;

                 if(status=='YES'){
                    console.log(status);
                    callback(data);
                    return data;

                 }else{
                  alert(err_mes);
                  location.reload();
                 }
             },

             error:function() {
              alert('通信エラー');
              location.reload();
             }

          });
      }
  }





});
