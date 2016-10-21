<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'barang-form',
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

<?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 10)))); ?>

<?php echo $form->textFieldGroup($model, 'nama', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->textFieldGroup($model, 'harga', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)), 'prepend' => 'Rp')); ?>

<?php echo $form->textFieldGroup($model, 'satuan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 15)))); ?>

<?php
if ($_SESSION['level'] == "admin") {
    echo $form->textFieldGroup($model, 'stok', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5'))));
}
?>

<div class="form-actions" style="text-align: center">
    <a href="<?php echo Yii::app()->createUrl('barang/') ?>" class="btn btn-success">Back</a>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
