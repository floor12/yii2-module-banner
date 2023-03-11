<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 12:13
 */

namespace floor12\banner\widgets;

use floor12\banner\models\AdsPopupPlace;
use Yii;
use yii\base\Widget;
use yii\web\Cookie;

class PopupWidget extends Widget
{
    public $place_id;

    const COOKIE_NAME = 'popup-banner-showed-';

    private $_banner;
    private $_place;

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    public function init(): bool
    {
        // Некоторые браузеры любят посылать HEAD запросы, что ошибочно увеличивает счетчик просмотров
        if (Yii::$app->request->method == 'HEAD')
            return false;

        $this->_place = AdsPopupPlace::findOne($this->place_id);

        // Если не найдена площадка - ничего не делаем
        if (!$this->_place)
            return false;

        // Если не найдены активные баннеры -  тоже ничего не делаем
        if (!$this->_place->popupsActive)
            return false;

        $cookie = Yii::$app->request->cookies->get($this->getCookieName());

        if (!$cookie)
            $this->_banner = $this->_place->getPopupsActive()->one();

        return true;
    }

    /** Рендерим вьюху
     * @return string
     */
    public function run(): string
    {
        if (!$this->_banner)
            return "";
        else {
            $this->_banner->increaseViews();
            Yii::$app->response->cookies->add(new Cookie([
                'name' => $this->getCookieName(),
                'value' => 'true',
                'expire' => time() + $this->_banner->repeat_period
            ]));
            return $this->render('popupWidget', ['model' => $this->_banner]);
        }

    }

    public function getCookieName()
    {
        return self::COOKIE_NAME . $this->place_id;
    }

}
