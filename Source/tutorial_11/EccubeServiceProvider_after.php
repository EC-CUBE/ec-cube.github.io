<?php

.
..
...
 $app['eccube.repository.help'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\Help');
        });
        $app['eccube.repository.plugin'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\Plugin');
        });
        $app['eccube.repository.plugin_event_handler'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\PluginEventHandler');
        });

        $app['eccube.repository.crud'] = $app->share(function () use ($app) { ★この行を追加
            return $app['orm.em']->getRepository('Eccube\Entity\Crud');
        });

        // em
.
..
...
