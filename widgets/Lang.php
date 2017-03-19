<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.11.16
 * Time: 11:40
 */

namespace dench\language\widgets;

use Yii;
use dench\language\models\Language;
use yii\bootstrap\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;

class Lang extends Widget
{
    public $short = false;

    public $current;

    public $langs = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (!isset($this->current)) {
            $this->current = Language::getCurrent();
            //throw new InvalidConfigException("The 'current' option is required.");
        }

        if (!isset($this->langs)) {
            $this->langs = Language::nameList();
            //throw new InvalidConfigException("The 'langs' option is required.");
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return $this->renderItems();
    }

    /**
     * Renders widget items.
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->langs as $key => $name) {
            $items[] = $this->renderItem($name, $key);
        }

        Html::addCssClass($this->options, 'navbar-nav');

        return Html::tag('ul', implode("\n", $items), $this->options);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($name, $key)
    {
        $options = [];
        $linkOptions = [];
        $url = Url::current(['lang' => $key]);

        if (Yii::$app->language == $key) {
            Html::addCssClass($options, 'active');
        }

        if ($this->short) {
            $name = mb_substr($name, 0, 3, 'UTF-8');
        }

        Html::addCssClass($options, 'nav-item');
        Html::addCssClass($linkOptions, 'nav-link');

        return Html::tag('li', Html::a($name, $url, $linkOptions), $options);
    }
}