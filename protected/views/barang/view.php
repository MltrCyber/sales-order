
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'id',
        'kode',
        'nama',
        'hargaBrg',
        'satuan',
        'stok',
    ),
));
?>
<div style="margin-top: 25px;text-align: center">
    <a href="<?php echo Yii::app()->createUrl('barang/') ?>" class="btn btn-success">Back</a>    
</div>
