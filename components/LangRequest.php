<?php
namespace dench\language\components;

use dench\language\models\Language;
use yii\web\Request;

class LangRequest extends Request
{
    public function resolve()
    {
        $lang_id = @$this->get()['lang'];

        Language::setCurrent($lang_id);

        return parent::resolve();
    }
}