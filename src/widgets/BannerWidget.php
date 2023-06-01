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
use yii\helpers\Html;

class BannerWidget extends Widget
{
    public $place_id;
    public $targetBlank = true;
    public $showSubLink = false;
    public $showSubtitle = false;
    public $js = '';
    private $place;
    private $banners;
    private $bannersActive;

    /**
     * @return bool
     */
    public function init(): bool
    {
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
                ->orderBy('weight DESC')
                ->andWhere(['place_id' => $place->id])
                ->all();
            return [
                $place,
                $bannersActive ?? []
            ];
        }, 60 * 60, new TagDependency(['tags' => [Module::CACHE_TAG_BANNERS]]));

        return true;
    }

    /** Рендерим вьюху
     * @return string
     */
    public function run(): string
    {
        if (sizeof((array)$this->bannersActive) == 0)
            return '';

        if ($this->place->slider == AdsPlace::SLIDER_ENABLED) {

            foreach ($this->bannersActive as $banner)
                $banner->increaseViews();
            $renderedBanner = $this->render('bannerWidgetSlider', [
                'banners' => $this->bannersActive,
                'place' => $this->place,
                'targetBlank' => $this->targetBlank,
            ]);


        } else {

            $position = rand(0, (sizeof($this->bannersActive)) - 1);
            $banner = $this->bannersActive[$position];
            $banner->increaseViews();
            $renderedBanner = $this->render('bannerWidgetSingle', [
                'banner' => $banner,
                'place' => $this->place,
                'targetBlank' => $this->targetBlank,
            ]);

            if ($this->showSubLink) {
                $renderedBanner .= Html::a($banner->title, ['/banner/redirect', 'id' => $banner->id], $this->targetBlank ? ['target' => '_blank'] : []);
                $renderedBanner .= Html::tag('p', $banner->subtitle);
            }

        }


        if ($this->js) {
            $this->getView()->registerJs($this->js);
        }
        return $renderedBanner;

    }

}
