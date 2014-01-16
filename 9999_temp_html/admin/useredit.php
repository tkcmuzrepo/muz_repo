<?php
 include 'inc/header.php';
?>
<div id="main">
  <div id="main_inner">
    <div id="form_etc">


      <div id="homeleft">
        <h2>ログイン情報一覧</h2>
        <div class="homeleftbox usereditset">

              <!-- hidden_value -->
              <input type="hidden" value="a_123456" class="hidden_value" name="account_id">
              <!-- hidden_value -->


          <div class="homeleftboxhead">
            <p class="homeleftboxheadtitle"><span class="usernametitle">山田太郎</span><span class="usercode">abc</span></p>
              <p class="homeleftboxheaddelete useritemedelete">削除</p>
              <p class="homeleftboxheadubmit useritemesubmit">保存</p>
              <p class="homeleftboxheadubmit useritemeclose">閉じる</p>
              <p class="homeleftboxheadedit useritemeedit">編集</p>
              <p class="homeleftboxheadstate useritemestate">編集中</p>
          </div>

          <div class="useredititemtablewrap">
            <table class="useredititemtable">

              <tr>
                <td>ユーザー名 : </td>
                <td>
                  <input type="text" class="itemusernameinput" value="山田太郎">
                </td>
              </tr>

              <tr>
                <td>ユーザーID : </td>
                <td>
                  <input type="text" class="itemuseridinput" value="abc">
                </td>
              </tr>

              <tr>
                <td>パスワード : </td>
                <td>
                  <input type="text" class="itemuserpassinput" value="pass">
                </td>
              </tr>

            </table>

                <!-- hidden_value -->
                <input type="hidden" class="hidden_value" name="account_id" value="a_123456">
                <!-- /hidden_value -->
          </div>
        </div>
      </div>


      <div id="homeright">
        <h2>ログイン情報の新規作成</h2>
        <table class="useredititemtable useredititemtableshort">
          <tr>
            <td>ユーザー名 : </td>
            <td>
              <input type="text" class="itemusernameinput" id="itemusernameinput">
            </td>
          </tr>
          <tr>
            <td>ユーザーID : </td>
            <td>
              <input type="text" class="itemuseridinput" id="itemuseridinput">
            </td>
          </tr>
          <tr>
            <td class="useredititemtable_long">パスワード : </td>
            <td>
              <input type="text" class="itemuserpassinput" id="itemuserpassinput">
            </td>
          </tr>
          <tr>
            <td class="useredititemtable_long">パスワード(確認用) : </td>
            <td>
              <input type="text" class="itemuserpasscommitinput" id="itemuserpasscommitinput">
            </td>
          </tr>
          
          <tr>
            <td class="useredititemtable_long">マスター権限: </td>
            <td>
              <ul class="usereditradio">
                <li>
                  <input type="checkbox" name="masetauthority" value="true">マスター権限を作成する
                </li>
              </ul>
            </td>
          </tr>


        </table>


        <center>
          <input type="submit" value="ログイン情報を作成する" id="useredcreatnewuser">
        </center>
      </div>
    </div>
  </div>
</div>



<!-- template -->
<script id="useredititemtabletnp" type="text/x-jquery-tmpl">

    <div class="homeleftbox usereditset">


          // hidden_value
          <input type="hidden" class="hidden_value" name="account_id" value="${account_id}">
          // hidden_value

  
         <div class="homeleftboxhead">
              <p class="homeleftboxheadtitle"><span class="usernametitle">${itemusernameinput}</span><span class="usercode">${itemuseridinput}</span></p>
              <p class="homeleftboxheaddelete useritemedelete">削除</p>
              <p class="homeleftboxheadubmit useritemesubmit">保存</p>
              <p class="homeleftboxheadubmit useritemeclose">閉じる</p>
              <p class="homeleftboxheadedit useritemeedit">編集</p>
              <p class="homeleftboxheadstate useritemestate">編集中</p>
         </div>


      <div class="useredititemtablewrap">
         <table class="useredititemtable">
            <tr>
                <td>
                    ユーザー名 :
                </td>

                <td>
                     <input type="text" class="itemusernameinput" value="${itemusernameinput}">
                </td>
            </tr>

            <tr>
                <td>
                    ユーザーID :
                </td>

                <td>
                     <input type="text" class="itemuseridinput" value="${itemuseridinput}">
                </td>
            </tr>

            <tr>
                <td>
                    パスワード :
                </td>

                <td>
                     <input type="text" class="itemuserpassinput" value="${itemuserpassinput}">
                </td>
            </tr>

         </table>

    

         </div>

    </div>

</script>
<!-- /template -->


</body>
</html>