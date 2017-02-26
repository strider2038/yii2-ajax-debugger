<?php

namespace strider2038\ajaxdebugger;

use yii\web\Controller;
use yii\web\Response;
use yii\base\Component;

/**
 * This component is used to intercept JSON or JSONP responses from server
 * and format them as html document. After rendering JSON data JSONBeautifyIt
 * function is applied for beautifying rendered data array. Be aware of using
 * this component in production mode.
 * 
 * To set up this component for work you should add this lines to your web
 * config file
 * 
 * ```php
 * $config = [
 *      // this is needed to initialize component on app load
 *      'bootstrap' => ['ajaxDebugger', ...], 
 *      'components' => [
 *          'ajaxDebugger' => [
 *              'class' => 'strider2038\ajaxdebugger\DebugDetector',
 *              // conditions for enabling debug mode
 *              'enabled' => YII_ENV_DEV && !empty($_GET['_debug']),
 *          ],
 *          ...
 *      ],
 *      ...
 * ];
 * ```
 * 
 * After that you can open pages with AJAX or API responses in browser. If you
 * add GET parameter _debug=1 you will see parsed JSON data and debug panel as
 * on other html pages.
 *
 * @author Igor Lazarev <strider2038@rambler.ru>
 */
class DebugDetector extends Component {
    
    /**
     * Global flag for enabling debug mode. You may use a callable function
     * to determine when you want to enable debug mode.
     * 
     * @var boolean|callable
     */
    public $enabled = false;
    
    /**
     * Initializing interception of response to load debug mode
     * @return mixed
     */
    public function init() {
        $enabled = is_callable($this->enabled) ? $this->enabled() : $this->enabled;
        if (!$enabled) {
            return;
        }
        
        \Yii::$app->on(Controller::EVENT_AFTER_ACTION, function($event) {
            $controller = \Yii::$app->controller;
            $response = \Yii::$app->response;
            $content = ''; 
            if ($response->format === Response::FORMAT_JSON) {
                $content = json_encode($event->result);
            } elseif ($response->format === Response::FORMAT_JSONP 
                    && !empty($event->result['callback'])
                    && !empty($event->result['data'])) {
                $content = $event->result['callback'] . '(' . json_encode($event->result['data']) . ')';
            } else {
                return $event->result;
            }
            $response->format = Response::FORMAT_HTML;
            $controller->layout = '@vendor/strider2038/yii2-ajax-debugger/views/layout';
            $event->result = $controller->render(
                '@vendor/strider2038/yii2-ajax-debugger/views/json', 
                compact('content')
            );
        });
    }
    
}
