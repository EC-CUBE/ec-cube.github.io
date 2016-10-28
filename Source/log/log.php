<?php

if (version_compare(\Eccube\Common\Constant::VERSION, '3.0.12', '>=')) {
    return;
}

if (function_exists('log_emergency') === false) {

    function log_emergency($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->emergency($message, $context);
        }
    }

}

if (function_exists('log_alert') === false) {

    function log_alert($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->alert($message, $context);
        }
    }

}

if (function_exists('log_critical') === false) {

    function log_critical($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->critical($message, $context);
        }
    }

}

if (function_exists('log_error') === false) {

    function log_error($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->error($message, $context);
        }
    }

}

if (function_exists('log_warning') === false) {

    function log_warning($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->warning($message, $context);
        }
    }

}

if (function_exists('log_notice') === false) {

    function log_notice($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->notice($message, $context);
        }
    }

}

if (function_exists('log_info') === false) {

    function log_info($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->info($message, $context);
        }
    }

}

if (function_exists('log_debug') === false) {

    function log_debug($message, array $context = array())
    {
        if (isset($GLOBALS['eccube_logger'])) {
            $GLOBALS['eccube_logger']->debug($message, $context);
        }
    }

}

if (function_exists('eccube_log_init') === false) {

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

}

// 3.0.9以上の場合は初期化処理を行う.
if (method_exists('Eccube\Application', 'getInstance') === true) {
    $app = \Eccube\Application::getInstance();
    eccube_log_init($app);
}
