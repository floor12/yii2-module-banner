<?php

namespace floor12\banner\models;


use floor12\banner\Module;
use Yii;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ads_place".
 *
 * @property int $id
 * @property string $title Название площадки
 * @property int $desktop_width Ширина (дексктоп)
 * @property int $desktop_height Высота (дексктоп)
 * @property int $mobile_width Ширина (мобильный)
 * @property int $mobile_height Высота (мобильный)
 * @property int $status Выключить
 * @property int $slider Активировать слайдер
 * @property int $slider_direction Направление слайдера
 * @property int $slider_time Длительность слайда
 * @property int $slider_arrows Показывать стрелки слайдера
 * @property string $arrows Возвращает строковое true или false для вставки в JS
 * @property string $vertical Возвращает строковое true или false для вставки в JS
 * @property boolean $desktop_width_max Растягивать по ширине
 * @property boolean $mobile_width_max Растягивать по ширине
 * @property AdsBanner[] $banners Связанные баннеры
 * @property AdsBanner[] $bannersActive Активные баннеры
 *
 */
class AdsPlace extends ActiveRecord
{

    const STATUS_ACTIVE = 0;
    const STATUS_DISABLED = 1;

    const SLIDER_DISABLED = 0;
    const SLIDER_ENABLED = 1;

    const SLIDER_ARROWS_SHOW = 1;
    const SLIDER_ARROWS_HIDE = 0;

    const SLIDER_VERTICAL = 1;
    const SLIDER_HORIZONTAL = 0;

    public $directions = [
        self::SLIDER_HORIZONTAL => 'Горизонтальный',
        self::SLIDER_VERTICAL => 'Вертикальный',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ads_place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'desktop_width', 'desktop_height'], 'required'],
            [['desktop_width_max', 'mobile_width_max'], 'boolean'],
            [['desktop_width', 'desktop_height', 'mobile_width', 'mobile_height', 'status', 'slider', 'slider_direction', 'slider_arrows', 'slider_time'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['slider_time', 'default', 'value' => '3000'],


        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, [Module::CACHE_TAG_BANNERS]);
        parent::afterSave($insert, $changedAttributes);

    }

    /** Связь площадки с баннерами
     * @return AdsBannerQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getBanners(): AdsBannerQuery
    {
        return $this
            ->hasMany(AdsBanner::class, ['place_id' => 'id'])
            ->viaTable('ads_place_banner', ['banner_id' => 'id'])
            ->inverseOf('places');
    }

    /** Активные баннеры.
     *  Проверяем, активен ли баннер, есть если у него выставлены даты - сравниваем с текущей датой
     * @return AdsBannerQuery
     * @throws \yii\base\InvalidConfigException
     */

    public function getBannersActive(): AdsBannerQuery
    {
        return $this->getBanners()->with('file_desktop', 'file_mobile')->orderBy('weight DESC, id')->active();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название площадки',
            'desktop_width' => 'Ширина (дексктоп)',
            'desktop_height' => 'Высота (дексктоп)',
            'mobile_width' => 'Ширина (мобильный)',
            'mobile_height' => 'Высота (мобильный)',
            'status' => 'Выключить',
            'slider' => 'Активировать слайдер',
            'slider_direction' => 'Направление слайдера',
            'slider_arrows' => 'Показывать стрелки',
            'slider_time' => 'Длительность слайда (мс)',
            'desktop_width_max' => 'Растягивать по ширине',
            'mobile_width_max' => 'Растягивать по ширине'
        ];
    }

    /** Если не задана ширина мобильного баннера, копируем туда значения десктопного варианта.
     * @return bool
     */
    public function beforeValidate(): bool
    {
        if (!$this->mobile_width)
            $this->mobile_width = $this->desktop_width;

        if (!$this->mobile_height)
            $this->mobile_height = $this->desktop_height;

        return parent::beforeValidate();
    }

    /** Удобно использовать возможность привести объект к строке
     * @return string
     */
    public function __toString(): string
    {
        return $this->title;
    }

    /** Возвращаем строковое значение для вставки в JS
     * @return string
     */
    public function getVertical(): string
    {
        if ($this->slider_direction == self::SLIDER_VERTICAL)
            return "true";
        return "false";
    }

    /** Возвращаем строковое значение для вставки в JS
     * @return string
     */
    public function getArrows(): string
    {
        if ($this->slider_arrows == self::SLIDER_ARROWS_SHOW)
            return "true";
        return "false";
    }

}
