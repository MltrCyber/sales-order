<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>
<ul class="chats">
    <?php
    $detail = Pesan::model()->findAll(array('condition' => 'pesan_id=' . $model->pesan_id . ' and hapus1 != ' . Yii::app()->user->id . ' and hapus2 != ' . Yii::app()->user->id, 'order' => 'tanggal ASC'));
    foreach ($detail as $val) {
        if (Yii::app()->user->id == $val->pengirim_id) {
            $stt = 'out';
            $nm = $val->Pengirim->nama;
        } else {
            $nm = $val->Pengirim->nama;
            $stt = 'in';
        }

        if ($val->penerima_id == Yii::app()->user->id and $val->dibaca == 0) {
            $status = '<span class="badge">New</span>';
            $val->dibaca = 1;
            $val->save();
        } else {
            $status = '';
        }

        echo '<li class="' . $stt . '">
                <div class="message">
                    <span class="arrow">
                    </span>
                    <a href="#" class="name">' . $nm . '</a>
                    </a>
                    <span class="datetime">' . (Yii::app()->tindik->tgl_indo($val->tanggal, true)) . ' ' . $status . '</span>
                    <span class="body">
                        ' . $val->isi . '
                    </span>
                </div>
            </li>';
    }
    ?>
</ul>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'pesan-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
$model->isi = '';
?>
<div class="form-body">
    <?php echo $form->textAreaGroup($model, 'isi', array('widgetOptions' => array('htmlOptions' => array('rows' => 6, 'cols' => 50, 'class' => 'span8', 'placeholder' => 'Masukkan Balasan')), 'label' => false)); ?>
    <div class="form-group">   
        <div style="margin-right: 20px;margin-left: 20px; " align="right">
            <a href="<?php echo Yii::app()->createUrl('pesan/index') ?>" class="btn btn-success">Back</a>
            <input type="submit" class="btn btn-primary" name="ok" value="Kirim">
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>