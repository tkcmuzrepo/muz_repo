<?php
 include 'inc/header.php';
?>
<div id="main">
  <div id="main_inner">
    <div id="form_etc">


     
     <div id="homeleft">
    <h2>広告コード管理</h2>
 
    <div class="advertisingset">
         
        <input type="hidden" value="a_123456" class="hidden_value" name="a_code" >
 
          <div class="advertisingsethead">
            <p class="advertisingtitle">広告コード1</p>
            <input type="text" value="広告コード1" class="advertisingtitleinput">
            <p class="advertisingdelete">削除</p>
            <p class="advertisingsubmit">保存</p>
            <p class="advertisingsubclose">閉じる</p>
            <p class="advertisingedit">編集</p>
            <!-- <p class="advertisingstate">編集中</p> -->
          </div>
 
        <input type="text" class="advertisinginput" value="google_ad_client =ca-pub-xxxxxxxxxxxxxxxx">
    </div>
  </div>
 

  <div id="homeright">
    <h2>広告コード新規作成</h2>
    <p class="advertisingsetnewtitle">広告コードのタイトル</p>
    <input type="text" id="advertisingtitle">
    <input type="text" id="advertisingtextarea" value="google_ad_client=ca-pub-xxxxxxxxxxxxxxxx">
    <input type="submit" value="コードを作成する" id="advertisingsubmitnew">
  </div>
 
</div>
</div>
</div>
 

 

<!-- template -->
<script id="advertisingsettemp" type="text/x-jquery-tmpl">
    <div class="advertisingset">
 
         <div class="advertisingsethead">
 
          <input type="hidden" value="${promotion_id}" class='hidden_value' name="promotion_id">
           
          <p class="advertisingtitle">${advertisingtitle}</p>
          <input type="text" value="${advertisingtitle}" class="advertisingtitleinput">
          <p class="advertisingdelete">削除</p>
          <p class="advertisingsubmit">保存</p>
          <p class="advertisingedit">編集</p>
          // <p class="advertisingstate">編集中</p>
         </div>
           
          <textarea class="" rows="10" placeholder="">${advertisingtextarea}
          </textarea>
     
    </div>
 
</script>
<!-- /template -->


</body>
</html>