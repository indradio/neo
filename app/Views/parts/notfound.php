<?php $this->extend('layouts/template');?>
<?php $this->section('content');?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title"></h4>
                        <p class="card-category"></p>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12 ml-auto mr-auto">
                            <form id="TypeValidation" class="form-horizontal" action="<?= base_url(); ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="card text-center">
                                    <h5 class="card-header">Maaf</h5>
                                    <div class="card-body">
                                        <p class="card-text"><i>Part yang anda cari tidak ditemukan.</i></p>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-outline btn-wd btn-primary"><span class="btn-label">Kembali</span></button>
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