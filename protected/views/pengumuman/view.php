
<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'judul',
        'tanggal',
        'isi',
    ),
));
?>
<div style="margin-top: 25px;text-align: center">
    <a href="<?php echo Yii::app()->createUrl('pengumuman/') ?>" class="btn btn-success">Back</a>    
</div>