<?php

//常用方法
class Common{

    /**
     * 读取应用参数
     * @static
     * @access public
     * @param string $name 参数名称
     * @param mixed $default 空值时返回的默认值
     * @return mixed 返回任意类型
     */
    public static function yiiparam($name, $default = null) {
        if (isset(Yii::app()->params[$name])) {
            return Yii::app()->params[$name];
        } else {
            return $default;
        }
    }

   /**
     * 渲染ueditor编辑器
     * @static
     * @access public
     * @param string $id textarea唯一id
     * @param string $style 编辑器样式
     * @return array $options 编辑器个性化定制参数
     * @example
     */
    public static  function ueditor($id='content',$style='base',$options=array()){
        $default=self::yiiparam('ueditor');
        //获取工具栏样式
        $default['toolbars']=isset($default['toolbars_'.$style])?$default['toolbars_'.$style]:null;
        $options=array_merge($default,$options); 
        $controller=new CController(null);
        return $controller->renderPartial('application.views.global.ueditor',array('id'=>$id,'options'=>$options));
    }
    
}