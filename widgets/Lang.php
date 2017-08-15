<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 01.07.17
 * Time: 13:45
 */

namespace dench\language\widgets;

use Yii;
use dench\language\models\Language;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class Lang extends Widget
{
    public $short = false;

    public $current;

    public $langs = [];

    public $tag = "ul";

    public $options = [
        'class' => 'navbar-nav',
    ];

    public $itemTag = "li";

    public $itemOptions = [
        'class' => 'nav-item',
    ];

    public $linkOptions = [
        'class' => 'nav-link',
    ];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (empty($this->current)) {
            $this->current = Language::getCurrent();
        }

        if (empty($this->langs)) {
            $this->langs = Language::nameList();
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

        return ($this->tag) ? Html::tag($this->tag, implode("\n", $items), $this->options) : implode("\n", $items);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($name, $key)
    {
        $itemOptions = $this->itemOptions;
        $linkOptions = $this->linkOptions;

        $url = Url::current(['lang' => $key]);

        if (Yii::$app->language == $key) {
            if ($this->itemTag) {
                Html::addCssClass($itemOptions, 'active');
            } else {
                Html::addCssClass($linkOptions, 'active');
            }
        }

        if ($this->short) {
            $name = mb_substr($name, 0, 3, 'UTF-8');
        }

        $link = Html::a($name, $url, $linkOptions);

        return ($this->itemTag) ? Html::tag($this->itemTag, $link, $itemOptions) : $link;
    }
}