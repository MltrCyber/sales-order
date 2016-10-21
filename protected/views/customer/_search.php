<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>

<?php // echo $form->textFieldGroup($model, 'id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25)))); ?>

<?php echo $form->textFieldGroup($model, 'nama', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php echo $form->textFieldGroup($model, 'cp', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php // echo $form->textFieldGroup($model, 'telepon', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25)))); ?>

<?php // echo $form->textFieldGroup($model, 'email', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

<?php 
if($_SESSION['level'] == "admin"){
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
}
?>

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
