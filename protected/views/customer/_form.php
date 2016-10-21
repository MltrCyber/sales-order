<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'customer-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25, 'readonly' => true)))); ?>

<?php echo $form->textFieldGroup($model, 'nama', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->textFieldGroup($model, 'cp', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php echo $form->textFieldGroup($model, 'telepon', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25)))); ?>

<?php echo $form->textFieldGroup($model, 'email', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php // echo $form->textFieldGroup($model, 'id_marketing', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<div class="form-actions" style="text-align: center">
    <a href="<?php echo Yii::app()->createUrl('customer/') ?>" class="btn btn-success">Back</a>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
