<?php
$this->breadcrumbs=array(
	'Barangs',
);

$this->menu=array(
array('label'=>'Create Barang','url'=>array('create')),
array('label'=>'Manage Barang','url'=>array('admin')),
);
?>

<h1>Barangs</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
