<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="header" style="background: #ef6c00; color: white; padding: 20px;">
                <h4 class="title"><i class="fa fa-smile-o"></i> Mood Observation</h4>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">Student: <?php echo strtoupper($student['nama']); ?></p>
            </div>
            <div class="content" style="padding: 30px;">
                <form action="<?php echo base_url() . $url; ?>/simpan_mood" method="post">
                    <input type="hidden" name="student_id" value="<?php echo $id_siswa; ?>">
                    <input type="hidden" name="id_kelas" value="<?php echo $_GET['id_kelas']; ?>">
                    
                    <div class="form-group text-center">
                        <label style="font-weight: 700; color: #555; display: block; margin-bottom: 25px;">How is the student feeling today?</label>
                        
                        <div class="row">
                            <div class="col-xs-4">
                                <label class="mood-option">
                                    <input type="radio" name="mood" value="Enthusiastic" required>
                                    <div class="mood-box">
                                        <div class="emoji">😊</div>
                                        <div class="mood-label">Enthusiastic</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-4">
                                <label class="mood-option">
                                    <input type="radio" name="mood" value="Neutral">
                                    <div class="mood-box">
                                        <div class="emoji">😐</div>
                                        <div class="mood-label">Neutral</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-4">
                                <label class="mood-option">
                                    <input type="radio" name="mood" value="Low mood">
                                    <div class="mood-box">
                                        <div class="emoji">😢</div>
                                        <div class="mood-label">Low mood</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 40px;">
                        <button type="submit" class="btn btn-warning btn-fill btn-block" style="border-radius: 10px; padding: 12px; font-weight: 700; font-size: 16px; background: #ef6c00; border: none;">
                            SAVE OBSERVATION
                        </button>
                        <a href="<?php echo base_url() . $url; ?>/students/<?php echo $_GET['id_kelas']; ?>" class="btn btn-default btn-block" style="border-radius: 10px; margin-top: 10px;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .mood-option {
        display: block;
        cursor: pointer;
    }
    .mood-option input {
        display: none;
    }
    .mood-box {
        padding: 15px 5px;
        border: 2px solid #eee;
        border-radius: 15px;
        transition: all 0.2s;
    }
    .mood-option input:checked + .mood-box {
        border-color: #ef6c00;
        background: #fff3e0;
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(239, 108, 0, 0.2);
    }
    .emoji {
        font-size: 40px;
        margin-bottom: 10px;
    }
    .mood-label {
        font-weight: 700;
        font-size: 12px;
        color: #555;
    }
    .mood-option input:checked + .mood-box .mood-label {
        color: #ef6c00;
    }
</style>
