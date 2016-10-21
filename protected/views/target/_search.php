<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>

<?php // echo $form->textFieldGroup($model, 'id', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php echo $form->textFieldGroup($model, 'bulan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 2)))); ?>

<?php echo $form->textFieldGroup($model, 'tahun', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 5)))); ?>

<?php // echo $form->textFieldGroup($model, 'target', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20)))); ?>

<?php // echo $form->textFieldGroup($model, 'bonus', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

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
