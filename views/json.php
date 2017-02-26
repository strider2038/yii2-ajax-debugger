<?php
/** $this yii\web\View */
use yii\helpers\Html;
\strider2038\ajaxdebugger\JsonBeautifyItAsset::register($this);
$this->registerJs("JSONBeautifyIt('#json', {encodeStrings: false})");
?>
<pre id="json"><?= Html::encode($content) ?></pre>