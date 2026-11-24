<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="header" style="background: #2e7d32; color: white; padding: 20px;">
                <h4 class="title"><i class="fa fa-cutlery"></i> Meal Monitoring</h4>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">Student: <?php echo strtoupper($student['nama']); ?></p>
            </div>
            <div class="content" style="padding: 30px;">
                <form action="<?php echo base_url() . $url; ?>/simpan_meal" method="post">
                    <input type="hidden" name="student_id" value="<?php echo $id_siswa; ?>">
                    <input type="hidden" name="id_kelas" value="<?php echo $_GET['id_kelas']; ?>">
                    
                    <div class="form-group">
                        <label style="font-weight: 700; color: #555; display: block; margin-bottom: 15px;">Daily Meal Status</label>
                        
                        <div class="radio-option">
                            <label style="display: flex; align-items: center; padding: 15px; border: 1px solid #eee; border-radius: 10px; margin-bottom: 10px; cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="meal_status" value="Finished" required style="margin-right: 15px;">
                                <span style="font-size: 16px; font-weight: 600;">Finished</span>
                            </label>
                        </div>
                        
                        <div class="radio-option">
                            <label style="display: flex; align-items: center; padding: 15px; border: 1px solid #eee; border-radius: 10px; margin-bottom: 10px; cursor: pointer;">
                                <input type="radio" name="meal_status" value="Half Eaten" style="margin-right: 15px;">
                                <span style="font-size: 16px; font-weight: 600;">Half Eaten</span>
                            </label>
                        </div>
                        
                        <div class="radio-option">
                            <label style="display: flex; align-items: center; padding: 15px; border: 1px solid #eee; border-radius: 10px; margin-bottom: 10px; cursor: pointer;">
                                <input type="radio" name="meal_status" value="Not Eating" style="margin-right: 15px;">
                                <span style="font-size: 16px; font-weight: 600;">Not Eating</span>
                            </label>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <button type="submit" class="btn btn-success btn-fill btn-block" style="border-radius: 10px; padding: 12px; font-weight: 700; font-size: 16px;">
                            SAVE RECORD
                        </button>
                        <a href="<?php echo base_url() . $url; ?>/students/<?php echo $_GET['id_kelas']; ?>" class="btn btn-default btn-block" style="border-radius: 10px; margin-top: 10px;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .radio-option label:hover {
        background: #f8f9fa;
        border-color: #2e7d32;
    }
    input[type="radio"]:checked + span {
        color: #2e7d32;
    }
</style>
