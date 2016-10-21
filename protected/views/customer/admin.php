<?php
$this->breadcrumbs = array(
    'Customers' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Customer', 'url' => array('index')),
    array('label' => 'Create Customer', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('customer-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php
echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-success', 'style' => 'margin-right:10px;'));
if ($_SESSION['level'] == "marketing") {
    echo CHtml::link('Tambah Data', Yii:: app()->createUrl('customer/create'), array('class' => 'btn btn-primary'));
}
?>
<div class="search-form" style="display:none; margin-top:20px;">
    <?php
    $this->renderPartial('_search', array('model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('booster.widgets.TbGridView', array('id' => 'customer-grid',
    'dataProvider' => $model->search(),
//    'filter' => $model,
    'columns' => array(
//        'id',
        'kode',
        'nama',
        'cp',
        'telepon',
        array(
            'name' => 'id_marketing',
            'header' => 'ID Marketing',
            'value' => '$data->kodeMarketing',
        ),
        array(
            'name' => 'id_marketing',
            'header' => 'Nama Marketing',
            'value' => '$data->namaMarketing',
        ),
//        'email',
        /*
          'id_marketing',
         */
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{view}{update}{delete}',
            'htmlOptions' => array(
                'width' => '100'
            ),
            'buttons' => array(
                'update' => array(
                    'label' => 'Update ',
                    'visible' => '$_SESSION["level"] == "marketing"',
                ),
                'delete' => array(
                    'label' => 'Delete ',
                    'visible' => '$_SESSION["level"] == "marketing"',
                ),
            ),
        ),
    ),
));
?>
 