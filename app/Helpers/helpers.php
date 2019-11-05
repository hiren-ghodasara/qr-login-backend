<?php
if (!function_exists('lq')) {
    function lq($type = false)
    {
        list($callee) = debug_backtrace();
        echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
        echo '<legend style="background:lightgrey; padding:5px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend><pre>';
        $query = DB::getQueryLog();
        if ($type) {
            var_dump($query);
        } else {
            $query = end($query);
            print_r($query['query']);
        }
        echo '</pre>' . PHP_EOL;
        echo '</fieldset>' . PHP_EOL;
        die;
    }
}

if (!function_exists('lqLog')) {
    function lqLog()
    {
        $query = DB::getQueryLog();
        $query = end($query);
        return $query['query'];
    }
}

if (!function_exists('ddd')) {
    function ddd($data)
    {
        list($callee) = debug_backtrace();
        echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
        echo '<legend style="background:lightgrey; padding:5px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend><pre>';
        print_r($data);
        echo '</pre>' . PHP_EOL;
        echo '</fieldset>' . PHP_EOL;
        die;
    }
}
