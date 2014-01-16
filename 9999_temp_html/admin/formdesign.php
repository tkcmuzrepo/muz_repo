<?php
  include 'inc/header.php';
?>

<div id="main">



<?php
  include 'inc/navi.php';
?>



<div id="main_inner" class="formdesign">

  <!-- hidden_value -->
  <input hidden class="hidden_value" value="1231">
  <!-- hidden_value -->

  
  <div id="homeleft">
    <h2>ヘッダーの編集</h2>


      <div class="formboxdesign">
              
              <!-- hidden_value -->
              <input type="hidden" value="f_123456" class="hidden_value" name="form_id">
              <input type="hidden" value="d_123456" class="hidden_value" name="date_key">
              <input type="hidden" value="s_123456" class="hidden_value" name="site">
              <!-- hidden_value -->

          <div class="formboxdesignhead">
            <p class="formboxdesignheadtitle">ヘッダー編集　PC</p>
            <p class="showhtml formboxdesignheaderedit_1">変更</p>
            <p class="formboxdesignfile"><input type="file"></p>
          </div>
        <textarea cols="" rows="10" placeholder="">aaa</textarea>
      </div>



      <div class="formboxdesign">

              <!-- hidden_value -->
              <input type="hidden" value="f_123456" class="hidden_value" name="form_id">
              <input type="hidden" value="d_123456" class="hidden_value" name="date_key">
              <input type="hidden" value="s_123456" class="hidden_value" name="site">
              <!-- hidden_value -->

          <div class="formboxdesignhead">
            <p class="formboxdesignheadtitle">ヘッダー編集 スマートフォン</p>
            <p class="showhtml formboxdesignheaderedit_2">変更</p>
            <p class="formboxdesignfile"><input type="file"></p>
          </div>
        <textarea cols="" rows="10" placeholder="">aaa</textarea>
      </div>



      <div class="formboxdesign">

              <!-- hidden_value -->
              <input type="hidden" value="f_123456" class="hidden_value" name="form_id">
              <input type="hidden" value="d_123456" class="hidden_value" name="date_key">
              <input type="hidden" value="s_123456" class="hidden_value" name="site">
              <!-- hidden_value -->

          <div class="formboxdesignhead">
            <p class="formboxdesignheadtitle">ヘッダー編集　フューチャーフォン</p>
            <p class="showhtml formboxdesignheaderedit_3">変更</p>
            <p class="formboxdesignfile"><input type="file"></p>
          </div>
        <textarea cols="" rows="10" placeholder="">aaa</textarea>
      </div>


    </div>






  <div id="homeright">
    <h2>色の変更</h2>

    <div class="homebox">
      <h3>文字の色</h3>

      <table>
        <tr>
          <td>フォームタイトル</td>
          <td><input class="color site_string_title_color" id="formdesign_color_1" value="FFE852"></td>
        </tr>

        <tr>
          <td>補助文</td>
          <td><input class="color site_string_auxiliary_color" id="formdesign_color_2" value="ABFFD2"></td>
        </tr>

        <tr>
          <td>注意文</td>
          <td><input class="color site_string_note_color" id="formdesign_color_3" value="66FF00"></td>
        </tr>


      </table>


    </div>





    <div class="homebox">
      <h3>背景の色</h3>
      
      <table>
        <tr>
          <td>全体背景</td>
          <td><input class="color site_bg_entire_color" id="formdesign_color_4" value="ABFFC1"></td>
        </tr>

        <tr>
          <td>グループタイトル</td>
         <td><input class="color site_bg_group_title_color" id="formdesign_color_5" value="66FF00"></td>
        </tr>

        <tr>
          <td>グループ背景</td>
         <td><input class="color site_bg_group_color" id="formdesign_color_6" value="FB80FF"></td>
        </tr>

        <tr>
          <td>フォームタイトル</td>
          <td><input class="color site_bg_title_color" id="formdesign_color_7" value="FF26D4"></td>
        </tr>

        <tr>
          <td>フォーム背景</td>
          <td><input class="color site_bg_form_color" id="formdesign_color_8" value="66FF00"></td>
        </tr>

        <tr>
          <td>入力フォーム</td>
          <td><input class="color site_bg_input_color" id="formdesign_color_9" value="66FF00"></td>
        </tr>

        <tr>
          <td>決定ボタン</td>
         <td><input class="color site_bg_decide_btn_color" id="formdesign_color_10" value="EEFFAB"></td>
        </tr>

      </table>

    </div>


  </div>


</div>
</div>





<!-- form_id -->
<input type="hidden" name="form_id" value="123">




</body>
</html>