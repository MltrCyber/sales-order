<?php
$this->breadcrumbs = array(
    'Sos' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List So', 'url' => array('index')),
    array('label' => 'Create So', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('so-grid', {
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
    'id' => 'so-grid',
    'dataProvider' => $model->search(),
//    'filter' => $model,
    'columns' => array(
//        'id',
        'kode',
        array(
            'header' => 'ID Quotation',
            'value' => '$data->idQuot',
        ),
        array(
            'header' => 'ID Customer',
            'value' => '$data->idCust',
        ),
        array(
            'header' => 'Tanggal Order',
            'value' => 'Yii::app()->tindik->tgldd($data->tanggal)',
        ),
        array(
            'header' => 'Total Bayar',
            'value' => 'Yii::app()->tindik->rupiah($data->totalBayar)',
        ),
        array(
            'header' => 'ID Marketing',
            'value' => '$data->idMarketing',
        ),
        /*
          'status',
         */
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{status}&nbsp;&nbsp;{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
            'htmlOptions' => array(
                'width' => '200',
                'style' => 'text-align:center'
            ),
            'buttons' => array(
                'status' => array(
                    'label' => 'Ubah Status',
                    'url' => 'Yii::app()->createUrl("po/create?id=$data->id")',
                    'icon' => 'fa fa-check',
                    'visible' => '$_SESSION["level"] == "admin"',
                ),
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
