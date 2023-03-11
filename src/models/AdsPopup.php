<?php

namespace floor12\banner\models;

use floor12\files\components\FileBehaviour;
use floor12\files\models\File;
use voskobovich\linker\LinkerBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ads_popup".
 *
 * @property int $id
 * @property int $status Выключить
 * @property string $title Название баннера
 * @property string $show_start Начало показа
 * @property string $show_end Окончание показа
 * @property string $href Ссылка
 * @property int $archive Архивный
 * @property string $repeat_period Период повторного показа
 * @property int $views Показы
 * @property int $clicks Клики
 * @property array $place_ids Массив айдишников связанных площадок
 * @property File $file_desktop
 *
 */
class AdsPopup extends ActiveRecord
{

    const STATUS_ACTIVE = 0;
    const STATUS_DISABLED = 1;

    public $periods = [
        60 * 60 * 24 * 1 => "1 день",
        60 * 60 * 24 * 2 => "2 дня",
        60 * 60 * 24 * 2 => "3 дня",
        60 * 60 * 24 * 4 => "4 дня",
        60 * 60 * 24 * 5 => "5 дней",
        60 * 60 * 24 * 10 => "10 дней",
        60 * 60 * 24 * 15 => "15 дней",
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ads_popup';
    }

    /**
     * {@inheritdoc}
     * @return AdsPopupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdsPopupQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status', 'views', 'clicks', 'repeat_period', 'archive'], 'integer'],
            [['title'], 'required'],
            [['show_start', 'show_end'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['href'], 'string', 'max' => 2048],
            ['file_desktop', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'zip', 'svg'], 'maxFiles' => 1],
            ['file_desktop', 'required'],
            ['href', 'url', 'defaultScheme' => 'https'],
            [['place_ids'], 'each', 'rule' => ['integer']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'status' => 'Выключить',
            'title' => 'Название баннера',
            'show_start' => 'Начало показа',
            'show_end' => 'Окончание показа',
            'href' => 'Ссылка',
            'views' => 'Показы',
            'clicks' => 'Клики',
            'file_desktop' => 'Изображение',
            'repeat_period' => 'Период повторного показа',
            'place_ids' => 'Связанные площадки',
            'archive' => 'Архивный'
        ];
    }

    /** Связь баннера с площадками
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    public function getPlaces(): ActiveQuery
    {
        return $this
            ->hasMany(AdsPopupPlace::class, ['id' => 'place_id'])
            ->viaTable('ads_popup_place_popup', ['popup_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'files' => [
                'class' => FileBehaviour::class,
                'attributes' => ['file_desktop']
            ],
            'ManyToManyBehavior' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'place_ids' => 'places',
                ],
            ],
        ];
    }

    /** Удобно использовать возможность привести объект к строке
     * @return string
     */
    public function __toString(): string
    {
        return $this->title;
    }

    /** Приводим дату к формату MySQL
     * @return bool
     */
    public function beforeValidate(): bool
    {
        if ($this->show_start)
            $this->show_start = date("Y-m-d", strtotime($this->show_start));

        if ($this->show_end)
            $this->show_end = date("Y-m-d", strtotime($this->show_end));

        return parent::beforeValidate();
    }

    /** После поиска из базы приводим дату к человеческому формату
     */
    public function afterFind()
    {
        if ($this->show_start)
            $this->show_start = date("d.m.Y", strtotime($this->show_start));

        if ($this->show_end)
            $this->show_end = date("d.m.Y", strtotime($this->show_end));

        parent::afterFind();
    }

    /** Увеличиваем счетчик просмотров
     *  Ради 2х строчек кода не буду выносить этот функционал в отдельный класс, хотя может в будущем.
     * @return bool
     */
    public function increaseViews(): bool
    {
        $this->views++;
        return $this->save(false, ['views']);
    }

    /** Увеличиваем счетчик кликов
     * @return bool
     */
    public function increaseClicks(): bool
    {
        $this->clicks++;
        return $this->save(false, ['clicks']);
    }


}
