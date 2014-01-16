$(function() {


initialize();





$("body").on("click", "#makenewinput", function(e) {


  if(!validation()){
    return;
  }

  var inputtext=$("#inputtext").val();
  var inputtextarea=$("#inputtextarea").val();
  var textnumber=$("#textnumber").val();
  var formtype = $("input[name='radio']:checked").val();
  var requiredchk = $("input[name='requiredchk']:checked").val();
  var viewflagchk = $("input[name='viewflag']:checked").val();
  var multinput=Array();
  var radioname='radio'+(new Date)/1000;
  var formid='demo1';
  var formtypenumber;

 
  $( ".multinput li").each(function() {
    var inputtext=$('input',this).val();
    if(!inputtext==''){
      multinput.push(inputtext);
    }
  });


  if(formtype == 'テキスト入力'){
    formtypenumber=1;
  }else if(formtype == '電話番号'){
    formtypenumber=3;
  }else if(formtype == '郵便番号'){
    formtypenumber=3;
  }else{
    formtypenumber=2;
  }


  var data = [{ 
      "inputtext" : inputtext,
      "inputtextarea" : inputtextarea, 
      "textnumber" : textnumber, 
      "formtype" : formtype, 
      "multinput" : multinput, 
      "requiredchk" : requiredchk, 
      "viewflagchk" : viewflagchk, 
      "radioname" : radioname, 
      "formid" : formid, 
      "formtypenumber" : formtypenumber, 
    } 
  ];



  $.tmpl( $('#template'), data ).appendTo( "#makedinput .formlist" );



    // $.ajax({
    //   type: 'post',
    //   url: 'post.php',
    //   data: {
    //     'data[Form][Title]': 'inputtext',
    //     'data[Form][Type]': 'formtype',
    //     'data[Form][Comment]': 'inputtextarea',
    //     'data[Form][Title]': 'nandeyanen',
    //     'data[Form][form_required]': 'nandeyanen',
    //     'data[Form][form_view]': 'nandeyanen',
    //     },
    //   success: function(data){
    //     alert(data);
    //   }
    // });



  $('#newinput input').val('');
  $('#newinput textarea').val('');
  $('#newinput .multinput li input').val('');
  $('#newinput .multinput').html('');
  $.tmpl( $('#multinputreset')).appendTo( "#newinput .multinput" );
  $('#newinput .modeselecrradio').html('');
  $.tmpl( $('#formtypeselectreset')).appendTo( "#newinput .modeselecrradio" );
  $('.switcheditshow_new_1').css("display","block");
  $('.switcheditshow_new_2').css("display","none");
  $("#textnumber").val('20');





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
});

$("body").on("click", ".groupdown", function(e) {
  var selector =$(this).parent(".formgroup");
  $(selector).insertAfter($(selector).next('.formgroup'));
});

$("body").on("click", ".togle", function(e) {
  $(this).next().slideToggle();
});




$("body").on("change",　".modeselecrradio input", function(e) {

  var str=$(this).val();

  if(str=='テキスト入力'){
    $('.switcheditshow_new_1').css("display","block");
    $('.switcheditshow_new_2').css("display","none");
  }else{
    $('.switcheditshow_new_1').css("display","none");
    $('.switcheditshow_new_2').css("display","block");
  }

  if(str=='電話番号'){
    $('.switcheditshow_new_1').css("display","none");
    $('.switcheditshow_new_2').css("display","none");
  }

  if(str=='郵便番号'){
    $('.switcheditshow_new_1').css("display","none");
    $('.switcheditshow_new_2').css("display","none");
  }

});




$("body").on("change",　".switcheditmoderadio", function(e) {

  var str=$(this).val();
  var wraphtml=$(this).parents(".formtypeselect");
  var wraphtml=$(this).parents(".formlistitem");

  if(str=='テキスト入力'){
    $('.switcheditshow_1',wraphtml).css("display","block");
    $('.switcheditshow_2',wraphtml).css("display","none");
  }else{
    $('.switcheditshow_1',wraphtml).css("display","none");
    $('.switcheditshow_2',wraphtml).css("display","block");
  }


  if(str=='電話番号'){
    $('.switcheditshow_1',wraphtml).css("display","none");
    $('.switcheditshow_2',wraphtml).css("display","none");
  }

  if(str=='郵便番号'){
    $('.switcheditshow_1',wraphtml).css("display","none");
    $('.switcheditshow_2',wraphtml).css("display","none");
  }

});


$("body").on("click",　"#newgroupsubmit", function(e) {
$.tmpl( $('#newgroup')).appendTo('#usedform');


initialize();



});







function initialize() {

  $(".formlist").sortable({
    connectWith: ".formlist",
    opacity: 0.7,
    revert: true,
    croll: true,
  });


  $( ".formlist" ).bind( "sortupdate", function(event, ui) { 
    var items = $( ".formlist" ).sortable( "toArray" );
  });

  $( ".formlist" ).on( "sortstart", function( event, ui ) {
    $('.formedit').css("display","none");
  });

}




function validation() {
  
  var error="";
  var inputtext=$("#inputtext").val();
  var inputtextarea=$("#inputtextarea").val();
  var textnumber=$("#textnumber").val();
  var formtype = $("input[name='radio']:checked").val();
  var multinput=Array();


  var textcount = inputtext.length;
  var inputtextareacount = inputtextarea.length;


  if(textcount == 0){
    error=error+'フォームのタイトルを入力してください\n';
  }else if(textcount > 20){
    error=error+'フォームのタイトルは20文字以内で入力してください。\n';
  }

  if(inputtextareacount >200){
    error=error+'補足文の入力は200文字以内にしてください。\n';
  }



  if(formtype=="テキスト入力"){
      if(!$.isNumeric(textnumber)){ 
        error=error+'最大文字数は数字のみ入力してください。\n';
      }else if(textnumber > 50){
        error=error+'最大文字数は10以上50以内で入力してください。\n';
      }else if(textnumber <= 10){
         error=error+'最大文字数は10以上50以内で入力してください。\n';
      }

  }else{

      if(formtype !="電話番号" && formtype !="郵便番号"){


        $( ".multinput li").each(function() {
          var inputtext=$('input',this).val();
          if(!inputtext==''){
            multinput.push(inputtext);
          }
        });

        var multinputnum = multinput.length;
        if(multinputnum == 0){
          error=error+'入力項目を記入してください。\n';
        }else if(multinputnum > 20){
          error=error+'入力項目は20個以内にて入力してください。\n';
        }


      }
  }



  if(error==''){
    return true
  }else{
    alert(error);
    return false
  }



}






});
