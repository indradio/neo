<?php $this->extend('layouts/template');?>
<?php $this->section('content');?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title"><?= $part['description'];?></h4>
                        <p class="card-category"><?= $part['part']; ?></p>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="card-img-top" src="<?= base_url(); ?>/assets/img/materials/<?= $part['part']; ?>.jpg" alt="...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 ml-auto mr-auto">
                                <div class="card">
                                <h5 class="card-header">Featured</h5>
                                    <div class="card-body">
                                        <h5 class="card-title">Special title treatment</h5>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <p class="card-text"><small class="text-muted">Tersedia <?= $part['qty'].' '.$part['uom']; ?> </small></p>
                                        <a href="#" class="btn btn-outline btn-wd btn-primary mt-2" data-toggle="modal" data-target="#addCart"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection('');?>