<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>

<?php // echo $form->textFieldGroup($model, 'id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 15)))); ?>

<?php
$array = Customer::model()->findAll(array('condition' => 'id_marketing=' . Yii::app()->user->id));
echo $form->dropDownListGroup(
        $model, 'id_customer', array(
    'widgetOptions' => array(
        'data' => array("0" => ".: Pilih Customer :.") + CHtml::listData($array, 'id', 'nama'),
        'htmlOptions' => array(
        ),
    ), 'label' => 'Customer'
        )
);
?>

<?php // echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('format'=>'yyyy-mm-dd'), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

<?php // echo $form->textFieldGroup($model, 'status', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25))));  ?>

<div class="form-actions">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => 'Search',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
