# Yii2 Ajax debugger

This tool is based on [JSONBeautifyIt](https://github.com/strider2038/json-beautify-it) 
function for formatting JSON/JSONP data. DebugDetector component can intercept JSON or 
JSONP responses from server and format them as html document. After rendering JSON 
data JSONBeautifyIt function is applied for beautifying rendered data array. Be aware 
of using this component in production mode.

To set up this component for work you should add this lines to your web
config file
 
```php
$config = [
     // this is needed to initialize component on app load
     'bootstrap' => ['ajaxDebugger', ...], 
     'components' => [
         'ajaxDebugger' => [
             'class' => 'strider2038\ajaxdebugger\DebugDetector',
             // conditions for enabling debug mode
             'enabled' => YII_ENV_DEV && !empty($_GET['_debug']),
         ],
         ...
     ],
     ...
];
```
 
After that you can open pages with AJAX or API responses in browser. If you
add GET parameter \_debug=1 you will see parsed JSON data and debug panel as
on other html pages.

You can see working examples in my Yii2 template - <https://github.com/strider2038/yii2-template/blob/master/controllers/AjaxController.php>