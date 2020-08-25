<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header">
                        <h4 class="card-title">Quotation</h4>
                        <p class="card-category">#<?= $order->quote_id; ?></p>
                        <div class="row mt-5 mb-3">
                            <div class="col-md-1">
                                <p class="card-text text-right">Ship To :</p>
                            </div>
                            <div class="col-md-3">
                            <?php 
                                $db = \Config\Database::connect();
                                $builder = $db->table('company');
                                $company = $builder->where(['id' => $order->user_company_id])->get()->getRow();
                            ?>
                                <h5 class="card-text"><?= $company->name; ?></h5>
                                <p class="card-text">
                                    <?= $company->address; ?> </br>
                                </p>
                                <p class="card-text">
                                    Attn &nbsp&nbsp&nbsp : <?= session()->get('name'); ?> </br>
                                    Email &nbsp: <?= session()->get('email'); ?> </br>
                                    Phone : <?= session()->get('phone'); ?> </br>
                                </p>
                            </div>
                            <div class="col-md-3 ml-auto text-center">
                            <a href="<?= base_url('assets/pdf/quotation/'.$order->quote_file); ?>" class="btn btn-round btn-outline btn-wd btn-primary btn-glowing" target="_blank"><i class="fa fa-arrow-down"></i> DOWNLOAD</a>
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
                                <th></th>
                            </thead>
                            <tbody>
                            <?php 
                            $num = 1;
                            foreach ($parts->getResult() as $row) { ?>
                                <tr>
                                    <td><?= $num++; ?></td>
                                    <td><?= $row->part_description; ?>
                                        </br><small><?= $row->part_name; ?></small></td>
                                    <td><?= $row->order_qty; ?></td>
                                    <td><?= $row->part_uom; ?></td>
                                    <td>
                                        <?= number_format($row->part_price, 0, '.', ',');
                                        if ($row->part_price_disc>0){
                                            $selisih = $row->part_price_sell - $row->part_price; 
                                            ?>
                                            </br><a class="card-text text-danger d-inline-block"><small><strike>Rp <?= number_format($row->part_price_sell, 0, '.', ','); ?></strike></small></a>
                                            <a class="badge badge-success text-light">-<?= $row->part_price_disc; ?>%</a>
                                        <?php } ?>
                                    </td>
                                    <td><?= number_format($row->subtotal, 0, '.', ','); ?></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th> Subtotal (IDR)</th>
                                    <th><?= number_format($order->total, 0, '.', ','); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th> VAT (10%)</th>
                                    <th><?= number_format($order->vat_amount, 0, '.', ','); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th> Shipping Cost (IDR)</th>
                                    <th><?= number_format($order->delivery_fee, 0, '.', ','); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th> Total (IDR)</th>
                                    <th><?= number_format($order->grandtotal, 0, '.', ','); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-header ml-5">
                        <h4 class="card-title">Conditions</h4>
                        <div class="row">
                            <div class="col-md-10 ml-4 mt-2">
                                <div class="card-text">Term of Payment   : 100% After Approval BAST</div>
                                <div class="card-text">Valid Until <?= date('d M Y', strtotime($order->quote_expired)); ?></div>
                                <div class="card-text">Pricing Exclude VAT 10%</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header ml-5">
                        <h4 class="card-title">Should you have any questions please do not hesitate to contact us. </h4>
                            <?php 
                                $db = \Config\Database::connect();
                                $builder = $db->table('users');
                                $sales = $builder->where(['id' => $order->sales_by_id])->get()->getRow();
                            ?>
                        <div class="row">
                            <div class="col-md-10 ml-4 mt-2">
                                <div class="card-text">Name &nbsp &nbsp: <?= $sales->name;?></div>
                                <div class="card-text">Phone &nbsp : 021-87901713</div>
                                <div class="card-text">Mobile &nbsp&nbsp: <?= $sales->phone;?></div>
                                <div class="card-text">E-Mail &nbsp&nbsp : <?= $sales->email;?></div>
                                <div class="card-text">Website : www.winteq-astra.co.id</div>
                            </div>
                        </div>
                    </div>
                    </p>
                    <div class="card-header ml-5">
                        <h5 class="card-title">Best Regards,</h5>
                        </br>
                        </br>
                        </br>
                        <h5 class="card-title">Luthfi Gusman</h5>
                    </div>
                    <div class="card-footer">
                    <button onclick="topFunction()" id="toTopBtn" class="btn btn-info" title="Go to top"><i class="fa fa-arrow-up"></i>Top</button>
                        <!-- <div class="row">
                            <div class="col-md-8"></div>
                            <a href="<?= base_url('/order'); ?>" class="btn btn-link">Kembali</a>
                            <div class="col-md-2 mr-2">
                                <a href="<?= base_url('assets/pdf/quotation/'.$order->quote_file); ?>" class="btn btn-round btn-outline btn-wd btn-primary form-control btn-glowing" target="_blank">DOWNLOAD</a>
                            </div>
                        </div>
                        </br> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection('');?>

<?php $this->section('javascript');?>
<script type="text/javascript">
//Get the button
var mybutton = document.getElementById("toTopBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

    $(document).ready(function() {
        
    });
</script>
<?php $this->endSection('');?>