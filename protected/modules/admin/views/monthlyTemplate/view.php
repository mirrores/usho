<?php
/* @var $this SendmailController */
/* @var $model MonthlyTemplate */

$this->breadcrumbs=array(
	'Monthly Templates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MonthlyTemplate', 'url'=>array('index')),
	array('label'=>'Create MonthlyTemplate', 'url'=>array('create')),
	array('label'=>'Update MonthlyTemplate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MonthlyTemplate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MonthlyTemplate', 'url'=>array('admin')),
);
?>

<h1>View MonthlyTemplate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'monthly_id',
		'content',
		'sended_num',
		'is_sended',
	),
)); ?>
