<?php
    global $post;
    $post_custom = get_post_custom($post->ID);
    
    $cpu = (isset($post_custom['cpu'])) ? $post_custom['cpu'][0] : '';
    $ram = (isset($post_custom['ram'])) ? $post_custom['ram'][0] : '';
    $hdd = (isset($post_custom['hdd'])) ? $post_custom['hdd'][0] : '';
    $port = (isset($post_custom['port'])) ? $post_custom['port'][0] : '';
    $bang_thong = (isset($post_custom['bang_thong'])) ? $post_custom['bang_thong'][0] : '';
    $phi_khoi_tao = (isset($post_custom['phi_khoi_tao'])) ? $post_custom['phi_khoi_tao'][0] : '';
    $data_center = (isset($post_custom['data_center'])) ? (bool)$post_custom['data_center'][0] : '';
    $server_price = (isset($post_custom['server_price'])) ? (int)$post_custom['server_price'][0] : '';
    
?>
<div class="row">
    <label>CPU</label>
    <input type="text" name="cpu" value="<?php echo $cpu; ?>"/>
</div>
<div class="row">
    <label>RAM</label>
    <input type="text" name="ram" value="<?php echo $ram; ?>"/>
</div>
<div class="row">
    <label>HDD</label>
    <input type="text" name="hdd" value="<?php echo $hdd; ?>"/>
</div>
<div class="row">
    <label>Cổng trong nước/ quốc tế:</label>
    <input type="text" name="port" value="<?php echo $port; ?>"/>
</div>
<div class="row">
    <label>Băng thông</label>
    <input type="text" name="bang_thong" value="<?php echo $bang_thong; ?>"/>
</div>
<div class="row">
    <label>Phí khởi tạo</label>
    <input type="text" name="phi_khoi_tao" value="<?php echo $phi_khoi_tao; ?>"/>
</div>
<div class="row">
    <label>Datacenter</label>
    <select name="data_center">
        <option value="yes"<?php if($data_center): ?> selected<?php endif; ?>>VDC</option>
        <option value="no"<?php if($data_center): ?> selected<?php endif; ?>>FPT</option>
    </select>
</div>
<div class="row">
    <label>Chọn mức giá</label>
    <select name="server_price">
        <option value="1"<?php if($server_price === 1): ?> selected<?php endif; ?>>12 tháng - 2.600.000 đ/tháng</option>
        <option value="2"<?php if($server_price === 2): ?> selected<?php endif; ?>>6 tháng - 2.700.000 đ/tháng</option>
        <option value="3"<?php if($server_price === 3): ?> selected<?php endif; ?>>3 tháng - 2.800.000 đ/tháng</option>
        <option value="4"<?php if($server_price === 4): ?> selected<?php endif; ?>>1 tháng - 2.900.000 đ/tháng</option>
    </select>
</div>
<div class="row">
    <input type="hidden" value="server_post_type" name="process_server"/>
</div>