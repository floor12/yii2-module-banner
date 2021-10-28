<?php

namespace floor12\banner\models;

use floor12\banner\Module;
use floor12\files\components\FileBehaviour;
use floor12\files\models\File;
use floor12\files\models\FileType;
use voskobovich\linker\LinkerBehavior;
use Yii;
use yii\base\ErrorException;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use ZipArchive;

/**
 * This is the model class for table "ads_banner".
 *
 * @property int $id
 * @property int $status Выключить
 * @property string $title Название баннера
 * @property string $show_start Начало показа
 * @property string $show_end Окончание показа
 * @property string $href Ссылка
 * @property int $views Показы
 * @property int $clicks Клики
 * @property int $archive Архивный
 * @property array $place_ids Массив айдишников связанных площадок
 * @property AdsPlace[] $places Связанные площадки
 * @property File $file_desktop Файл баннера для декстоп версии
 * @property File $file_mobile Файл баннера для мобильной версии
 * @property integer $weight Вес баннера
 * @property integer $type Тип баннера
 * @property string $webrootPath Полный путь к рич-баннеры
 * @property string $webPath Относительный путь к рич-баннеры
 * @property string $onclick Событие по клику на баннер
 *
 */
class AdsBanner extends ActiveRecord
{

    const STATUS_ACTIVE = 0;
    const STATUS_DISABLED = 1;

    const TYPE_IMAGE = 0;
    const TYPE_RICH = 1;

    /**
     * {@inheritdoc}
     * @return AdsBannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdsBannerQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status', 'views', 'clicks', 'weight', 'archive'], 'integer'],
            [['title'], 'required'],
            [['show_start', 'show_end'], 'safe'],
            [['title', 'onclick'], 'string', 'max' => 255],
            [['href'], 'string', 'max' => 2048],
            ['file_desktop', 'file', 'checkExtensionByMimeType' => false, 'extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'zip', 'svg'], 'maxFiles' => 1],
            ['file_mobile', 'file', 'checkExtensionByMimeType' => false, 'extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'zip', 'svg'], 'maxFiles' => 1],
            ['file_desktop', 'required'],
            [['place_ids'], 'each', 'rule' => ['integer']],
            ['href', 'url', 'defaultScheme' => 'https'],
            ['weight', 'default', 'value' => '0'],
        ];
    }

    /** Связь баннера с площадками
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPlaces(): ActiveQuery
    {
        return $this
            ->hasMany(AdsPlace::class, ['id' => 'place_id'])
            ->viaTable('ads_place_banner', ['banner_id' => 'id'])
            ->inverseOf('banners');
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
            'onclick' => 'JS Code',
            'views' => 'Показы',
            'clicks' => 'Клики',
            'file_desktop' => 'Изображение (декстоп)',
            'file_mobile' => 'Изображение (мобильный)',
            'place_ids' => 'Связанные площадки',
            'weight' => 'Вес баннера',
            'type' => 'Тип баннера',
            'archive' => 'Архивный'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'files' => [
                'class' => FileBehaviour::class,
                'attributes' => ['file_desktop', 'file_mobile']
            ],
            'ManyToManyBehavior' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'place_ids' => 'places',
                ],
            ],
        ];
    }

    /** Этот метод мы добавляем исключительно чтобы иметь возможность делать жадную загрузку изображений
     * @return ActiveQuery
     */
    public function getFile_desktop()
    {
        return $this->hasOne(File::class, ['object_id' => 'id'])
            ->andWhere(['class' => self::class, 'field' => 'file_desktop'])
            ->orderBy('ordering');
    }

    /** Этот метод мы добавляем исключительно чтобы иметь возможность делать жадную загрузку изображений
     * @return ActiveQuery
     */
    public function getFile_mobile()
    {
        return $this->hasOne(File::class, ['object_id' => 'id'])
            ->andWhere(['class' => self::class, 'field' => 'file_mobile'])
            ->orderBy('ordering');
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

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, [Module::CACHE_TAG_BANNERS]);
        parent::afterSave($insert, $changedAttributes);
    }

    /** Увеличиваем счетчик просмотров
     *  Ради 2х строчек кода не буду выносить этот функционал в отдельный класс, хотя может в будущем.
     * @return bool
     */
    public function increaseViews(): bool
    {
        $sql = "UPDATE {$this::tableName()} SET views=views+1 WHERE id=$this->id;";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ads_banner';
    }

    /** Увеличиваем счетчик кликов
     * @return bool
     */
    public function increaseClicks(): bool
    {
        $sql = "UPDATE {$this::tableName()} SET clicks=clicks+1 WHERE id=$this->id;";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }

    /** Определение типа баннера
     * @return int
     */
    public function getType()
    {

        if ($this->file_desktop && $this->file_desktop->type != FileType::IMAGE)
            return self::TYPE_RICH;

        return self::TYPE_IMAGE;
    }

    /**
     * @return bool|string|void
     * @throws ErrorException
     * @throws ErrorException
     */
    public function getWebPath()
    {
        if ($this->type == self::TYPE_IMAGE)
            return;
        else {
            $this->publish();
            return Yii::getAlias(Yii::$app->getModule('banner')->bannersWebPath . '/' . $this->file_desktop->hash . '/');
        }
    }

    /**
     * @throws ErrorException
     */
    protected function publish()
    {
        if (!file_exists($this->webrootPath)) {
            $zip = new ZipArchive;
            if ($zip->open($this->file_desktop->rootPath) === TRUE) {
                mkdir($this->webrootPath);
                $zip->extractTo($this->webrootPath);
                $zip->close();
            } else {
                throw new ErrorException('Rich banner zip extracting error.');
            }
        }
    }

    /**
     * @return bool|string|void
     */
    public function getWebrootPath()
    {
        if ($this->type == self::TYPE_IMAGE)
            return;
        else {
            return Yii::getAlias(Yii::$app->getModule('banner')->bannersWebRootPath . '/' . $this->file_desktop->hash . '/');
        }
    }
}
