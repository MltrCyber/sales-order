<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
        <div class="sidebar-toggler hidden-phone">        </div>
    </li>
    <li>
        <a href="<?php echo Yii::app()->createUrl('') ?>">
            <i class="fa fa-home"></i>
            <span class="title">
                Home            
            </span>
            <span class="selected">            
            </span>        
        </a>    
    </li>
    <li>
        <a href="">
            <i class="fa fa-barcode"></i>
            <span class="title">
                Data Master                
            </span>
            <span class="arrow">                
            </span> 
        </a>
        <ul class="sub-menu">
            <li>
                <a href="<?php echo Yii::app()->createUrl('barang') ?>">
                    Barang                   
                </a> 
            </li>
            <?php
            if ($_SESSION['level'] == "admin") {
                ?>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('marketing') ?>">
                        Markeeting                    
                    </a> 
                </li>
                <?php
            }
            ?>
            <li>
                <a href="<?php echo Yii::app()->createUrl('customer') ?>">
                    Customer                    
                </a> 
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('target') ?>">
                    Target Sales                    
                </a> 
            </li>
        </ul>
    </li>
    <?php
    $pesan = Pesan::model()->findAll(array('condition' => 'penerima_id=' . Yii::app()->user->id . ' and dibaca = 0'));
    $jmlPesan = count($pesan);
    ?>
    <li>
        <a href="<?php echo Yii::app()->createUrl('pesan') ?>">
            <i class="fa fa-envelope"></i>
            <span class="title">
                Pesan            
            </span>
            <span class="selected">            
            </span>
            <span class="badge"><?php echo $jmlPesan; ?></span>
        </a>    
    </li>
    <li>
        <a href="<?php echo Yii::app()->createUrl('pengumuman') ?>">
            <i class="fa fa-soundcloud"></i>
            <span class="title">
                Pengumuman            
            </span>
            <span class="selected">            
            </span>
            <?php
            if ($_SESSION['level'] == "marketing") {
                $j = PengumumanBaca::model()->findAll(array('condition' => 'id_user=' . Yii::app()->user->id . ' and baca = 0'));
                $jmlPengumuman = count($j);
                ?>
                <span class="badge"><?php echo isset($jmlPengumuman) ? $jmlPengumuman : 0; ?></span>
                <?php
            }
            ?>
        </a>    
    </li>
    <?php
    if ($_SESSION['level'] == "marketing") {
        ?>
        <li>
            <a href="<?php echo Yii::app()->createUrl('inquiry') ?>">
                <i class="fa fa-shopping-cart"></i>
                <span class="title">
                    Inquiry            
                </span>
                <span class="selected">            
                </span>        
            </a>    
        </li>
        <li>
            <a href="<?php echo Yii::app()->createUrl('quotation') ?>">
                <i class="fa fa-adn"></i>
                <span class="title">
                    Quotation            
                </span>
                <span class="selected">            
                </span>        
            </a>    
        </li>
        <?php
    }
    ?>
    <?php
//    if ($_SESSION['level'] == "admin") {
    if ($_SESSION['level'] == "marketing") {
        $proses = So::model()->with('Quotation.Inquiry')->findAll(array('condition' => 't.status="proses" and Inquiry.id_marketing=' . Yii::app()->user->id));
        $accept = Po::model()->findAll(array('condition' => 'status="Approve" and id_marketing=' . Yii::app()->user->id));
        $reject = Po::model()->findAll(array('condition' => 'status="Reject" and id_marketing=' . Yii::app()->user->id));
    } else {
        $proses = So::model()->findAll(array('condition' => 'status="proses"'));
        $accept = Po::model()->findAll(array('condition' => 'status="Approve"'));
        $reject = Po::model()->findAll(array('condition' => 'status="Reject"'));
    }
    ?>
    <li>
        <a href="">
            <i class="fa fa-user-md"></i>
            <span class="title">
                Sales Order              
            </span>
            <span class="arrow">                
            </span> 
        </a>
        <ul class="sub-menu">
            <li>
                <a href="<?php echo Yii::app()->createUrl('so/proses') ?>">
                    Proses <span class="badge"><?php echo count($proses) ?></span>                  
                </a> 
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('po/approve') ?>">
                    Approve <span class="badge"><?php echo count($accept) ?></span>                   
                </a> 
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('po/reject') ?>">
                    Reject <span class="badge"><?php echo count($reject) ?></span>                   
                </a> 
            </li>
        </ul>
    </li>
    <?php
    if ($_SESSION['level'] == "marketing") {
        $invoiceProses = Po::model()->findAll(array('condition' => 'invoice=0 and id_marketing=' . Yii::app()->user->id));
        $invoiceApprove = Invoice::model()->with('Po')->findAll(array('condition' => 'Po.id_marketing=' . Yii::app()->user->id));
    } else {
        $invoiceApprove = Invoice::model()->findAll();
        $invoiceProses = Po::model()->findAll(array('condition' => 'invoice=0'));
    }
    ?>
    <li>
        <a href="">
            <i class="fa fa-tags"></i>
            <span class="title">
                Invoice              
            </span>
            <span class="arrow">                
            </span> 
        </a>
        <ul class="sub-menu">
            <li>
                <a href="<?php echo Yii::app()->createUrl('po/invoice') ?>">
                    Proses <span class="badge"><?php echo count($invoiceProses) ?></span>                  
                </a> 
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('invoice') ?>">
                    Approve <span class="badge"><?php echo count($invoiceApprove) ?></span>                   
                </a> 
            </li>
        </ul>
    </li>
    <li>
        <a href="<?php echo Yii::app()->createUrl('delivery') ?>">
            <i class="fa fa-truck"></i>
            <span class="title">
                Delivery Order            
            </span>
            <span class="selected">            
            </span>        
        </a>    
    </li>
</ul>
