<?php
$this->breadcrumbs = array(
    'Deliveries' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Delivery', 'url' => array('index')),
    array('label' => 'Create Delivery', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('delivery-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php
echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-success', 'style' => 'margin-right:10px;'));
//echo CHtml::link('Tambah Data', Yii::app()->createUrl('create'), array('class' => 'btn btn-primary'));
?>
<div class="search-form" style="display:none; margin-top:20px;">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'delivery-grid',
    'dataProvider' => $model->search(),
//    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'ID Delivery Order',
            'value' => '$data->kode',
        ),
        array(
            'header' => 'ID Invoice',
            'value' => '$data->idInv',
        ),
        array(
            'header' => 'ID PO',
            'value' => '$data->idPo',
        ),
        array(
            'header' => 'ID Marketing',
            'value' => '$data->idMarketing',
        ),
        array(
            'header' => 'Total Bayar',
            'value' => 'Yii::app()->tindik->rupiah($data->totalBayar)',
        ),
        array(
            'header' => 'Tanggal Order',
            'value' => '$data->tglOrder',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
            'htmlOptions' => array(
                'width' => '200',
                'style' => 'text-align:center'
            ),
            'buttons' => array(
                'view',
                'update' => array(
                    'label' => 'Update ',
                    'visible' => 'false',
                ),
                'delete' => array(
                    'label' => 'Delete ',
                    'visible' => 'false',
                ),
            ),
        ),
    ),
));
?>
