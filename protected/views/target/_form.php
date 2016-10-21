<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'target-form',
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

<?php
$array = Marketing::model()->findAll(array('condition'=>'level="marketing"'));
echo $form->dropDownListGroup(
        $model, 'id_marketing', array(
    'widgetOptions' => array(
        'data' => array("0" => ".: Pilih Marketing :.") + CHtml::listData($array, 'id', 'nama'),
        'htmlOptions' => array(
        ),
    ), 'label' => 'Marketing'
        )
);

$array = Yii::app()->tindik->listbulan();
echo $form->dropDownListGroup(
        $model, 'bulan', array(
    'widgetOptions' => array(
        'data' => $array,
        'htmlOptions' => array(
        ),
    ), 'label' => 'Bulan'
        )
);
?>
<?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 5)))); ?>

<?php echo $form->textFieldGroup($model, 'target', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)),'prepend'=>'Rp')); ?>

<?php echo $form->textFieldGroup($model, 'bonus', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')),'append'=>'%')); ?>

<div class="form-actions" style="text-align: center">
    <a href="<?php echo Yii::app()->createUrl('target/') ?>" class="btn btn-success">Back</a>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
