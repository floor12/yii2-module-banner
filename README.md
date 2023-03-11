# yii2-module-banner

[![Latest Stable Version](https://poser.pugx.org/floor12/yii2-module-banner/v/stable)](https://packagist.org/packages/floor12/yii2-module-banner)
[![Latest Unstable Version](https://poser.pugx.org/floor12/yii2-module-banner/v/unstable)](https://packagist.org/packages/floor12/yii2-module-banner)
[![Total Downloads](https://poser.pugx.org/floor12/yii2-module-banner/downloads)](https://packagist.org/packages/floor12/yii2-module-banner)
[![License](https://poser.pugx.org/floor12/yii2-module-banner/license)](https://packagist.org/packages/floor12/yii2-module-banner)

Модуль для размещения и управления баннерами и поп-ап на сайте.

 
На данный момент оперирует со следующими сущностями 

- площадками (местами установки баннера на сайте),
- площадками для поп-ап баннеров
- непосредственно баннерами
- pop-up баннерами.


## Установка

### Добавление модуля в проект

Для добавления модуля выполняем команду
```bash
$ composer require floor12/yii2-module-banner
```
или добавляем в секцию "required" вашего файла composer.json следую строку:
```json
"floor12/yii2-module-banner": "dev-master"
```

Внимание, для работы модуля необходима библиотека [PHP-GD](https://www.php.net/manual/ru/book.image.php
), собранная с поддержкай формата WEBP. 
Этот формат имеет ряд преимуществ и используется модулем для отображения баннеров для тех браузеров, 
[которые это поддерживают](https://caniuse.com/#feat=webp).

### Выполнение миграций

Для работы модуль использует модуль для работы с файлами [floor12/yii2-module-files](https://github.com/floor12/yii2-module-files
), поэтому необходимо применить миграции сразу обоих модулей. Для автоматического применения миграций из 
установленных в проект модулей рекомендую использовать дополнительный компонент, 
например [fishvision/yii2-migrate](https://github.com/fishvision/yii2-migrate).

Выполняем миграции:

```bash
$ ./yii migrate --migrationPath=@vendor/floor12/yii2-module-banner/src/migrations
$ ./yii migrate --migrationPath=@vendor/floor12/yii2-module-files/src/migrations
```

### Регистрация и конфигурирование модуля

Для дальнейшей работы необходимо зарегистрировать данный и зависимый от него модули в конфиге приложения, в секции `modules
`. В минимальной конфигурации регистрация модулей выглядит следующим образом:

```php  
'modules' => [
    'modules' => [
        'banner' => [
            'class' => 'floor12\banner\Module',
        ],
        'files' => [
            'class' => 'floor12\files\Module',
        ],
    ],
    ]
    ...
```

При этом `floor12\banner\Module` имеет дополнительный параметры для конфигурации:

1. `administratorRole
` - роль пользователей, которым доступно управление, по умолчанию содержит `@` предоставляя доступ всем авторизованным пользователям;
2. `adminLayout` - алиас для лейаута админского контроллера, по умолчанию `@app/views/layouts/main`;
3. `adaptiveBreakpoint
` - ширина в пикселях, на которой происходит переключения баннера между мобильной и десктоп-версией, по умолчанию `700`;
4. `bannersWebPath` - алиас путь к папке для html баннеров для доступа из браузера, по умолчанию `@web/banners`;
5. `bannersWebRootPath` - алиас путь к папке для html баннеров относительно корня файловой системы, по умолчанию `@webroot/banners`;

Последние 2 параметра необходисы только при использовании Rich HTML баннеров, загрузка которых должна происходить в виде zip архива.

Необходимый для работы модуль файлов [floor12/yii2-module-files](https://github.com/floor12/yii2-module-files) имеет ряд параметров, 
описанных [в его документации](https://github.com/floor12/yii2-module-files/blob/master/README_RU.md).

Использование
-----
Для внедрения в view-файл баннера, вызываем виджет `BannerWidget
`, который размещает в этом месте площадку, созданную заранее. В баннер необходимо передать `place_id` - это id
 площадки для размещения. 


```php  
<?= floor12\banner\widgets\BannerWidget::widget(['place_id' => 1]) ?>
```

Если площадка не найдена, или в ней отсутствуют связанные баннеры, то виджет ничего не отобразит.

Если на одну и ту же площадку добавлено более одного активного баннера, то существуют две модели поведения.
По умолчанию, баннеры будут рандомно меняться при перезагрузке страницы. Но, если в настройках площадки выбрать 
"слайдер", то все активные баннеры текущей площадки будут перелистываться, образуя слайдер. 
В настройках баннера существует атрибут как "вес". Если на данной площадке включен режим слайдера, то этот атрибут отвечает за порядок
отображения баннеров в слайдере.

Для отображения pop-up баннеров, необходимо в основной layout вывести `PopupWidget`, куда передать `place_id` c ID площадки для pop-up
 баннеров:
```
<?php
    $this->beginBody();
    echo PopupWidget::widget(['place_id' => 1]);
?>
```

### Администрирование

По умолчанию админский контроллер доступен по адресу:

```
http://your-domain.com/banner/admin
```
