<?php
$this->breadcrumbs=array(
	'Inquiries',
);

$this->menu=array(
array('label'=>'Create Inquiry','url'=>array('create')),
array('label'=>'Manage Inquiry','url'=>array('admin')),
);
?>

<h1>Inquiries</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
