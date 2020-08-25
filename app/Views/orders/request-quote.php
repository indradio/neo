<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form id="RangeValidation" class="form-horizontal" action="<?= base_url('order/submit/quote'); ?>" method="post" enctype="multipart/form-data">
                    <input class="form-control" type="hidden" name="id" value="<?= $orders->id;?>" readonly/>
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Quotation</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Quote ID</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="quoteId" placeholder="<?= date('Y/m/').'QUO/XXX'; ?>" required/>
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>*Wajib</code>
                                </label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Create Date a Quote</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control datepicker" type="text" name="quoteDate" placeholder="<?= date('d-m-Y'); ?>" required/>
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>*Wajib</code>
                                </label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Expired Date a Quote</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control datepicker" type="text" name="quoteExpired" placeholder="<?= date('d-m-Y'); ?>" required/>
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>*Wajib</code>
                                </label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">UPLOAD A QUOTE</label>
                                <div class="col-sm-7">
                                    <div class="form-group custom-file">
                                        <input type="file" class="form-control" id="quoteFile" name="quoteFile" required/>
                                        <!-- <label class="btn btn-outline btn-success custom-file-label" for="quoteFile">Choose file</label> -->
                                    </div>
                                </div>
                                <label class="col-sm-3 label-on-right">
                                    <code>*Wajib</code>
                                </label>
                            </div>
                        </div>
                        <div class="card-header ">
                            <h4 class="card-title">Terms and Conditions</h4>
                        </div>
                            <div class="card-body ">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Sales By</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="sales_by" value="<?= session()->get('name'); ?>" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Terms and Condition</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="terms" value="Contained in a Quotation File." disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                            <a href="<?= base_url('/order/request/resume/'.$orders->id); ?>" class="btn btn-link">Kembali</a>
                            <button type="submit" class="btn btn-round btn-wd btn-primary">Submit a Quotation
                                <span class="btn-label btn-label-right ml-2">
                                    <i class="fa fa-arrow-up"></i>
                                </span>
                            </button>
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