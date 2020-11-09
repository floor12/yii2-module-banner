<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 12:13
 */

namespace floor12\banner\widgets;

use floor12\banner\models\AdsBanner;
use floor12\banner\models\AdsPlace;
use floor12\banner\Module;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

class BannerWidget extends Widget
{
    public $place_id;
    public $_place_id;
    public $targetBlank = true;
    private $place;
    private $banners;
    private $view;
    private $bannersActive;

    /**
     * @return bool
     */
    public function init(): bool
    {
        if (empty($this->place_id))
            $this->place = $this->_place_id;

        // Некоторые браузеры любят посылать HEAD запросы, что ошибочно увеличивает счетчик просмотров
        if (Yii::$app->request->method == 'HEAD')
            return false;

        $cacheKey = ['banner', $this->place_id];

        list($this->place, $this->bannersActive) = Yii::$app->cache->getOrSet($cacheKey, function () {
            $place = AdsPlace::findOne($this->place_id);
            if (!$place)
                return false;
            $bannersActive = AdsBanner::find()
                ->leftJoin('ads_place_banner', 'ads_place_banner.banner_id=ads_banner.id')
                ->active()
                ->andWhere(['place_id' => $place->id])
                ->all();
            return [
                $place,
                $bannersActive ?? []
            ];
        }, 60 * 60, new TagDependency(['tags' => [Module::CACHE_TAG_BANNERS]]));


        // Если не найдены активные баннеры -  тоже ничего не делаем
        if (empty($this->bannersActive))
            return false;

        // Если площадка в режиме слайдера - выбираем все баннеры. В противном случае - рандомно выбираем 1 баннер из актиыных
        if ($this->place->slider == AdsPlace::SLIDER_ENABLED) {
            $this->banners = $this->bannersActive;
            foreach ($this->banners as $banner)
                $banner->increaseViews();
            $this->view = 'bannerWidgetSlider';
        } else {
            $this->banners = $this->bannersActive[rand(0, sizeof($this->bannersActive) - 1)];
            $this->banners->increaseViews();
            $this->view = 'bannerWidgetSingle';
        }

        if (!$this->banners)
            return false;

        return true;
    }

    /** Рендерим вьюху
     * @return string
     */
    public function run(): string
    {
        if (!$this->banners)
            return "";
        return $this->render($this->view, [
            'banners' => $this->banners,
            'place' => $this->place,
            'id' => "banner" . rand(99999, 9999999),
            'targetBlank' => $this->targetBlank,
            'adaptiveBreakpoint' => Yii::$app->getModule('banner')->adaptiveBreakpoint
        ]);
    }

}
