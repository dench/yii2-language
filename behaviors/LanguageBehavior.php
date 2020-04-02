<?php

namespace dench\language\behaviors;

use app\models\Language;
use omgdef\multilingual\MultilingualBehavior;
use Yii;
use yii\base\InvalidConfigException;

class LanguageBehavior extends MultilingualBehavior
{
    public $attributes;

    public $languages;

    public $langForeignKey;

    public $tableName;

    public $languageField = 'lang_id';

    public $requireTranslations = true;

    /**
     * @param \yii\db\ActiveRecord $owner
     * @throws \yii\base\InvalidConfigException
     */
    public function attach($owner)
    {
        $this->languages = Language::nameList();

        if (empty($this->languages[Yii::$app->language])) {
            throw new InvalidConfigException('Please specify the correct language in the config.');
        }

        if (!$this->langForeignKey) {
            $this->langForeignKey = str_replace('*' . Yii::$app->db->tablePrefix, '', '*' . $owner->tableName()) . '_id';
        }

        if (!$this->tableName) {
            $this->tableName = $owner->tableName() . '_lang';
        }

        if (!$this->attributes) {

            $rules = $owner->rules();

            $attributes = [];

            foreach ($rules as $rule) {
                if (isset($rule[1]) && in_array($rule[1], ['string', 'safe'])) {
                    foreach ($rule[0] as $r) {
                        $attributes[$r] = $r;
                    }
                }
            }

            foreach ($owner->attributes as $k => $v) {
                if (isset($attributes[$k])) {
                    unset($attributes[$k]);
                }
            }

            $this->attributes = array_values($attributes);
        }

        parent::attach($owner);
    }
}