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
echo CHtml::link('Tambah Data', Yii::app()->createUrl('create'), array('class' => 'btn btn-primary'));
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
    'filter' => $model,
    'columns' => array(
        'id',
        'kode',
        'id_quotation',
        'fee',
        'total',
        'tanggal',
        /*
          'status',
         */
        array(
            'class' => 'booster.widgets.TbButtonColumn',
        ),
    ),
));
?>
