<?php
$this->breadcrumbs = array(
    'Pengumumen' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Pengumuman', 'url' => array('index')),
    array('label' => 'Create Pengumuman', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('pengumuman-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php
echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-success', 'style' => 'margin-right:10px;'));
echo CHtml::link('Tambah Data', Yii::app()->createUrl('pengumuman/create'), array('class' => 'btn btn-primary'));
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
    'id' => 'pengumuman-grid',
    'dataProvider' => $model->search(),
//'filter'=>$model,
    'columns' => array(
//		'id',
        'judul',
        array(
            'type' => 'raw',
            'header' => '',
            'value' => '$data->status',
            'visible' => '$_SESSION["level"] == "marketing"'
        ),
        'tanggal',
//		'isi',
        array(
            'class' => 'booster.widgets.TbButtonColumn',
        ),
    ),
));
?>
