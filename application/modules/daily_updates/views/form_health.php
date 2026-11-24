<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="header" style="background: #c62828; color: white; padding: 20px;">
                <h4 class="title"><i class="fa fa-medkit"></i> Health Status Monitoring</h4>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">Student: <?php echo strtoupper($student['nama']); ?></p>
            </div>
            <div class="content" style="padding: 30px;">
                <form action="<?php echo base_url() . $url; ?>/simpan_health" method="post">
                    <input type="hidden" name="student_id" value="<?php echo $id_siswa; ?>">
                    <input type="hidden" name="id_kelas" value="<?php echo $_GET['id_kelas']; ?>">
                    
                    <div class="form-group">
                        <label style="font-weight: 700; color: #555; display: block; margin-bottom: 15px;">Current Health Status</label>
                        
                        <div class="health-option">
                            <label class="status-box">
                                <input type="radio" name="status" value="Healthy" required onclick="toggleDetails(false)">
                                <div class="status-content">
                                    <span class="status-dot healthy"></span>
                                    <span>Healthy</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="health-option">
                            <label class="status-box">
                                <input type="radio" name="status" value="Minor Illness" onclick="toggleDetails(false)">
                                <div class="status-content">
                                    <span class="status-dot illness"></span>
                                    <span>Minor Illness</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="health-option">
                            <label class="status-box">
                                <input type="radio" name="status" value="Accident" onclick="toggleDetails(true)">
                                <div class="status-content">
                                    <span class="status-dot accident"></span>
                                    <span>Accident</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="health-option">
                            <label class="status-box">
                                <input type="radio" name="status" value="Emergency" onclick="toggleDetails(true)">
                                <div class="status-content">
                                    <span class="status-dot emergency"></span>
                                    <span>Emergency</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="details-section" style="display: none; margin-top: 20px; animation: fadeIn 0.3s;">
                        <div class="form-group">
                            <label style="font-weight: 700; color: #c62828;">Incident Details / Description</label>
                            <textarea name="details" class="form-control" rows="4" placeholder="Please describe exactly what happened..." style="border-radius: 10px; border: 2px solid #ffcdd2;"></textarea>
                            <p class="small text-danger" style="margin-top: 5px;"><i class="fa fa-info-circle"></i> This information will be sent immediately to parents.</p>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <button type="submit" class="btn btn-danger btn-fill btn-block" style="border-radius: 10px; padding: 12px; font-weight: 700; font-size: 16px; background: #c62828; border: none;">
                            SAVE HEALTH RECORD
                        </button>
                        <a href="<?php echo base_url() . $url; ?>/students/<?php echo $_GET['id_kelas']; ?>" class="btn btn-default btn-block" style="border-radius: 10px; margin-top: 10px;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDetails(show) {
        const section = document.getElementById('details-section');
        if (show) {
            section.style.display = 'block';
            section.querySelector('textarea').setAttribute('required', 'required');
        } else {
            section.style.display = 'none';
            section.querySelector('textarea').removeAttribute('required');
        }
    }
</script>

<style>
    .status-box {
        display: block;
        cursor: pointer;
        margin-bottom: 10px;
    }
    .status-box input {
        display: none;
    }
    .status-content {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .status-box input:checked + .status-content {
        border-color: #c62828;
        background: #ffebee;
    }
    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 15px;
    }
    .healthy { background: #4caf50; }
    .illness { background: #fbc02d; }
    .accident { background: #f57c00; }
    .emergency { background: #d32f2f; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
