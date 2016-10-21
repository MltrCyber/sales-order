<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'so-form',
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

<div class="row">
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 15, 'readonly' => true)))); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Inquiry</label>
            <div class="col-sm-9">
                <input type="hidden" name="Quotation[id_inquiry]" value="<?php echo isset($quo->id) ? $quo->id : 0; ?>">
                <input class="span5 form-control" placeholder="ID Inquiry" name="t1" id="" type="text" readonly="true" value="<?php echo isset($quo->Inquiry->kode) ? $quo->Inquiry->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Customer</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Customer" name="t2" id="" type="text" readonly="true" value="<?php echo isset($quo->Inquiry->Customer->kode) ? $quo->Inquiry->Customer->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Nama PT</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama PT" name="t3" id="" type="text" readonly="true" value="<?php echo isset($quo->Inquiry->Customer->nama) ? $quo->Inquiry->Customer->nama : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Contact Person</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama PT" name="t4" id="" type="text" readonly="true" value="<?php echo isset($quo->Inquiry->Customer->cp) ? $quo->Inquiry->Customer->cp : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">No Telepon</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="No Telepon" name="t5" id="" type="text" readonly="true" value="<?php echo isset($quo->Inquiry->Customer->telepon) ? $quo->Inquiry->Customer->telepon : '-'; ?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-3 control-label">ID Quotation</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Quotation" name="t6" id="" type="text" readonly="true" value="<?php echo isset($quo->kode) ? $quo->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Marketing</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Marketing" name="t7" id="" type="text" readonly="true" value="<?php echo isset($quo->Inquiry->Marketing->kode) ? $quo->Inquiry->Marketing->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Nama Marketing</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama Marketing" name="t8" id="" type="text" readonly="true" value="<?php echo isset($quo->Inquiry->Marketing->nama) ? $quo->Inquiry->Marketing->nama : '-'; ?>">
            </div>
        </div>

        <?php // echo $form->textFieldGroup($model, 'id_inquiry', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php // echo $form->textFieldGroup($model, 'fee', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('format' => 'dd-mm-yyyy'), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

    </div>
</div>

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
    <thead>
    <tbody>
        <?php
        $id = isset($quo->Inquiry->id) ? $quo->Inquiry->id : 0;
        $barang = InquiryDet::model()->findAll(array('condition' => 'id_inquiry=' . $id));
        $jml = 0;
        foreach ($barang as $val) {
            $jml += ($val->harga * $val->jumlah);
            echo '<tr id="' . $val->id . '">';
            echo '<td><input type="hidden" name="id_inquiry_det[]" value="' . $val->id . '">' . (isset($val->Barang->kode) ? $val->Barang->kode : '- ') . '</td>';
            echo '<td>' . (isset($val->Barang->nama) ? $val->Barang->nama : '- ') . '</td>';
            echo '<td style="text-align:center"><span class="jumlah">' . $val->jumlah . '</span></td>';
            echo '<td style="width:200px;text-align:right">' . $val->harga . '</td>';
            echo '<td style="text-align:right"><span class="subTotal">' . $val->harga * $val->jumlah . '</span></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Jumlah</th>
            <td width="200" style="text-align:right"><input type="hidden" name="So[total]" readonly="true" class="form-control total"><span class="spntotal"><?php echo $jml?></span></td>
        </tr>
        <tr>
            <th colspan="3">Fee Customer (%)</th>
            <td><input type="text" name="So[fee]" class="form-control fee" onkeyup="kalkulasi()"></td>
            <td style="text-align:right"><span class="totalFee"></span></td>
        </tr>
        <tr>
            <th colspan="4">Total Bayar</th>
            <td style="text-align:right"><input type="hidden" name="So[total_bayar]" readonly="true" class="form-control totalBayar"><span class="spntotalBayar"></span></td>
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
//        var total = 0;
//        $(".jumlah").each(function () {
//            var jumlah = parseFloat($(this).html());
//            var harga = parseInt($(this).parent().parent().find(".harga").html());
//            var sub_total = jumlah * harga;
//            total += parseInt(sub_total);
//            $(this).parent().parent().find(".subTotal").html(sub_total);
//        });
//
        var total = ($(".spntotal").html() != "") ? parseFloat($(".spntotal").html()) : 0;
        var fee = ($(".fee").val() != "") ? parseFloat($(".fee").val()) : 0;
//        console.log(fee);
        var total_fee = total * (fee / 100);
        var total_bayar = total - total_fee;
        $(".total").val(total);
//        $(".spntotal").html(total);
        $(".totalFee").html(total_fee);
        $(".totalBayar").val(total_bayar);
        $(".spntotalBayar").html(total_bayar);
    }
</script>