<style type="text/css">
    .card-modern {
        border-radius: 12px;
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
        border: none;
        margin-bottom: 30px;
        background: #fff;
    }
    .card-modern .header {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px 12px 0 0;
        border-bottom: 1px solid #eee;
    }
    .card-modern .title {
        font-weight: 700;
        color: #333;
        margin: 0;
    }
    .form-group label {
        color: #555;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        height: auto;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #1d62f0;
        box-shadow: 0 0 0 3px rgba(29,98,240,0.1);
    }
    .day-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 5px;
    }
    .day-checkbox {
        display: none;
    }
    .day-label {
        padding: 8px 15px;
        background: #f1f3f5;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
        border: 1px solid transparent;
        user-select: none;
    }
    .day-checkbox:checked + .day-label {
        background: #1d62f0;
        color: #fff;
        box-shadow: 0 4px 6px rgba(29,98,240,0.2);
    }
    .day-label:hover {
        background: #e9ecef;
    }
    .btn-modern {
        border-radius: 20px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-fill-modern {
        background: #1d62f0;
        border: none;
        color: #fff;
    }
    .btn-fill-modern:hover {
        background: #1551cc;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="card card-modern">
            <div class="header">
                <h4 class="title"><i class="fa fa-pencil text-info"></i> <?php echo ucfirst($data['mode']); ?> CCTV Stream</h4>
            </div>
            <div class="content">
                <form action="<?php echo base_url() . $url; ?>/simpan" method="post" id="<?php echo $nama_form; ?>">
                    <input type="hidden" name="_id" value="<?php echo $data['id']; ?>">
                    <input type="hidden" name="_mode" value="<?php echo $data['mode']; ?>">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><i class="fa fa-tag"></i> CCTV Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g., Main Entrance / Classroom 10" value="<?php echo $data['name']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><i class="fa fa-link"></i> Stream URL (RTSP / HTTP)</label>
                                <input type="text" name="url" class="form-control" placeholder="rtsp://admin:pass@192.168.1.100:554/ch1" value="<?php echo $data['url']; ?>" required>
                                <small class="text-muted">Ensure the URL is accessible by the target application.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><i class="fa fa-calendar"></i> Broadcast Days</label>
                                <div class="day-selector">
                                    <?php 
                                    $days_selected = explode(',', $data['days']);
                                    $all_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                                    foreach ($all_days as $day) {
                                        $checked = in_array($day, $days_selected) ? 'checked' : '';
                                        $id = 'day_'.strtolower($day);
                                        ?>
                                        <input type="checkbox" name="days[]" value="<?php echo $day; ?>" id="<?php echo $id; ?>" class="day-checkbox" <?php echo $checked; ?>>
                                        <label for="<?php echo $id; ?>" class="day-label"><?php echo $day; ?></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-clock-o"></i> Active From</label>
                                <input type="time" name="time_from" class="form-control" value="<?php echo $data['time_from']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-clock-o"></i> Active Until</label>
                                <input type="time" name="time_until" class="form-control" value="<?php echo $data['time_until']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info btn-fill btn-modern btn-fill-modern pull-right">
                                <i class="fa fa-save"></i> Save Configuration
                            </button>
                            <a href="<?php echo base_url() . $url; ?>" class="btn btn-default btn-modern pull-right" style="margin-right: 15px;">
                                Cancel
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
