<?php

namespace strider2038\ajaxdebugger;

use yii\web\AssetBundle;

/**
 * Asset for JSONBeautifyIt tool
 *
 * @see https://github.com/strider2038/json-beautify-it
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class JsonBeautifyItAsset extends AssetBundle {
    public $sourcePath = '@bower/json-beautify-it/dist';
    public $js = [
        'json-beautify-it.min.js'
    ];
}
