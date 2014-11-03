<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle= ' 访问错误 _  '.Yii::app()->name;
?>
<div class="error" style="text-align: center;height: 250px;padding-top: 70px">
    <h1 style="font-size: 16px;font-weight: bold">访问出错 <?php echo $code; ?></h1>
<?php echo CHtml::encode($message); ?>
</div>