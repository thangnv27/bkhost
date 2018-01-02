<?php
    global $post;
    $post_custom = get_post_custom($post->ID);
    
    $disk_space = (isset($post_custom['disk_space'])) ? $post_custom['disk_space'][0] : '';
    $bandwidth = (isset($post_custom['bandwidth'])) ? $post_custom['bandwidth'][0] : '';
    $addon_domain = (isset($post_custom['addon_domain'])) ? $post_custom['addon_domain'][0] : '';
    $parked_domain = (isset($post_custom['parked_domain'])) ? $post_custom['parked_domain'][0] : '';
    $sub_domain = (isset($post_custom['sub_domain'])) ? $post_custom['sub_domain'][0] : '';
    $mssql_account = (isset($post_custom['mssql_account'])) ? $post_custom['mssql_account'][0] : '';
    $plesk_control = (isset($post_custom['plesk_control'])) ? (bool)$post_custom['plesk_control'][0] : '';
    $hosting_price = (isset($post_custom['hosting_price'])) ? (int)$post_custom['hosting_price'][0] : '';
    
?>
<div class="row">
    <label>Disk Space</label>
    <input type="text" name="disk_space" value="<?php echo $disk_space; ?>"/>
</div>
<div class="row">
    <label>Bandwidth</label>
    <input type="text" name="bandwidth" value="<?php echo $bandwidth; ?>"/>
</div>
<div class="row">
    <label>Addon Domain</label>
    <input type="text" name="addon_domain" value="<?php echo $addon_domain; ?>"/>
</div>
<div class="row">
    <label>Parked Domain</label>
    <input type="text" name="parked_domain" value="<?php echo $parked_domain; ?>"/>
</div>
<div class="row">
    <label>Sub-domain</label>
    <input type="text" name="sub_domain" value="<?php echo $sub_domain; ?>"/>
</div>
<div class="row">
    <label>MSSQL Account</label>
    <input type="text" name="mssql_account" value="<?php echo $mssql_account; ?>"/>
</div>
<div class="row">
    <label>Plesk control</label>
    <select name="plesk_control">
        <option value="yes"<?php if($plesk_control): ?> selected<?php endif; ?>>Có</option>
        <option value="no"<?php if($plesk_control): ?> selected<?php endif; ?>>Không</option>
    </select>
</div>
<div class="row">
    <label>Chọn mức giá</label>
    <select name="hosting_price">
        <option value="1"<?php if($hosting_price === 1): ?> selected<?php endif; ?>>12 tháng - 2.600.000 đ/tháng</option>
        <option value="2"<?php if($hosting_price === 2): ?> selected<?php endif; ?>>6 tháng - 2.700.000 đ/tháng</option>
        <option value="3"<?php if($hosting_price === 3): ?> selected<?php endif; ?>>3 tháng - 2.800.000 đ/tháng</option>
        <option value="4"<?php if($hosting_price === 4): ?> selected<?php endif; ?>>1 tháng - 2.900.000 đ/tháng</option>
    </select>
</div>
<div class="row">
    <input type="hidden" value="hosting_post_type" name="process_hosting"/>
</div>