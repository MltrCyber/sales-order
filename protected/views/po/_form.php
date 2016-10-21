<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'po-form',
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
                <input type="hidden" name="Po[id_quotation]" value="<?php echo isset($so->Quotation->id) ? $so->Quotation->id : 0; ?>">
                <input type="hidden" name="Po[id_customer]" value="<?php echo isset($so->Quotation->Inquiry->id_customer) ? $so->Quotation->Inquiry->id_customer : 0; ?>">
                <input type="hidden" name="Po[id_marketing]" value="<?php echo isset($so->Quotation->Inquiry->id_marketing) ? $so->Quotation->Inquiry->id_marketing : 0; ?>">
                <input class="span5 form-control" placeholder="ID Inquiry" name="t1" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->Inquiry->kode) ? $so->Quotation->Inquiry->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Customer</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Customer" name="t2" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->Inquiry->Customer->kode) ? $so->Quotation->Inquiry->Customer->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Nama PT</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama PT" name="t3" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->Inquiry->Customer->nama) ? $so->Quotation->Inquiry->Customer->nama : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Contact Person</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama PT" name="t4" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->Inquiry->Customer->cp) ? $so->Quotation->Inquiry->Customer->cp : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">No Telepon</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="No Telepon" name="t5" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->Inquiry->Customer->telepon) ? $so->Quotation->Inquiry->Customer->telepon : '-'; ?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-3 control-label">ID Quotation</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Quotation" name="t6" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->kode) ? $so->Quotation->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Marketing</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Marketing" name="t7" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->Inquiry->Marketing->kode) ? $so->Quotation->Inquiry->Marketing->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Nama Marketing</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama Marketing" name="t8" id="" type="text" readonly="true" value="<?php echo isset($so->Quotation->Inquiry->Marketing->nama) ? $so->Quotation->Inquiry->Marketing->nama : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Tanggal Order</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Tanggal Order" name="t8" id="" type="text" readonly="true" value="<?php echo isset($so->tanggal) ? $so->tanggal : '-'; ?>">
            </div>
        </div>

        <?php // echo $form->textFieldGroup($model, 'id_inquiry', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php // echo $form->textFieldGroup($model, 'fee', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php // echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('format' => 'dd-mm-yyyy'), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

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
        $id = isset($so->Quotation->id_inquiry) ? $so->Quotation->id_inquiry : 0;
        $barang = InquiryDet::model()->findAll(array('condition' => 'id_inquiry=' . $id));
        $jml = 0;
        foreach ($barang as $val) {
            $jml += ($val->harga * $val->jumlah);
            echo '<tr id="' . $val->id . '">';
            echo '<td>' . (isset($val->Barang->kode) ? $val->Barang->kode : '- ') . '</td>';
            echo '<td>' . (isset($val->Barang->nama) ? $val->Barang->nama : '- ') . '</td>';
            echo '<td style="text-align:center"><span class="jumlah1">' . $val->jumlah . '</span></td>';
            echo '<td style="width:200px;text-align:right">' . $val->harga . '</td>';
            echo '<td style="text-align:right"><span class="subTotal1">' . $val->harga * $val->jumlah . '</span></td>';
            echo '</tr>';
        }
        $total_bayar = $so->total - ($so->total * ($so->fee / 100));
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Jumlah</th>
            <td width="200" style="text-align:right"><span class="spntotal1"><?php echo $jml ?></span></td>
        </tr>
        <tr>
            <th colspan="3">Fee Customer (%)</th>
            <td style="text-align:right"><?php echo $so->fee; ?>%</td>
            <td style="text-align:right"><span class="totalFee1"><?php echo $so->total * ($so->fee / 100) ?></span></td>
        </tr>
        <tr>
            <th colspan="4">Total Bayar</th>
            <td style="text-align:right"><span class="spntotalBayar1"><?php echo $total_bayar ?></span></td>
        </tr>
    </tfoot>
</table>
<h3 class="page-header">Purchase</h3>
<table class="table table-bordered table-striped table-hover" id="detail-table">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Beli</th>
            <th>Total Harga</th>
        </tr>
    <thead>
    <tbody>
        <?php
        foreach ($barang as $val) {
            echo '<tr id="' . $val->id . '">';
            echo '<td><input type="hidden" name="id_barang[]" value="' . $val->id_barang . '">' . (isset($val->Barang->kode) ? $val->Barang->kode : '- ') . '</td>';
            echo '<td><input type="hidden" name="harga[]" value="' . $val->harga . '">' . (isset($val->Barang->nama) ? $val->Barang->nama : '- ') . '</td>';
            echo '<td style="text-align:center"><input type="hidden" name="jumlah[]" value="' . $val->jumlah . '"><span class="jumlah">' . $val->jumlah . '</span></td>';
            echo '<td style="width:200px;"><input type="text" class="span2 form-control harga" onkeyup="kalkulasi()" name="harga_beli[]" style="width:200px;"></td>';
            echo '<td style="text-align:right"><span class="subTotal"></span></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Total Purchase</th>
            <td width="200" style="text-align:right"><input type="hidden" name="Po[total]" readonly="true" class="form-control total"><span class="spntotal"></span></td>
        </tr>
        <tr>
            <th colspan="2">Laba / Rugi</th>
            <th colspan="2" style="text-align: right"><span><?php echo $total_bayar ?></span> - <span class="spntotal"></span></th>
            <td style="text-align: right"><span class="grandTotal"></span></td>
        </tr>
    </tfoot>
</table>

<div class="form-actions" style="text-align: center">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'success',
        'htmlOptions' => array(
            'name' => 'approve',
            'style' => 'margin-right:10px;'
        ),
        'label' => 'Accept',
    ));
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'button',
        'context' => 'danger',
        'htmlOptions' => array(
            'name' => 'reject',
            'onclick' => 'save()'
        ),
        'label' => 'Reject',
    ));
    ?>
    <script>
        function save() {
             document.getElementById("po-form").action = '<?php echo Yii::app()->createUrl('po/create?id='.$_GET['id'].'&status=Reject')?>'
             document.getElementById("po-form").submit();
        }
    </script>
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
        $(".grandTotal").html(parseInt(<?php echo $total_bayar ?>) - parseInt(total));
    }
</script>