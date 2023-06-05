<div class="row">    
    <div class="col-xl-12">
        <div class="d-sm-flex  d-block align-items-center mb-4">
            <div class="mr-auto">
                <form method="GET" action="">
                <div class="input-group search-area-tracking-posisi d-lg-inline-flex">
                    <div class="input-group-append">
                        <button class="input-group-text"><i class="flaticon-381-search-2"></i></button>
                    </div>
                        <input type="text" name="q" class="form-control" placeholder="Search by Nama/Email/Nomor HP" value="<?php echo isset($_GET['q'])?$_GET['q']:''; ?>">
                </div>
                </form>
            </div>
            <div class="dropdown custom-dropdown mr-3 mb-2">
                
            </div>
            <div class="dashboard_bar mb-1">
                <a href="<?php echo base_url();?>user/add">
                    <button type="button" class="btn btn-rounded btn-info">
                        <span class="btn-icon-left text-info">
                            <i class="fa fa-plus color-info"></i>
                        </span>Add User
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List User</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Email/Phone</th>
                                <th>Created At</th>
                                <th>Last Login</th>
                                <th>Status</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($datas as $key => $value) { ?>
                            <tr>
                                <td><span class="text-black font-w500"><?php echo $no++; ?></span></td>
                                <td><span class="text-black font-w500"><?php echo $value->role; ?></span></td>
                                <td><span class="text-black font-w500"><?php echo $value->username; ?></span></td>
                                <td><span class="text-black font-w500"><?php echo $value->nama; ?></span></td>
                                <td><span class="text-black"><?php echo $value->no_telp; ?><br><?php echo $value->email; ?></span></td>
                                <td><span class="text-black text-nowrap"><?php echo date('d M Y H:i',strtotime($value->created_at)); ?></span></td>
                                <td><span class="text-black text-nowrap"><?php echo ($value->last_login!=null)?date('d M Y H:i',strtotime($value->last_login)):''; ?></span></td>
                                <td><div class="d-flex align-items-center">
                                    <?php if($value->is_active=='1'){ ?>
                                        <i class="fa fa-circle text-success mr-1"></i> Active</div></td>
                                    <?php }else if($value->is_active=='0'){ ?>
                                        <i class="fa fa-circle text-danger mr-1"></i> Inactive</div></td>
                                    <?php } ?>
                                <td>
                                    <div class="d-flex">
                                        <a href="<?php echo base_url(); ?>user/ubah-password/<?php echo encrypt_decrypt('encrypt', $value->id_user); ?>" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-unlock"></i></a>
                                        <a href="<?php echo base_url(); ?>user/edit/<?php echo encrypt_decrypt('encrypt', $value->id_user); ?>" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger shadow btn-xs sharp" onclick='deleteData("<?php echo encrypt_decrypt('encrypt', $value->id_user); ?>")'><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group mt-2 text-right">
                                    Showing <?php echo ($start+1); ?> to <?php echo $start + count($datas); ?> of <?php echo $total_data; ?> entries
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <style type="text/css">
                                    .pagination{
                                        justify-content: flex-end !important;
                                    }
                                </style>
                                <?php if($pagination!=""){ ?>
                                    <?php echo $pagination; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" >
function deleteData(id) {
    swal({
        title: 'Are you sure?',
        text: "Anda yakin akan menghapus data ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            window.location.href = "<?php echo base_url('user/delete/'); ?>"+id;
        }
    })
}
</script>

<style type="text/css">
    .swal2-select{
        display: none !important;
    }
</style>

<?php if($this->session->flashdata('error')){ ?>
<script language='JavaScript'>
    swal({
      type: 'error',
      title: 'Oops...',
      text: "<?php echo $this->session->flashdata('error'); ?>",
    });
</script>
<?php }else if($this->session->flashdata('success')){ ?>
<script language='JavaScript'>
    swal({
      type: 'success',
      title: 'Success',
      text: "<?php echo $this->session->flashdata('success'); ?>",
    });
</script>
<?php } ?>