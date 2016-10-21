<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'inquiry-form',
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

<?php echo $form->textFieldGroup($model, 'kode', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 15, 'readonly' => true)))); ?>

<?php
$array = Customer::model()->findAll(array('condition' => 'id_marketing=' . Yii::app()->user->id));
echo $form->dropDownListGroup(
        $model, 'id_customer', array(
    'widgetOptions' => array(
        'data' => array("0" => ".: Pilih Customer :.") + CHtml::listData($array, 'id', 'kode'),
        'htmlOptions' => array(
            'ajax' => array(
                'type' => 'POST',
                'url' => Yii::app()->createUrl('inquiry/getCustomer'),
                'success' => 'function(data){
                        var dt = JSON.parse(data);
                        $("#nama").val(dt.nama);
                        $("#cp").val(dt.cp);
                        $("#telepon").val(dt.telepon);
                }',
            )
        ),
    ), 'label' => 'ID Customer'
        )
);
?>

<div class="form-group">
    <label class="col-sm-3 control-label">Nama PT</label>
    <div class="col-sm-9">
        <input class="span5 form-control" placeholder="Nama PT" name="nama_pt" id="nama" type="text" readonly="true" value="<?php echo isset($model->Customer->nama) ? $model->Customer->nama : '-' ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Contact Person</label>
    <div class="col-sm-9">
        <input class="span5 form-control" placeholder="Contact Person" name="cp" id="cp" type="text" readonly="true" value="<?php echo isset($model->Customer->cp) ? $model->Customer->cp : '-' ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Telepon</label>
    <div class="col-sm-9">
        <input class="span5 form-control" placeholder="Telepon" name="telepon" id="telepon" type="text" readonly="true" value="<?php echo isset($model->Customer->telepon) ? $model->Customer->telepon : '-' ?>">
    </div>
</div>

<?php
if ($model->isNewRecord == true)
    $model->tanggal = date("d-m-Y");

//echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('format' => 'dd-mm-yyyy'), 'htmlOptions' => array('class' => 'span5')), 'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'));
?>

<?php
$this->beginWidget(
        'booster.widgets.TbModal', array('id' => 'myModal')
);
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Pilih Barang</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <label class="col-sm-3 control-label">Kode</label>
        <div class="col-sm-9">
            <input class="span5 form-control" placeholder="Kode Barang" name="Barang_kode" id="Barang_kode" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Nama</label>
        <div class="col-sm-9">
            <input class="span5 form-control" placeholder="Nama Barang" name="Barang_nama" id="Barang_nama" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Jumlah</label>
        <div class="col-sm-9">
            <input class="span5 form-control" placeholder="Jumlah" name="Barang_jumlah" id="Barang_jumlah" type="text">
        </div>
    </div>
</div>

<div class="modal-footer">
    <script>
        function addDetail() {
            if ($("#Barang_kode").val() != "" && $("#Barang_nama").val() != "" && $("#Barang_jumlah").val() != "") {
                var row;
                row += "<tr>";
                row += "<td><input type='hidden' name='Barang[kode][]' value='" + $("#Barang_kode").val() + "'>" + $("#Barang_kode").val() + "</td>";
                row += "<td><input type='hidden' name='Barang[nama][]' value='" + $("#Barang_nama").val() + "'>" + $("#Barang_nama").val() + "</td>";
                row += "<td><input type='hidden' name='Barang[jumlah][]' value='" + $("#Barang_jumlah").val() + "'>" + $("#Barang_jumlah").val() + "</td>";
                row += "<td><button type='button' class='btn btn-danger' onclick='$(this).parent().parent().remove();'><i class='fa fa-minus'></i></button></td>";
                row += "</tr>";
                $("#detail-table").append(row);
                $("#Barang_kode").val("");
                $("#Barang_nama").val("");
                $("#Barang_jumlah").val("");
            }
        }
    </script>
    <?php
    $this->widget(
            'booster.widgets.TbButton', array(
        'context' => 'primary',
        'label' => 'Tambah',
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
            'onclick' => 'addDetail()',
        ),
            )
    );
    ?>
    <?php
    $this->widget(
            'booster.widgets.TbButton', array(
        'label' => 'Kembali',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
            )
    );
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->widget(
        'booster.widgets.TbButton', array(
    'label' => 'Tambah Barang',
    'context' => 'primary',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#myModal',
    ),
        )
);
?>
<br><br>
<table class="table table-bordered table-striped table-hover" id="detail-table">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th width="20"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($model->isNewRecord == false) {
            $det = InquiryDet::model()->findAll(array('condition' => 'id_inquiry=' . $model->id));
            foreach ($det as $val) {
                ?>
                <tr>
                    <td><input type='hidden' name='Barang[kode][]' value='<?php echo $val->Barang->kode ?>'><?php echo $val->Barang->kode ?></td>
                    <td><input type='hidden' name='Barang[nama][]' value='<?php echo $val->Barang->nama ?>'><?php echo $val->Barang->nama ?></td>
                    <td><input type='hidden' name='Barang[jumlah][]' value='<?php echo $val->jumlah ?>'><?php echo $val->jumlah ?></td>
                    <td><button type='button' class='btn btn-danger' onclick='$(this).parent().parent().remove();'><i class='fa fa-minus'></i></button></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>

<div class="form-actions" style="text-align: center">
    <a href="<?php echo Yii::app()->createUrl('inquiry/') ?>" class="btn btn-success">Back</a>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

