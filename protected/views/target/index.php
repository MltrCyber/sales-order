<?php
$this->breadcrumbs=array(
	'Targets',
);

$this->menu=array(
array('label'=>'Create Target','url'=>array('create')),
array('label'=>'Manage Target','url'=>array('admin')),
);
?>

<h1>Targets</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
