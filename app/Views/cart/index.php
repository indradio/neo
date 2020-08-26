<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card table-big-boy">
                    <div class="card-header ">
                        <h4 class="card-title">Troli</h4>
                        <p class="card-category">Siap untuk anda borong</p>
                        <br />
                    </div>
                    <div class="card-body table-full-width">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="th-description">Deskripsi</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                
                                $db = \Config\Database::connect();
                                $builder = $db->table('parts');
                                $grandTotal = 0;
                                $outStock = 0;
                                
                                foreach ($parts->getResult() as $row) { 
                                $query = $builder->where(['id' => $row->id])->get(); 
                                $part = $query->getRow();
                                if (empty($part)){
                                    $qty = 0;
                                    $price = 0;
                                    $photo = 'soldout.jpg';
                                }else{
                                    $qty = $part->qty;
                                    $price = $part->price;
                                    $photo = $part->photo;
                                }
                                $subTotal = $price * $row->order_qty;
                                $grandTotal = $grandTotal + $subTotal;
                                if ($row->order_qty>$qty){$outStock++;}
                                ?>
                                    <tr>
                                        <td>
                                            <div class="img-container" style="width:100px; height:100%;">
                                                <img src="<?= base_url(); ?>/assets/img/parts/<?= $photo; ?>" alt="...">
                                            </div>
                                        </td>
                                        <td class="td-name">
                                            <?= $row->description; ?>
                                            </br><small><?= $row->name; ?></small>
                                        </td>
                                        <?php if ($price==0){ ?>
                                            <td class="td-number"><a href="#" class="btn btn-round btn-sm btn-primary">Hubungi Sales</a></td>
                                        <?php }else{ ?>
                                            <td class="td-number"><?= number_format($price, 0, '.', ','); ?>
                                            <?php if ($part->discount>0){
                                                $selisih = $part->high_price - $part->price; 
                                            ?>
                                                </br><a class="card-text text-danger d-inline-block"><small><strike>Rp <?= number_format($part->high_price, 0, '.', ','); ?></strike></small></a>
                                                   <a class="badge badge-success text-light">Hemat Rp <?= number_format($selisih, 0, '.', ','); ?></a>
                                            <?php } ?>
                                            </td>
                                        <?php } ?>
                                        <td class="td-number">
                                        <?= $row->order_qty; ?> 
                                            <button type="button" rel="tooltip" data-placement="top" title="Update Qty" class="btn btn-success btn-lg btn-link btn-icon mt-1" data-toggle="modal" data-target="#updateCart" data-id="<?= $row->id; ?>" data-name="<?= $row->name; ?>" data-description="<?= $row->description; ?>" data-order_qty="<?= $row->order_qty; ?>" data-qty="Tersedia <?= intval($qty).' '. $row->uom; ?>" data-img="<?= base_url(); ?>/assets/img/materials/<?= $row->name; ?>.jpg">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <?php if ($row->order_qty>$qty) {
                                                echo '</br><a href="#" class="badge badge-round badge-danger">Out of Stock</a>';
                                                if ($qty>0){ 
                                                    echo '</br><small>Sisa '. intval($qty).' '.$part->uom.' Lagi nih</small>';
                                                }else{
                                                    echo '</br><small>Maaf, Stock sudah habis</small>';
                                                }
                                            } ?>
                                        </td>
                                        <td class="td-number">
                                            <?= number_format($subTotal, 0, '.', ','); ?>
                                            <button type="button" rel="tooltip" data-placement="left" title="Remove Part" class="btn btn-danger btn-lg btn-link btn-icon mt-1" data-toggle="modal" data-target="#delCart" data-id="<?= $row->id; ?>" data-header="Anda yakin akan membatalkan komponen </br><?= $row->description; ?> ?">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body ">
                        <a class="card-text">TOTAL</a>
                        <a class="card-text"><h3>Rp <?= number_format($grandTotal, 0, '.', ','); ?></h3></a>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <?php if ($outStock > 0) {
                            echo '<a href="#" class="btn btn-round btn-wd btn-danger">Out of Stock</a>';
                        }elseif ($countParts > 0 and $outStock == 0) { ?>
                            <form id="#" class="form-horizontal mt-2" action="<?= base_url('cart/checkout'); ?>" method="post">
                                <input class="form-control" type="hidden" name="everythingOk" value="OK" />
                                <button type="submit" class="btn btn-lg btn-wd btn-fill btn-primary form-control" style="background-color:#447df7; color:#fff7fd; height: 55px; font-size: 1.4rem;">Checkout</button>
                            </form>
                            <!-- <a href="'. base_url('cart/checkout'). '" class="btn btn-round btn-wd btn-primary">Checkout</a>'; -->
                        <?php }else{
                            echo '<button type="submit" class="btn btn-lg btn-wd btn-fill btn-default form-control disabled" style="background-color:#f1f1f1; color:#212529; height: 55px; font-size: 1.4rem;">Checkout</button>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header ">
                        <h4 class="card-title">Parts Favorite</h4>
                        <p class="card-category">Buruan sikat, sebelum kehabisan part.</p>
                    </div>
                    <div class="card-body table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="fresh-datatables">
                            <table id="dt" class="table table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr></tr>
                                </thead>    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="updateCart" tabindex="-1" role="dialog" aria-labelledby="updateCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCartTitle">Modal title</h5>
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
                                        <input class="form-control" type="number" name="order_qty" id="order_qty" value="1" number="true" min="1" required/>
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

<div class="modal fade" id="addCart" tabindex="-1" role="dialog" aria-labelledby="addCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCartTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="AddValidation" class="form-horizontal" action="<?= base_url('cart/add'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="id" />
        <input class="form-control" type="hidden" name="cart" value="cart" />
            <div class="card border-0" style="max-width: 100%;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img id="addimg" src="" class="card-img" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" id="addpartDesc"></h5>
                            <p class="card-text"></p>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">QTY</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="order_qty" id="order_qty" value="1" number="true" min="1" required/>
                                        <p class="card-text"><small class="text-muted" id="qty"></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-wd btn-primary">Tambahkan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $this->endSection('');?>

<?php $this->section('javascript');?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#updateCart').on('show.bs.modal', function(event) {
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
            document.getElementById("updateCartTitle").innerHTML = name;
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

    $(document).ready(function() {
        $("#dt thead").hide();
        $('#dt').DataTable({
            "pagingType": "full_numbers",
                   "dom": 'lrtip',
            // "lengthMenu": [
            //     [25, 50, 100,-1],
            //     [25, 50, 100, "All"]
            // ],
            lengthChange: false,
            displayLength: 6,
            language: {
                // search: "_INPUT_",
                // searchPlaceholder: "Search records",
                zeroRecords: "Oops! Anda belum punya part favorit.",
            },
            ajax: {
                    "url": "<?= site_url('parts/partFav') ?>",
                    "type": "POST"
                },
         responsive: true,
              bInfo: false,
        deferRender: true,
         processing: true,
            columns: [
                {
                    render: function (data, type, row, meta) { 
                        if (row.soldout==1){
                            var html =
                            '<a href="<?= base_url(); ?>/parts/item/'+row.id+'">'+
                            '  <img src="<?= base_url(); ?>/assets/img/parts/'+row.photo+'" class="card-img-top" />'+
                            '  <div class="card-body mb-5">'+
                            '    <h5 class="card-title">'+row.description+'</h5>'+
                            '    <div class="card-text text-muted mb-3"><small>'+row.name+'</small></div>'+
                            // '    <div class="card-text">Rp '+price+'</div>'+
                            '  </div>'+
                            '  <div class="card-footer" style="position: absolute; left:8%; bottom:0;">'+
                            '    <a href="#" class="btn btn-fill btn-wd btn-danger"><span class="btn-label">Sold Out <i class="fa fa-close"></i></span></a>'+
                            '  </div>'+
                            '</a>';
                        }else{

                            var crncy = row.price;
                            var high_crncy = row.high_price;
            
                            var	reverse = crncy.toString().split('').reverse().join(''),
                                price 	= reverse.match(/\d{1,3}/g);
                                price	= price.join('.').split('').reverse().join('');

                            var	reverse = high_crncy.toString().split('').reverse().join(''),
                                high_price 	= reverse.match(/\d{1,3}/g);
                                high_price	= high_price.join('.').split('').reverse().join('');

                            if (row.discount>0){ 
                                var html =
                                '<a href="<?= base_url(); ?>/parts/item/'+row.id+'">'+
                                '  <img src="<?= base_url(); ?>/assets/img/parts/'+row.photo+'" class="card-img-top" />'+
                                '  <div class="card-body mb-5">'+
                                '    <h5 class="card-title">'+row.description+'</h5>'+
                                '    <div class="card-text text-muted"><small>'+row.name+'</small></div>'+
                                '    <div class="card-text text-danger d-inline-block"><strike>Rp '+high_price+'</strike></div>'+
                                '    <a class="badge badge-success text-light">-'+row.discount+'%</a>'+
                                '    <h5 class="card-text text-dark">Rp '+price+'</h5>'+
                                '  </div>'+
                                '  <div class="card-footer" style="position: absolute; left:8%; bottom:0;">'+
                                '    <a href="#" class="btn btn-outline btn-wd btn-primary d-inline-block" data-toggle="modal" data-target="#addCart" data-id="'+row.id+'" data-name="'+row.name+'" data-description="'+row.description+'" data-qty="Tersedia '+parseInt(row.qty)+' '+row.uom+'" data-img="<?= base_url(); ?>/assets/img/parts/'+row.photo+'"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
                                '  </div>'+
                                '</a>';
                            }else if (row.price==0){ 
                                var html =
                                '<a href="<?= base_url(); ?>/parts/item/'+row.id+'">'+
                                '  <img src="<?= base_url(); ?>/assets/img/parts/'+row.photo+'" class="card-img-top" />'+
                                '  <div class="card-body mb-5">'+
                                '    <h5 class="card-title">'+row.description+'</h5>'+
                                '    <div class="card-text text-muted"><small>'+row.name+'</small></div>'+
                                '    <h5 class="card-text text-dark">Rp - </h5>'+
                                '    <a class="badge badge-primary text-light mb-3">Hubungi Sales</a></br>'+
                                '  </div>'+
                                '  <div class="card-footer" style="position: absolute; left:8%; bottom:0;">'+
                                '    <a href="#" class="btn btn-outline btn-wd btn-primary d-inline-block" data-toggle="modal" data-target="#addCart" data-id="'+row.id+'" data-name="'+row.name+'" data-description="'+row.description+'" data-qty="Tersedia '+parseInt(row.qty)+' '+row.uom+'" data-img="<?= base_url(); ?>/assets/img/parts/'+row.photo+'"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
                                '  </div>'+
                                '</a>';
                            }else{
                                var html =
                                '<a href="<?= base_url(); ?>/parts/item/'+row.id+'">'+
                                '  <img src="<?= base_url(); ?>/assets/img/parts/'+row.photo+'" class="card-img-top" />'+
                                '  <div class="card-body mb-5">'+
                                '    <h5 class="card-title">'+row.description+'</h5>'+
                                '    <div class="card-text text-muted"><small>'+row.name+'</small></div>'+
                                '    <h5 class="card-text text-dark mb-3">Rp '+price+'</h5>'+
                                '  </div>'+
                                '  <div class="card-footer" style="position: absolute; left:8%; bottom:0;">'+
                                '    <a href="#" class="btn btn-outline btn-wd btn-primary d-inline-block" data-toggle="modal" data-target="#addCart" data-id="'+row.id+'" data-name="'+row.name+'" data-description="'+row.description+'" data-qty="Tersedia '+parseInt(row.qty)+' '+row.uom+'" data-img="<?= base_url(); ?>/assets/img/parts/'+row.photo+'"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
                                '  </div>'+
                                '</a>';
                            }
                        }
                        return html;
                    }
                },
                {
                  data :"id", visible: false
                }
            ]
        });

        var table = $('#dt').DataTable();

        table.on('draw', function(data){
            $('#dt tbody').addClass('row');
            $('#dt tbody tr').addClass('col-lg-2 col-md-4 col-sm-6 mt-0 mb-0');
        });

        $('#addCart').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var description = button.data('description')
            var qty = button.data('qty')
            var img = button.data('img')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            $(".modal-body #addimg").attr("src", img);
            document.getElementById("addCartTitle").innerHTML = name;
            document.getElementById("addpartDesc").innerHTML = description;
            document.getElementById("qty").innerHTML = qty;
        })  

        // Edit record
        // table.on('click', '.edit', function() {
        //     $tr = $(this).closest('tr');

        //     if ($tr.hasClass('child')) {
        //         $tr = $tr.prev('.parent');
        //     }

        //     var data = table.row($tr).data();
        //     alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        // });

        // Delete a record
        // table.on('click', '.remove', function(e) {
        //     $tr = $(this).closest('tr');
        //     table.row($tr).remove().draw();
        //     e.preventDefault();
        // });

        //Like record
        // table.on('click', '.like', function() {
        //     alert('You clicked on Like button');
        // });
    });

    $(document).ready(function() {
        setFormValidation('#TypeValidation');
        setFormValidation('#AddValidation');
    });
</script>
<?php $this->endSection('');?>