<script type="text/javascript">
<!--
var urlObjOriginal={

<?php
/*
■広告コードの編集
data[MuzPromotionSetting][name] : タイトル
data[MuzPromotionSetting][promotion_code] : プロモーションコード

※class="advertisingset" の子要素に class=hidden_valueを設定しています
*/
?>
'urlAdvertisingSubmitEdit':'server.php',

<?php
/*
■広告コードの削除

hidden_value

※戻り値
err_mes : 
status  : 
*/
?>
'urlAdvertisingDelete':'server.php',

<?php
/*
■広告コード新規作成
data[MuzPromotionSetting][name] : タイトル
data[MuzPromotionSetting][promotion_code] : プロモーションコード

戻り値
promotion_id : 新規作成した広告のID
status       : YES , NO
error_mes    : エラーメッセージ

※id=homeright の子要素に class=hidden_value を設定しています
*/
?>
'urlAdvertisingSubmitNew':'server.php',

<?php
/*
■ログイン情報の新規作成
http://up.hyhdmax.com/admin/useredit.php
data[MuzMasterAccount][name]       ユーザ名
data[MuzMasterAccount][login_id]		    ユーザID
data[MuzMasterAccount][login_pass]	    パスワード
data[MuzMasterAccount][login_pass_conf]   パスワード確認
data[MuzMasterAccount][master_flg]		master権限付与  0チェック無　　1チェック有

※ useredititemtablewrap の子要素に class=hidden_value を設定しています

戻り値
account_id  : 新規作成したユーザのID
status      : YES,NO
error_mes   : エラーメッセージ

●入力制限
ユーザIDは英数字のみ
名前は制限なし
パスワード、パスワード確認は英数字のみ
*/
?>
'urlUserSubmit':'server.php',

<?php
/*	
■ログイン情報の編集
http://up.hyhdmax.com/admin/useredit.php

data[MuzMasterAccount][name]       ユーザ名
data[MuzMasterAccount][login_id]		    ユーザID
data[MuzMasterAccount][login_pass]	    パスワード

# ★編集時は権限の変更はありませんのでつけなくて大丈夫です
# data[Form][master_flg]		master権限付与  0チェック無　　1チェック有

パスワードhiddenタグ
<input type="hidden" name="user_id" value="11111">

●入力制限
ユーザIDは英数字のみ
名前は制限なし
パスワード、パスワード確認は英数字のみ
*/
?>
'urlUserEdit':'server.php',


<?php
/*
■フォームデザインの変更
http://up.hyhdmax.com/admin/formdesign.php

data[MuzFormColorSetting][site_string_title_color]             フォームタイトル
data[MuzFormColorSetting][site_string_auxiliary_color]		    補足文
data[MuzFormColorSetting][site_string_note_color]	            注意文
data[MuzFormColorSetting][site_bg_entire_color]		        全体背景
data[MuzFormColorSetting][site_bg_group_title_color]		    グループタイトル
data[MuzFormColorSetting][site_bg_group_color]		            グループ背景
data[MuzFormColorSetting][site_bg_title_color]		            フォームタイトル
data[MuzFormColorSetting][site_bg_form_color]		            フォーム背景
data[MuzFormColorSetting][site_bg_input_color]	            	入力ボタン
data[MuzFormColorSetting][site_bg_decide_btn_color]		    決定ボタン
data[MuzFormHtmlSetting][header_html] : ヘッダー編集
data[MuzFormHtmlSetting][fotter_html] : フッター編集

※ class="formdesign" の子要素に class=hidden_value があります
※ 各項目が変更されたら その値と hidden_value のデータを送信して下さい
*/
?>
'urlFormDesign':'server.php',


<?php
/*
フィールドの新規追加
http://up.hyhdmax.com/admin/formedit.php
data[MuzFormFieldSettingDetail][max_num] : 最大文字数
data[MuzFormFieldSetting][validate_type] : 入力制限('none',validate_number,validate_alpha)
※何も制限をかけない場合は none を送信して下さい
data[MuzFormFieldSetting][title] : タイトル
data[MuzFormFieldSetting][sub_title] : 補足文
data[MuzFormFieldSetting][required_flg] : 入力必須 0 : しない , 1 : 必須
data[MuzFormFieldSetting][view_flg] : 表示の設定 0 : しない , 1 : する
data[MuzFormFieldSetting][type] : フォームの種類 (text,select,checkbox,radio,textarea)
data[MuzFormFieldValue][value][0],data[MuzFormFieldValue][value][1] : 選択肢　※ここ難しいですが、選択肢の上から[0],[1],... として送信する事できますか？

返り値
status : YES,NO
error_mes : エラーメッセージ
field_id : 

field_idを返すのでドラッグする要素の中に埋め込んでもらい、ドラッグ完了後このfield_idを送信出来るようにして下さい。

#	テキスト入力
#	data[Form][Title]           タイトル
#	data[Form][Type]            フォームタイトル
#	data[Form][sub_title]		補足文
#	data[Form][view_flg]	    注意文
#	data[Form][required_flg]	必須フラグ
#	data[Form][max_num]		    最大文字数
#	data[Form][????]		    入力文字制限
#							
#	テキストエリア
#	data[Form][Title]           タイトル
#	data[Form][Type]            フォームタイトル
#	data[Form][sub_title]		補足文
#	data[Form][view_flg]	    注意文
#	data[Form][required_flg]	必須フラグ
#
#	プルダウン/ラジオボタン/チェックボックス/テキストエリア
#
#	data[Form][Title]           タイトル
#	data[Form][Type]            フォームタイトル
#	data[Form][sub_title]		補足文
#	data[Form][view_flg]	    注意文
#	data[Form][required_flg]	必須フラグ
#	data[Form][value0]	        入力項目

返り値
?
*/
?>
'urlFieldNew':'server.php',


<?php
/*
■フィールドの更新処理
http://up.hyhdmax.com/admin/formedit.php
data[MuzFormFieldSetting][title] : タイトル
data[MuzFormFieldSetting][sub_title] : サブタイトル
data[MuzFormFieldSetting][view_flg] : 表示非表示 0 非表示 , 1 表示
data[MuzFormFieldSetting][required_flg] : 入力必須 0 必須では無い , 1 必須
data[MuzFormFieldSetting][max_num] : 最大入力文字数
data[MuzFormFieldSetting][validate_type] : 入力制限
data[MuzFormValueSetting][value][0] ... data[MuzFormValueSetting][value][9] : 選択肢 ※3つ目の数値は可変です。 class='formtypeselect' の下のデータを送信して下さい
※ class=formlistitem の子要素に class=hidden_value を設定しています 入力データと一緒に送信して下さい

#	テキスト入力
#	data[Form][field_id]		フィールドID
#	data[Form][Title]           タイトル
#	data[Form][Type]            フォームタイトル
#	data[Form][sub_title]		補足文
#	data[Form][view_flg]	    注意文
#	data[Form][required_flg]	必須フラグ
#	data[Form][max_num]		    最大文字数
#	data[Form][????]		    入力文字制限
#	
#	テキストエリア
#	data[Form][field_id]		フィールドID
#	data[Form][Title]           タイトル
#	data[Form][Type]            フォームタイトル
#	data[Form][sub_title]		補足文
#	data[Form][view_flg]	    注意文
#	data[Form][required_flg]	必須フラグ
#
#
#	プルダウン/ラジオボタン/チェックボックス/テキストエリア
#	data[Form][field_id]		フィールドID
#	data[Form][Title]           タイトル
#	data[Form][Type]            フォームタイトル
#	data[Form][sub_title]		補足文
#	data[Form][view_flg]	    注意文
#	data[Form][required_flg]	必須フラグ
#	data[Form][value0]	        入力項目


*/
?>
'urlFieldEdit':'server.php',

<?php
/*
■フィールドの削除
http://up.hyhdmax.com/admin/formedit.php
※ class=formlistitem の子要素に class=hidden_value を設定しています これだけ送信して下さい

#data[Form][field_id]		フィールドID
*/
?>
'urlFieldDelete':'server.php',

<?php
/*
■フィールドのソート
http://up.hyhdmax.com/admin/formedit.php
data[MuzFormFieldSetting][sort_number] : 1_2_3  
data[MuzFormFieldSetting][group_id] : 移動先のグループID
※ class=formlistitem の子要素に class=hidden_value を設定しています 入力データと一緒に送信して下さい
※ グループIDはclass=formgroup の子要素に class="group_id" の要素があります

例)
data[MuzFormFieldSetting][sort_number] : 3_1_2  
の場合、「移動先グループ内」で上から順に field_id3,field_id1,field_id2 の順番並んでいる事となります。

*/
?>
'urlSortUpdate':'server.php',

<?php
/*
■グループの順番入れ替え
http://up.hyhdmax.com/admin/formedit.php
data[MuzFormFieldSetting][sort_number] : 移動後の現在の位置(グループの位置が上から何番目か)
data[MuzFormFieldSetting][group_id] : グループID
※ グループIDは class=formgroup の子要素に class="group_id" の要素があります

グループの並び替え変更後、
data[Form][group_sort_values] : 1_2_3 のグループIDを送信して下さい 

例)
2_1_3 : 上から グループID2,グループID1,グループID3の順番で並んでいる事とな
ります。
*/
?>
'urlGroupSort':'server.php',

<?php
/*
■グループの新規作成
http://up.hyhdmax.com/admin/groupmanagement.php
data[MuzFormGroupSetting][group_title] : タイトル
data[MuzFormGroupSetting][group_sub_title] : サブタイトル

※ class=homeright_inner の子要素に class=hidden_value を設定しています 新規作成時に一緒にサーバに送信して下さい

※ サーバAjax通信後 group_id のパラメータでグループIDを返すので
☆class="group_id" の value にその値を埋め込んで下さい

*/
?>
'urlGroupManagementNew':'server.php',

<?php
/*
グループの配置保存
■http://up.hyhdmax.com/admin/groupmanagement.php
data[MuzFormGroupSetting][view_flg] : 表示か非表示か 0 : 非表示 , 1 : 表示
※ class=managementformwarap の子要素に class=hidden_value を設定しています ドラッグ完了後に view_flg と一緒にサーバに送信して下さい
*/
?>
'urlGroupManagementSort':'server.php',

<?php
/*
■グループの削除
http://up.hyhdmax.com/admin/groupmanagement.php
※ class=managementformwarap の子要素に class=hidden_value を設定しています これだけ削除後にサーバに送信して下さい
*/
?>
'urlGroupManagementDelete':'server.php',

<?php
# ■注意文削除
# http://muz.kiyosawa.com/master/muz_ajax_form_messages/deleteMessage
# 
# ○戻り値
# err_mes : 
# status  : 
?>
'urlNoteDelete':'server.php',

<?php
# ■注意文表示、非表示切り替え
# http://muz.kiyosawa.com/master/muz_ajax_form_messages/viewEdit
# 
# ○戻り値
# err_mes : 
# status  : 
# view_flg : 保存後の表示ステータス
# 0 が返れば今は非表示の状態なので「表示する」のリンクに切り替え、1の場合はその逆
?>
'urlNoteShow':'server.php',

<?php
# ■注意文編集
# http://muz.kiyosawa.com/master/muz_ajax_form_messages/messageEdit
# 
# ○戻り値
# err_mes : 
# status  : 
?>
'urlNoteEdit':'server.php',

<?php
# ■注意文新規作成
# http://muz.kiyosawa.com/master/muz_ajax_form_messages/saveMessage
# 
# ○戻り値
# err_mes : 
# status  : 
# message_id : 保存後の注意文ID (編集する場合は、このIDを再送して下さい)
# date_key
# form_id
?>
'urlNoteNew':'server.php',

<?php
# アカウントの駆除
#○送信データ
#アカウントID ※ hidden_value に埋め込んであります

#○戻り値
#err_mes :
#status : 
?>
'urlUserDelete':'server.php',

<?php
#○応募前(PC)
#
#data[MuzFormHtmlSetting][after_page_html]
#
#○戻り値
#err_mes :
#status : 
?>
'urlAfterPageHtml':'server.php',

<?php
#○応募前(スマホ)
#
#data[MuzFormHtmlSetting][sp_after_page_html] 
#
#○戻り値
#err_mes :
#status : 
?>
'urlSpAfterPageHtml':'server.php',

<?php
#○応募前(ガラケー)
#
#data[MuzFormHtmlSetting][mb_after_page_html]
#
#○戻り値
#err_mes :
#status : 
?>
'urlMbAfterPageHtml':'server.php',


<?php
#フォームの保存
#
#
#○戻り値
#err_mes :
#status : 
?>
'urlFormHtmlSave':'server.php',


<?php
// グループの入れ替え
// http://up.hyhdmax.com/admin/groupmanagement.php

// ○送信パラメータ
// ※group_id
// hidden_valueを仕込んで置くので(group_id,date_key)それを移動し終わったら送って下さい。
// ※表示したか、非表示にしたか
// 表示 : 1 非表示 : 0 で送信して下さい

// ○戻り値
// error_mes : 
// status :
?>
'urlGroupManagementSort':'server.php',




// お疲れ様です、清沢です。
// 上メニューにある保存ボタンのAjax処理の件となります。(プレビューの本番反映)
// ○戻り値

// error_mes : 
// status : 

// となります。
//  <li id="adminHeaderNaviFunction">
// この要素がform_nav.htmlに配置されているかと思いますのでこの要素をルート要素とし、その子要素にhidden_valueを仕込んであります。
// 宜しくお願い致します。



/*
お疲れ様です、上から優先度高めで記載してます。

不明な点があったら連絡を下さい。



■フィールドの並び替え

○戻り値
error_mes : 
status : 

○送信
※hidden_value で 「field_id」「date_key」の２を設定します
※どこのグループに移動したか => グループID
※移動したグループの中での並び順 => 10_2_3_4_4 
を下さい
*/




<?php
#ログイン情報一覧->削除
#
#
#○戻り値
#err_mes :
#status : 
#○送信
#hidden_value で 「account_id」を設定します
?>
'urlUserLoginDelete':'server.php',



<?php
#応募後HTML
#
#
#○戻り値
#error_mes : 
#status : 
#
#hidden_value で「form_id」と「date_key」と「site」を設定します
#site => pc,sp,mb のそれぞれの値
#
#○name属性
#pc(textarea) : data[MuzFormHtmlSetting][after_page_html]
#sp(textarea) : data[MuzFormHtmlSetting][sp_after_page_html]
#mb(textarea) : data[MuzFormHtmlSetting][mb_after_page_html]
?>
'urlHtmlEdit':'server.php',



<?php
#■ヘッダーを３個　pcのみ画像のアップロード

#○戻り値
#error_mes : 
#status : 

#※hidden_value で「form_id」と「date_key」と「site」を設定します
#※site => pc,sp,mb のそれぞれの値
#※アップロードは同期通信で行います <input type="file"> とボタンの調整をお願いします

#○name属性
#pc(textarea) : data[MuzFormHtmlSetting][header_html]
#sp(textarea) : data[MuzFormHtmlSetting][sp_header_html]
#mb(textarea) : data[MuzFormHtmlSetting][mb_header_html]
?>
'urlHtmlHeader':'server.php',




<?php
#■グループの新規作成
#
#○戻り値
#error_mes : 
#statsu :
#
#group_id : 
#※hidden_value で 「date_key」を設定します
#正常に作成出来たらgroup_idを返すので、そのグループが並び替えられたら再度サーバに
#送られる様にお願いします。
#○name属性
#グループタイトル : data[MuzFormGroupSetting][group_title]
#グループサブタイトル : data[MuzFormGroupSetting][group_sub_title]
?>
'urlHtmlHeader':'server.php',



<?php
#■グループの新規作成
#
#○戻り値
#error_mes : 
#statsu :
#
#group_id : 
#※hidden_value で 「date_key」を設定します
#正常に作成出来たらgroup_idを返すので、そのグループが並び替えられたら再度サーバに
#送られる様にお願いします。
#○name属性
#グループタイトル : data[MuzFormGroupSetting][group_title]
#グループサブタイトル : data[MuzFormGroupSetting][group_sub_title]
?>
'urlHtmlHeader':'server.php',








}; 
// -->
</script>