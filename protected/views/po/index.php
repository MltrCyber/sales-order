<?php
$this->breadcrumbs=array(
	'Pos',
);

$this->menu=array(
array('label'=>'Create Po','url'=>array('create')),
array('label'=>'Manage Po','url'=>array('admin')),
);
?>

<h1>Pos</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
