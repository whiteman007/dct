<?php
include "cookie.php";
define('PATH', 'backup/');
define('URL',  'backup/');
// Максимальное время выполнения скрипта в секундах
// 0 - без ограничений
define('TIME_LIMIT', 0);
// Ограничение размера данных доставаемых за одно обращения к БД (в мегабайтах)
// Нужно для ограничения количества памяти пожираемой сервером при дампе очень объемных таблиц
define('LIMIT', 1);
// mysql сервер
define('DBHOST', 'localhost');
// Базы данных, если сервер не разрешает просматривать список баз данных,
// и ничего не показывается после авторизации. Перечислите названия через запятую
define('DBNAMES', '');
// Кодировка соединения с MySQL
// auto - автоматический выбор (устанавливается кодировка таблицы), cp1251 - windows-1251, и т.п.
define('CHARSET', 'auto');
// Кодировка соединения с MySQL при восстановлении
// На случай переноса со старых версий MySQL (до 4.1), у которых не указана кодировка таблиц в дампе
// При добавлении 'forced->', к примеру 'forced->cp1251', кодировка таблиц при восстановлении будет принудительно заменена на cp1251
// Можно также указывать сравнение нужное к примеру 'cp1251_ukrainian_ci' или 'forced->cp1251_ukrainian_ci'
define('RESTORE_CHARSET', 'utf-8');
// Включить сохранение настроек и последних действий
// Для отключения установить значение 0
define('SC', 1);
// Типы таблиц у которых сохраняется только структура, разделенные запятой
define('ONLY_CREATE', 'MRG_MyISAM,MERGE,HEAP,MEMORY');
// Глобальная статистика
// Для отключения установить значение 0
define('GS', 1);


// Дальше ничего редактировать не нужно

$is_safe_mode = ini_get('safe_mode') == '1' ? 1 : 0;
if (!$is_safe_mode && function_exists('set_time_limit')) set_time_limit(TIME_LIMIT);

header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

$timer = array_sum(explode(' ', microtime()));
ob_implicit_flush();
error_reporting(E_ALL);

$auth = 0;
$error = '';
	$login = $IM_username;
	$pass = $IM_pass;
if (!empty($login) && isset($pass) && @$_COOKIE['sess']!="1") {
     
	if (@mysql_connect(DBHOST, $login, $pass)){
		@setcookie("sxd", base64_encode("SKD101:{$login}:{$pass}"));
		@setcookie("sess","1");
		header("Location: dumper.php");
		mysql_close();

		exit;
	}
	else{
		$error = '#' . mysqli_errno($GLOBALS["db_link"]) . ': ' . mysqli_error($GLOBALS["db_link"]);
	}
}
elseif (!empty($_COOKIE['sxd'])) {
    $user = explode(":", base64_decode($_COOKIE['sxd']));
	if (@mysql_connect(DBHOST, $user[1], $user[2])){
		$auth = 1;
	}
	else{
		$error = '#' . mysqli_errno($GLOBALS["db_link"]) . ': ' . mysqli_error($GLOBALS["db_link"]);
	}
}

if (!$auth || (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] == 'reload')) {
	setcookie("sxd");
	echo tpl_page(tpl_auth($error ? tpl_error($error) : ''), "<SCRIPT>if (jsEnabled) {document.write('<INPUT TYPE=submit VALUE=&#1583;&#1582;&#1608;&#1604;>');}</SCRIPT>");
	echo "<SCRIPT>document.getElementById('timer').innerHTML = '" . round(array_sum(explode(' ', microtime())) - $timer, 4) . " seconds.'</SCRIPT>";
	exit;
}
if (!file_exists(PATH) && !$is_safe_mode) {
    mkdir(PATH, 0777) || trigger_error("Не удалось создать каталог для бекапа", E_USER_ERROR);
}

$SK = new dumper();
define('C_DEFAULT', 1);
define('C_RESULT', 2);
define('C_ERROR', 3);
define('C_WARNING', 4);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
switch($action){
	case 'backup':
		$SK->backup();
		break;
	case 'restore':
		$SK->restore();
		break;
	default:
		$SK->main();
}

mysql_close();

echo "<SCRIPT>document.getElementById('timer').innerHTML = '" . round(array_sum(explode(' ', microtime())) - $timer, 4) . " seconds.'</SCRIPT>";

class dumper {
	function dumper() {
		if (file_exists(PATH . "dumper.cfg.php")) {
		    include(PATH . "dumper.cfg.php");
		}
		else{
			$this->SET['last_action'] = 0;
			$this->SET['last_db_backup'] = '';
			$this->SET['tables'] = '';
			$this->SET['comp_method'] = 2;
			$this->SET['comp_level']  = 7;
			$this->SET['last_db_restore'] = '';
		}
		$this->tabs = 0;
		$this->records = 0;
		$this->size = 0;
		$this->comp = 0;

		// Версия MySQL вида 40101
		preg_match("/^(\d+)\.(\d+)\.(\d+)/", mysql_get_server_info(), $m);
		$this->mysql_version = sprintf("%d%02d%02d", $m[1], $m[2], $m[3]);

		$this->only_create = explode(',', ONLY_CREATE);
		$this->forced_charset  = false;
		$this->restore_charset = $this->restore_collate = '';
		if (preg_match("/^(forced->)?(([a-z0-9]+)(\_\w+)?)$/", RESTORE_CHARSET, $matches)) {
			$this->forced_charset  = $matches[1] == 'forced->';
			$this->restore_charset = $matches[3];
			$this->restore_collate = !empty($matches[4]) ? ' COLLATE ' . $matches[2] : '';
		}
	}

	function backup() {
		if (!isset($_POST)) {$this->main();}

		//set_error_handler("SXD_errorHandler");
		$buttons = "<A ID=save HREF='' STYLE='display: none;'>&#1578;&#1581;&#1605;&#1610;&#1604; &#1575;&#1604;&#1605;&#1604;&#1601;</A> &nbsp; <INPUT ID=back TYPE=button VALUE='&#1585;&#1580;&#1608;&#1593; &#1604;&#1604;&#1582;&#1604;&#1601;' DISABLED onClick=\"history.back();\">";
		echo tpl_page(tpl_process("&#1575;&#1604;&#1606;&#1587;&#1582; &#1575;&#1604;&#1575;&#1581;&#1578;&#1610;&#1575;&#1591;&#1610; &#1604;&#1602;&#1575;&#1593;&#1583;&#1577; &#1575;&#1604;&#1576;&#1610;&#1575;&#1606;&#1575;&#1578;"), $buttons);

		$this->SET['last_action']     = 0;
		$this->SET['last_db_backup']  = isset($_POST['db_backup']) ? $_POST['db_backup'] : '';
		$this->SET['tables_exclude']  = !empty($_POST['tables']) && $_POST['tables']{0} == '^' ? 1 : 0;
		$this->SET['tables']          = isset($_POST['tables']) ? $_POST['tables'] : '';
		$this->SET['comp_method']     = isset($_POST['comp_method']) ? intval($_POST['comp_method']) : 0;
		$this->SET['comp_level']      = isset($_POST['comp_level']) ? intval($_POST['comp_level']) : 0;
		$this->fn_save();

		$this->SET['tables']          = explode(",", $this->SET['tables']);
		if (!empty($_POST['tables'])) {
		    foreach($this->SET['tables'] AS $table){
    			$table = preg_replace("/[^\w*?^]/", "", $table);
				$pattern = array( "/\?/", "/\*/");
				$replace = array( ".", ".*?");
				$tbls[] = preg_replace($pattern, $replace, $table);
    		}
		}
		else{
			$this->SET['tables_exclude'] = 1;
		}

		if ($this->SET['comp_level'] == 0) {
		    $this->SET['comp_method'] = 0;
		}
		$db = $this->SET['last_db_backup'];

		if (!$db) {
			echo tpl_l("ОШИБКА! Не указана база данных!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l("&#1575;&#1587;&#1605; &#1575;&#1604;&#1602;&#1575;&#1593;&#1583;&#1577; `{$db}`.");
		mysql_select_db($db) or trigger_error ("Не удается выбрать базу данных.<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
		$tables = array();
        $result = mysqli_query2("SHOW TABLES");
		$all = 0;
        while($row = mysqli_fetch_array($result)) {
			$status = 0;
			if (!empty($tbls)) {
			    foreach($tbls AS $table){
    				$exclude = preg_match("/^\^/", $table) ? true : false;
    				if (!$exclude) {
    					if (preg_match("/^{$table}$/i", $row[0])) {
    					    $status = 1;
    					}
    					$all = 1;
    				}
    				if ($exclude && preg_match("/{$table}$/i", $row[0])) {
    				    $status = -1;
    				}
    			}
			}
			else {
				$status = 1;
			}
			if ($status >= $all) {
    			$tables[] = $row[0];
    		}
        }

		$tabs = count($tables);
		// Определение размеров таблиц
		$result = mysqli_query2("SHOW TABLE STATUS");
		$tabinfo = array();
		$tab_charset = array();
		$tab_type = array();
		$tabinfo[0] = 0;
		$info = '';
		while($item = mysqli_fetch_assoc($result)){
			//print_r($item);
			if(in_array($item['Name'], $tables)) {
				$item['Rows'] = empty($item['Rows']) ? 0 : $item['Rows'];
				$tabinfo[0] += $item['Rows'];
				$tabinfo[$item['Name']] = $item['Rows'];
				$this->size += $item['Data_length'];
				$tabsize[$item['Name']] = 1 + round(LIMIT * 1048576 / ($item['Avg_row_length'] + 1));
				if($item['Rows']) $info .= "|" . $item['Rows'];
				if (!empty($item['Collation']) && preg_match("/^([a-z0-9]+)_/i", $item['Collation'], $m)) {
					$tab_charset[$item['Name']] = $m[1];
				}
				$tab_type[$item['Name']] = isset($item['Engine']) ? $item['Engine'] : $item['Type'];
			}
		}
		$show = 10 + $tabinfo[0] / 50;
		$info = $tabinfo[0] . $info;
		$name = $db . '_' . date("Y-m-d_H-i");
        $fp = $this->fn_open($name, "w");
		echo tpl_l("Create file with backup database:<BR>\\n  -  {$this->filename}");
		$this->fn_write($fp, "#SKD101|{$db}|{$tabs}|" . date("Y.m.d H:i:s") ."|{$info}\n\n");
		$t=0;
		echo tpl_l(str_repeat("-", 60));
		$result = mysqli_query2("SET SQL_QUOTE_SHOW_CREATE = 1");
		// Кодировка соединения по умолчанию
		if ($this->mysql_version > 40101 && CHARSET != 'auto') {
			mysqli_query2("SET NAMES '" . CHARSET . "'") or trigger_error ("Неудается изменить кодировку соединения.<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
			$last_charset = CHARSET;
		}
		else{
			$last_charset = '';
		}
        foreach ($tables AS $table){
			// Выставляем кодировку соединения соответствующую кодировке таблицы
			if ($this->mysql_version > 40101 && $tab_charset[$table] != $last_charset) {
				if (CHARSET == 'auto') {
					mysqli_query2("SET NAMES '" . $tab_charset[$table] . "'") or trigger_error ("Неудается изменить кодировку соединения.<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
					echo tpl_l("An encoding of the connection `" . $tab_charset[$table] . "`.", C_WARNING);
					$last_charset = $tab_charset[$table];
				}
				else{
					echo tpl_l('Encryption of connection and the table does not match:', C_ERROR);
					echo tpl_l('&#1575;&#1587;&#1578;&#1585;&#1580;&#1575;&#1593; `'. $table .'` -> ' . $tab_charset[$table] . ' (соединение '  . CHARSET . ')', C_ERROR);
				}
			}
			echo tpl_l("&#1580;&#1575;&#1585;&#1610; &#1578;&#1606;&#1601;&#1610;&#1584; &#1575;&#1604;&#1593;&#1605;&#1604;&#1610;&#1577; &#1593;&#1604;&#1609; `{$table}` [" . fn_int($tabinfo[$table]) . "].");
        	// Создание таблицы
			$result = mysqli_query2("SHOW CREATE TABLE `{$table}`");
        	$tab = mysqli_fetch_array($result);
			$tab = preg_replace('/(default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP|DEFAULT CHARSET=\w+|COLLATE=\w+|character set \w+|collate \w+)/i', '/*!40101 \\1 */', $tab);
        	$this->fn_write($fp, "DROP TABLE IF EXISTS `{$table}`;\n{$tab[1]};\n\n");
        	// Проверяем нужно ли дампить данные
        	if (in_array($tab_type[$table], $this->only_create)) {
				continue;
			}
        	// Опредеделяем типы столбцов
            $NumericColumn = array();
            $result = mysqli_query2("SHOW COLUMNS FROM `{$table}`");
            $field = 0;
            while($col = mysql_fetch_row($result)) {
            	$NumericColumn[$field++] = preg_match("/^(\w*int|year)/", $col[1]) ? 1 : 0;
            }
			$fields = $field;
            $from = 0;
			$limit = $tabsize[$table];
			$limit2 = round($limit / 3);
			if ($tabinfo[$table] > 0) {
			if ($tabinfo[$table] > $limit2) {
			    echo tpl_s(0, $t / $tabinfo[0]);
			}
			$i = 0;
			$this->fn_write($fp, "INSERT INTO `{$table}` VALUES");
            while(($result = mysqli_query2("SELECT * FROM `{$table}` LIMIT {$from}, {$limit}")) && ($total = mysqli_num_rows($result))){
            		while($row = mysql_fetch_row($result)) {
                    	$i++;
    					$t++;

						for($k = 0; $k < $fields; $k++){
                    		if ($NumericColumn[$k])
                    		    $row[$k] = isset($row[$k]) ? $row[$k] : "NULL";
                    		else
                    			$row[$k] = isset($row[$k]) ? "'" . mysql_escape_string($row[$k]) . "'" : "NULL";
                    	}

    					$this->fn_write($fp, ($i == 1 ? "" : ",") . "\n(" . implode(", ", $row) . ")");
    					if ($i % $limit2 == 0)
    						echo tpl_s($i / $tabinfo[$table], $t / $tabinfo[0]);
               		}
					mysql_free_result($result);
					if ($total < $limit) {
					    break;
					}
    				$from += $limit;
            }

			$this->fn_write($fp, ";\n\n");
    		echo tpl_s(1, $t / $tabinfo[0]);}
		}
		$this->tabs = $tabs;
		$this->records = $tabinfo[0];
		$this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
        echo tpl_s(1, 1);
        echo tpl_l(str_repeat("-", 60));
        $this->fn_close($fp);
		echo tpl_l("&#1606;&#1587;&#1582; &#1602;&#1575;&#1593;&#1583;&#1577; `{$db}` &#1578;&#1605;.", C_RESULT);
		echo tpl_l("&#1581;&#1580;&#1605; &#1575;&#1604;&#1602;&#1575;&#1593;&#1583;&#1577;:       " . round($this->size / 1048576, 2) . " mb", C_RESULT);
		$filesize = round(filesize(PATH . $this->filename) / 1048576, 2) . " mb";
		echo tpl_l("&#1581;&#1580;&#1605; &#1575;&#1604;&#1605;&#1604;&#1601;: {$filesize}", C_RESULT);
		echo tpl_l("&#1605;&#1580;&#1605;&#1608;&#1593; &#1575;&#1604;&#1580;&#1583;&#1575;&#1608;&#1604;: {$tabs}", C_RESULT);
		echo tpl_l("Error found:   " . fn_int($tabinfo[0]), C_RESULT);
		echo "<SCRIPT>with (document.getElementById('save')) {style.display = ''; innerHTML = '&#1585;&#1575;&#1576;&#1591; &#1575;&#1604;&#1605;&#1604;&#1601; ({$filesize})'; href = '" . URL . $this->filename . "'; }document.getElementById('back').disabled = 0;</SCRIPT>";

	}

	function restore(){
		if (!isset($_POST)) {$this->main();}
		//set_error_handler("SXD_errorHandler");
		$buttons = "<INPUT ID=back TYPE=button VALUE='&#1575;&#1604;&#1585;&#1580;&#1608;&#1593; &#1604;&#1604;&#1582;&#1604;&#1601;' DISABLED onClick=\"history.back();\">";
		echo tpl_page(tpl_process("&#1575;&#1587;&#1578;&#1585;&#1580;&#1575;&#1593; &#1602;&#1575;&#1593;&#1583;&#1577; &#1576;&#1610;&#1575;&#1606;&#1575;&#1578;"), $buttons);

		$this->SET['last_action']     = 1;
		$this->SET['last_db_restore'] = isset($_POST['db_restore']) ? $_POST['db_restore'] : '';
		$file						  = isset($_POST['file']) ? $_POST['file'] : '';
		$this->fn_save();
		$db = $this->SET['last_db_restore'];

		if (!$db) {
			echo tpl_l("ОШИБКА! Не указана база данных!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l("&#1575;&#1587;&#1605; &#1575;&#1604;&#1602;&#1575;&#1593;&#1583;&#1577; `{$db}`.");
		mysql_select_db($db) or trigger_error ("Не удается выбрать базу данных.<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);

		// Определение формата файла
		if(preg_match("/^(.+?)\.sql(\.(bz2|gz))?$/", $file, $matches)) {
			if (isset($matches[3]) && $matches[3] == 'bz2') {
			    $this->SET['comp_method'] = 2;
			}
			elseif (isset($matches[2]) &&$matches[3] == 'gz'){
				$this->SET['comp_method'] = 1;
			}
			else{
				$this->SET['comp_method'] = 0;
			}
			$this->SET['comp_level'] = '';
			if (!file_exists(PATH . "/{$file}")) {
    		    echo tpl_l("ОШИБКА! Файл не найден!", C_ERROR);
				echo tpl_enableBack();
    		    exit;
    		}
			echo tpl_l("&#1575;&#1587;&#1605; &#1575;&#1604;&#1605;&#1604;&#1601; `{$file}`.");
			$file = $matches[1];
		}
		else{
			echo tpl_l("&#1604;&#1605; &#1578;&#1602;&#1605; &#1576;&#1575;&#1582;&#1578;&#1610;&#1575;&#1585; &#1605;&#1604;&#1601; &#1604;&#1575;&#1587;&#1578;&#1585;&#1580;&#1575;&#1593;&#1607;", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l(str_repeat("-", 60));
		$fp = $this->fn_open($file, "r");
		$this->file_cache = $sql = $table = $insert = '';
        $is_skd = $query_len = $execute = $q =$t = $i = $aff_rows = 0;
		$limit = 300;
        $index = 4;
		$tabs = 0;
		$cache = '';
		$info = array();

		// Установка кодировки соединения
		if ($this->mysql_version > 40101 && (CHARSET != 'auto' || $this->forced_charset)) { // Кодировка по умолчанию, если в дампе не указана кодировка
			mysqli_query2("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("Неудается изменить кодировку соединения.<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
			echo tpl_l("An encoding of the connection `" . $this->restore_charset . "`.", C_WARNING);
			$last_charset = $this->restore_charset;
		}
		else {
			$last_charset = '';
		}
		$last_showed = '';
		while(($str = $this->fn_read_str($fp)) !== false){
			if (empty($str) || preg_match("/^(#|--)/", $str)) {
				if (!$is_skd && preg_match("/^#SKD101\|/", $str)) {
				    $info = explode("|", $str);
					echo tpl_s(0, $t / $info[4]);
					$is_skd = 1;
				}
        	    continue;
        	}
			$query_len += strlen($str);

			if (!$insert && preg_match("/^(INSERT INTO `?([^` ]+)`? .*?VALUES)(.*)$/i", $str, $m)) {
				if ($table != $m[2]) {
				    $table = $m[2];
					$tabs++;
					$cache .= tpl_l("&#1575;&#1587;&#1578;&#1585;&#1580;&#1575;&#1593; `{$table}`.");
					$last_showed = $table;
					$i = 0;
					if ($is_skd)
					    echo tpl_s(100 , $t / $info[4]);
				}
        	    $insert = $m[1] . ' ';
				$sql .= $m[3];
				$index++;
				$info[$index] = isset($info[$index]) ? $info[$index] : 0;
				$limit = round($info[$index] / 20);
				$limit = $limit < 300 ? 300 : $limit;
				if ($info[$index] > $limit){
					echo $cache;
					$cache = '';
					echo tpl_s(0 / $info[$index], $t / $info[4]);
				}
        	}
			else{
        		$sql .= $str;
				if ($insert) {
				    $i++;
    				$t++;
    				if ($is_skd && $info[$index] > $limit && $t % $limit == 0){
    					echo tpl_s($i / $info[$index], $t / $info[4]);
    				}
				}
        	}

			if (!$insert && preg_match("/^CREATE TABLE (IF NOT EXISTS )?`?([^` ]+)`?/i", $str, $m) && $table != $m[2]){
				$table = $m[2];
				$insert = '';
				$tabs++;
				$is_create = true;
				$i = 0;
			}
			if ($sql) {
			    if (preg_match("/;$/", $str)) {
            		$sql = rtrim($insert . $sql, ";");
					if (empty($insert)) {
						if ($this->mysql_version < 40101) {
				    		$sql = preg_replace("/ENGINE\s?=/", "TYPE=", $sql);
						}
						elseif (preg_match("/CREATE TABLE/i", $sql)){
							// Выставляем кодировку соединения
							if (preg_match("/(CHARACTER SET|CHARSET)[=\s]+(\w+)/i", $sql, $charset)) {
								if (!$this->forced_charset && $charset[2] != $last_charset) {
									if (CHARSET == 'auto') {
										mysqli_query2("SET NAMES '" . $charset[2] . "'") or trigger_error ("Неудается изменить кодировку соединения.<BR>{$sql}<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
										$cache .= tpl_l("An encoding of the connection `" . $charset[2] . "`.", C_WARNING);
										$last_charset = $charset[2];
									}
									else{
										$cache .= tpl_l('Encryption of connection and the table does not match:', C_ERROR);
										$cache .= tpl_l('&#1575;&#1587;&#1578;&#1585;&#1580;&#1575;&#1593; `'. $table .'` -> ' . $charset[2] . ' (соединение '  . $this->restore_charset . ')', C_ERROR);
									}
								}
								// Меняем кодировку если указано форсировать кодировку
								if ($this->forced_charset) {
									$sql = preg_replace("/(\/\*!\d+\s)?((COLLATE)[=\s]+)\w+(\s+\*\/)?/i", '', $sql);
									$sql = preg_replace("/((CHARACTER SET|CHARSET)[=\s]+)\w+/i", "\\1" . $this->restore_charset . $this->restore_collate, $sql);
								}
							}
							elseif(CHARSET == 'auto'){ // Вставляем кодировку для таблиц, если она не указана и установлена auto кодировка
								$sql .= ' DEFAULT CHARSET=' . $this->restore_charset . $this->restore_collate;
								if ($this->restore_charset != $last_charset) {
									mysqli_query2("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("Неудается изменить кодировку соединения.<BR>{$sql}<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
									$cache .= tpl_l("An encoding of the connection `" . $this->restore_charset . "`.", C_WARNING);
									$last_charset = $this->restore_charset;
								}
							}
						}
						if ($last_showed != $table) {$cache .= tpl_l("&#1575;&#1587;&#1578;&#1585;&#1580;&#1575;&#1593; `{$table}`."); $last_showed = $table;}
					}
					elseif($this->mysql_version > 40101 && empty($last_charset)) { // Устанавливаем кодировку на случай если отсутствует CREATE TABLE
						mysqli_query2("SET $this->restore_charset '" . $this->restore_charset . "'") or trigger_error ("Неудается изменить кодировку соединения.<BR>{$sql}<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
						echo tpl_l("An encoding of the connection `" . $this->restore_charset . "`.", C_WARNING);
						$last_charset = $this->restore_charset;
					}
            		$insert = '';
            	    $execute = 1;
            	}
            	if ($query_len >= 65536 && preg_match("/,$/", $str)) {
            		$sql = rtrim($insert . $sql, ",");
            	    $execute = 1;
            	}
    			if ($execute) {
            		$q++;
            		mysqli_query2($sql) or trigger_error ("Bad Request.<BR>" . mysqli_error($GLOBALS["db_link"]), E_USER_ERROR);
					if (preg_match("/^insert/i", $sql)) {
            		    $aff_rows += mysqli_affected_rows($GLOBALS["db_link"]);
            		}
            		$sql = '';
            		$query_len = 0;
            		$execute = 0;
            	}
			}
		}
		echo $cache;
		echo tpl_s(1 , 1);
		echo tpl_l(str_repeat("-", 60));
		echo tpl_l("DB restored from a backup.", C_RESULT);
		if (isset($info[3])) echo tpl_l("Date copies: {$info[3]}", C_RESULT);
		echo tpl_l("Query the database: {$q}", C_RESULT);
		echo tpl_l("Tables created: {$tabs}", C_RESULT);
		echo tpl_l("Rows inserted: {$aff_rows}", C_RESULT);

		$this->tabs = $tabs;
		$this->records = $aff_rows;
		$this->size = filesize(PATH . $this->filename);
		$this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
		echo "<SCRIPT>document.getElementById('back').disabled = 0;</SCRIPT>";
		// Передача данных для глобальной статистики

		$this->fn_close($fp);
	}

	function main(){
		$this->comp_levels = array('9' => '9 (&#1602;&#1608;&#1610;)', '8' => '8', '7' => '7', '6' => '6', '5' => '5 (&#1605;&#1578;&#1608;&#1587;&#1591;)', '4' => '4', '3' => '3', '2' => '2', '1' => '1 (&#1582;&#1601;&#1610;&#1601;)','0' => 'sql');

		if (function_exists("bzopen")) {
		    $this->comp_methods[2] = 'BZip2';
		}
		if (function_exists("gzopen")) {
		    $this->comp_methods[1] = 'GZip';
		}
		$this->comp_methods[0] = 'sql';
		if (count($this->comp_methods) == 1) {
		    $this->comp_levels = array('0' =>'sql');
		}

		$dbs = $this->db_select();
		$this->vars['db_backup']    = $this->fn_select($dbs, $this->SET['last_db_backup']);
		$this->vars['db_restore']   = $this->fn_select($dbs, $this->SET['last_db_restore']);
		$this->vars['comp_levels']  = $this->fn_select($this->comp_levels, $this->SET['comp_level']);
		$this->vars['comp_methods'] = $this->fn_select($this->comp_methods, $this->SET['comp_method']);
		$this->vars['tables']       = $this->SET['tables'];
		$this->vars['files']        = $this->fn_select($this->file_select(), '');
		$buttons = "<INPUT TYPE=submit VALUE=&#1578;&#1606;&#1601;&#1610;&#1584;><INPUT TYPE=button VALUE=&#1585;&#1580;&#1608;&#1593; onClick=\"location.href = 'members.php'\">";
		echo tpl_page(tpl_main(), $buttons);
	}

	function db_select(){
		if (DBNAMES != '') {
			$items = explode(',', trim(DBNAMES));
			foreach($items AS $item){
    			if (mysql_select_db($item)) {
    				$tables = mysqli_query2("SHOW TABLES");
    				if ($tables) {
    	  			    $tabs = mysqli_num_rows($tables);
    	  				$dbs[$item] = "{$item} ({$tabs})";
    	  			}
    			}
			}
		}
		else {
    		$result = mysqli_query2("SHOW DATABASES");
    		$dbs = array();
    		while($item = mysqli_fetch_array($result)){
    			if (mysql_select_db($item[0])) {
    				$tables = mysqli_query2("SHOW TABLES");
    				if ($tables) {
    	  			    $tabs = mysqli_num_rows($tables);
    	  				$dbs[$item[0]] = "{$item[0]} ({$tabs})";
    	  			}
    			}
    		}
		}
	    return $dbs;
	}

	function file_select(){
		$files = array('' => ' ');
		if (is_dir(PATH) && $handle = opendir(PATH)) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match("/^.+?\.sql(\.(gz|bz2))?$/", $file)) {
                    $files[$file] = $file;
                }
            }
            closedir($handle);
        }
        ksort($files);
		return $files;
	}

	function fn_open($name, $mode){
		if ($this->SET['comp_method'] == 2) {
			$this->filename = "{$name}.sql.bz2";
		    return bzopen(PATH . $this->filename, "{$mode}b{$this->SET['comp_level']}");
		}
		elseif ($this->SET['comp_method'] == 1) {
			$this->filename = "{$name}.sql.gz";
		    return gzopen(PATH . $this->filename, "{$mode}b{$this->SET['comp_level']}");
		}
		else{
			$this->filename = "{$name}.sql";
			return fopen(PATH . $this->filename, "{$mode}b");
		}
	}

	function fn_write($fp, $str){
		if ($this->SET['comp_method'] == 2) {
		    bzwrite($fp, $str);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    gzwrite($fp, $str);
		}
		else{
			fwrite($fp, $str);
		}
	}

	function fn_read($fp){
		if ($this->SET['comp_method'] == 2) {
		    return bzread($fp, 4096);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    return gzread($fp, 4096);
		}
		else{
			return fread($fp, 4096);
		}
	}

	function fn_read_str($fp){
		$string = '';
		$this->file_cache = ltrim($this->file_cache);
		$pos = strpos($this->file_cache, "\n", 0);
		if ($pos < 1) {
			while (!$string && ($str = $this->fn_read($fp))){
    			$pos = strpos($str, "\n", 0);
    			if ($pos === false) {
    			    $this->file_cache .= $str;
    			}
    			else{
    				$string = $this->file_cache . substr($str, 0, $pos);
    				$this->file_cache = substr($str, $pos + 1);
    			}
    		}
			if (!$str) {
			    if ($this->file_cache) {
					$string = $this->file_cache;
					$this->file_cache = '';
				    return trim($string);
				}
			    return false;
			}
		}
		else {
  			$string = substr($this->file_cache, 0, $pos);
  			$this->file_cache = substr($this->file_cache, $pos + 1);
		}
		return trim($string);
	}

	function fn_close($fp){
		if ($this->SET['comp_method'] == 2) {
		    bzclose($fp);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    gzclose($fp);
		}
		else{
			fclose($fp);
		}
		@chmod(PATH . $this->filename, 0666);
		$this->fn_index();
	}

	function fn_select($items, $selected){
		$select = '';
		foreach($items AS $key => $value){
			$select .= $key == $selected ? "<OPTION VALUE='{$key}' SELECTED>{$value}" : "<OPTION VALUE='{$key}'>{$value}";
		}
		return $select;
	}

	function fn_save(){
		if (SC) {
			$ne = !file_exists(PATH . "dumper.cfg.php");
		    $fp = fopen(PATH . "dumper.cfg.php", "wb");
        	fwrite($fp, "<?php\n\$this->SET = " . fn_arr2str($this->SET) . "\n?>");
        	fclose($fp);
			if ($ne) @chmod(PATH . "dumper.cfg.php", 0666);
			$this->fn_index();
		}
	}

	function fn_index(){
		if (!file_exists(PATH . 'index.html')) {
		    $fh = fopen(PATH . 'index.html', 'wb');
			fwrite($fh, tpl_backup_index());
			fclose($fh);
			@chmod(PATH . 'index.html', 0666);
		}
	}
}

function fn_int($num){
	return number_format($num, 0, ',', ' ');
}

function fn_arr2str($array) {
	$str = "array(\n";
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$str .= "'$key' => " . fn_arr2str($value) . ",\n\n";
		}
		else {
			$str .= "'$key' => '" . str_replace("'", "\'", $value) . "',\n";
		}
	}
	return $str . ")";
}

// Шаблоны

function tpl_page($content = '', $buttons = ''){
include "head.php";
include "navigation.php";

return <<<HTML



<STYLE TYPE="TEXT/CSS">
<!--
body{
	overflow: auto;
}
td {
	font: 11px tahoma, verdana, arial;
	color:#000000;
	cursor: default;
	direction:rtl;
}
input, select, div {
	font: 11px tahoma, verdana, arial;
}
input.text, select {
	width: 100%;
}
fieldset {
	margin-bottom: 10px;
}
-->
</STYLE>




<TABLE WIDTH=100%  BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=60% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=360 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP STYLE="border: 1px solid #919B9C;">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=1 CELLPADDING=0>
<TR>
<TD ID=Header HEIGHT=20 BGCOLOR=#7A96DF STYLE="font-size: 13px; color: white; font-family: verdana, arial;
padding-left: 5px; FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=1,startColorStr=#7A96DF,endColorStr=#FBFBFD)"
TITLE=''>
<B><A HREF=# STYLE="color: white; text-decoration: none;">نسخ و استرجاع قاعدة بيانات</A></B><IMG ID=GS WIDTH=1 HEIGHT=1 STYLE="visibility: hidden;"></TD>
</TR>
<TR>
<FORM NAME=skb METHOD=POST ACTION=dumper.php>
<TD VALIGN=TOP BGCOLOR=#F4F3EE STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#FCFBFE,endColorStr=#F4F3EE); padding: 8px 8px;">
{$content}
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD STYLE='color: #CECECE' ID=timer></TD>
<TD ALIGN=RIGHT>{$buttons}</TD>
</TR>
</TABLE></TD>
</FORM>
</TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
HTML;
}

function tpl_main(){
global $SK;
return <<<HTML
<FIELDSET onClick="document.skb.action[0].checked = 1;">
<LEGEND>
<INPUT TYPE=radio NAME=action VALUE=backup>
Backup / &#1575;&#1604;&#1606;&#1587;&#1582; &#1575;&#1604;&#1575;&#1581;&#1578;&#1610;&#1575;&#1591;&#1610; &#1604;&#1602;&#1608;&#1575;&#1593;&#1583; &#1575;&#1604;&#1576;&#1610;&#1575;&#1606;&#1575;&#1578;&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD WIDTH=35%>&#1602;&#1575;&#1593;&#1583;&#1577; &#1575;&#1604;&#1576;&#1610;&#1575;&#1606;&#1575;&#1578;:</TD>
<TD WIDTH=65%><SELECT NAME=db_backup>
{$SK->vars['db_backup']}
</SELECT></TD>
</TR>
<TR>
<TD>&#1604;&#1606;&#1587;&#1582; &#1580;&#1583;&#1608;&#1604; &#1601;&#1602;&#1591; &#1602;&#1605; &#1576;&#1575;&#1583;&#1585;&#1575;&#1580; &#1575;&#1587;&#1605; &#1575;&#1604;&#1580;&#1583;&#1608;&#1604;:</TD>
<TD><INPUT NAME=tables TYPE=text CLASS=text VALUE='{$SK->vars['tables']}'></TD>
</TR>
<TR>
<TD>&#1582;&#1610;&#1575;&#1585;&#1575;&#1578; &#1575;&#1604;&#1606;&#1587;&#1582;:</TD>
<TD><SELECT NAME=comp_method>
{$SK->vars['comp_methods']}
</SELECT></TD>
</TR>
<TR>
<TD>&#1582;&#1610;&#1575;&#1585;&#1575;&#1578;gzip:</TD>
<TD><SELECT NAME=comp_level>
{$SK->vars['comp_levels']}
</SELECT></TD>
</TR>
</TABLE>
</FIELDSET>
<FIELDSET onClick="document.skb.action[1].checked = 1;">
<LEGEND>
<INPUT TYPE=radio NAME=action VALUE=restore>
Restore / &#1575;&#1587;&#1578;&#1585;&#1580;&#1575;&#1593; &#1602;&#1575;&#1593;&#1583;&#1577; &#1576;&#1610;&#1575;&#1606;&#1575;&#1578;&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD>&#1602;&#1575;&#1593;&#1583;&#1577; &#1575;&#1604;&#1576;&#1610;&#1575;&#1606;&#1575;&#1578;:</TD>
<TD><SELECT NAME=db_restore>
{$SK->vars['db_restore']}
</SELECT></TD>
</TR>
<TR>
<TD WIDTH=35%>&#1575;&#1582;&#1578;&#1585; &#1575;&#1604;&#1605;&#1604;&#1601;:</TD>
<TD WIDTH=65%><SELECT NAME=file>
{$SK->vars['files']}
</SELECT></TD>
</TR>
</TABLE>
</FIELDSET>
</SPAN>
<SCRIPT>
document.skb.action[{$SK->SET['last_action']}].checked = 1;
</SCRIPT>

HTML;
}

function tpl_process($title){
return <<<HTML
<FIELDSET>
<LEGEND>{$title}&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR><TD COLSPAN=2><DIV ID=logarea STYLE="width: 100%; height: 140px; border: 1px solid #7F9DB9; padding: 3px; overflow: auto;"></DIV></TD></TR>
<TR><TD WIDTH=31%>&#1580;&#1575;&#1585;&#1610; &#1606;&#1587;&#1582; &#1575;&#1604;&#1580;&#1583;&#1608;&#1604; :</TD><TD WIDTH=69%><TABLE WIDTH=100% BORDER=1 CELLPADDING=0 CELLSPACING=0>
<TR><TD BGCOLOR=#FFFFFF><TABLE WIDTH=1 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#5555CC ID=st_tab
STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCCCFF,endColorStr=#5555CC);
border-right: 1px solid #AAAAAA"><TR><TD HEIGHT=12></TD></TR></TABLE></TD></TR></TABLE></TD></TR>
<TR><TD>&#1580;&#1575;&#1585;&#1610; &#1606;&#1587;&#1582; &#1602;&#1575;&#1593;&#1583;&#1577; &#1575;&#1604;&#1576;&#1610;&#1575;&#1606;&#1575;&#1578;:</TD><TD><TABLE WIDTH=100% BORDER=1 CELLSPACING=0 CELLPADDING=0>
<TR><TD BGCOLOR=#FFFFFF><TABLE WIDTH=1 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#00AA00 ID=so_tab
STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCFFCC,endColorStr=#00AA00);
border-right: 1px solid #AAAAAA"><TR><TD HEIGHT=12></TD></TR></TABLE></TD>
</TR></TABLE></TD></TR></TABLE>
</FIELDSET>
<SCRIPT>
var WidthLocked = false;
function s(st, so){
	document.getElementById('st_tab').width = st ? st + '%' : '1';
	document.getElementById('so_tab').width = so ? so + '%' : '1';
}
function l(str, color){
	switch(color){
		case 2: color = 'navy'; break;
		case 3: color = 'red'; break;
		case 4: color = 'maroon'; break;
		default: color = 'black';
	}
	with(document.getElementById('logarea')){
		if (!WidthLocked){
			style.width = clientWidth;
			WidthLocked = true;
		}
		str = '<FONT COLOR=' + color + '>' + str + '</FONT>';
		innerHTML += innerHTML ? "<BR>\\n" + str : str;
		scrollTop += 14;
	}
}
</SCRIPT>
HTML;
}

function tpl_auth($error){
return <<<HTML
<SPAN ID=error>
<FIELDSET>
<LEGEND>Mistake</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD>Для работы Sypex Dumper Lite требуется:<BR> - Internet Explorer 5.5+, Mozilla whether Opera 8+ (<SPAN ID=sie>-</SPAN>)<BR> - включено выполнение JavaScript скриптов (<SPAN ID=sjs>-</SPAN>)</TD>
</TR>
</TABLE>
</FIELDSET>
</SPAN>
<SPAN ID=body STYLE="display: none;">
{$error}
<FIELDSET>
<LEGEND>&#1578;&#1587;&#1580;&#1610;&#1604; &#1583;&#1582;&#1608;&#1604; </LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD WIDTH=41%>&#1575;&#1587;&#1605; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605; :</TD>
<TD WIDTH=59%><INPUT NAME=login TYPE=text CLASS=text></TD>
</TR>
<TR>
<TD>&#1603;&#1604;&#1605;&#1577; &#1575;&#1604;&#1605;&#1585;&#1608;&#1585; :</TD>
<TD><INPUT NAME=pass TYPE=password CLASS=text></TD>
</TR>
</TABLE>
</FIELDSET>
</SPAN>
<SCRIPT>
document.getElementById('sjs').innerHTML = '+';
document.getElementById('body').style.display = '';
document.getElementById('error').style.display = 'none';
var jsEnabled = true;
</SCRIPT>
HTML;
}

function tpl_l($str, $color = C_DEFAULT){
$str = preg_replace("/\s{2}/", " &nbsp;", $str);
return <<<HTML
<SCRIPT>l('{$str}', $color);</SCRIPT>

HTML;
}

function tpl_enableBack(){
return <<<HTML
<SCRIPT>document.getElementById('back').disabled = 0;</SCRIPT>

HTML;
}

function tpl_s($st, $so){
$st = round($st * 100);
$st = $st > 100 ? 100 : $st;
$so = round($so * 100);
$so = $so > 100 ? 100 : $so;
return <<<HTML
<SCRIPT>s({$st},{$so});</SCRIPT>

HTML;
}

function tpl_backup_index(){
return <<<HTML
<CENTER>
<H1>&#1575;&#1604;&#1608;&#1589;&#1608;&#1604; &#1573;&#1604;&#1609; &#1607;&#1584;&#1607; &#1575;&#1604;&#1589;&#1601;&#1581;&#1577; &#1594;&#1610;&#1585; &#1605;&#1587;&#1605;&#1608;&#1581; &#1576;&#1607;!<br>
Access to the requested URL is not allowed!
</H1>
</CENTER>

HTML;
}

function tpl_error($error){
return <<<HTML
<FIELDSET>
<LEGEND>&#1604;&#1602;&#1583; &#1571;&#1583;&#1582;&#1604;&#1578; &#1575;&#1587;&#1605; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605;  &#1571;&#1608; &#1603;&#1604;&#1605;&#1577; &#1605;&#1585;&#1608;&#1585; &#1582;&#1575;&#1591;&#1574;&#1577;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD ALIGN=center>{$error}</TD>
</TR>
</TABLE>
</FIELDSET>

HTML;
}

function SXD_errorHandler($errno, $errmsg, $filename, $linenum, $vars) {
	if ($errno == 2048) return true;
	if (preg_match("/chmod\(\).*?: Operation not permitted/", $errmsg)) return true;
    $dt = date("Y.m.d H:i:s");
    $errmsg = addslashes($errmsg);

	echo tpl_l("{$dt}<BR><B>Error!</B>", C_ERROR);
	echo tpl_l("{$errmsg} ({$errno})", C_ERROR);
	echo tpl_enableBack();
	die();
}
?>