<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    ⚠️<strong>PEMBERITAHUAN!</strong>⚠️
                    </br>
                    </br>Semangat Pagi <?= session()->get('name'); ?>,
                    </br>NEO adalah Layanan Portal B2B (Business to Business) yang memudahkan anda mencari komponen (part) untuk peralatan industri maupun manufaktur. 
                    </br>Kami akan segera menghubungi anda melalui kontak telepon maupun email dengan penawaran dan harga terbaik setelah anda KLIK tombol <strong>"Request Quote"</strong>.
                    </br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <h4 class="card-title">Checkout</h4>
                        <p class="card-category">Penawaran terbaik akan kami siapkan hanya untuk anda</p>
                        <div class="row mt-5 mb-3">
                            <div class="col-md-1">
                                <p class="card-text text-right">Ship To :</p>
                            </div>
                            <div class="col-md-3">
                            <?php 
                                $db = \Config\Database::connect();
                                $builder = $db->table('company');
                                $company = $builder->where(['id' => session()->get('companyId')])->get()->getRow();
                            ?>
                                <h5 class="card-text"><?= $company->name; ?></h5>
                                <p class="card-text">
                                    <?= $company->address; ?> </br>
                                </p>
                                <p class="card-text">
                                    Attn: <?= session()->get('name'); ?> </br>
                                    Email: <?= session()->get('email'); ?> </br>
                                    Phone: <?= session()->get('phone'); ?> </br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>#</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>UoM</th>
                                <th>Unit Price (IDR)</th>
                                <th>Amount (IDR)</th>
                            </thead>
                            <tbody>
                            <?php 
                                
                                $db = \Config\Database::connect();
                                $builder = $db->table('parts');
                                $total = 0;
                                $num = 1;
                                
                                foreach ($parts->getResult() as $row) { 
                                $query = $builder->where(['id' => $row->id])->get(); 
                                $part = $query->getRow();        
                                $subTotal = $part->price * $row->order_qty;
                                $total = $total + $subTotal;
                                $vat = $total * 0.10;
                                $grandTotal = $total + $vat;
                                ?>
                                <tr>
                                    <td><?= $num++; ?></td>
                                    <td><?= $row->description; ?>
                                        </br><small><?= $row->name; ?></small></td>
                                    <td><?= $row->order_qty; ?></td>
                                    <td><?= $row->uom; ?></td>
                                    <td><?= number_format($part->price, 0, '.', ','); ?></td>
                                    <td><?= number_format($subTotal, 0, '.', ','); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th> Subtotal (IDR)</th>
                                    <th><?= number_format($total, 0, '.', ','); ?></th>
                                </tr>
                                <!-- <tr>
                                    <th colspan="4"></th>
                                    <th> VAT (10%)</th>
                                    <th><?= number_format($vat, 0, '.', ','); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th> Total (IDR)</th>
                                    <th><?= number_format($grandTotal, 0, '.', ','); ?></th>
                                </tr> -->
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <a href="<?= base_url('cart'); ?>" class="btn btn-link">Kembali</a>
                            <div class="col-md-2 mr-2">
                                <a href="<?= base_url('cart/order'); ?>" class="btn btn-round btn-outline btn-wd btn-primary form-control btn-glowing">Request a Quote</a>
                            </div>
                        </div>
                                </br>
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
                    <img src="<?= base_url(); ?>/assets/img/materials/WMCSTD-XATP40L37A.jpg" class="card-img" />
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
            <button type="submit" class="btn btn-wd btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->endSection('');?>

<?php $this->section('javascript');?>
<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
<?php $this->endSection('');?>