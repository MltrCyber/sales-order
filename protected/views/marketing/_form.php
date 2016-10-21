<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'user-form',
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

<?php echo $form->textAreaGroup($model, 'alamat', array('widgetOptions' => array('htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'span8')))); ?>

<?php echo $form->textFieldGroup($model, 'no_tlp', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25)))); ?>

<?php echo $form->textFieldGroup($model, 'username', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'readonly' => true)))); ?>

<?php echo $form->passwordFieldGroup($model, 'password', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>

<?php // echo $form->dropDownListGroup($model, 'level', array('widgetOptions' => array('data' => array("marketing" => "marketing", "admin" => "admin",), 'htmlOptions' => array('class' => 'input-large')))); ?>

<div class="form-actions" style="text-align: center">
    <a href="<?php echo Yii::app()->createUrl('marketing/') ?>" class="btn btn-success">Back</a>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
