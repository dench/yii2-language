<?php
namespace dench\language\behaviors;

use dench\language\models\Language;
use omgdef\multilingual\MultilingualBehavior;
use yii\helpers\ArrayHelper;

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

        $ownerTableName = $owner->tableName();

        if (!$this->langForeignKey) {
            $this->langForeignKey = $ownerTableName . '_id';
        }

        if (!$this->tableName) {
            $this->tableName = $ownerTableName . '_lang';
        }

        if (!$this->attributes) {

            $rules = ArrayHelper::getColumn($owner->rules(), 0);
            
            $attributes = [];

            foreach ($rules as $rule) {
                if (is_array($rule)) {
                    foreach ($rule as $r) {
                        if (!strpos($r, '_ids') && !strpos($r, '_from') && !strpos($r, '_to')) {
                            $attributes[$r] = $r;
                        }
                    }
                } else {
                    if (!strpos($rule, '_ids') && !strpos($rule, '_from') && !strpos($rule, '_to')) {
                        $attributes[$rule] = $rule;
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