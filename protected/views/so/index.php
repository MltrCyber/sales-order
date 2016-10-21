<?php
$this->breadcrumbs=array(
	'Sos',
);

$this->menu=array(
array('label'=>'Create So','url'=>array('create')),
array('label'=>'Manage So','url'=>array('admin')),
);
?>

<h1>Sos</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
