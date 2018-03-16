---
title: Symfonyの機能を使ったカスタマイズ
keywords: core カスタマイズ Symfony
tags: [core, symfony]
sidebar: home_sidebar
permalink: customize_symfony
folder: customize
---


---

## 概要

EC-CUBEは、SymfonyやDoctrineをベースに開発されています。
そのため、SymfonyやDoctrineが提供している拡張機構を利用することができます。

ここでは、代表的な拡張機構とその実装方法を紹介します。

## Symfony Event

Symfonyのイベントシステムを利用することができます。

### hello worldを表示するイベントリスナーを作成する

`app/Acme/EventListener`配下にに`HelloListener.php`を作成します。

```php
<?php

namespace Acme\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class HelloListener implements EventSubscriberInterface
{
    public function onResponse(FilterResponseEvent $event)
    {
        echo 'hello world';
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onResponse',
        ];
    }
}
```

作成後、画面を表示(どのページでも表示されます)し、`hello world`が表示されていれば成功です。

表示されない場合は、`bin/console cache:clear --no-warmup`でキャッシュを削除してください。
また、`bin/console debug:event-dispatcher`で登録されているイベントリスナーを確認できます。

イベントに関する詳細は以下を参照してください。

- [The HttpKernel Component](https://symfony.com/doc/current/components/http_kernel.html)
- [Events and Event Listeners](https://symfony.com/doc/current/event_dispatcher.html)
- [Built-in Symfony Events](https://symfony.com/doc/current/reference/events.html)

## Command

`bin/console`から実行できるコンソールコマンドを作成することが出来ます。

### hello worldを表示するコマンドを作成する

`app/Acme/Command`配下に`HelloCommand.php`を作成します。

```php
<?php

namespace Acme\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HelloCommand extends Command
{
    // コマンド名
    protected static $defaultName = 'acme:hello';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // hello worldを表示
        $io->success('hello world');
    }
}
```

- `$defaultName`はコマンド名を表します。
- `$io->success('hello world')`で、hello worldを表示します。

作成後、`bin/console`で実行することができます。

```bash

$ bin/console acme:helllo

 [OK] hello world

```

※ コマンドが認識されない場合は、`bin/console cache:clear --no-warmup`でキャッシュを削除してください。

Commandに関する詳細は以下を参照してください。

- [Console Commands](https://symfony.com/doc/current/console.html)

## Doctrine Event

Doctrineのイベントシステムを利用することができます。

### ショップ名にようこそを付与するイベントリスナーを作成する

`app/Acme/Doctrine`配下に`HelloEventSubscriber.php`を作成します。

```php
<?php

namespace Acme\Doctrine\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Eccube\Entity\BaseInfo;

class HelloEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [Events::postLoad];
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof BaseInfo) {
            $shopName = $entity->getShopName();
            $shopName = 'ようこそ '.$shopName.' へ';
            $entity->setShopName($shopName);
        }
    }
}
```

作成後、トップページを開き、`ようこそ [ショップ名] へ`が表示されていれば成功です。

表示されない場合は、`bin/console cache:clear --no-warmup`でキャッシュを削除してください。

イベントに関する詳細は以下を参照してください。

- [The Event System](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html)
- [Doctrine Event Listeners and Subscribers](https://symfony.com/doc/current/doctrine/event_listeners_subscribers.html)

※ [Doctrine Event Listeners and Subscribers](https://symfony.com/doc/current/doctrine/event_listeners_subscribers.html)では、`services.yaml`での設定方法が記載されていますが、EC-CUBEはDoctrineのイベントリスナーをコンテナへ自動登録します。そのため、`services.yaml`での設定は不要です。

## SymfonyのBundleを利用する

TODO

