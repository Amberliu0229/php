<?php
define('SUPPORT_LANGS', 'support.json');
define('FIND_NO_STRING_KEY', 'GER');

$arr = json_decode(removeBOM(file_get_contents(SUPPORT_LANGS)), true);

foreach ($arr as $key => $value) {
    $langKey[] = $key;
}
shell_exec('rm -rf csv');
walk_dir_scan("./", true);

if (file_exists('csv.zip')) {
    shell_exec('rm csv.zip');
}
shell_exec('zip -r csv csv/* -x "**/.svn**"');

/**
 * remove UTF8-BOM
 */
function removeBOM($str = '') {
    if (substr($str, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
        $str = substr($str, 3);
    }
    return $str;
}

function walk_dir_scan($dir, $check_exist = true) {
    if (substr($dir, -1) != "/") {
        $dir .= "/";
    }
    if ($dh = opendir($dir)) {
        while (false !== ($file = readdir($dh))) {
            if (($file !== '.') && ($file !== '..') && ($file !=='render') && ($file !=='csv')) {
                if (!is_dir($dir . $file)) {

                    if ($file == 'ENG.json' && strpos($dir, 'keyword') == 0) {
                        $newDir = str_replace('./', './csv/', $dir);
                        if (!file_exists($newDir)) {
                            mkdir($newDir, 0755, true);
                        }
                        // file_put_contents($newDir . "ALL.csv", $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)), LOCK_EX);

                        foreach ($GLOBALS['langKey'] as $value) {
                            if (file_exists($dir . $value . '.json')) {
                                file_put_contents($newDir . $value . ".csv", $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)), LOCK_EX);
                                $json = json_decode(removeBOM(file_get_contents($dir . $value . '.json', true)), true);
                                $engJson = json_decode(removeBOM(file_get_contents($dir . 'ENG.json', true)), true);
                                $fp = fopen($newDir . $value . ".csv", "w");
                                fputcsv($fp, array("key", $value, "ENG"));
                                foreach ($engJson as $engKey => $engStr) {
                                    $mapping = false;
                                    foreach ($json as $key => $str) {
                                        if ($engKey === $key) {
                                            fputcsv($fp, array($key, $str, $engStr));
                                            /* save no string key */
                                            if (!$str &&
                                                $key !== '----------' &&
                                                $value == FIND_NO_STRING_KEY &&
                                                $engStr !== '') {
                                                $fopen = fopen("csv/" . FIND_NO_STRING_KEY . ".csv", "a");
                                                fputcsv($fopen, array($engKey, $engStr, ""));
                                                fclose($fopen);
                                            }
                                            $mapping = true;
                                            break;
                                        }
                                    }
                                    if(!$mapping){
                                        fputcsv($fp, array($engKey, "", $engStr));
                                    }
                                }
                                // print_r($content);
                                // file_put_contents($newDir . $value . ".csv", $content . "\n", FILE_APPEND | LOCK_EX);
                                fclose($fp);
                            } else {
                                $engJson = json_decode(removeBOM(file_get_contents($dir . 'ENG.json', true)), true);
                                $fp = fopen($newDir . $value . ".csv", "w");
                                fputcsv($fp, array("key", $value, "ENG"));
                                foreach ($engJson as $engKey => $engStr) {
                                    fputcsv($fp, array($engKey, '', $engStr));
                                    /* save no string key */
                                    if ($engKey !== '----------' &&
                                        $value == FIND_NO_STRING_KEY &&
                                        $engStr !== '') {
                                        $fopen = fopen("csv/" . FIND_NO_STRING_KEY . ".csv", "a");
                                        fputcsv($fopen, array($engKey, $engStr, ""));
                                        fclose($fopen);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    walk_dir_scan($dir . $file, $check_exist);
                }
            }
        }
    } else {
        //dbg_printf("$dir not exist");
    }
}

function json_clean_decode($json, $assoc = false, $depth = 512, $options = 0) {
    // search and remove comments like /* */ and //
    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);

    if (version_compare(phpversion(), '5.4.0', '>=')) {
        $json = json_decode($json, $assoc, $depth, $options);
    } elseif (version_compare(phpversion(), '5.3.0', '>=')) {
        $json = json_decode($json, $assoc, $depth);
    } else {
        $json = json_decode($json, $assoc);
    }

    return $json;
}
?>
