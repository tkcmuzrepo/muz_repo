<?php 

/**
 * コントローラで頻繁に用いる処理をモジュール化したクラス
 *
 * @update 2008/07/17 10:53:20 赤羽根
 *d
 */

class BjComponent extends Component{
	
	var $someVar = null;
	var $controller = true;
	

	function startup(Controller $controller) {
		if(!is_object($this->controller)){
			$this->controller =& $controller;
		}
	}
	
	/**
	 * プルダウン用配列生成 <Set::combineのラッパー>
	 * 
	 * $model_select (xx_ary)の形式でViewに自動で変数をセットします
	 *
	 * @author Akabane 
	 * @date 2008/12/11 14:23:57 
	 */
	function setSelect($modelName , $key_value = array()){
		//プラン
		$ary = $this->controller->$modelName->findAll(null,"$modelName.{$key_value[0]},$modelName.{$key_value[1]}");
		if(empty($ary[0])){
			return null;
		}
		$ary =  Set::combine($ary , "{n}.$modelName.{$key_value[0]}", "{n}.$modelName.{$key_value[1]}");
		//2009/01/20 03:22:02 UserList →user_list と命名変更
		$this->controller->set( Inflector::underscore($modelName)."_ary" , $ary );
		return $ary;
	}


	/**
	 * 自動ページング
	 *
	 * @param $ModelName String 検索対象モデル名 （この値を元にfindAll / paginateします）
	 * @param $sql_cond  Array  paginateのconditionsやfieldsを指定すると絞り込みます
	 *		$this->dataで追記されない様に気をつけて下さい
	 *
	 * @param $paginate_option  Array [View]で、$paginator->set($option); する時に追記する場合は記述
	 * @param $csv_replace_name Array CSVダウンロードする時の置換名（"User.id" => ユーザ番号　の形式）を指定できます
	 *
	 *
	 * 1.ぺージング対応
	 * 2.検索対応
	 * 3.条件付与対応
	 * 
	 * $model_list (xx_list)の形式でViewに自動で変数をセットします
	 *
	 * ルール
	 * 範囲指定での期間検索の場合、 field_start (xxx_start)の場合以降の日付を
	 * field_end (xxx_end)の場合以前の日付を検索対象とします
	 * なので、xxx_startとかをフィールド名にしないで下さい。使う場合はこのメソッドは使用しないで下さい
	 *
	 * @author Akabane 
	 * @date 
	 * @edit 2008/12/30 01:31:01 CSVダウンロード機能実装 $this->data["BJ_CSV"]をissetすると、結果をSJISのCSVデータでreturnします
	 */
	function paging($ModelName , $sql_cond = array() , $paginate_option = null , $csv_replace_name = array()){
		
		$ary_sparator = "@@";
		$opt = $paginate_option;

		//簡略版
		$w      = (!empty($sql_cond["w"]))     ? $sql_cond["w"]  : null; // conditions
		$f      = (!empty($sql_cond["f"]))     ? $sql_cond["f"]  : null; // fields
		$order  = (!empty($sql_cond["o"]))     ? $sql_cond["o"]   : null; //order
		$limit  = (!empty($sql_cond["l"]))     ? $sql_cond["l"]   : 100; //limit
		// ページング
		if($this->controller->passedArgs){
			foreach($this->controller->passedArgs as $k=>$v){
				if($k=="page" or $k=="sort" or $k=="direction") continue;
				
				//2009/05/01 19:37:55  Akabane
				//passedArgsのプリフィックスがアンダースコアの場合は、自動的に検索条件追加をやめる
				//paginator_optionには自動的に追加するようにする
				if(preg_match("/^_/" , $k)){
					$opt["url"][$k] = $v;
					continue;
				}
				$this->controller->data[$ModelName][$k] = (!strpos($v , $ary_sparator)) ? $v : explode($ary_sparator , $v);;
			}
		}
		
		// 検索
		if(!empty($this->controller->data)){
			foreach($this->controller->data as $k=>$v){
				//１文字目がアンダースコアで始まるモデルは検索対象に含めない
				if(strpos($k , "_") === 0){
					continue;
				}
				
				if(is_array($v))
				foreach($v as $_k=>$_v){
					$flg = false;
					if(preg_match( '/_start$|_end$/' ,  $_k)){
						//2009/01/08 06:38:19 正規表現修正 Akabane
						$field = ereg_replace("_start$|_end$" , "" , $_k );
						if($_v){
							//日付検索時
							if(preg_match("/start/" , $_k)){
								$w["and"][]["{$k}.{$field}"] = ">= " . dd("Y-m-d",$_v) ." 00:00:00"; #以下
							}
							elseif(preg_match("/end/" , $_k)){
								$w["and"][]["{$k}.{$field}"] = "<= " . dd("Y-m-d",$_v) ." 23:59:59"; #以下
							}
							else{
								$w["and"][]["{$k}.{$field}"] = "= " . $_v; #以下
							}
						}
					}elseif(is_array($_v) and empty($_v)){
						continue;
					}
					elseif(is_null($_v) or $_v===""){
						 continue;
					}
					// 完全一致
					elseif(is_numeric($_v) or is_array($_v)){
						
						if(!is_numeric($_k)){
							$w["and"]["{$k}.{$_k}"] = $_v; # 完全一致
						}
					
					}
					// 数字以外の時は部分一致
					else{
						
						if(!is_numeric($_k)){
							$w["and"]["{$k}.{$_k}"] = "like %{$_v}%"; # 部分一致
						}
						
					}
					$opt["url"][$_k] = (!is_array($_v)) ? urlencode($_v) : implode($ary_sparator , $_v);
				}
			}
			#v($w);
			#v($opt);
		}
		//CSVダウンロードの時
		if(isset($this->controller->data["BJ_CSV"])){
			//CSV生成時のメモリエラーとタイムアウトを防ぐ
			ini_set("memory_limit", -1);
			set_time_limit(0);
			Configure::write("debug" , 0);
			$csv_data_ary = $this->controller->{$ModelName}->findAll($w, $f , $order , $limit);
			$output = $this->convert_csv($csv_data_ary , $csv_replace_name);
			$output = enc($output , "SJIS" );
			$fname = "{$ModelName}_" . uniqid( date("YmdHis_")) .".csv";
			file_put_contents(USER_DATA ."csv/". $fname , $output);
			header("location:" . ROOT_DOMAIN . "user_data/csv/{$fname}");
		}
		//通常の検索ボタンの時
		else{

			$this->controller->paginate = 	array(
				$ModelName =>array(
					"conditions" =>$w,
					"order"  => $order,
					"limit"  => $limit,
					"fields" => $f,
				)
			);
			$param_name = strtolower($ModelName) . "_list";
			$list = $this->controller->paginate($ModelName);
			//取得した一覧をセット
			$this->controller->set($param_name , $list);
		
			//ページングオプションをセット
			$this->controller->set("paginator_options" , $opt);
		
			return $list;
		}
	}

	#
	# TSVファイルを複数ファイルまとめてセット
	#
	# $pref = tsv("pref.tsv");
	# $this->set("pref_tsv" , $pref);
	#
	# などの簡略化
	#
	function tsv(){
		$args = func_get_args();
		foreach($args as $k=>$v){
			$$v = tsv("{$v}.tsv");
			$this->controller->set("{$v}_tsv" , $$v);
		}//foreach
	}

	#
	# 入力⇒確認⇒完了
	# 完了ボタンを押して、validateを通過した場合のみ true
	#
	# @param $modelName モデル名 ex."User"
	# モデル名を指定した場合、そのモデルに対応したバリデーションを行う
	# 指定が無い場合は、$this->this_model(app_controller参照)
	#
	function confirm($modelName=""){

		$modelName = ($modelName) ? $modelName : $this->controller->this_model;

		if($this->controller->data){
			//初回画面：
			if(isset($_POST["confirm_input"])){
				$this->controller->{$modelName}->set($this->controller->data);
				if($this->controller->{$modelName}->validates()){
					$this->controller->data["Form"]["action"] = "confirm";
					$this->controller->render();
				}
				return false;
			}
			// 確認画面：編集しなおし
			elseif(isset($_POST["confirm_edit"])){
				$this->controller->render();
				return false;

			}
			// 確認画面：完了ボタン
			elseif(isset($_POST["confirm_done"])){
				$this->controller->{$modelName}->set($this->controller->data);
				if($this->controller->{$modelName}->validates()){
					return true;
				}
				return false;
			}
			else{
				return false;
			}
		}
		return false;
	}

	/**
	 * findAllした結果をCSVデータに補正する
	 * array[0]["User"]["id"]の構成前提
	 */
	function convert_csv($data_ary , $csv_replace_name){
		if(!is_array($data_ary))
			return false;
		
		//■ 1行目
		$first_line = null;
		foreach($data_ary[0] as $k=>$v){
			foreach($v as $_k=>$_v){
				$key = "$k.$_k";
				//置換処理
				if(!empty($csv_replace_name[$key])){
					$menu[] = $csv_replace_name[$key];
				}else{
					$menu[] = $key;
				}
			}//foreach
		}//foreach
		$first_line .= "\"" . implode("\",\"" , $menu ) . "\"";

		//■ 2行目以降
		$line  = array();
		$i = 0;

		foreach($data_ary as $k=>$row){
			$line[$i] = null;
			foreach($row as $_k => $field_data){
				$line[$i] .= "\"" . implode("\",\"" , $field_data ) . "\"";
			}//foreach
			$i++;
		}//foreach
		
		$output = $first_line . "\n" .
				  implode("\n" , $line);
		
		return $output;
	}

}
?>
