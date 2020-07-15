<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-big-boy">
                    <div class="card-header ">
                        <h4 class="card-title">Komponen</h4>
                        <p class="card-category">Parts</p>
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
                                        <th class="text-right">Order Qty</th>
                                        <th class="text-right">Sub Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                
                                $db = \Config\Database::connect();
                                $builder = $db->table('orders_parts');
                                $parts = $builder->where(['order_id' => $orders->id])->get();
                                $outStock = 0;
                                
                                foreach ($parts->getResult() as $row) { 
                                $builder = $db->table('parts');
                                $part = $builder->where(['id' => $row->part_id])->get()->getRow();
                                if ($row->order_qty>$part->qty){$outStock++;}
                                ?>
                                    <tr>
                                        <td>
                                            <div class="img-container" style="width:200px; height:100%;">
                                                <img src="<?= base_url(); ?>/assets/img/materials/<?= $row->part_name; ?>.jpg" alt="...">
                                            </div>
                                        </td>
                                        <td class="td-name">
                                        <?= $outStock; ?> 
                                            <?= $row->part_description; ?>
                                            </br><small><?= $row->part_name; ?></small>
                                        </td>
                                        <td class="td-number">
                                            <?= number_format($row->part_price, 0, '.', ','); ?>
                                            <button type="button" rel="tooltip" data-placement="right" title="Update Harga" class="btn btn-success btn-lg btn-link btn-icon mt-1" data-toggle="modal" data-target="#updatePrice" data-order_id="<?= $row->order_id; ?>" data-disc="<?= $orders->discount_percent; ?>" data-part_id="<?= $row->part_id; ?>" data-old_price="<?= number_format($row->part_price, 0, '.', ','); ?>" data-new_price="<?= number_format($part->price, 0, '.', ','); ?>" data-price="<?= $row->part_price; ?>" data-name="<?= $row->part_name; ?>" data-description="<?= $row->part_description; ?>" data-order_qty="<?= $row->order_qty; ?>" data-img="<?= base_url(); ?>/assets/img/materials/<?= $row->part_name; ?>.jpg">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                        <td class="td-number">
                                            <?= $row->order_qty; ?> 
                                            <button type="button" rel="tooltip" data-placement="right" title="Tambah/Kurang" class="btn btn-success btn-lg btn-link btn-icon mt-1" data-toggle="modal" data-target="#updateQty" data-order_id="<?= $row->order_id; ?>" data-disc="<?= $orders->discount_percent; ?>" data-part_id="<?= $row->part_id; ?>" data-price="<?= $row->part_price; ?>" data-name="<?= $row->part_name; ?>" data-description="<?= $row->part_description; ?>" data-order_qty="<?= $row->order_qty; ?>" data-qty="Tersedia <?= intval($part->qty).' '. $part->uom; ?>" data-img="<?= base_url(); ?>/assets/img/materials/<?= $row->part_name; ?>.jpg">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <?php if ($row->order_qty>$part->qty) {?>
                                                </br><a href="#" class="badge badge-round badge-danger">Out of Stock</a>
                                            <?php } ?>
                                            </br>Tersedia <?= intval($part->qty).' '.$part->uom; ?> 
                                        </td>
                                        <td class="td-number"><?= number_format($row->subtotal, 0, '.', ','); ?>
                                            <button type="button" rel="tooltip" data-placement="right" title="Delete" class="btn btn-danger btn-lg btn-link btn-icon mt-1" data-toggle="modal" data-target="#delCart" data-order_id="<?= $row->order_id; ?>" data-disc="<?= $orders->discount_percent; ?>" data-part_id="<?= $row->part_id; ?>" data-header="Anda yakin akan membatalkan komponen </br><?= $row->part_description; ?> ?">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                        <td class="td-actions"></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="td-name text-right"><h4>TOTAL</h4></td>
                                        <td class="td-name text-right"><h4><?= number_format($orders->total, 0, '.', ','); ?></h4></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form id="FrResume" class="form-horizontal" action="<?= base_url('order/discount'); ?>" method="post">
                            <input class="form-control" type="hidden" name="id" value="<?= $orders->id;?>" readonly/>
                            <div class="row ml-auto">
                                <label class="col-sm-8 col-form-label text-right">TOTAL (IDR)</label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="total" value="<?= number_format($orders->total, 0, '.', ',');?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row ml-auto">
                                <label class="col-sm-8 col-form-label text-right">DISCOUNT (%)</label>
                                <div class="col-sm-4">
                                    <div class="form-group input-group mb-1">
                                        <input class="form-control" type="number" name="discount_percent" value="<?= $orders->discount_percent;?>" range="[0,100]" required/>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ml-auto">
                                <label class="col-sm-8 col-form-label text-right">DISCOUNT (IDR)</label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="discount_amount" value="<?= number_format($orders->discount_amount, 0, '.', ',');?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row ml-auto">
                                <label class="col-sm-8 col-form-label text-right">TOTAL AFTER DISCOUNT (IDR)</label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="totalaftdisc" value="<?= number_format($orders->total - $orders->discount_amount, 0, '.', ',');?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row ml-auto">
                                <label class="col-sm-8 col-form-label text-right">VAT <?= $orders->vat_percent;?>%</label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="vat_amount" value="<?= number_format($orders->vat_amount, 0, '.', ',');?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row ml-auto">
                                <label class="col-sm-8 col-form-label text-right">GRAND TOTAL (IDR)</label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="grandtotal" value="<?= number_format($orders->grandtotal, 0, '.', ',');?>" readonly/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-right mr-1">
                        <a href="<?= base_url('/order/request/'); ?>" class="btn btn-link">Kembali</a>
                        <?php if ($outStock==0) {?>
                            <a href="<?= base_url('/order/request/quote/'.$orders->id); ?>" class="btn btn-round btn-wd btn-primary">Selanjutnya
                                <span class="btn-label btn-label-right ml-2">
                                    <i class="fa fa-arrow-right"></i>
                                </span>
                            </a>
                        <?php }else{ ?>
                            <a href="#" class="btn btn-round btn-wd btn-danger">Out of Stock</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="updatePrice" tabindex="-1" role="dialog" aria-labelledby="updatePriceTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatePriceTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="FrUpdatePrice" class="form-horizontal" action="<?= base_url('order/update_price'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="order_id" id="order_id" />
        <input class="form-control" type="hidden" name="part_id" id="part_id" />
        <input class="form-control" type="hidden" name="order_qty" id="order_qty" />
        <input class="form-control" type="hidden" name="disc" id="disc" />
            <div class="card border-0" style="max-width: 100%;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                    <img id="img" src="" class="card-img" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" id="partDescPrice"></h5>
                            <p class="card-text"></p>
                            <div class="row">
                                <label class="col-sm-4 col-form-label">Harga (Rp)</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="new_price" id="new_price" number="true" min="1" autofocus />
                                    </div>
                                </div>
                            </div>
                            <p class="card-text"><small class="text-muted" id="beforePrice"></small></p>
                            <p class="card-text"><small class="text-muted" id="partPrice"></small></p>
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

<div class="modal fade" id="updateQty" tabindex="-1" role="dialog" aria-labelledby="updateQtyTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateQtyTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="FrUpdateQty" class="form-horizontal" action="<?= base_url('order/update_qty'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="order_id" id="order_id" />
        <input class="form-control" type="hidden" name="part_id" id="part_id" />
        <input class="form-control" type="hidden" name="price" id="price" />
        <input class="form-control" type="hidden" name="disc" id="disc" />
            <div class="card border-0" style="max-width: 100%;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                    <img id="img" src="" class="card-img" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" id="partDescQty"></h5>
                            <p class="card-text"></p>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">QTY</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="order_qty" id="order_qty" value="1" number="true" min="1" autofocus />
                                    </div>
                                </div>
                            </div>
                            <p class="card-text"><small class="text-muted" id="partQty"></small></p>
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
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('order/delete_part'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="order_id" id="order_id" />
        <input class="form-control" type="hidden" name="part_id" id="part_id" />
        <input class="form-control" type="hidden" name="disc" id="disc" />
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
        $('#updateQty').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var order_id = button.data('order_id')
            var disc = button.data('disc')
            var part_id = button.data('part_id')
            var price = button.data('price')
            var name = button.data('name')
            var description = button.data('description')
            var qty = button.data('qty')
            var order_qty = button.data('order_qty')
            var img = button.data('img')
            var modal = $(this)
            modal.find('.modal-body input[name="order_id"]').val(order_id)
            modal.find('.modal-body input[name="part_id"]').val(part_id)
            modal.find('.modal-body input[name="price"]').val(price)
            modal.find('.modal-body input[name="order_qty"]').val(order_qty)
            modal.find('.modal-body input[name="disc"]').val(disc)
            $(".modal-body #img").attr("src", img);
            document.getElementById("updateQtyTitle").innerHTML = name;
            document.getElementById("partDescQty").innerHTML = description;
            document.getElementById("partQty").innerHTML = qty;
        })  

        $('#updatePrice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var order_id = button.data('order_id')
            var disc = button.data('disc')
            var part_id = button.data('part_id')
            var price = button.data('price')
            var old_price = button.data('old_price')
            var new_price = button.data('new_price')
            var name = button.data('name')
            var description = button.data('description')
            var order_qty = button.data('order_qty')
            var img = button.data('img')
            var modal = $(this)
            modal.find('.modal-body input[name="order_id"]').val(order_id)
            modal.find('.modal-body input[name="part_id"]').val(part_id)
            modal.find('.modal-body input[name="order_qty"]').val(order_qty)
            modal.find('.modal-body input[name="new_price"]').val(price)
            modal.find('.modal-body input[name="disc"]').val(disc)
            $(".modal-body #img").attr("src", img);
            document.getElementById("updatePriceTitle").innerHTML = name;
            document.getElementById("partDescPrice").innerHTML = description;
            document.getElementById("beforePrice").innerHTML = 'Harga sebelumnya Rp '+old_price;
            document.getElementById("partPrice").innerHTML = 'Harga normal Rp '+new_price;
        })  
   
        $('#delCart').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var order_id = button.data('order_id')
            var disc = button.data('disc')
            var part_id = button.data('part_id')
            var header = button.data('header')
            var modal = $(this)
            modal.find('.modal-body input[name="order_id"]').val(order_id)
            modal.find('.modal-body input[name="part_id"]').val(part_id)
            modal.find('.modal-body input[name="disc"]').val(disc)
            document.getElementById("delCartTitle").innerHTML = header;
        })  
    });

    // function setFormValidation(id) {
    //     $(id).validate({
    //         highlight: function(element) {
    //             $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    //             $(element).closest('.form-check').removeClass('has-success').addClass('has-error');
    //         },
    //         success: function(element) {
    //             $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    //             $(element).closest('.form-check').removeClass('has-error').addClass('has-success');
    //         },
    //         errorPlacement: function(error, element) {
    //             $(element).closest('.form-group').append(error).addClass('has-error');
    //         },
    //     });
    // }

    $(document).ready(function() {
        setFormValidation('#FrResume');
        setFormValidation('#FrUpdateQty');
        setFormValidation('#FrUpdatePrice');
    });
</script>
<?php $this->endSection('');?>