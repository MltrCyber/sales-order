
<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'id',
        'kode',
        'nama',
        'alamat',
        'no_tlp',
        'username',
        'password',
        'level',
    ),
));
?>
<div style="margin-top: 25px;text-align: center">
    <a href="<?php echo Yii::app()->createUrl('marketing/') ?>" class="btn btn-success">Back</a>    
</div>
