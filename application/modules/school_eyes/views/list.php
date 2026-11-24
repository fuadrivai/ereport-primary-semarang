<style type="text/css">
    .card-modern {
        border-radius: 12px;
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
        border: none;
        margin-bottom: 30px;
        background: #fff;
    }
    .card-modern .header {
        padding: 20px 20px 0;
        border-bottom: none;
    }
    .card-modern .title {
        font-weight: 700;
        color: #333;
        font-size: 22px;
    }
    .btn-modern {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .table-modern thead th {
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #eee !important;
        padding: 15px !important;
    }
    .table-modern tbody td {
        padding: 15px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f1f1;
    }
    .animate-pulse {
        animation: pulse-animation 2s infinite;
    }
    @keyframes pulse-animation {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.05); }
        100% { opacity: 1; transform: scale(1); }
    }
    .label {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 11px;
    }
    .text-primary-modern {
        color: #1d62f0;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card card-modern">
            <div class="header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="title"><i class="fa fa-video-camera text-primary-modern"></i> School Eyes</h4>
                        <p class="category">Manage CCTV streams and broadcasting schedules</p>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo base_url() . $url; ?>/edit" class="btn btn-info btn-fill btn-modern pull-right">
                            <i class="fa fa-plus"></i> Add New Stream
                        </a>
                    </div>
                </div>
            </div>
            <hr style="margin: 15px 0 0;">
            <div class="content mt-3">
                <div class="table-responsive">
                    <table class="table table-modern" id="datatabel">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">CCTV Name & Status</th>
                                <th width="35%">Stream URL</th>
                                <th width="15%">Active Days</th>
                                <th width="15%">Time Window</th>
                                <th width="10%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var dataTable = $('#datatabel').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo base_url() . $url; ?>/datatable",
                type: "post"
            },
            "columnDefs": [
                { "targets": [0, 5], "orderable": false }
            ],
            "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search streams...",
                "lengthMenu": "Show _MENU_ entries"
            }
        });
        
        // Style adjustments for DataTables
        $('.dataTables_filter input').addClass('form-control').css('border-radius', '20px');
        $('.dataTables_length select').addClass('form-control').css('width', 'auto').css('display', 'inline-block').css('border-radius', '20px');
    });

    function hapus(id) {
        swal({
            title: 'Delete Stream?',
            text: "This CCTV configuration will be permanently removed.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#95a5a6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = "<?php echo base_url() . $url; ?>/hapus/" + id;
            }
        });
        return false;
    }
</script>
