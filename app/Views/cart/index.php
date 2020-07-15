<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-big-boy">
                    <div class="card-header ">
                        <h4 class="card-title">Troli</h4>
                        <p class="card-category">A table for content management</p>
                        <br />
                    </div>
                    <div class="card-body table-full-width">
                        <div class="table-responsive">
                            <table class="table table-bigboy">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="th-description">Deskripsi</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Sub Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                
                                $db = \Config\Database::connect();
                                $builder = $db->table('parts');
                                $grandTotal = 0;
                                
                                foreach ($parts->getResult() as $row) { 
                                $query = $builder->where(['id' => $row->id])->get(); 
                                $part = $query->getRow();        
                                $subTotal = $part->price * $row->order_qty;
                                $grandTotal = $grandTotal + $subTotal;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="img-container" style="width:200px; height:100%;">
                                                <img src="<?= base_url(); ?>/assets/img/materials/<?= $row->name; ?>.jpg" alt="...">
                                            </div>
                                        </td>
                                        <td class="td-name">
                                            <?= $row->description; ?>
                                            </br><small><?= $row->name; ?></small>
                                        </td>
                                        <td class="td-number"><?= number_format($part->price, 0, '.', ','); ?></td>
                                        <td class="td-number">
                                        <?= $row->order_qty; ?> 
                                            <button type="button" rel="tooltip" data-placement="top" title="Update Qty" class="btn btn-success btn-lg btn-link btn-icon mt-1" data-toggle="modal" data-target="#addCart" data-id="<?= $row->id; ?>" data-name="<?= $row->name; ?>" data-description="<?= $row->description; ?>" data-order_qty="<?= $row->order_qty; ?>" data-qty="Tersedia <?= intval($part->qty).' '. $part->uom; ?>" data-img="<?= base_url(); ?>/assets/img/materials/<?= $row->name; ?>.jpg">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                        <td class="td-number"><?= number_format($subTotal, 0, '.', ','); ?></td>
                                        <td class="td-actions">
                                            <button type="button" rel="tooltip" data-placement="left" title="View Post" class="btn btn-info btn-link btn-icon mt-4">
                                                <i class="fa fa-image"></i>
                                            </button>
                                            <button type="button" rel="tooltip" data-placement="left" title="Edit Post" class="btn btn-success btn-link btn-icon mt-2">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" rel="tooltip" data-placement="left" title="Remove Post" class="btn btn-danger btn-link btn-icon mt-2" data-toggle="modal" data-target="#delCart" data-id="<?= $row->id; ?>" data-header="Anda yakin akan membatalkan komponen </br><?= $row->description; ?> ?">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="td-name text-right"><h4>TOTAL</h4></td>
                                        <td class="td-name text-right"><h4><?= number_format($grandTotal, 0, '.', ','); ?></h4></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right mr-3">
                        <a href="<?= base_url(); ?>" class="btn btn-link">Kembali ke Dashboard</a>
                        <?php if ($countParts>0) {?>
                            <a href="<?= base_url('cart/checkout'); ?>" class="btn btn-round btn-wd btn-primary">Checkout</a>
                        <?php } ?>
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
                            <h5 class="card-title" id="partDesc"></h5>
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
            <button type="submit" class="btn btn-wd btn-primary">YA!</button>
            <button type="button" class="btn btn-wd btn-danger ml-1" data-dismiss="modal">TIDAK</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->endSection('');?>

<?php $this->section('javascript');?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#addCart').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var description = button.data('description')
            var qty = button.data('qty')
            var order_qty = button.data('order_qty')
            var img = button.data('img')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="order_qty"]').val(order_qty)
            $(".modal-body #img").attr("src", img);
            document.getElementById("addCartTitle").innerHTML = name;
            document.getElementById("partDesc").innerHTML = description;
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