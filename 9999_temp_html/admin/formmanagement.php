

<?php
 include 'inc/header.php';
?>
<div id="main">
<?php
  include 'inc/navi_2.php';
?>





<div id="main_inner" class="homemanagement">

  <div id="homeleft">
    <h2>現在公開中のフォーム</h2>

    <div class="managementformwrap">
       <div class="managementform">
          <p class="managementformtitle">新規採用</p>
          <p class="managementformesit">編集する</p>
          <p class="managementformpre">プレビュー</p>
      </div>

       <div class="managementform">
          <p class="managementformtitle">中途採用</p>
          <p class="managementformesit">編集する</p>
          <p class="managementformpre">プレビュー</p>
      </div>
      
    </div>
  </div>




  <div id="homeright" class="homemanagementright">

      <h2>未公開のフォーム</h2>
    <div class="managementformwrap">
          <div class="managementform">
            <p class="managementformtitle">店長候補採用</p>
            <p class="managementformesit">編集する</p>
            <p class="managementformpre">プレビュー</p>
        </div>

         <div class="managementform">
            <p class="managementformtitle">企画営業採用</p>
            <p class="managementformesit">編集する</p>
            <p class="managementformpre">プレビュー</p>
        </div>
  </div>
</div>



</div>
</div>




<script type="text/javascript">
<!--


  $(".managementformwrap").sortable({
    connectWith: ".managementformwrap",
    opacity: 0.7,
    revert: true,
    croll: true,
  });



// -->
</script>









</body>
</html>
