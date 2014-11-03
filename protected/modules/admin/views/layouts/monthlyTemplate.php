<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<script type="text/javascript" src="<?= Yii::app()->baseUrl ?>/static/js/jQuery-1.9.1.js"></script>

<div style="padding: 10px">
    <?=CHtml::htmlButton('返回', array('class' => 'btn', 'onclick' => 'history.back()')); ?>
</div>

<div style="margin:20px auto;width:1000px;background: #fff;padding: 20px;border: 2px dotted #eee">
    <?php echo $content; ?>
</div>
