<?php $this->extend('layouts/template');?>
<?php $this->section('content');?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title"><?= $part['description'];?></h4>
                        <p class="card-category"><?= $part['name']; ?></p>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="card-img-top" src="<?= base_url(); ?>/assets/img/parts/<?= $part['photo']; ?>" alt="...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 ml-auto mr-auto">
                            <form id="TypeValidation" class="form-horizontal" action="<?= base_url('cart/add'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <input class="form-control" type="hidden" name="id" id="id" value="<?= $part['id']; ?>" />
                                <div class="card">
                                    <h5 class="card-header">Deskripsi</h5>
                                    <div class="card-body">
                                        <!-- <h5 class="card-title">Special title treatment</h5> -->
                                        <p class="card-text"><i>Tidak ada deskripsi untuk part ini.</i></p>
                                        <?php if ($part['discount']>0){ ?>
                                            <div class="card-text text-danger d-inline-block"><strike>Rp <?= number_format($part['high_price'], 0, '.', ','); ?></strike></div>
                                            <a class="badge badge-success text-light"><?= $part['discount']; ?>%</a>
                                            <h3 class="card-text">Rp <?= number_format($part['price'], 0, '.', ','); ?></h3>
                                        <?php }elseif ($part['price']==0) { ?>
                                            <h3 class="card-text">Rp - </h3>
                                            <a class="btn btn-sm btn-primary text-light mb-3">Hubungi Sales</a>
                                        <?php }else{ ?>
                                            <h3 class="card-text">Rp <?= number_format($part['price'], 0, '.', ','); ?></h3>
                                        <?php } ?>
                                        <div class="row">
                                            <label class="col-sm-1 col-form-label">QTY</label>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="order_qty" id="order_qty" value="1" number="true" min="1" required/>
                                                <p class="card-text"><small class="text-muted">Tersedia <?= intval($part['qty']).' '.$part['uom']; ?> </small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-outline btn-wd btn-primary"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection('');?>

<?php $this->section('javascript');?>
<script type="text/javascript">
    $(document).ready(function() {
        setFormValidation('#TypeValidation');
    });
</script>
<?php $this->endSection('');?>