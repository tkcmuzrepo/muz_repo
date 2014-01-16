<?php

require_once 'Microsoft/WindowsAzure/Storage/Blob.php';
require_once 'Microsoft/WindowsAzure/RetryPolicy/NoRetry.php';
require_once 'win_blob_strage.php';
require_once 'blob_log.php';

define("STORAGE_BLOB_URL","http://aimasterstg001.blob.core.windows.net/");
define("STORAGE_URL",Microsoft_WindowsAzure_Storage::URL_CLOUD_BLOB);
define("STORAGE_ACCOUNT","aimasterstg001");
define("STORAGE_KEY","ioe4oL6KvZYOBeOe0q7M8nM3ERzbP4xWk/1S7XnIDmkfloVbMxtuXqIMDmWq38dNUNMwWqxijOr9zzP+8NzyTg==");

# GLOBAL
Configure::write("BLOB_LOG",new BlobLog());

#ACL
define("BLOB_PUBLIC",'public');
define("BLOB_PRIVATE",'private');

#ヘッダー画像
define("HEADER_IMG_BLOB","header-image");

#会員情報
define("USER_REGIST_BLOB","user-regist-data");

#SQLログ
define("SQL_LOG","sqllog");

#メールテンプレート
define("MAILTPL","mailtpl");

#CSV 仮ファイル
define("CSV_TMP","csv-tmp");

?>