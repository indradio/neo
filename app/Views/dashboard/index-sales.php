<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row" hidden>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-light-3 text-success"></i>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="numbers">
                                    <p class="card-category">Pesanan Baru</p>
                                    <h4 class="card-title"><?= $countNewOrders; ?> Pesanan</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar-o"></i> Last day
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-tag-content text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="numbers">
                                    <p class="card-category">Penawaran Aktif</p>
                                    <h4 class="card-title">3 Penawaran</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i> In the last hour
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-favourite-28 text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="numbers">
                                    <p class="card-category">Favorit</p>
                                    <h4 class="card-title">3 Item</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> Update now
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-paper-2 text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="numbers">
                                    <p class="card-category">Penawaran Aktif</p>
                                    <h4 class="card-title">2 Penawaran</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> Update Now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header ">
                        <h4 class="card-title">New Orders</h4>
                        <p class="card-category">A table for content management</p>
                        <br />
                    </div>
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        $db = \Config\Database::connect();
                                        $builder = $db->table('orders_status');
                                        foreach ($newOrders->getResult() as $row) { 
                                            $status = $builder->where(['id' => $row->status])->get()->getRow(); 
                                    ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= date('d M Y', strtotime($row->date)); ?></td>
                                        <td><?= $row->user_name; ?></td>
                                        <td><?= $row->user_company_id; ?></td>
                                        <td><?= number_format($row->grandtotal, 0, '.', ','); ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('order/request/resume/'.$row->id); ?>" class="btn btn-outline btn-wd btn-info"><?= $status->name; ?></a>
                                        </td>
                                    </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header ">
                        <h4 class="card-title">Waiting Purchase Order</h4>
                        <p class="card-category">A table for content management</p>
                        <br />
                    </div>
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="fresh-datatables">
                            <table id="datatables2" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        foreach ($poReceive->getResult() as $row) { 
                                    ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= date('d M Y', strtotime($row->date)); ?></td>
                                        <td><?= $row->user_name; ?></td>
                                        <td><?= $row->user_company_id; ?></td>
                                        <td><?= number_format($row->grandtotal, 0, '.', ','); ?></td>
                                        <td class="text-right">
                                        <a href="#" data-toggle="modal" data-target="#popNext" data-order_id="<?= $row->id; ?>" class="btn btn-outline btn-wd btn-success">PO RECEIVING</a>
                                        </td>
                                    </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header ">
                        <h4 class="card-title">Ready to Delivery</h4>
                        <p class="card-category">A table for content management</p>
                        <br />
                    </div>
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="fresh-datatables">
                            <table id="datatables3" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        foreach ($shipping->getResult() as $row) { 
                                    ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= date('d M Y', strtotime($row->date)); ?></td>
                                        <td><?= $row->user_name; ?></td>
                                        <td><?= $row->user_company_id; ?></td>
                                        <td><?= number_format($row->grandtotal, 0, '.', ','); ?></td>
                                        <td class="text-right">
                                            <a href="#" data-toggle="modal" data-target="#modalProcess" data-order_id="<?= $row->id; ?>" data-header="#<?= $row->po_id; ?>" class="btn btn-outline btn-wd btn-reddit">DELIVERY</a>
                                        </td>
                                    </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="popNext" tabindex="-1" role="dialog" aria-labelledby="popNextTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title"> Proses selanjutnya?</h5>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('order/requote'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
            <input class="form-control" type="hidden" name="order_id" id="order_id" />
        </div>
        <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-wd btn-warning">REQUOTE</button>
            <a href="<?= base_url('order/receiving/'.$row->id);?>" class="btn btn-wd btn-success ml-2">PO RECEIVE</a>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalProcess" tabindex="-1" role="dialog" aria-labelledby="modalProcessTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProcessTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('order/submit/dn'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="id" id="id" />
            <div class="card-body">
                <div class="row">
                    <label class="col-sm-3 col-form-label">Delvery ID / DN</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="deliveryId" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label">Delvery at</label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input class="form-control datepicker" type="text" name="deliveryDate" placeholder="<?= date('d-m-Y'); ?>" required/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-wd btn-primary">Delivered</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->endSection('');?>

<?php $this->section('javascript');?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });

        $('#datatables2').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });

        $('#datatables3').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });

        var table = $('#datatables').DataTable();
        
        $('#addCart').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var part = button.data('part')
            var description = button.data('description')
            var qty = button.data('qty')
            var img = button.data('img')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            $(".modal-body #img").attr("src", img);
            document.getElementById("addCartTitle").innerHTML = part;
            document.getElementById("partName").innerHTML = description;
            document.getElementById("qty").innerHTML = qty;
        })

        $('#modalProcess').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('order_id')
            var header = button.data('header')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            document.getElementById("modalProcessTitle").innerHTML = header;
            })  
    });

    function setFormValidation(id) {
        $(id).validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                $(element).closest('.form-check').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(element).closest('.form-check').removeClass('has-error').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error).addClass('has-error');
            },
        });
    }

    $(document).ready(function() {
        setFormValidation('#TypeValidation');
    });

</script>
<?php $this->endSection('');?>