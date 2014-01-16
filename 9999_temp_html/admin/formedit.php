<?php

function formlistitem(){

$item = <<< EOF

            <div class="formlistitem" style=
            "position: relative; opacity: 1; z-index: 0;">

                <input type="hidden" value="select" class="formmodetypehidden">


                <!-- hidden_value -->
                <input type="hidden" class="field_id" value="f_1">
                <input type="hidden" class="hidden_value" name="hidden_value_1_1" type="hidden" value="h_1_1"">
                <input type="hidden" class="hidden_value" name="hidden_value_1_1" type="hidden" value="h_1_1"">
                <!-- /hidden_value -->



                <div class="formlistitemtitle">
                    プルダウンサンプル
                </div><!-- formlistitemtitle -->

                <div class="togle">
                    ▼
                </div><!-- togle -->

                <div class="formedit" style="display: none;">
                    <div class="formeditleft">
                        <h2>フォームのタイトル</h2><input class="inputtext" type="text" value="プルダウンサンプル">

                        <div class="switcheditshow_1" style="display:none">
                            <h2>最大文字数</h2><input class="inputtext textnumber" type="text" value="20">

                            <h2>入力の制限</h2>

                            <ul>
                                <li><select class="newinputvalidation">
                                    <option value="none">制限なし</option>
                                    <option value="validate_number">数字のみ</option>
                                    <option value="validate_alpha">アルファベットのみ</option>
                                </select></li>
                            </ul>

                        </div><!-- switcheditshow_1 -->

                        <div class="switcheditshow_2">
                            <h2>入力項目</h2>

                            <ul class=
                            "formtypeselect multinput_edit">
                                <li><span class="multinputremove">×</span>
                                <input name="" type="text" value=""></li>

                                <li><span class="multinputremove">×</span>
                                <input name="" type="text" value=""></li>

                                <li><span class="multinputremove">×</span>
                                <input name="" type="text" value=""></li>

                                <li><span class="multinputremove">×</span>
                                <input name="" type="text" value=""></li>

                                <li><span class="multinputremove">×</span>
                                <input name="" type="text" value=""></li>

                                <li><span class="multinputremove">×</span>
                                <input name="" type="text" value=""></li>
                            </ul>
                        </div><!-- switcheditshow_2 -->

                        <h2>補足文</h2>
                        <textarea class="inputtextarea" cols="40" rows="4">補足文</textarea>

                        <h2>必須項目の設定</h2>
                        <p><input checked class="requiredcheckbox" name="requiredchk" type="checkbox" value="1">必須項目</p>
                        <h2>表示の設定</h2>
                        <p><input checked class="viewflagchkbox" name="requiredchk" type="checkbox" value="1">この項目表示する</p>
                    </div>

                    <div class="formeditright">
                        <h2>フォームの種類</h2>
                        <p class="formmodetype">プルダウン</p>
                        <input type="hidden" value="プルダウン" class="formmodetypehidden">

                        <div class="fieldeditsubmit">
                            変更する
                        </div><!-- fieldeditsubmit -->
                    </div><!-- formeditright -->

                    <div class="fielddeltesubmit">
                        削除する
                    </div><!-- fielddeltesubmit -->
                </div><!-- formedit -->
            </div><!-- /formlistitem -->


EOF;

echo $item;

}




function formlistitemPre(){

$item = <<< EOF

         <div class="formlistitem">
                
                <input type="hidden" value="preset" class="formmodetypehidden">
                <input type="hidden" value="f_2" class="field_id">

                
                <div class="hidden_value">
                    <input name="hidden_value" type="hidden"
                    value="h_2">
                </div><!-- hidden_value -->


                <div class="formlistitemtitle presetitme">
                    名前(性・名)
                </div><!-- formlistitemtitle -->

                <div class="togle">
                    ▼
                </div><!-- togle -->

                <div class="formedit">

                    <div class="formeditleft">

                        <h2>フォームのタイトル</h2>
                        <input class="inputtext" type="text" value="名前(性・名)">
                        <div class="switcheditshow_2" style="display:none">
                            <h2>入力項目</h2>
                            <ul class="formtypeselect multinput_edit">
                                <li><span class="multinputremove">×</span>
                                <input name="" type="text" value="">
                            </li>
                            </ul>
                        </div><!-- switcheditshow_2 -->


                        <h2>補足文</h2>
                        <textarea class="inputtextarea" cols="40" rows="4"></textarea>
                        <h2>必須項目の設定</h2>
                        <p><input checked class="requiredcheckbox" name="requiredchk" type="checkbox" value="1">必須項目</p>
                        <h2>表示の設定</h2>
                        <p><input checked class="viewflagchkbox" name="requiredchk" type="checkbox" value="1">この項目表示する</p>

                    </div><!-- formeditleft -->


                    <div class="formeditright">
                        <div class="fieldeditsubmit">
                            変更する
                        </div><!-- fieldeditsubmit -->
                    </div><!-- formeditright -->
                </div><!-- formedit -->
            </div><!-- formlistitem -->

EOF;

echo $item;

}







?>




<?php
 include 'inc/header.php';
?>

<div id="main">

<?php
  include 'inc/navi.php';
?>


   <div id="main_inner">
            <div id="main_inner_left">
                <div id="usedform">
                    <h1>現在使用中のフィールド</h1>

                    <div class="formgroup formgroup_sort">
                        <input class="group_id" type="hidden" value="g_1">

                        <div class="groupup">
                            ▲
                        </div><!-- groupup -->

                        <div class="groupdown">
                            ▼
                        </div><!-- groupdown -->

                        <h1>グループ1</h1>


                        <div class="formlist">
                            

                                <?php formlistitem() ?>
                                <?php formlistitem() ?>
                                <?php formlistitem() ?>


                        </div><!-- formlist -->
                    </div><!-- formgroup -->

                    <div class="formgroup formgroup_sort">

                        <input class="group_id" type="hidden" value="g_2">

                        <div class="groupup">
                            ▲
                        </div><!-- groupup -->

                        <div class="groupdown">
                            ▼
                        </div><!-- groupdown -->

                        <h1>グループ2</h1>

                        <div class="formlist">

                                <?php formlistitem() ?>
                                <?php formlistitem() ?>
                                <?php formlistitem() ?>


                        </div><!-- formlist -->
                    </div><!-- formgroup -->
                </div><!-- usedform -->
            </div><!-- main_inner_left -->

            <div id="main_inner_right">
                <div id="makedinput">
                    <h1>使用可能なフィールド</h1>

                    <div class="formgroup">
                        <!-- グループID -->
                        <input class="group_id" type="hidden" value="g_0">
                        <!-- /グループID -->

                        <div class="formlist">


                           

                    
                           <?php formlistitemPre() ?>
                           <?php formlistitemPre() ?>
                           <?php formlistitemPre() ?>
                           <?php formlistitemPre() ?>


                           



                        </div><!-- formlist -->
                    </div><!-- formgroup -->
                </div><!-- makedinput -->

                <div id="newinput">
                    <h1>フィールドの新規作成</h1>

                    <h2>フォームのタイトル</h2><input id="inputtext" placeholder=
                    "フォームのタイトル" type="text">

                    <h2>フォームの種類</h2>

                    <ul class="newformul modeselecrradio">
                        <li><input type="radio" name="radio" value="text" class="" checked>テキスト入力</li>
                        <li><input type="radio" name="radio" value="select">プルダウン</li>
                        <li><input type="radio" name="radio" value="radio">ラジオボタン</li>
                        <li><input type="radio" name="radio" value="checkbox">チェックボックス</li>
                        <li><input type="radio" name="radio" value="textarea">テキストエリア</li>
                    </ul>
                    

                    <div class="switcheditshow_new_1">
 
                            
                            <h2>最大文字数</h2>
                            <ul class="newformul">
                                <li><input id="textnumber" name="" type="text"
                                value="20"></li>
                            </ul>
                    </div><!-- switcheditshow_new_1 -->


                    <div class="switcheditshow_new_2">
                            <h2>入力の制限</h2>
                            <ul class="newformul">
                                <li>
                                    <select id="newinputvalidation">
                                    <option value="none">制限なし</option>
                                    <option value="validate_number">数字のみ</option>
                                    <option value="validate_alpha">アルファベットのみ</option>
                                    </select>
                                </li>
                            </ul>                        
                    </div><!-- switcheditshow_new_1 -->



                    <div class="switcheditshow_new_3" style="display:none">
                        <h2>入力項目</h2>
                        <div class="formtypeselecttext">
                            <ul class="newformul multinput">
                                <li><input name="" type="text" value=""></li>
                                <li><input name="" type="text" value=""></li>
                            </ul>
                        </div><!-- formtypeselecttext -->
                    </div><!-- switcheditshow_new_2 -->




                    <h2>補足文</h2>
                    <textarea class="inputtextarea" cols="40" id=
                    "inputtextarea" placeholder="補足文" rows="4"></textarea>

                    <h2>必須項目の設定</h2>

                    <p><input class="checkboxhtml" id="requiredcheckbox" name=
                    "requiredchk" type="checkbox" value="1">必須項目に設定する</p>

                    <h2>表示の設定</h2>

                    <p><input class="checkboxhtml" id="viewflagchkbox" name=
                    "viewflagchk" type="checkbox" value="1">この項目表示する</p>

                    <div id="makenewinput">
                        フィールドを作成する
                    </div><!-- makenewinput -->
                </div><!-- newinput -->
            </div><!-- main_inner_right -->
        </div><!-- main_inner -->
    </div><!-- main -->
 </div><!-- wrap -->



<!-- template -->
<script id="template" type="text/x-jquery-tmpl">

<div class="formlistitem">


      <!-- フィールドID -->
        <input type="hidden" value="${formid}　" class="field_id">
      <!-- フィールド -->

      <!-- hidden_value -->
      <div class="hidden_value">
        <input type="hidden" value="h_12" name="hidden_value">
      </div>
      <!-- /hidden_value -->




<div class="formlistitemtitle"> 
${inputtext}
</div>


<div class="togle">▼</div>
<div class="formedit">

  <div class="formeditleft">


  <h2>フォームのタイトル</h2>
   <input type="text" class="inputtext" value="${inputtext}">




    {{if formtype == 'text'}}

    <h2>最大文字数</h2>
    <input type="text" class="inputtext textnumber" value="${textnumber}">

    <h2>入力の制限</h2>
    
          <ul>
            <li>
            <select class="newinputvalidation">
              <option value="none" {{if newinputvalidationval == 'none'}} selected {{/if}}>制限なし</option>
              <option value="validate_number" {{if newinputvalidationval == 'validate_number'}} selected {{/if}}>数字のみ</option>
              <option value="validate_alpha" {{if newinputvalidationval == 'validate_alpha'}} selected {{/if}}>アルファベットのみ</option>
            </select>
            </li>
          </ul>

    {{/if}}


    {{if formtype == 'textarea'}}
    <h2>最大文字数</h2>
    <input type="text" class="inputtext textnumber" value="${textnumber}">
    {{/if}}



    {{if formtype == 'text'}}
      <div class="switcheditshow_2" style="display:none">    
    {{else}} 
           
          {{if formtypenumber > 2}}
              <div class="switcheditshow_2">
          {{else}}
              <div class="switcheditshow_2" style="display:none">    
          {{/if}}

    {{/if}}


    <h2>入力項目</h2>
    <ul class="formtypeselect multinput_edit">
       {{each multinput}}
         <li><span class="multinputremove">×</span><input type="text" name="" value="${this}"></li>
        {{/each}}
        <li><span class="multinputremove">×</span><input type="text" name="" value=""></li>
    </ul>

    </div>


    <h2>補足文</h2>
    <textarea cols=40 rows=4 class="inputtextarea">${inputtextarea}</textarea>

    <h2>必須項目の設定</h2>
        {{if requiredchk == '1'}}
          <p><input type="checkbox" class="requiredcheckbox" name="requiredchk" value="1" checked>必須項目</p>
        {{else}} 
         <p><input type="checkbox" class="requiredcheckbox" name="requiredchk" value="1">必須項目</p>
      {{/if}}


    <h2>表示の設定</h2>
        {{if requiredchk == '1'}}
          <p><input type="checkbox" class="viewflagchkbox" name="requiredchk" value="1" checked>この項目表示する</p>
        {{else}} 
         <p><input type="checkbox" class="viewflagchkbox" name="requiredchk" value="1">この項目表示する</p>
      {{/if}}


</div>


  <div class="formeditright">


  <h2>フォームの種類</h2>

    {{if formtype == 'text'}}
        <p class="formmodetype">テキスト入力</p>
        <input type="hidden" value="text" class="formmodetypehidden">
    {{/if}}
  
    {{if formtype == 'select'}}
        <p class="formmodetype">プルダウン</p>
        <input type="hidden" value="select" class="formmodetypehidden">
    {{/if}}

    {{if formtype == 'radio'}}
        <p class="formmodetype">ラジオボタン</p>
        <input type="hidden" value="radio" class="formmodetypehidden">
    {{/if}}
  
    {{if formtype == 'checkbox'}}
        <p class="formmodetype">チェックエリア</p>
        <input type="hidden" value="checkbox" class="formmodetypehidden">
    {{/if}}

    {{if formtype == 'textarea'}}
        <p class="formmodetype">テキストエリア</p>
        <input type="hidden" value="textarea" class="formmodetypehidden">
    {{/if}}


    <div class="fieldeditsubmit">変更する</div>
  </div>

<div class="fielddeltesubmit">削除する</div>
</div>
</div>


</script>
<!-- /template -->

<!-- template -->
<script id="multinputli" type="text/x-jquery-tmpl">
<li><span class="multinputremove">×</span><input type="text" name="example" value=""></li>
</script>
<!-- /template -->

<!-- template -->
<script id="formtypeselectreset" type="text/x-jquery-tmpl">
<li><input type="radio" name="radio" value="text" checked>テキスト入力</li>
<li><input type="radio" name="radio" value="select">プルダウン</li>
<li><input type="radio" name="radio" value="radio">ラジオボタン</li>
<li><input type="radio" name="radio" value="checkbox">チェックボックス</li>
<li><input type="radio" name="radio" value="textarea">テキストエリア</li>
</script>
<!-- /template -->

<!-- template -->
<script id="multinputreset" type="text/x-jquery-tmpl">
<li><input type="text" name="example" value=""></li>
<li><input type="text" name="example" value=""></li>
</script>
<!-- /template -->



    </body>
</html>