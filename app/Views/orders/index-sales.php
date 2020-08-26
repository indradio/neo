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
                                        foreach ($orders->getResult() as $row) { 
                                            $status = $builder->where(['id' => $row->status])->get()->getRow(); 
                                    ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= date('d M Y', strtotime($row->date)); ?></td>
                                        <td><?= $row->user_name; ?></td>
                                        <td><?= $row->user_company_id; ?></td>
                                        <td><?= number_format($row->grandtotal, 0, '.', ','); ?></td>
                                        <td class="text-right">
                                            <?php 
                                            if ($row->status==0){
                                                echo '<a href="#" class="btn btn-outline btn-wd btn-success mt-1">EXPIRED</a>';
                                            }elseif ($row->status==1) {
                                                echo '<a href="'.base_url('order/request/resume/'.$row->id).'" class="btn btn-outline btn-wd btn-info mt-1">'. $status->name.'</a>';
                                            }elseif ($row->status==2) {
                                                echo '<a href="#" class="btn btn-outline btn-wd btn-success mt-1">WAITING PO</a>';
                                            }elseif ($row->status==3) {
                                                echo '<a href="#" data-toggle="modal" data-target="#modalProcess" data-order_id="'. $row->id .'" data-header="#'. $row->po_id.'" class="btn btn-outline btn-wd btn-reddit mt-1">DELIVERY</a>';
                                            }elseif ($row->status==9) {
                                                echo '<a href="'.base_url('quote/order/'.$row->id).'" class="btn btn-outline btn-wd btn-primary mt-1">DELIVERED</a>';
                                            }
                                            ?>
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
<div class="modal fade" id="addCart" tabindex="-1" role="dialog" aria-labelledby="addCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCartTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('cart/update'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="id" id="id" />
            <div class="card border-0" style="max-width: 100%;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                    <img id="img" src="" class="card-img" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" id="partName"></h5>
                            <p class="card-text"></p>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">QTY</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="order_qty" id="order_qty" value="1" number="true" min="1" />
                                    </div>
                                </div>
                            </div>
                            <p class="card-text"><small class="text-muted" id="qty"></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-wd btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="delCart" tabindex="-1" role="dialog" aria-labelledby="delCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title" id="delCartTitle"></h5>
        </button>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('cart/delete'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="id" id="id" />
        </div>
        <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-primary">YA!</button>
            <button type="button" class="btn btn-wd btn-danger ml-1" data-dismiss="modal">TIDAK</button>
        </div>
      </form>
    </div>
  </div>
</div>

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

            $('#addCart').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var part = button.data('part')
                var description = button.data('description')
                var qty = button.data('qty')
                var order_qty = button.data('order_qty')
                var img = button.data('img')
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(id)
                modal.find('.modal-body input[name="order_qty"]').val(order_qty)
                $(".modal-body #img").attr("src", img);
                document.getElementById("addCartTitle").innerHTML = part;
                document.getElementById("partName").innerHTML = description;
                document.getElementById("qty").innerHTML = qty;
            })  
        });

        $(document).ready(function() {
            $('#delCart').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var header = button.data('header')
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(id)
                document.getElementById("delCartTitle").innerHTML = header;
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