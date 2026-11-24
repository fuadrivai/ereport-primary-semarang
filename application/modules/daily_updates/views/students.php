<style type="text/css">
    .student-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        border: 1px solid #f0f0f0;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: block;
    }
    .student-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        border-color: #1d62f0;
    }
    .student-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f8f9fa;
    }
    .student-name-text {
        font-weight: 800;
        font-size: 18px;
        color: #1a1a1a;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 180px;
    }
    .student-meta {
        font-size: 13px;
        color: #888;
    }

    /* Search Bar */
    .search-container {
        margin-bottom: 25px;
        position: relative;
    }
    .search-input {
        width: 100%;
        padding: 12px 20px 12px 45px;
        border-radius: 30px;
        border: 2px solid #eee;
        background: #fff;
        font-size: 15px;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .search-input:focus {
        border-color: #1d62f0;
        outline: none;
        box-shadow: 0 8px 15px rgba(29, 98, 240, 0.1);
    }
    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 16px;
    }
    
    .attendance-btns {
        display: flex;
        gap: 8px;
    }
    .btn-attend {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.2s;
        border: none;
    }
    .btn-checkin {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .btn-checkin:hover {
        background: #2e7d32;
        color: #fff;
    }
    .btn-checkout {
        background: #ffebee;
        color: #c62828;
    }
    .btn-checkout:hover {
        background: #c62828;
        color: #fff;
    }
    
    .btn-checkin.completed {
        background: #2e7d32;
        color: #fff;
    }
    .btn-checkout.completed {
        background: #c62828;
        color: #fff;
    }
    
    /* Segmented Controls */
    .segmented-control {
        display: flex;
        background: #f4f6f9;
        padding: 4px;
        border-radius: 12px;
        margin-bottom: 15px;
    }
    .segment-item {
        flex: 1;
        position: relative;
    }
    .segment-item input {
        display: none;
    }
    .segment-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 5px;
        font-size: 12px;
        font-weight: 700;
        color: #666;
        cursor: pointer;
        border-radius: 10px;
        transition: all 0.2s;
        text-align: center;
    }
    .segment-item input:checked + .segment-label {
        background: #fff;
        color: #1d62f0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    
    /* Color coding for specific segments */
    .segment-item.meal input:checked + .segment-label { color: #2e7d32; }
    .segment-item.mood input:checked + .segment-label { color: #ef6c00; }
    .segment-item.health input:checked + .segment-label { color: #c62828; }

    .section-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #aaa;
        margin-bottom: 8px;
        display: block;
        letter-spacing: 0.5px;
    }

    .health-detail-input {
        background: #fff;
        border: 1.5px solid #eee;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 13px;
        width: 100%;
        margin-top: 10px;
        transition: border-color 0.2s;
    }
    .health-detail-input:focus {
        border-color: #c62828;
        outline: none;
    }

    .sticky-actions {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        display: flex;
        gap: 15px;
    }
    .btn-premium {
        border-radius: 30px;
        padding: 15px 40px;
        font-weight: 800;
        font-size: 16px;
        letter-spacing: 1px;
        text-transform: uppercase;
        border: none;
        box-shadow: 0 10px 25px rgba(29, 98, 240, 0.4);
        transition: all 0.3s;
    }
    .btn-premium:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 20px 35px rgba(29, 98, 240, 0.5);
    }
</style>

<div class="row">
    <div class="col-md-12">
        <?php echo $this->session->flashdata('k'); ?>
        <div style="margin-bottom: 40px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <?php if ($admlevel == 'admin'): ?>
                <a href="<?php echo base_url() . $url; ?>" class="btn btn-link" style="color: #1d62f0; padding-left: 0;"><i class="fa fa-arrow-left"></i> Change Class</a>
                <?php endif; ?>
                <h2 style="font-weight: 900; color: #1a1a1a; margin-top: 5px;">Class <?php echo $kelas['nama']; ?></h2>
                <p style="color: #888; font-size: 15px;">Daily monitoring and observations</p>
            </div>
            <div class="hidden-xs">
                <div style="background: white; padding: 10px 20px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <span style="font-weight: 700; color: #555;"><i class="fa fa-calendar-o"></i> <?php echo date('l, d F Y'); ?></span>
                </div>
            </div>
        </div>

        <form action="<?php echo base_url() . $url; ?>/simpan_bulk" method="post">
            <input type="hidden" name="id_kelas" value="<?php echo $kelas['id']; ?>">
            
            <div class="search-container">
                <i class="fa fa-search search-icon"></i>
                <input type="text" id="student_search" class="search-input" placeholder="Search student name here...">
            </div>

            <div class="row" id="student_list">
                <?php foreach ($students as $s): ?>
                <div class="col-md-6 col-lg-4 student-card-container" data-name="<?php echo strtolower($s['nama']); ?>">
                    <div class="student-card">
                        <div class="student-header">
                            <div>
                                <h4 class="student-name-text"><?php echo strtoupper($s['nama']); ?></h4>
                                <div class="student-meta">NIS: <?php echo $s['nis']; ?></div>
                            </div>
                            <input type="hidden" name="student_ids[]" value="<?php echo $s['id']; ?>">
                            
                            <!-- Attendance Buttons -->
                            <div class="attendance-btns">
                                <a href="<?php echo base_url() . $url; ?>/form/check_in/<?php echo $s['id']; ?>?id_kelas=<?php echo $kelas['id']; ?>" class="btn-attend btn-checkin <?php echo !empty($s['is_checkin']) ? 'completed' : ''; ?>" title="<?php echo !empty($s['is_checkin']) ? 'Checked-In' : 'Check-In'; ?>">
                                    <i class="fa <?php echo !empty($s['is_checkin']) ? 'fa-check' : 'fa-sign-in'; ?>"></i>
                                </a>
                                <a href="<?php echo base_url() . $url; ?>/form/check_out/<?php echo $s['id']; ?>?id_kelas=<?php echo $kelas['id']; ?>" class="btn-attend btn-checkout <?php echo !empty($s['is_checkout']) ? 'completed' : ''; ?>" title="<?php echo !empty($s['is_checkout']) ? 'Checked-Out' : 'Check-Out'; ?>">
                                    <i class="fa <?php echo !empty($s['is_checkout']) ? 'fa-check' : 'fa-sign-out'; ?>"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Meal Monitoring -->
                        <span class="section-label">Meal Intake</span>
                        <div class="segmented-control">
                            <div class="segment-item meal">
                                <input type="radio" name="meal_status[<?php echo $s['id']; ?>]" id="meal_f_<?php echo $s['id']; ?>" value="Finished" <?php echo (empty($s['today_meal']) || $s['today_meal'] == 'Finished') ? 'checked' : ''; ?>>
                                <label for="meal_f_<?php echo $s['id']; ?>" class="segment-label">Finished</label>
                            </div>
                            <div class="segment-item meal">
                                <input type="radio" name="meal_status[<?php echo $s['id']; ?>]" id="meal_h_<?php echo $s['id']; ?>" value="Half Eaten" <?php echo ($s['today_meal'] == 'Half Eaten') ? 'checked' : ''; ?>>
                                <label for="meal_h_<?php echo $s['id']; ?>" class="segment-label">Half Eaten</label>
                            </div>
                            <div class="segment-item meal">
                                <input type="radio" name="meal_status[<?php echo $s['id']; ?>]" id="meal_n_<?php echo $s['id']; ?>" value="Not Eating" <?php echo ($s['today_meal'] == 'Not Eating') ? 'checked' : ''; ?>>
                                <label for="meal_n_<?php echo $s['id']; ?>" class="segment-label">Not Eating</label>
                            </div>
                        </div>

                        <!-- Mood Observation -->
                        <span class="section-label">Student Mood</span>
                        <div class="segmented-control">
                            <div class="segment-item mood">
                                <input type="radio" name="mood[<?php echo $s['id']; ?>]" id="mood_e_<?php echo $s['id']; ?>" value="Enthusiastic" <?php echo ($s['today_mood'] == 'Enthusiastic') ? 'checked' : ''; ?>>
                                <label for="mood_e_<?php echo $s['id']; ?>" class="segment-label">😊 Enthuse</label>
                            </div>
                            <div class="segment-item mood">
                                <input type="radio" name="mood[<?php echo $s['id']; ?>]" id="mood_n_<?php echo $s['id']; ?>" value="Neutral" <?php echo (empty($s['today_mood']) || $s['today_mood'] == 'Neutral') ? 'checked' : ''; ?>>
                                <label for="mood_n_<?php echo $s['id']; ?>" class="segment-label">😐 Neutral</label>
                            </div>
                            <div class="segment-item mood">
                                <input type="radio" name="mood[<?php echo $s['id']; ?>]" id="mood_l_<?php echo $s['id']; ?>" value="Low mood" <?php echo ($s['today_mood'] == 'Low mood') ? 'checked' : ''; ?>>
                                <label for="mood_l_<?php echo $s['id']; ?>" class="segment-label">😢 Low</label>
                            </div>
                        </div>

                        <!-- Health Status -->
                        <span class="section-label">Health Status</span>
                        <div class="segmented-control">
                            <div class="segment-item health">
                                <input type="radio" name="health_status[<?php echo $s['id']; ?>]" id="health_h_<?php echo $s['id']; ?>" value="Healthy" <?php echo (empty($s['today_health']) || $s['today_health'] == 'Healthy') ? 'checked' : ''; ?> onclick="toggleDetail(<?php echo $s['id']; ?>, false)">
                                <label for="health_h_<?php echo $s['id']; ?>" class="segment-label">Healthy</label>
                            </div>
                            <div class="segment-item health">
                                <input type="radio" name="health_status[<?php echo $s['id']; ?>]" id="health_i_<?php echo $s['id']; ?>" value="Minor Illness" <?php echo ($s['today_health'] == 'Minor Illness') ? 'checked' : ''; ?> onclick="toggleDetail(<?php echo $s['id']; ?>, true)">
                                <label for="health_i_<?php echo $s['id']; ?>" class="segment-label">Illness</label>
                            </div>
                            <div class="segment-item health">
                                <input type="radio" name="health_status[<?php echo $s['id']; ?>]" id="health_a_<?php echo $s['id']; ?>" value="Accident" <?php echo ($s['today_health'] == 'Accident') ? 'checked' : ''; ?> onclick="toggleDetail(<?php echo $s['id']; ?>, true)">
                                <label for="health_a_<?php echo $s['id']; ?>" class="segment-label">Incident</label>
                            </div>
                        </div>
                        
                        <?php $show_detail = (!empty($s['today_health']) && $s['today_health'] != 'Healthy'); ?>
                        <input type="text" name="health_details[<?php echo $s['id']; ?>]" id="details_<?php echo $s['id']; ?>" class="health-detail-input" placeholder="Explain details here..." style="display: <?php echo $show_detail ? 'block' : 'none'; ?>;" value="<?php echo isset($s['today_health_details']) ? $s['today_health_details'] : ''; ?>">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="sticky-actions">
                <button type="submit" class="btn btn-primary btn-fill btn-premium">
                    <i class="fa fa-cloud-upload"></i> Save All Updates
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Real-time search
        $("#student_search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".student-card-container").filter(function() {
                $(this).toggle($(this).data("name").indexOf(value) > -1)
            });
        });
    });

    function toggleDetail(studentId, show) {
        const el = document.getElementById('details_' + studentId);
        if (show) {
            el.style.display = 'block';
            el.focus();
        } else {
            el.style.display = 'none';
        }
    }

    $(document).ready(function() {
        $('form').on('submit', function() {
            var $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true);
            $btn.html('<i class="fa fa-spinner fa-spin"></i> SAVING...');
            
            swal({
                title: 'Saving Updates...',
                text: 'Please wait while we sync all student observations.',
                imageUrl: '<?php echo base_url(); ?>aset/img/loading-bubbles.svg',
                showConfirmButton: false,
                allowOutsideClick: false
            });
        });
    });
</script>
