<?php
$this->breadcrumbs=array(
	'Quotations',
);

$this->menu=array(
array('label'=>'Create Quotation','url'=>array('create')),
array('label'=>'Manage Quotation','url'=>array('admin')),
);
?>

<h1>Quotations</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
