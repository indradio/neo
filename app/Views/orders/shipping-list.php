<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PO Num</th>
                                        <th>PO Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>PO Num</th>
                                        <th>PO Date</th>
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
                                        foreach ($orders->getResult() as $row) { 
                                            $status = $builder->where(['id' => $row->status])->get()->getRow(); 
                                    ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= $row->po_id; ?></td>
                                        <td><?= date('d M Y', strtotime($row->po_date)); ?></td>
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
<div class="modal fade" id="modalProcess" tabindex="-1" role="dialog" aria-labelledby="modalProcessTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProcessTitle">Modal title</h5>
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
                order: [[ 0, "desc" ]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }

            });

            var table = $('#datatables').DataTable();

            $('#modalProcess').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('order_id')
            var header = button.data('header')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            document.getElementById("modalProcessTitle").innerHTML = header;
            })  
        });
    </script>
<?php $this->endSection('');?>