<?php
 include 'inc/header.php';
?>
<div id="main">
<?php
  include 'inc/navi.php';
?>
<div id="main_inner" class="formsetting">
<div id="managementnewform">
<h2>フォームの基本設定</h2>

<div class="formsettingboxwrap">


<div class="formsettingbox">
<input type="hidden" class="hidden_value" name="hoge" value="1111">
<div class="formsettingboxhead left">
<p class="formsettingboxheadtitle">応募後ページ テキスト編集　PC画面</p>
<p class="showhtml" id="after_page_html">変更する</p>
</div>
<ul id="radiolist_2">
  <li>
    <input type="file">
  </li>
</ul>
<textarea cols="" rows="10">google_ad_client = "ca-pub-xxxxxxxxxxxxxxxx";
google_ad_slot = "2644871640";
google_ad_width = 728;
google_ad_height = 90;
google_ad_client = "ca-pub-xxxxxxxxxxxxxxxx";
google_ad_slot = "2644871640"; google_ad_width = 728; google_ad_height = 90; 
</textarea>
</div>


<div class="formsettingbox">
<input type="hidden" class="hidden_value" name="hoge" value="1111">
<div class="formsettingboxhead left">
<p class="formsettingboxheadtitle">応募後ページ テキスト編集　スマートフォン</p>
<p class="showhtml" id="sp_after_page_html">変更する</p>
</div>


<textarea cols="" rows="10">google_ad_client = "ca-pub-xxxxxxxxxxxxxxxx";
google_ad_slot = "2644871640";
google_ad_width = 728;
google_ad_height = 90;
google_ad_client = "ca-pub-xxxxxxxxxxxxxxxx";
google_ad_slot = "2644871640"; google_ad_width = 728; google_ad_height = 90; 
</textarea>
</div>

<div class="formsettingbox">
<input type="hidden" class="hidden_value" name="hoge" value="1111">
<div class="formsettingboxhead left">
<p class="formsettingboxheadtitle">応募後ページ テキスト編集 フューチャーフォン</p>
<p class="showhtml" id="mb_after_page_html">変更する</p>
</div>


<textarea cols="" rows="10">google_ad_client = "ca-pub-xxxxxxxxxxxxxxxx";
google_ad_slot = "2644871640";
google_ad_width = 728;
google_ad_height = 90;
google_ad_client = "ca-pub-xxxxxxxxxxxxxxxx";
google_ad_slot = "2644871640"; google_ad_width = 728; google_ad_height = 90; 
</textarea>
</div>


<div class="formsettingbox">
<div class="formsettingboxhead left">
<p class="formsettingboxheadtitle">注意文の編集</p>
</div>






<table class="table table-hover notetable">

<tr>
  <td>
    <h4>新規作成</h4>
  </td>
</tr>

<tr>
  <td class="th">
    <textarea class="form-control" rows="1" id="noteNewTextarea"></textarea>
  </td>
  
  <td>
    <button type="button" class="btn btn-warning" id="noteNewSubmit">　　　　 注意文を新規作成する 　　　　</button>
  </td>

</tr>
</table>




<table class="table table-hover notetable" id="notearea">

<tr>
  <td>
    <h4>既存の注意文</h4>
  </td>
</tr>


<tr>
  <td class="th">
    <textarea disabled class="form-control" rows="1">注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文 </textarea>
    
    <!-- hidden_value -->
    <input type="hidden" class="hidden_value" name="message_id" value="m_123456">
    <!-- hidden_value -->

  </td>
  <td>
  <button type="button" class="btn btn-primary btn-sm noteedit">　編集する　</button>
  <button type="button" class="btn btn-warning btn-sm noteeditsubmit">　更新する　</button>
  <button type="button" class="btn btn-danger btn-sm notedelete">　削除する　</button>
  
  <span class="showhide">
  <button type="button" class="btn btn-default btn-sm noteshow">非表示にする</button>
  <button type="button" class="btn btn-success btn-sm notehide">　表示する　</button>
  </span>
  
  </td>
</tr>




<tr>
   <td class="th">
   <textarea disabled class="form-control" rows="1">注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文注意文 </textarea>

    <!-- hidden_value -->
    <input type="hidden" class="hidden_value" name="message_id" value="m_123457">
    <!-- hidden_value -->

  </td>
  <td>
  <button type="button" class="btn btn-primary btn-sm noteedit">　編集する　</button>
  <button type="button" class="btn btn-warning btn-sm noteeditsubmit">　更新する　</button>
  <button type="button" class="btn btn-danger btn-sm notedelete">　削除する　</button>
  
  <span class="showhide">
  <button type="button" class="btn btn-default btn-sm noteshow">非表示にする</button>
  <button type="button" class="btn btn-success btn-sm notehide">　表示する　</button>
  </span>
  
  </td>
</tr>

</table>




<!-- template -->
<script id="tempnote" type="text/x-jquery-tmpl">

<tr>
  <td>
    <textarea disabled class="form-control" rows="1">${noteNewTextarea}</textarea>


    <input type="hidden" class="hidden_value" name="message_id" value="${message_id}">
    <input type="hidden" class="hidden_value" name="date_key" value="${date_key}">
    <input type="hidden" class="hidden_value" name="form_id" value="${form_id}">
  </td>
  
  <td>
  <button type="button" class="btn btn-primary btn-sm noteedit">　編集する　</button>
  <button type="button" class="btn btn-warning btn-sm noteeditsubmit">　更新する　</button>
  <button type="button" class="btn btn-danger btn-sm notedelete">　削除する　</button>
  
  <span class="showhide">
  <button type="button" class="btn btn-default btn-sm noteshow">非表示にする</button>
  <button type="button" class="btn btn-success btn-sm notehide">　表示する　</button>
  </span>
  
  </td>
</tr>



</script>
<!-- /template -->








</div>
</div>
</div>
</div>
</body>
</html>