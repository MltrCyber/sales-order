<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'quotation-form',
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

<div class="form-group">
    <label class="col-sm-3 control-label">ID Inquiry</label>
    <div class="col-sm-9">
        <input type="hidden" name="Quotation[id_inquiry]" value="<?php echo isset($inq->id) ? $inq->id : 0; ?>">
        <input class="span5 form-control" placeholder="ID Inquiry" name="t1" id="" type="text" readonly="true" value="<?php echo isset($inq->kode) ? $inq->kode : '-'; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">ID Customer</label>
    <div class="col-sm-9">
        <input class="span5 form-control" placeholder="ID Customer" name="t2" id="" type="text" readonly="true" value="<?php echo isset($inq->Customer->kode) ? $inq->Customer->kode : '-'; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Nama PT</label>
    <div class="col-sm-9">
        <input class="span5 form-control" placeholder="Nama PT" name="t3" id="" type="text" readonly="true" value="<?php echo isset($inq->Customer->nama) ? $inq->Customer->nama : '-'; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Contact Person</label>
    <div class="col-sm-9">
        <input class="span5 form-control" placeholder="Nama PT" name="t4" id="" type="text" readonly="true" value="<?php echo isset($inq->Customer->cp) ? $inq->Customer->cp : '-'; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">No Telepon</label>
    <div class="col-sm-9">
        <input class="span5 form-control" placeholder="No Telepon" name="t5" id="" type="text" readonly="true" value="<?php echo isset($inq->Customer->telepon) ? $inq->Customer->telepon : '-'; ?>">
    </div>
</div>
<?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 15, 'readonly' => true)))); ?>

<?php // echo $form->textFieldGroup($model, 'id_inquiry', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php // echo $form->textFieldGroup($model, 'fee', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

<?php // echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array(), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>', 'append' => 'Click on Month/Year to select a different Month/Year.')); ?>

<?php // echo $form->textFieldGroup($model, 'status', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 15)))); ?>
<style>
    td, th{
        vertical-align: middle !important;
    }

    td span{
        font-size: 14px;
    }
</style>
<table class="table table-bordered table-striped table-hover" id="detail-table">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $id = isset($inq->id) ? $inq->id : 0;
        $barang = InquiryDet::model()->findAll(array('condition' => 'id_inquiry=' . $id));
        foreach ($barang as $val) {
            echo '<tr id="' . $val->id . '">';
            echo '<td><input type="hidden" name="id_inquiry_det[]" value="' . $val->id . '">' . (isset($val->Barang->kode) ? $val->Barang->kode : '- ') . '</td>';
            echo '<td>' . (isset($val->Barang->nama) ? $val->Barang->nama : '- ') . '</td>';
            echo '<td style="text-align:center"><span class="jumlah">' . $val->jumlah . '</span></td>';
            echo '<td style="width:200px;"><input type="text" class="span2 form-control harga" onkeyup="kalkulasi()" name="harga[]" style="width:200px;"></td>';
            echo '<td style="text-align:right"><span class="subTotal"></span></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Jumlah</th>
            <td width="200" style="text-align:right"><input type="hidden" name="Quotation[total]" readonly="true" class="form-control total"><span class="spntotal"></span></td>
        </tr>
    </tfoot>
</table>

<div class="form-actions" style="text-align: center">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function kalkulasi() {
        var total = 0;
        $(".jumlah").each(function () {
            var jumlah = parseFloat($(this).html());
            var harga = parseInt($(this).parent().parent().find(".harga").val());
            var sub_total = jumlah * harga;
            total += parseInt(sub_total);
            $(this).parent().parent().find(".subTotal").html(sub_total);
        });
        $(".total").val(total);
        $(".spntotal").html(total);
    }
</script>