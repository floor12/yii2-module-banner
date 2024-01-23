<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 13.01.2017
 * Time: 22:12
 */

namespace floor12\banner\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class TabWidget extends Widget
{
    public $linkPostfix;
    public $items;

    public function init()
    {
        $this->items = [
            [
                'name' => \Yii::t('app.f12.banner', 'Banners'),
                'href' => Url::toRoute(['banner'])
            ],
            [
                'name' => \Yii::t('app.f12.banner', 'Pop-up banners'),
                'href' => Url::toRoute(['popup'])
            ],
            [
                'name' => \Yii::t('app.f12.banner', 'Banner places'),
                'href' => Url::toRoute(['place'])
            ],
            [
                'name' => \Yii::t('app.f12.banner', 'Pop-up places'),
                'href' => Url::toRoute(['pop-place'])
            ],
        ];
    }

    function run(): string
    {

        $active_flag = false;
        $nodes = [];

        if ($this->items) {

            foreach ($this->items as $item) {
                if (\Yii::$app->urlManager->baseUrl . $_SERVER['REQUEST_URI'] == $item['href']) {
                    $active_flag = true;
                }

            }

            foreach ($this->items as $key => $item) {

                if (!isset($item['visible']) || $item['visible']) {

                    if (($active_flag == false && $key == 0) || \Yii::$app->urlManager->baseUrl . $_SERVER['REQUEST_URI'] == $item['href']) {
                        $item['active'] = true;
                    }

                    $nodes[] = $this->render('tabWidget', ['item' => $item, 'linkPostfix' => $this->linkPostfix]);
                }
            }
        }
        return Html::tag('ul', implode("\n", $nodes), ['class' => 'nav nav-tabs nav-tabs-banner']);
    }
}
