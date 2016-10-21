
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'id',
        'kodeMarketing',
        'marketing',
        'targetBulan',
        'tahun',
        'targetSales',
        'bonusSales',
    ),
));
?>
<div style="margin-top: 25px;text-align: center">
    <a href="<?php echo Yii::app()->createUrl('target/') ?>" class="btn btn-success">Back</a>    
</div>