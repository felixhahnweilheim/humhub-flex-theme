<?php

namespace humhub\modules\flexTheme\widgets;

use humhub\modules\file\widgets\FileHandlerButtonDropdown;
use humhub\libs\Html;
use yii\helpers\ArrayHelper;
use Yii;

/*
 * Show Icon Buttons instead of Dropdown
 */

class FileHandlerButtons extends FileHandlerButtonDropdown
{
    public $known_labels = [];
    
    public function init()
    {
        $this->known_labels = [
            Yii::t('FileModule.base', 'Attach an image'),
            Yii::t('FileModule.base', 'Attach a video '),
            Yii::t('FileModule.base', 'Attach an audio message'),
            Yii::t('FileModule.base', 'Attach a video')
        ];
    }
    public function run()
    {
        if (!$this->primaryButton && count($this->handlers) === 0) {
            return;
        }

        if ($this->cssButtonClass === 'btn-defaul') {
            $output = Html::beginTag('div', ['class' => $this->cssClass, 'style' => 'margin-right: 120px']);
        } else {
            $output = Html::beginTag('div', ['class' => $this->cssClass]);
        }

        if (!$this->primaryButton) {
            $firstButton = array_shift($this->handlers)->getLinkAttributes();
            Html::addCssClass($firstButton, ['btn', $this->cssButtonClass]);
            $output .= $this->renderLink($firstButton);
        } else {
            $output .= $this->primaryButton;
        }

        if (count($this->handlers) !== 0) {
            //$output .= '<button type="button" class="btn ' . $this->cssButtonClass . ' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';

            //$cssClass = ($this->pullRight) ? 'dropdown-menu dropdown-menu-right' : 'dropdown-menu';

            //$output .= Html::beginTag('ul', ['class' => $cssClass]);
            foreach ($this->handlers as $handler) {
                //$output .= Html::beginTag('li');
                $output .= $this->renderLink($handler->getLinkAttributes());
                //$output .= Html::endTag('li');
            }
            //$output .= Html::endTag('ul');
        }
        $output .= Html::endTag('div');

        return $output;
    }

    /**
     * Renders the file handle link
     *
     * @param array $options the HTML options
     * @return string the rendered HTML tag
     */
    protected function renderLink($options)
    {
        $options['data-action-process'] = 'file-handler';
        $options['data-placement'] = 'bottom';
        $options['class'] = 'btn '.$this->cssButtonClass.' fileinput-button';
        $options['style'] = ['margin-left' => '0'];
        
        $label = ArrayHelper::remove($options, 'label', 'Label');
        
        // Move text from known labels into tooltip
        foreach ($this->known_labels as $search)
        {
            if (strpos($label, $search) !== false) {
                $label = trim(str_replace($search, '', $label));
                $options['class'] .= ' tt btn-icon-only';
                $options['title'] = $search;
            }
        }
        // Shorten "Create draw.io document"
        if (stripos($label, 'draw.io') !== false) {
            $options['title'] = $label;
            $label = 'draw.io';
            $options['class'] .= ' tt btn-icon-only';
        }

        if (isset($options['url'])) {
            $url = ArrayHelper::remove($options, 'url', '#');
            $options['href'] = $url;
        }

        return Html::tag('span', $label, $options);
    }
}
