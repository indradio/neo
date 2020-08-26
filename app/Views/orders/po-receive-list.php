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
                                        <th>Quote Num</th>
                                        <th>Quote Date</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Amount</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Quote Num</th>
                                        <th>Quote Date</th>
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
                                        <td><?= $row->quote_id; ?></td>
                                        <td><?= date('d M Y', strtotime($row->quote_date)); ?></td>
                                        <td><?= $row->user_name; ?></td>
                                        <td><?= $row->user_company_id; ?></td>
                                        <td><?= number_format($row->grandtotal, 0, '.', ','); ?></td>
                                        <td class="text-right">
                                           <a href="#" data-toggle="modal" data-target="#popNext" data-order_id="<?= $row->id; ?>" class="btn btn-outline btn-wd btn-info">PO RECEIVING</a>
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

            $('#popNext').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var order_id = button.data('order_id')
            var modal = $(this)
            modal.find('.modal-body input[name="order_id"]').val(order_id)
            })  
        });
    </script>
<?php $this->endSection('');?>