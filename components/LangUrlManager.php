<?php
namespace dench\language\components;

use Yii;
use yii\web\UrlManager;

class LangUrlManager extends UrlManager
{
    public $defaultLanguage = 'en';

    public function createUrl($params)
    {
        if (empty($params['lang']) && $this->defaultLanguage != Yii::$app->language) {
            $params['lang'] = Yii::$app->language;
        }

        if ($this->defaultLanguage == @$params['lang']) {
            unset($params['lang']);
        }

        return parent::createUrl($params);
    }
}