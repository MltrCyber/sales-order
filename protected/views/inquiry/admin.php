<?php
$this->breadcrumbs = array(
    'Inquiries' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Inquiry', 'url' => array('index')),
    array('label' => 'Create Inquiry', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('inquiry-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php
echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-success', 'style' => 'margin-right:10px;'));
if ($_SESSION['level'] == "marketing")
    echo CHtml::link('Tambah Data', Yii::app()->createUrl('inquiry/create'), array('class' => 'btn btn-primary'));
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
    'id' => 'inquiry-grid',
    'dataProvider' => $model->search(),
//    'filter' => $model,
    'columns' => array(
//        'id',
        'kode',
        array(
            'name' => 'id_customer',
            'header' => 'ID Customer',
            'value' => '$data->idCust',
        ),
        array(
            'name' => 'id_customer',
            'header' => 'Nama PT',
            'value' => '$data->namaCust',
        ),
//        'idCust',
//        'namaCust',
//        'id_marketing',
//        'tanggal',
//        'status',
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
                    'url' => 'Yii::app()->createUrl("quotation/create?id=$data->id")',
                    'icon' => 'fa fa-check',
                    'visible' => '$data->status != "quotation"',
                ),
                'view',
                'update' => array(
                    'label' => 'Update ',
                    'visible' => '$data->status != "quotation"',
                ),
                'delete' => array(
                    'label' => 'Delete ',
                    'visible' => '$data->status != "quotation"',
                ),
            ),
        ),
    ),
));
?>
