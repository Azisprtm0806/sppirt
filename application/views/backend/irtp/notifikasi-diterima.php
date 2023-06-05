<div class="row">
    <div class="col-12 text-right mb-2">
        <button type="button" id="btn-mark" class="btn btn-xs btn-primary pull-right"><i class="fa fa-check"></i> Mark All AS Read</button>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-menu-sppirt" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No SPPIRT</th>
                                <th>Nama Produk Pangan</th>
                                <th>Jenis Pangan</th>
                                <th>Kemasan</th>
                                <th>Masa Berlaku</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        loadData()
    })

    function loadData() {
        dt = $('#dt-menu-sppirt').DataTable({
            //   "processing": true,
            // "serverSide": true,

            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": base_url + "backend/Notifikasi/getData/2",
                "type": "POST",
            },
            "columnDefs": [{
                    targets: [-1, 0],
                    orderable: false
                },
                {
                    targets: [-1, 0],
                    class: 'text-nowrap text-center'
                }
            ],
            "order": [],
        });
    }
    $('#btn-mark').click(function() {
        $.ajax({
            url: `${base_url}backend/Notifikasi/markall/2`,

            dataType: 'json',
            success: function(response) {
                console.log(response)
                sukses(response.msg)
                dt.ajax.reload()
            }
        })
    })

    function sukses(msg) {
        toastr.success(msg, "Dibaca", {
            timeOut: 3000,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            positionClass: "toast-top-right",
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1
        })
    }
</script>