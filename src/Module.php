<?php

namespace floor12\banner;

/**
 * Banner module definition class
 * @property  string $adminLayout
 * @property  string $controllerNamespace
 * @property  string $administratorRole
 */
class Module extends \yii\base\Module
{
    const CACHE_TAG_BANNERS = 'banners_cache';
    const CACHE_TAG_POPUPS = 'popaup_cache';
    /** 
     * @inheritdoc
     */
    public $controllerNamespace = 'floor12\banner\controllers';

    /**
     * @var string Layout alias to use it admin controller
     */
    public $adminLayout = '@app/views/layouts/main';

    /**
     * @var string Role to access admin controller
     */
    public $administratorRole = '@';

    /**
     * @var string WEb path to save rich html banners
     */
    public $bannersWebPath = '@web/banners';

    /**
     * @var string Absolute path to save rich html banners
     */
    public $bannersWebRootPath = '@webroot/banners';
    /**
     * Width to switch between mobile and desktop banner version
     * @var int
     */
    public $adaptiveBreakpoint = 700;


}
