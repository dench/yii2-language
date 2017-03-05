<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.11.16
 * Time: 11:40
 */

namespace dench\language\widgets;

use dench\language\models\Language;
use yii\base\Widget;

class Lang extends Widget
{
    public function run()
    {
        return $this->render('lang', [
            'current' => Language::getCurrent(),
            'langs' => Language::nameList(),
        ]);
    }
}