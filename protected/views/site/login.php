<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>
<div class="login-panel panel panel-default">                  
    <div class="panel-heading">
        <h3 class="panel-title">Please Sign In</h3>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'login-form',
//            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <fieldset>
            <?php echo $form->textFieldGroup($model, 'username', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 35)))); ?>
            <?php echo $form->passwordFieldGroup($model, 'password', array('widgetOptions' => array('htmlOptions' => array('type' => 'password', 'class' => 'span5', 'maxlength' => 35)))); ?><?php echo $form->checkBoxGroup($model, 'rememberMe', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 35)))); ?>
            <div align="right">
                <!--<a href="<?php echo Yii::app()->createUrl('site/index'); ?>" class="btn btn-success">Back</a>-->
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'label' => 'Login',
                ));
                ?>
            </div>
        </fieldset>
        <?php $this->endWidget(); ?>
    </div>
</div>