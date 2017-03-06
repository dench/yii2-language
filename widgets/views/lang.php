<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.11.16
 * Time: 11:54
 */

/** @var $current \dench\language\widgets\Lang */

use dench\language\models\Language;
use yii\helpers\Html;
use yii\helpers\Url;

echo '<div class="lang-change">';
foreach (Language::nameList() as $key => $value) {
    echo Html::a($value, Url::to(['', 'lang' => $key]), (Yii::$app->language == $key ? ['class' => 'active']: false));
}
echo '</div>';

?>