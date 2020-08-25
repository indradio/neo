<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form id="RangeValidation" class="form-horizontal" action="<?= base_url('order/submit/po'); ?>" method="post" enctype="multipart/form-data">
                    <input class="form-control" type="hidden" name="id" value="<?= $orders->id;?>" readonly/>
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Purchase Order Receiving</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">PO ID/Num</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="poId" placeholder="Contoh : <?= date('Y/m/').'PO/XXX'; ?>" required/>
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>*Wajib</code>
                                </label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Date of PO</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control datepicker" type="text" name="poDate" placeholder="<?= date('d-m-Y'); ?>" required/>
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>*Wajib</code>
                                </label>
                            </div>
                            <!-- <div class="row">
                                <label class="col-sm-2 col-form-label">Expired Date a Quote</label>
                                <div class="col-sm-7">
                                    <div class="form-group input-group">
                                        <input class="form-control datepicker" type="text" name="quoteExpired" placeholder="<?= date('d-m-Y'); ?>" required/>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>*Wajib</code>
                                </label>
                            </div> -->
                            <div class="row">
                                <label class="col-sm-2 col-form-label">UPLOAD A PO</label>
                                <div class="col-sm-7">
                                    <div class="form-group custom-file">
                                        <input type="file" class="form-control" id="quoteFile" name="quoteFile" disabled="true"/>
                                        <!-- <label class="btn btn-outline btn-success custom-file-label" for="quoteFile">Choose file</label> -->
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <!-- <code>*Wajib</code> -->
                                </label>
                            </div>
                            <div class="card-footer text-center">
                            <a href="<?= base_url('/order/receive/'.$orders->id); ?>" class="btn btn-link">Kembali</a>
                            <button type="submit" class="btn btn-round btn-wd btn-primary">RECEIVED</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<?php $this->endSection('');?>

<?php $this->section('javascript');?>
    <script type="text/javascript">

    $(document).ready(function() {
        setFormValidation('#RangeValidation');
    });
    </script>
<?php $this->endSection('');?>