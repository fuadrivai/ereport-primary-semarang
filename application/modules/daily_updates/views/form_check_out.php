<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="header" style="background: #e74c3c; color: white; padding: 20px;">
                <h4 class="title"><i class="fa fa-sign-out"></i> Student Check-Out</h4>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">Student: <?php echo strtoupper($student['nama']); ?></p>
            </div>
            <div class="content" style="padding: 30px;">
                <form action="<?php echo base_url() . $url; ?>/simpan_check_out" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="student_id" value="<?php echo $id_siswa; ?>">
                    <input type="hidden" name="id_kelas" value="<?php echo $_GET['id_kelas']; ?>">
                    
                    <div class="form-group text-center">
                        <label style="font-weight: 700; color: #555; display: block; margin-bottom: 20px;">
                            <i class="fa fa-camera"></i> Capture / Upload Dismissal Photo
                        </label>
                        
                        <div id="photo-preview-container" style="margin-bottom: 20px; display: none;">
                            <img id="photo-preview" src="#" alt="Preview" style="max-width: 100%; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        </div>

                        <div class="upload-btn-wrapper" style="position: relative; overflow: hidden; display: inline-block;">
                            <button type="button" class="btn btn-danger btn-fill btn-lg" style="border-radius: 30px; padding: 10px 30px; background: #e74c3c; border: none;">
                                <i class="fa fa-upload"></i> SELECT PHOTO
                            </button>
                            <input type="file" name="photo" accept="image/*" capture="environment" onchange="previewImage(this)" style="font-size: 100px; position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 30px;">
                        <label class="checkbox" style="font-weight: 600; color: #555;">
                            <input type="checkbox" name="summary_inclusion" value="1" data-toggle="checkbox" checked>
                            Include in Daily Summary report for parents
                        </label>
                    </div>

                    <div style="margin-top: 40px;">
                        <button type="submit" class="btn btn-danger btn-fill btn-block" style="border-radius: 10px; padding: 12px; font-weight: 700; font-size: 16px; background: #e74c3c; border: none;">
                            COMPLETE CHECK-OUT
                        </button>
                        <a href="<?php echo base_url() . $url; ?>/students/<?php echo $_GET['id_kelas']; ?>" class="btn btn-default btn-block" style="border-radius: 10px; margin-top: 10px;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photo-preview').src = e.target.result;
                document.getElementById('photo-preview-container').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $('form').on('submit', function() {
            var $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true);
            $btn.html('<i class="fa fa-spinner fa-spin"></i> PROCESSING...');
            
            swal({
                title: 'Uploading...',
                text: 'Please wait while we process the student photo.',
                imageUrl: '<?php echo base_url(); ?>aset/img/loading-bubbles.svg',
                showConfirmButton: false,
                allowOutsideClick: false
            });
        });
    });
</script>
