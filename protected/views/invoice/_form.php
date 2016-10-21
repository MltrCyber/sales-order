<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'invoice-form',
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

        <?php echo $form->textFieldGroup($model, 'status_bayar', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->textFieldGroup($model, 'jenis_pembayaran', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>


        <div class="form-group">
            <label class="col-sm-3 control-label">ID PO</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Inquiry" name="t1" id="" type="text" readonly="true" value="<?php echo isset($po->kode) ? $po->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Inquiry</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Inquiry" name="t1" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->Inquiry->kode) ? $po->Quotation->Inquiry->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Customer</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Customer" name="t2" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->Inquiry->Customer->kode) ? $po->Quotation->Inquiry->Customer->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Nama PT</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama PT" name="t3" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->Inquiry->Customer->nama) ? $po->Quotation->Inquiry->Customer->nama : '-'; ?>">
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-3 control-label">Contact Person</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama PT" name="t4" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->Inquiry->Customer->cp) ? $po->Quotation->Inquiry->Customer->cp : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">No Telepon</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="No Telepon" name="t5" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->Inquiry->Customer->telepon) ? $po->Quotation->Inquiry->Customer->telepon : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Quotation</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Quotation" name="t6" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->kode) ? $po->Quotation->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">ID Marketing</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="ID Marketing" name="t7" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->Inquiry->Marketing->kode) ? $po->Quotation->Inquiry->Marketing->kode : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Nama Marketing</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Nama Marketing" name="t8" id="" type="text" readonly="true" value="<?php echo isset($po->Quotation->Inquiry->Marketing->nama) ? $po->Quotation->Inquiry->Marketing->nama : '-'; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Tanggal Order</label>
            <div class="col-sm-9">
                <input class="span5 form-control" placeholder="Tanggal Order" name="t8" id="" type="text" readonly="true" value="<?php echo isset($po->tanggal) ? $po->tanggal : '-'; ?>">
            </div>
        </div>

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
        $id = isset($po->Quotation->id_inquiry) ? $po->Quotation->id_inquiry : 0;
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
        $total_bayar = $jml - ($jml * ($po->Quotation->So->fee / 100));
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Jumlah</th>
            <td width="200" style="text-align:right"><span class="spntotal1"><?php echo $jml ?></span></td>
        </tr>
        <tr>
            <th colspan="3">Fee Customer (%)</th>
            <td style="text-align:right"><?php echo $po->Quotation->So->fee ?>%</td>
            <td style="text-align:right"><span class="totalFee1"><?php echo $jml * ($po->Quotation->So->fee / 100) ?></span></td>
        </tr>
        <tr>
            <th colspan="4">Total Bayar</th>
            <td style="text-align:right"><span class="spntotalBayar1"><?php echo $total_bayar ?></span></td>
        </tr>
    </tfoot>
</table>

<div class="form-actions" style="text-align: center">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'htmlOptions' => array(
            'name' => 'approve',
            'style' => 'margin-right:10px;'
        ),
        'label' => 'Create',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>