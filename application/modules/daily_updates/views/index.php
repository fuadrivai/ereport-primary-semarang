<style type="text/css">
    .index-header {
        margin-bottom: 40px;
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .level-badge {
        background: #f0f4ff;
        color: #1d62f0;
        padding: 6px 12px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 10px;
    }
    .class-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        padding: 25px;
        margin-bottom: 25px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: block;
        text-decoration: none !important;
        position: relative;
        overflow: hidden;
    }
    .class-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(29, 98, 240, 0.1);
        border-color: #1d62f0;
    }
    .class-card::after {
        content: '\f105';
        font-family: FontAwesome;
        position: absolute;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 24px;
        color: #1d62f0;
        transition: all 0.3s;
        opacity: 0;
    }
    .class-card:hover::after {
        right: 20px;
        opacity: 1;
    }
    .class-avatar {
        width: 50px;
        height: 50px;
        background: #1d62f0;
        color: white;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 15px;
        box-shadow: 0 8px 15px rgba(29, 98, 240, 0.2);
    }
    .class-name {
        font-size: 20px;
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 5px;
    }
    .class-stats {
        font-size: 13px;
        color: #888;
    }
    
    .level-section-title {
        font-weight: 900;
        color: #1a1a1a;
        font-size: 24px;
        margin-top: 40px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .level-section-title::after {
        content: '';
        flex-grow: 1;
        height: 2px;
        background: #f0f0f0;
    }

    /* Search bar styles (shared with students.php) */
    .search-container {
        margin-top: 20px;
        position: relative;
    }
    .search-input {
        width: 100%;
        padding: 15px 20px 15px 50px;
        border-radius: 35px;
        border: 2px solid #eee;
        background: #fdfdfd;
        font-size: 16px;
        transition: all 0.3s;
    }
    .search-input:focus {
        border-color: #1d62f0;
        background: white;
        outline: none;
        box-shadow: 0 10px 20px rgba(29, 98, 240, 0.05);
    }
    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 18px;
    }
</style>

<div class="index-header">
    <div class="row">
        <div class="col-md-7">
            <h1 style="font-weight: 900; color: #1a1a1a; margin: 0;">Daily Updates</h1>
            <p style="color: #888; font-size: 16px; margin-top: 10px;">Select a class to manage monitoring and observations.</p>
        </div>
        <div class="col-md-5">
            <div class="search-container">
                <i class="fa fa-search search-icon"></i>
                <input type="text" id="class_search" class="search-input" placeholder="Find a class...">
            </div>
        </div>
    </div>
</div>

<?php 
// Group classes by level
$grouped_classes = array();
foreach ($p_kelas as $k) {
    if (!empty($k['id'])) { // Ensure it's not the empty placeholder if it exists
        $grouped_classes[$k['tingkat']][] = $k;
    }
}
ksort($grouped_classes);
?>

<?php foreach ($grouped_classes as $tingkat => $classes): ?>
<div class="level-group" data-tingkat="<?php echo $tingkat; ?>">
    <h3 class="level-section-title">
        <span style="color: #1d62f0;">Level</span> <?php echo $tingkat; ?>
    </h3>
    <div class="row">
        <?php foreach ($classes as $k): ?>
        <div class="col-md-4 col-sm-6 class-card-container" data-name="<?php echo strtolower($k['nama']); ?>">
            <a href="<?php echo base_url() . $url; ?>/students/<?php echo $k['id']; ?>" class="class-card">
                <div class="class-avatar">
                    <?php echo substr($k['nama'], 0, 1); ?>
                </div>
                <div class="class-name"><?php echo $k['nama']; ?></div>
                <div class="class-stats">
                    <i class="fa fa-graduation-cap"></i> Primary School 
                    <span style="margin: 0 8px; color: #eee;">|</span>
                    <i class="fa fa-calendar-check-o text-success"></i> Active
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $("#class_search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".class-card-container").filter(function() {
                var match = $(this).data("name").indexOf(value) > -1;
                $(this).toggle(match);
                return match;
            });
            
            // Hide level titles if no classes are visible in that group
            $(".level-group").each(function() {
                var hasVisible = $(this).find(".class-card-container:visible").length > 0;
                $(this).toggle(hasVisible);
            });
        });
    });
</script>
