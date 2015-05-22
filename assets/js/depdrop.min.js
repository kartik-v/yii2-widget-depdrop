/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @subpackage yii2-widget-depdrop
 * @version 1.0.1
 *
 * Extensions to dependent dropdown for Yii:
 * - Initializes dependent dropdown for Select2 widget
 * 
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */var initDepdropS2=function(e,n){!function(o){"use strict";var a=o("#"+e),t=o("#select2-"+e+"-container"),i="...";a.on("depdrop.beforeChange",function(){a.find("option").attr("value",i).html(n),a.select2("val",i),t.removeClass("kv-loading").addClass("kv-loading")}).on("depdrop.change",function(){a.select2("val",a.val()),t.removeClass("kv-loading")})}(window.jQuery)};