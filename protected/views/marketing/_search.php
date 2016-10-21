<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>

<?php // echo $form->textFieldGroup($model, 'id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25)))); ?>

<?php echo $form->textFieldGroup($model, 'nama', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>

<?php // echo $form->textAreaGroup($model, 'alamat', array('widgetOptions' => array('htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'span8')))); ?>

<?php // echo $form->textFieldGroup($model, 'no_tlp', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 25)))); ?>

<?php // echo $form->textFieldGroup($model, 'username', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)))); ?>

<?php // echo $form->dropDownListGroup($model, 'level', array('widgetOptions' => array('data' => array("marketing" => "marketing", "admin" => "admin",), 'htmlOptions' => array('class' => 'input-large')))); ?>

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
