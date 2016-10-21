<?php

//echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-success', 'style' => 'margin-right:10px;'));
echo CHtml::link('Buat Pesan Baru', Yii::app()->createUrl('pesan/create'), array('class' => 'btn btn-primary'));
?>

<?php

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'pesan-grid',
    'pager' => array(
        'class' => 'booster.widgets.TbPager',
        'displayFirstAndLast' => true,
    ),
    'summaryText' => 'Displaying {page}-{end} of {count} results. Page {page} from {pages}',
    'dataProvider' => $model->search(),
//    'filter' => $model,
    'columns' => array(
        array(
            'header' => '',
            'type' => 'raw',
            'name' => 'penerima_id',
            'value' => '$data->penerimaPesan'
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'name' => 'subjek',
            'value' => '$data->subjekPesan',
        ),
        array(
            'header' => '',
            'name' => 'tanggal',
            'value' => '$data->tanggalpesan',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'name' => 'dibaca',
            'value' => '$data->status',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{lihat}{hapus}',
            'htmlOptions' => array(
                'width' => '100'
            ),
            'buttons' => array(
                'lihat' => array(
                    'label' => 'Lihat ',
                    'url' => 'Yii::app()->createUrl("pesan/lihat",array("id"=>$data->id))',
                ),
                'hapus' => array(
                    'label' => ' Hapus',
                    'url' => 'Yii::app()->createUrl("pesan/delete",array("id"=>$data->id))',
                ),
                'delete',
            ),
        ),
    ),
));
?>
