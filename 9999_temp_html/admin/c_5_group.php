<div id="main_inner" class="formmanagement">



		<div id="homeleft">
			<h2>現在公開中のグループ</h2>


			<!-- managementformwarap -->
			<div class="managementformwarap show">



				<!-- managementform -->
				<div class="managementform">
					公開グループ1
					<p class="makenewgroupDelete">×</p>	
					
					<!-- hidden_value -->
					<input type="hidden" value="g_123456" class='hidden_value' name="group_id">
					<input type="hidden" value="d_123456" class='hidden_value' name="date_key">
					<!-- hidden_value -->

				</div>
				<!-- /managementform -->


				<!-- managementform -->
				<div class="managementform" id="managementformwarapNewShow">
					公開グループ2
					<p class="makenewgroupDelete">×</p>	
					
					<!-- hidden_value -->
					<input type="hidden" value="g_123456" class='hidden_value' name="group_id">
					<input type="hidden" value="d_123456" class='hidden_value' name="date_key">
					<!-- hidden_value -->

				</div>
				<!-- /managementform -->


			</div>






		</div>





		<div id="main_inner_right" clas="formmanagement_right">

			<div id="homeright" class="makenewgroupunused">
				<h2>未公開のグループ</h2>
				
				<!-- managementformwarap -->
				<div class="managementformwarap" id="managementformwarapNew">
				

					<!-- managementform -->
					<div class="managementform">
						テストグループ1
						<p class="makenewgroupDelete">×</p>
						
						<!-- hidden_value -->
						<input type="hidden" value="g_123456" class='hidden_value' name="group_id">
						<input type="hidden" value="d_123456" class='hidden_value' name="date_key">
						<!-- hidden_value -->

					</div>
					<!-- /managementform -->
				</div>

			</div>




			<div id="homeright">
				<h2>グループの新規作成</h2>
				<div class="homeright_inner">
				<p>グループのタイトルグループのタイトル</p>
				<input name="data[MuzFormGroupSetting][group_title]" id="inputgrouptitle" placeholder="" type="text"/><p>サブタイトル</p>
				<input name="data[MuzFormGroupSetting][inputgroupsubtitle]" id="inputgroupsubtitle" placeholder="" type="text"/>
				<div id="makenewgroup">グループを作成する</div>
				</div>
			</div>
			
		</div>



	</div>
</div>




<!-- template -->
<script id="managementformtmp" type="text/x-jquery-tmpl">

<div class="managementform">


<input type="hidden" value="${group_id}" name="group_id" class="hidden_value">
<input type="hidden" value="${date_key}" name="date_key" class="hidden_value">


${inputgrouptitle}
<p class="makenewgroupDelete">×</p>
</div>

</script>
<!-- /template -->





</body>
</html>
