<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
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
                                    <p class="card-category">Rekomendasi</p>
                                    <h4 class="card-title">10 Item</h4>
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
                                    <p class="card-category">Kupon</p>
                                    <h4 class="card-title">3 Kupon</h4>
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
                    <!-- <div class="card-header ">
                        <h4 class="card-title">Table Big Boy</h4>
                        <p class="card-category">A table for content management</p>
                    </div> -->
                    <div class="card-body table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <div class="col-md-12 mr-auto ml-auto">
                                <form method="#" action="#">
                                    <div class="input-group input-group-lg mt-2 mb-4">
                                        <input type="text" class="form-control" id="mySearch" placeholder="Cari Komponen..." autofocus>
                                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                    </div>
                                </form>
                            </div>
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
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
                    "url": "<?= site_url('parts/part') ?>",
                    "type": "POST"
                },
         responsive: true,
              bInfo: false,
        deferRender: true,
         processing: true,
            columns: [
                {
                    render: function (data, type, row, meta) { 
                        var crncy = row.price;
		
                        var	reverse = crncy.toString().split('').reverse().join(''),
                            price 	= reverse.match(/\d{1,3}/g);
                            price	= price.join('.').split('').reverse().join('');
                        var html =
                        '<a href="<?= base_url(); ?>/parts/item/'+row.id+'">'+
                        '  <img src="<?= base_url(); ?>/assets/img/materials/NO-PART.jpg" class="card-img-top" />'+
                        '  <div class="card-body">'+
                        '    <h5 class="card-title">'+row.description+'</h5>'+
                        '    <div class="card-text">'+row.name+'</div>'+
                        '    <div class="card-text">Rp '+price+'</div>'+
                        '    <a href="#" class="btn btn-outline btn-wd btn-dribbble mt-2"><span class="btn-label">Favorit <i class="fa fa-heart"></i></span></a>'+
                        '    <a href="#" class="btn btn-outline btn-wd btn-primary" data-toggle="modal" data-target="#addCart" data-id="'+row.id+'" data-name="'+row.name+'" data-description="'+row.description+'" data-qty="Tersedia '+parseInt(row.qty)+' '+row.uom+'" data-img="<?= base_url(); ?>/assets/img/materials/'+row.name+'.jpg"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
                        '  </div>'+
                        '</a>';
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
            $('#dt tbody tr').addClass('col-lg-2 col-md-3 col-sm-12');
        });

        $('#mySearch').on( 'keyup', function () {
            table.search( this.value ).draw();
        } );

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