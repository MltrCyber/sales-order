<?php
$this->breadcrumbs = array(
    'Pos' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Po', 'url' => array('index')),
    array('label' => 'Create Po', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('po-grid', {
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
    'id' => 'po-grid',
    'dataProvider' => $model->searchReject(),
//    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'ID Purchase',
            'value' => '$data->kode'
        ),
        array(
            'header' => 'ID Quotation',
            'value' => '$data->idQuot'
        ),
        array(
            'header' => 'ID Customer',
            'value' => '$data->idCust'
        ),
        array(
            'header' => 'ID Marketing',
            'value' => '$data->idMarketing'
        ),
        array(
            'header' => 'Tanggal Order',
            'value' => '$data->tglOrder'
        ),
        array(
            'header' => 'Total Bayar',
            'value' => 'Yii::app()->tindik->rupiah($data->Quotation->So->totalBayar)'
        ),
        /*
          'status',
         */
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
