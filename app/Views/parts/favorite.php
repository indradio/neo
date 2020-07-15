<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
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
                                        <th>nama</th>
                                        <th>gender</th>
                                        <th>email</th>
                                        <th>address</th>
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
      <form id="TypeValidation" class="form-horizontal" action="" method="">
        <div class="modal-body">
            <div class="card border-0" style="max-width: 100%;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                    <img src="<?= base_url(); ?>/assets/img/materials/BDBOLT-BATCNTD5X5.jpg" class="card-img" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card.</p>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">QTY</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="qty" value="1" number="true" range="[1,10]"/>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
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
                        '  <img src="<?= base_url(); ?>/assets/img/materials/'+row.id+'.jpg" class="card-img-top" />'+
                        '  <div class="card-body">'+
                        '    <h5 class="card-title">'+row.description+'</h5>'+
                        '    <div class="card-text">'+row.id+'</div>'+
                        '    <div class="card-text">Rp '+price+'</div>'+
                        '    <a href="#" class="btn btn-outline btn-wd btn-dribbble mt-2"><span class="btn-label">Favorit <i class="fa fa-heart"></i></span></a>'+
                        '    <a href="#" class="btn btn-outline btn-wd btn-primary" data-toggle="modal" data-target="#addCart"><span class="btn-label">Tambah Ke <i class="fa fa-shopping-cart"></i></span></a>'+
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