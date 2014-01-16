<?php
 include 'inc/header.php';
?>

<div id="main">
  <div id="main_inner" class="userlist">



  <div id="homeleft" >
    <h2>ユーザー 一覧<span class="admin_download"><img src="img/admin_download_2.png" alt="#" /></span></h2>

    <div class="userlisthomeboxmain">

    <div class="userlistitemset">

        <!-- hidden -->
        <input type="hidden" class="hidden_value" name="userid" value="a_12131">
        <!-- hidden -->

        <div class="userlistitemsethead">
          <p class="userlistitemtitle">山田花子</p>
          <p class="userlistitemshow">表示する</p>
          <p class="userlistitemclose">閉じる</p>
          <p class="userlistitemdelete"><img src="img/admin_delete.png" alt="削除"/></p>
          
          <form action="" method="post">
          <p class="userlistitemdownlosd">
          <input type="image" src="img/admin_download.png" alt="ダウンロード">
          </p>
          </form> 

          <p class="userlistitemsave"><img src="img/admin_save.png" alt="保存"/></p>
          <p class="userlistitemeditting"><img src="img/admin_editting.png" alt="編集中"/></p>

          <p class="userlistitemsethead_left">a</p>

        </div>

            <div class="textareashow">



                  <table>
                  <tr>
                  <td>セイ/メイ</td>
                  <td>:</td>
                  <td>ヤマダ ハナコ</td>
                  </tr>

                  <tr>
                  <td>生年月日</td>
                  <td>:</td>
                  <td>1990/01/01</td>
                  </tr>

                  <tr>
                  <td>郵便番号</td>
                  <td>:</td>
                  <td>000-0000</td>
                  </tr>

                  <tr>
                  <td>電話番号</td>
                  <td>:</td>
                  <td>090-0000-0000</td>
                  </tr>

                  <tr>
                  <td>都道府県</td>
                  <td>:</td>
                  <td>東京都</td>
                  </tr>

                  </table>


           </div>
    </div>




    <div class="userlistitemset">


        <!-- hidden -->
        <input type="hidden" class="hidden_value" name="userid" value="a_12131">
        <!-- hidden -->


          <div class="userlistitemsethead">
          <p class="userlistitemtitle">山田花子</p>
          <p class="userlistitemshow">表示する</p>
          <p class="userlistitemclose">閉じる</p>
          <p class="userlistitemdelete"><img src="img/admin_delete.png" alt="削除"/></p>


          <form action="" method="post">
          <p class="userlistitemdownlosd">
          <input type="image" src="img/admin_download.png" alt="ダウンロード">
          </p>
          </form> 


          <p class="userlistitemsave"><img src="img/admin_save.png" alt="保存"/></p>
          <p class="userlistitemeditting"><img src="img/admin_editting.png" alt="編集中"/></p>


        </div>

            <div class="textareashow">


                  <table>
                  <tr>
                  <td>セイ/メイ</td>
                  <td>:</td>
                  <td>ヤマダ ハナコ</td>
                  </tr>

                  <tr>
                  <td>生年月日</td>
                  <td>:</td>
                  <td>1990/01/01</td>
                  </tr>

                  <tr>
                  <td>郵便番号</td>
                  <td>:</td>
                  <td>000-0000</td>
                  </tr>

                  <tr>
                  <td>電話番号</td>
                  <td>:</td>
                  <td>090-0000-0000</td>
                  </tr>

                  <tr>
                  <td>都道府県</td>
                  <td>:</td>
                  <td>東京都</td>
                  </tr>

                  </table>

           </div>


    </div>





    <?php
    // pagination
    include 'inc/pagination.php';
    ?>




    </div>
  </div>

  <div class="homeright_list_wrap">





    <div class="homeright_list">
      <h2>並び替え/絞り込み</h2>

    <div class="userlisthomebox">
        <h2>並び替え</h2>



      <ul id="radiolist">
        <li><input type="radio" name="usersort" value="最新順" checked>最新順</li>
        <li><input type="radio" name="usersort" value="名前順">名前順</li>
      </ul>


      <div class="claer"></div>
    </div>




      <div class="homebox">
        <h2>絞り込み</h2>


      <table>


        <tr>
          <td class="td_1">名前</td>
          <td class="td_2">
                <select class="inputselect required">
                  <option value="あ">あ</option>
                  <option value="い">い</option>
                  <option value="う">う</option>
                </select>
          </td>
        </tr>


          <td class="td_1">フォーム名</td>
          <td class="td_2">
                <select class="inputselect required">
                  <option value="あ">あ</option>
                  <option value="い">い</option>
                  <option value="う">う</option>
                </select>
          </td>
        </tr>

        <tr>
          <td class="td_1">登録年月日</td>

          <td class="td_2">
            <input type="text" id="finfdate_more"   class="userlist_finfdate" placeholder="" readonly="readonly">　〜 　
            <input type="text" id="finfdate_before" class="userlist_finfdate " placeholder="" readonly="readonly">
            <p class="cleardate">日付クリアー</p>
          </td>
        </tr>


      </table>


        <input type="submit" id="userlistserchsubmit2" value="この条件で検索する">
        <br/>


      </div>
    </div>
</div>



  
    </div>
</div>



        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

        <script type="text/javascript">
        <!--
        $(function() {
            $(".userlist_finfdate").datepicker();
        });
        // -->
        </script>






    </div>
    <!-- wrap -->
  </body>
</html>