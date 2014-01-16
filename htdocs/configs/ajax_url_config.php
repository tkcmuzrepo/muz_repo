<?php

# ログイン情報管理
define("AJAX_ACCOUNT_BASE_URL",MASTER_DOMAIN."muz_ajax_master_accounts"."/");
define("AJAX_USER_ACCOUNT_SAVE",AJAX_ACCOUNT_BASE_URL."account");
define("AJAX_USER_ACCOUNT_EDIT",AJAX_ACCOUNT_BASE_URL."accountEdit");
define("AJAX_USER_ACCOUNT_DELETE",AJAX_ACCOUNT_BASE_URL."accountDelete");

# プロモーション
define("AJAX_PROMOTION_BASE_URL",MASTER_DOMAIN."muz_ajax_promotion_settings"."/");
define("AJAX_PROMOTION_SAVE",AJAX_PROMOTION_BASE_URL."promotionSave");
define("AJAX_PROMOTION_EDIT",AJAX_PROMOTION_BASE_URL."promotionEdit");
define("AJAX_PROMOTION_DELETE",AJAX_PROMOTION_BASE_URL."promotionRemove");

# 注意文
define("AJAX_NOTE_BASE_URL",MASTER_DOMAIN."muz_ajax_form_messages"."/");
define("AJAX_NOTE_SAVE",AJAX_NOTE_BASE_URL."saveMessage");
define("AJAX_NOTE_EDIT",AJAX_NOTE_BASE_URL."editMessage");
define("AJAX_NOTE_VIEW_EDIT",AJAX_NOTE_BASE_URL."viewEdit");
define("AJAX_NOTE_DELETE",AJAX_NOTE_BASE_URL."deleteMessage");

# デザイン
define("AJAX_COLOR_BASE_URL",MASTER_DOMAIN."muz_ajax_form_color_settings"."/");
define("AJAX_COLOR_SAVE",AJAX_COLOR_BASE_URL."color_edit");

# プレビュー反映
define("AJAX_PREVIEW_RESTORE_BASE_URL",MASTER_DOMAIN."muz_ajax_previews"."/");
define("AJAX_PREVIEW_RESTORE",AJAX_PREVIEW_RESTORE_BASE_URL."restore_exec");

# 応募後HTML
define("AJAX_HTML_AFTER_BASE_URL",MASTER_DOMAIN."muz_ajax_form_html_settings"."/");
define("AJAX_HTML_AFTER_SAVE_URL",AJAX_HTML_AFTER_BASE_URL."html_after_edit");

# グループ
define("AJAX_GROUP_BASE_URL",MASTER_DOMAIN."muz_ajax_form_group_settings"."/");
define("AJAX_GROUP_SAVE_URL",AJAX_GROUP_BASE_URL."makeGroup");
define("AJAX_GROUP_VIEW_CHANGE_URL",AJAX_GROUP_BASE_URL."dragEnd");

# フィールド処理
define("AJAX_FIELD_BASE_URL",MASTER_DOMAIN."muz_ajax_form_field_settings"."/");
define("AJAX_FIELD_SAVE_URL",AJAX_FIELD_BASE_URL."fieldNewSave");


?>
