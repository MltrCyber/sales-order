<?php
$this->breadcrumbs = array(
    'Barangs' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Barang', 'url' => array('index')),
    array('label' => 'Create Barang', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('barang-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php
echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-success', 'style' => 'margin-right:10px;'));
echo CHtml::link('Tambah Data', Yii::app()->createUrl('barang/create'), array('class' => 'btn btn-primary'));
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
    'id' => 'barang-grid',
    'dataProvider' => $model->search(),
//    'filter' => $model,
    'columns' => array(
//        'id',
        'kode',
        'nama',
        'hargaBrg',
        'satuan',
        'stok',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{view}{update}{delete}',
            'htmlOptions' => array(
                'width' => '100'
            ),
            'buttons' => array(
                'update' => array(
                    'label' => 'Update ',
                    'visible' => '$_SESSION["level"] == "admin"',
                ),
                'delete' => array(
                    'label' => 'Delete ',
                    'visible' => '$_SESSION["level"] == "admin"',
                ),
            ),
        ),
    ),
));
?>
