<?php $this->extend('layouts/template');?>
<?php $this->section('content');?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title"><?= $part['description'];?></h4>
                        <p class="card-category"><?= $part['name']; ?></p>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="card-img-top" src="<?= base_url(); ?>/assets/img/parts/<?= $part['photo']; ?>" alt="...">
                                    </div>
                                </div>
                                <form id="RangeValidation" class="form-horizontal" action="<?= base_url('parts/change'); ?>" method="post" enctype="multipart/form-data">
                                    <input class="form-control" type="hidden" name="id_part" id="id_part" value="<?= $part['id']; ?>" />
                                    <input class="form-control" type="hidden" name="name_part" id="name_part" value="<?= $part['name']; ?>" />
                                    <div class="col-sm-12">
                                        <div class="form-group custom-file">
                                            <input type="file" class="form-control" id="photo" name="photo" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-1">
                                        <button type="submit" class="btn btn-outline btn-wd btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8 ml-auto mr-auto">
                            <form id="TypeValidation" class="form-horizontal" action="<?= base_url('parts/modify'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <input class="form-control" type="hidden" name="id" id="id" value="<?= $part['id']; ?>" />
                                <div class="card">
                                    <h5 class="card-header">Deskripsi</h5>
                                    <div class="card-body">
                                        <!-- <h5 class="card-title">Special title treatment</h5> -->
                                        <p class="card-text"><i>Tidak ada deskripsi untuk part ini.</i></p>
                                        <p class="card-text"><small class="text-muted">Tersedia <?= intval($part['qty']).' '.$part['uom']; ?> </small></p>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">KATEGORI</label>
                                            <div class="col-sm-3">
                                            <div class="form-group">
                                                    <select name="category" id="category" class="selectpicker show-tick" data-title="Pilih Kategori" data-style="btn-primary btn-fill" data-menu-style="dropdown-blue" required>
                                                        <option value="UNCATEGORY" <?= ($part['category']=='UNCATEGORY') ? 'selected' : '';?>>UNCATEGORY</option>
                                                        <option value="STANDAR" <?= ($part['category']=='STANDAR') ? 'selected' : '';?>>STANDAR</option>
                                                        <option value="ELEKTRIK" <?= ($part['category']=='ELEKTRIK') ? 'selected' : '';?>>ELEKTRIK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">HARGA DASAR (Rp)</label>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="base_price" id="base_price" value="<?= $part['base_price']; ?>" number="true" min="0" required readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">HARGA TERTINGGI (Rp)</label>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="high_price" id="high_price" value="<?= $part['high_price']; ?>" number="true" min="0" required/>
                                                    <h6 class="card-text"><small>Untuk hubungi sales isikan "0"</small></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Diskon (%)</label>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="discount" id="discount" value="<?= $part['discount']; ?>" number="true" range="[0,100]" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">HARGA JUAL (Rp)</label>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="price" id="price" value="<?= $part['price']; ?>" number="true" min="0" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                    <div class="row">
                                            <label class="col-sm-2 col-form-label"><a href="<?= base_url('/parts'); ?>" class="btn btn-link">Kembali</a></label>
                                            <div class="col-sm-7">
                                                <button type="submit" class="btn btn-outline btn-wd btn-primary">Update</button>
                                                <?php if ($part['base_price'] != $part['price']){ ?>
                                                    <a href="#" class="btn btn-outline btn-wd btn-danger" data-toggle="modal" data-target="#resetPart" data-id="<?= $part['id']; ?>" data-base="<?= $part['base_price']; ?>" data-header="Harga jual akan menggunakan harga dasar?">Reset</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resetPart" tabindex="-1" role="dialog" aria-labelledby="resetPartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title" id="resetPartTitle"></h5>
        </button>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('parts/reset'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="id" id="id" />
        <input class="form-control" type="hidden" name="base_price" id="base_price" />
        <input class="form-control text-center" type="text" name="crncy_price" id="crncy_price" readonly/>
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
        setFormValidation('#TypeValidation');

    });

    $("#high_price").keyup(function() {
        var x = document.getElementById("high_price").value;
        var y = document.getElementById("discount").value;
        var z = x * (y/100);
        var harga = x - z  ;

        document.getElementById("price").value = harga;
        
        if (x==0){
            document.getElementById("discount").value = 0;
            document.getElementById("price").value = 0;
            document.getElementById("discount").readOnly = true;
            document.getElementById("price").readOnly = true;
        }else{
            document.getElementById("discount").readOnly = false;
            document.getElementById("price").readOnly = false;
        }
    });

    $("#discount").keyup(function() {
        var x = document.getElementById("high_price").value;
        var y = document.getElementById("discount").value;
        var z = x * (y/100);
        var harga = x - z  ;

        document.getElementById("price").value = harga;
        
    });

    $("#price").keyup(function() {
        var x = document.getElementById("high_price").value;
        var z = document.getElementById("price").value;
        var y = (z / x)*100; 
        var discount = 100 - y  ;

        document.getElementById("discount").value = discount;
        
    });

    $('#resetPart').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var base_price = button.data('base')
        var header = button.data('header')

        var	reverse = base_price.toString().split('').reverse().join(''),
            price 	= reverse.match(/\d{1,3}/g);
            crncy_price	= price.join('.').split('').reverse().join('');

        var modal = $(this)
        modal.find('.modal-body input[name="id"]').val(id)
        modal.find('.modal-body input[name="base_price"]').val(base_price)
        modal.find('.modal-body input[name="crncy_price"]').val('Rp ' + crncy_price)
        document.getElementById("resetPartTitle").innerHTML = header;
    });
</script>
<?php $this->endSection('');?>