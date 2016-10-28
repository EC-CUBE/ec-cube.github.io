<?php

if (function_exists('log_info') === false) {

    function log_emergency($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->emergency($message, $context);
    }

    function log_alert($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->alert($message, $context);
    }

    function log_critical($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->critical($message, $context);
    }

    function log_error($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->error($message, $context);
    }

    function log_warning($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->warning($message, $context);
    }

    function log_notice($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->notice($message, $context);
    }

    function log_info($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->info($message, $context);
    }

    function log_debug($message, array $context = array())
    {
        $GLOBALS['eccube_logger']->debug($message, $context);
    }

    function eccube_log_init($app)
    {
        if (isset($GLOBALS['eccube_logger'])) {
            return;
        }
        $GLOBALS['eccube_logger'] = $app['monolog'];
        $app['eccube.monolog.factory'] = $app->protect(function ($config) use ($app) {
            return $app['monolog'];
        });
    }

    // 3.0.9以上の場合は初期化処理を行う.
    if (method_exists('Eccube\Application', 'getInstance')) {
        $app = \Eccube\Application::getInstance();
        eccube_log_init($app);
    }


}
