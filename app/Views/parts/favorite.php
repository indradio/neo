<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-body">
                        <nav class="navbar navbar-expand-lg" data-spy="affix" data-offset-top="197">
                            <div class="input-group input-group-lg rounded">
                                <input type="text" class="form-control border-primary" style="height: unset;border-width: medium; border-right: none;" id="mySearch" name="mySearch" placeholder="Cari part jadi lebih mudah" autofocus>
                                <span class="input-group-addon border-primary" style=" border-width: medium; border-left: none;"><i class="fa fa-search"></i></span>
                            </div>
                        </nav>
                    </div>
                    <div class="card-footer">
                        <!-- <hr> -->
                        <div class="stats">
                            <i class="fa fa-shopping-cart ml-3"></i> Buruan sikat, sebelum kehabisan part.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-1">
                <div class="card data-tables">
                    <!-- <div class="card-header ">
                        <h4 class="card-title">Table Big Boy</h4>
                        <p class="card-category">A table for content management</p>
                    </div>
                    <div class="card-body table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <div class="col-md-12 mr-auto ml-auto">
                                <form method="#" action="#">
                                    <div class="input-group input-group-lg mt-2 mb-4">
                                        <input type="text" class="form-control" id="mySearch" placeholder="Cari Komponen..." autofocus>
                                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                    </div>
                                </form>
                            </div> -->
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        <!-- </div> -->
                        <div class="fresh-datatables">
                            <table id="dt" class="table table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                    </tr>
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
<div class="modal fade" id="addCart" tabindex="-1" role="dialog" aria-labelledby="addCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCartTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('cart/add'); ?>" method="post">
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

<div class="modal fade" id="delFav" tabindex="-1" role="dialog" aria-labelledby="delFavTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title" id="delFavTitle"></h5>
        </button>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('parts/remove_favorite'); ?>" method="post">
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
        $("#dt thead").hide();
        $('#dt').DataTable({
            "pagingType": "full_numbers",
                   "dom": 'lrtip',
            // "lengthMenu": [
            //     [25, 50, 100,-1],
            //     [25, 50, 100, "All"]
            // ],
            lengthChange: false,
            displayLength: 30,
            language: {
                // search: "_INPUT_",
                // searchPlaceholder: "Search records",
                zeroRecords: "Yaah! Komponen yang anda cari tidak ditemukan",
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
                            '    <a href="#" class="btn btn-fill btn-danger"><span class="btn-label">Sold Out <i class="fa fa-close"></i></span></a>'+
                            '    <a href="#" class="btn btn-outline btn-danger ml-1" style="position: absolute;" data-toggle="modal" data-target="#delFav" data-id="'+row.id+'" data-header="Anda yakin akan membatalkan part </br>'+row.description+'"><span class="btn-label"><i class="fa fa-trash"></i></span></a>'+
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
                                '  <div class="card-footer" style="position: absolute; bottom:0;">'+
                                '    <a href="#" class="btn btn-outline btn-primary d-inline-block" data-toggle="modal" data-target="#addCart" data-id="'+row.id+'" data-name="'+row.name+'" data-description="'+row.description+'" data-qty="Tersedia '+parseInt(row.qty)+' '+row.uom+'" data-img="<?= base_url(); ?>/assets/img/parts/'+row.photo+'"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
                                '    <a href="#" class="btn btn-outline btn-danger ml-1" style="position: absolute;" data-toggle="modal" data-target="#delFav" data-id="'+row.id+'" data-header="Anda yakin akan membatalkan part </br>'+row.description+'"><span class="btn-label"><i class="fa fa-trash"></i></span></a>'+
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
                                '    <a href="#" class="btn btn-outline btn-primary d-inline-block" data-toggle="modal" data-target="#addCart" data-id="'+row.id+'" data-name="'+row.name+'" data-description="'+row.description+'" data-qty="Tersedia '+parseInt(row.qty)+' '+row.uom+'" data-img="<?= base_url(); ?>/assets/img/parts/'+row.photo+'"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
                                '    <a href="#" class="btn btn-outline btn-danger ml-1" style="position: absolute;" data-toggle="modal" data-target="#delFav" data-id="'+row.id+'" data-header="Anda yakin akan membatalkan part </br>'+row.description+'"><span class="btn-label"><i class="fa fa-trash"></i></span></a>'+
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
                                '    <a href="#" class="btn btn-outline btn-primary d-inline-block" data-toggle="modal" data-target="#addCart" data-id="'+row.id+'" data-name="'+row.name+'" data-description="'+row.description+'" data-qty="Tersedia '+parseInt(row.qty)+' '+row.uom+'" data-img="<?= base_url(); ?>/assets/img/parts/'+row.photo+'"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
                                '    <a href="#" class="btn btn-outline btn-danger ml-1" style="position: absolute;" data-toggle="modal" data-target="#delFav" data-id="'+row.id+'" data-header="Anda yakin akan membatalkan part </br>'+row.description+'"><span class="btn-label"><i class="fa fa-trash"></i></span></a>'+
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

        $('#mySearch').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );

        $('#addCart').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var description = button.data('description')
            var qty = button.data('qty')
            var img = button.data('img')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            $(".modal-body #img").attr("src", img);
            document.getElementById("addCartTitle").innerHTML = name;
            document.getElementById("partDesc").innerHTML = description;
            document.getElementById("qty").innerHTML = qty;
        })

        $('#delFav').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var header = button.data('header')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            document.getElementById("delFavTitle").innerHTML = header;
        })  
    });

    $( "#mySearch" ).keyup(function() {
        document.body.scrollTop = 60;
        document.documentElement.scrollTop = 60;
    });

    $(document).ready(function() {
        setFormValidation('#TypeValidation');
    });

</script>
<?php $this->endSection('');?>