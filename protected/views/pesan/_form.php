<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'pesan-form',
//    'enableAjaxValidation' => false,
//    'enableClientValidation' => true,
//    'clientOptions' => array(
//        'validateOnSubmit' => true,
//    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php
$array = User::model()->findAll(array('condition' => 'id!=' . Yii::app()->user->id, 'order' => 'level ASC'));
echo $form->dropDownListGroup(
        $model, 'penerima_id', array(
    'widgetOptions' => array(
        'data' => array("" => ".: Pilih Penerima :.") + CHtml::listData($array, 'id', 'nama'),
        'htmlOptions' => array(
        ),
    )
        )
);
?>

<?php echo $form->textFieldGroup($model, 'subjek', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php echo $form->textAreaGroup($model, 'isi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255,'style'=>'height:175px;')))); ?>

<div class="form-actions" align="center">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>

    <?php
    echo CHtml::link('Back', array('pesan/index'), array('class' => 'btn btn-success'));
    ?>
</div>

<?php $this->endWidget(); ?>
