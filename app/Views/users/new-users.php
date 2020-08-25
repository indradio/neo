<?php $this->extend('layouts/template');?>

<?php $this->section('content');?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header ">
                        <h4 class="card-title">Users</h4>
                        <p class="card-category">A table for customer users</p>
                        <br />
                    </div>
                    <div class="card-body table-striped table-no-bordered table-hover dataTable dtr-inline table-full-width">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th class="disabled-sorting text-right">Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        $db = \Config\Database::connect();
                                        $builder = $db->table('company');
                                        foreach ($users->getResult() as $row) { 
                                            $company = $builder->where(['id' => $row->company_id])->get()->getRow(); 
                                    ?>
                                    <tr>
                                        <td><?= $row->id; ?></td>
                                        <td><?= $row->name; ?></td>
                                        <td><?= $row->email; ?></td>
                                        <td><?= $row->phone; ?></td>
                                        <td><?= $company->name; ?></td>
                                        <?php if ($row->status=='NEW'){?>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-outline btn-wd btn-info" data-toggle="modal" data-target="#verifyUser" data-id="<?= $row->id; ?>" data-name="<?= $row->name; ?>" data-email="<?= $row->email; ?>" data-phone="<?= $row->phone; ?>" data-company="<?= $company->name; ?>"><?= $row->status; ?></a>
                                        </td>
                                        <?php }else{?>
                                        <td class="text-right">
                                            <a href="<?= base_url('users/user/'.$row->id); ?>" class="btn btn-outline btn-wd btn-success"><?= $row->status; ?></a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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