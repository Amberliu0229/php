<?
walk_dir_scan("csv/", true);
// walk_dir_scan("./www_extjs/production/", true);
// walk_dir_scan("./www_common/include", true);

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
            if (($file !== '.') && ($file !== '..')) {
                if (!is_dir($dir . $file)) {
                    $data = file_get_contents($dir . $file);
                    $all = array_map("str_getcsv", explode("\n", $data));
                    // print_r($all);
                    $json = array();
                    foreach ($all as $key => $value) {
                        // print_r(array($key,$value));
                        if (count($value) == 3) {
                            foreach ($value as $idx => $str) {
                                if ($key === 0) {
                                    if ($idx == 1) {
                                        $jsonDir = str_replace('csv', 'json', $dir);
                                        $jsonFile = $str . ".json";
                                        if (!file_exists($jsonDir)) {
                                            mkdir($jsonDir, 0755, true);
                                        }
                                        if (!file_exists($jsonDir . $jsonFile)) {
                                            // echo $jsonDir . $jsonFile . "\n";
                                            file_put_contents($jsonDir . $jsonFile, json_encode(array()));
                                        }
                                    }
                                } else {
                                    if ($idx == 0) {
                                        $json[$str] = urlencode($value[$idx + 1]);
                                    }
                                }
                                // echo $jsonDir . $jsonFile . "\n";
                                // echo str_replace("\"", "", $arr[$idx + 1]) . "\n";
                            }
                            // print_r(array($json, $jsonFile));
                            unset($json[""]);
                            if (file_exists($jsonDir . $jsonFile)) {
                                $url_format_json = json_encode($json, JSON_BIGINT_AS_STRING | JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_FORCE_OBJECT );
                                $final_json = urldecode($url_format_json);
                                file_put_contents($jsonDir . $jsonFile, chr(239) . chr(187) . chr(191). $final_json);
                            }
                        }
                    }

                    // print_r($json);
                } else {
                    //dbg_printf("Go to dir:[$dir] file:[$file]");
                    walk_dir_scan($dir . $file, $check_exist);
                }
            }
        }
    } else {
        //dbg_printf("$dir not exist");
    }
}

function unescapeUTF8EscapeSeq($str) {
    return preg_replace_callback("/\\\u([0-9a-f]{4})/i",
        create_function('$matches',
            'return html_entity_decode(\'&#x\'.$matches[1].\';\', ENT_QUOTES, \'UTF-8\');'
        ), $str);
}
?>
