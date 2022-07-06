<?php
/**
 * Default configuration for Xhgui
 */
return [
    'debug'           => false,
    'mode'            => 'development',
    /*
     * support extension: uprofiler, tideways_xhprof, tideways, xhprof
     * default: xhprof
     */
    'extension'       => 'tideways',

    // Can be either mongodb or file.
    /*
    'save.handler' => 'file',
    'save.handler.filename' => dirname(__DIR__) . '/cache/' . 'xhgui.data.' . microtime(true) . '_' . substr(md5($url), 0, 6),
    */
    'save.handler'    => 'mongodb',

    // Needed for file save handler. Beware of file locking. You can adujst this file path
    // to reduce locking problems (eg uniqid, time ...)
    //'save.handler.filename' => __DIR__.'/../data/xhgui_'.date('Ymd').'.dat',
    'db.host'         => 'mongodb://dev:dev123@mongodb:27017',
    'db.db'           => 'xhprof',

    // Allows you to pass additional options like replicaSet to MongoClient.
    // 'username', 'password' and 'db' (where the user is added)
    'db.options'      => [],
    'templates.path'  => dirname(__DIR__) . '/src/templates',
    'date.format'     => 'Y-m-d H:i:s',
    'detail.count'    => 6,
    'page.limit'      => 25,

    // Profile 1 in 100 requests.
    // You can return true to profile every request.
    'profiler.enable' => function() {
        //不记录自身
        if ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/favicon.ico') {
            return false;
        }
        return true;//rand(1, 100) === 42;
    },

    'profiler.simple_url' => function($url) {
        return preg_replace('/\=\d+/', '', $url);
    },

    'profiler.filter_path' => [
        //'/home/admin/www/xhgui/webroot','F:/phpPro'
    ]

];
