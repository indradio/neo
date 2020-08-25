<?php $this->extend('layouts/template');?>

<?php     
         $db = \Config\Database::connect();
    $builder = $db->table('company');
      $query = $builder->where(['id' => $user['company_id']])->get(); 
    $company = $query->getRowArray();
?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-4">
                <div class="card card-user">
                    <div class="card-header no-padding">
                        <!-- <div class="card-image">
                            <img src="../../assets/img/full-screen-image-3.jpg" alt="...">
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="author">
                            <a href="#">
                                <img class="avatar border-gray" src="../../assets/img/faces/<?= $user['photo']; ?>" alt="...">
                                <h5 class="card-title"><?= $user['name']; ?></h5>
                            </a>
                            <p class="card-description">
                            <?= $user['id']; ?>
                            </p>
                        </div>
                        <p class="card-description text-center">
                            Hey there! As you can see,
                            <br> it is already looking great.
                        </p>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <form id="RangeValidation" class="form-horizontal" action="<?= base_url('users/change_photo'); ?>" method="post" enctype="multipart/form-data">
                                    <input class="form-control" type="hidden" name="photo" id="photo" value="<?= $user['photo']; ?>" />
                                    <div class="col-sm-12">
                                        <div class="form-group custom-file">
                                            <input type="file" class="form-control" id="photo" name="photo" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                                    </div>
                                </form>
                        <!-- <div class="button-container text-center">
                            <button href="#" class="btn btn-simple btn-link btn-icon">
                                <i class="fa fa-facebook-square"></i>
                            </button>
                            <button href="#" class="btn btn-simple btn-link btn-icon">
                                <i class="fa fa-twitter"></i>
                            </button>
                            <button href="#" class="btn btn-simple btn-link btn-icon">
                                <i class="fa fa-google-plus-square"></i>
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-6">
                <form class="form" method="post" action="<?= base_url('users/update'); ?>">
                    <div class="card ">
                        <div class="card-header ">
                            <div class="card-header">
                                <h4 class="card-title">Profil</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?= $user['name']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?= $user['email']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nomor Ponsel</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="<?= $user['phone']; ?>" required="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Perusahaan</label>
                                        <input type="text" class="form-control" name="company" id="company" value="<?= $company['name']; ?>" disabled="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea rows="4" class="form-control" id="address" name="address" disabled="true"><?= $company['address']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Kota</label>
                                        <input type="text" class="form-control" name="city" id="city" value="<?= $company['city']; ?>" disabled="true" />
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>Company (disabled)</label>
                                        <input type="text" class="form-control" placeholder="Company" value="Creative Code Inc.">
                                    </div>
                                </div>
                                <div class="col-md-3 px-1">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" placeholder="Username" value="michael23">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                            </div> -->
                            <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="verifyUser" tabindex="-1" role="dialog" aria-labelledby="verifyUserTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyUserTitle">User Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="TypeValidation" class="form-horizontal" action="<?= base_url('users/verify'); ?>" method="post">
      <?= csrf_field(); ?>
        <div class="modal-body">
        <input class="form-control" type="hidden" name="id" id="id" />
            <div class="row">
                <label class="col-sm-4 col-form-label">Nama</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" id="name" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" id="email" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label">Phone</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input class="form-control" type="text" name="phone" id="phone" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4 col-form-label">Perusahaan</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input class="form-control" type="text" name="company" id="company" readonly/>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-right">
            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-wd btn-primary">Verifikasi</button>
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
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });

        var table = $('#datatables').DataTable();
        
        $('#verifyUser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var email = button.data('email')
            var phone = button.data('phone')
            var company = button.data('company')
            var modal = $(this)
            modal.find('.modal-body input[name="id"]').val(id)
            modal.find('.modal-body input[name="name"]').val(name)
            modal.find('.modal-body input[name="email"]').val(email)
            modal.find('.modal-body input[name="phone"]').val(phone)
            modal.find('.modal-body input[name="company"]').val(company)
        })
    });

    $(document).ready(function() {
        setFormValidation('#TypeValidation');
    });

</script>
<?php $this->endSection('');?>