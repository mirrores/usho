<?php

/*产品介绍模型
 * 作者：徐斌
 * 时间：14/2/28 上午
 */
class Product extends CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'product';
    }
    public function attributeLabels() {
        return array(
            'pro_name'=>'产品名称：',
            'pro_image'=>'产品图片',
            'pro_content'=>'产品介绍：',
        );
        
    }
  
    public function rules() {
        return array(
            array('pro_name,pro_content','required'),
             );
    }
}
