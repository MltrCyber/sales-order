
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//		'id',
        'kode',
        'nama',
        'cp',
        'telepon',
        'email',
        'kodeMarketing',
        'namaMarketing',
    ),
));
?>
<div style="margin-top: 25px;text-align: center">
    <a href="<?php echo Yii::app()->createUrl('customer/') ?>" class="btn btn-success">Back</a>    
</div>