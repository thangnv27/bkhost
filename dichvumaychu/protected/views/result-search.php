<?php 
    if (isset($_POST['d_text']) && !empty($_POST['d_text'])):
        $domain_text = trim($_POST['d_text']);
        $domain_text = preg_replace('/\s+/', ' ', trim($domain_text));
        $domain_text = explode(' ', $domain_text);
        $domain_text = array_unique($domain_text);
        
        if (!empty($domain_text)):
            $result_list = array();
            
            if (isset($_POST['d_type']) && !empty($_POST['d_type'])) {
                $list_domain_search = $_POST['d_type'];
                $list_domain_search = array_unique($list_domain_search);
            } else {
                $list_domain_search = $list_domain_top;
            }
            
            foreach ($domain_text as $domain) {
                if ($pos = strpos($domain, '.')) {
                    $d = substr($domain, $pos, strlen($domain));
                    if (domain_by_title(rtrim($d, '.'))) {
                        domain_check_availability($domain, $result_list);
                    }
                } else {
                    foreach ($list_domain_search as $search) {
                        domain_check_availability($domain.$search, $result_list);
                    }
                }
            }
?>

    <div class="clearfix" id="result-check-domain">
        <span>Kết quả kiểm tra tên miền</span>
        <form action="<?php bloginfo('url'); ?>/___order_add_domain" method="POST">
        <table class="list_add_domain">
            
            <thead>
                <tr>
                    <td><input type="checkbox"/></td>
                    <td>Tên miền</td>
                    <td>Phí cài đặt (vnd)</td>
                    <td>Phí duy trì (vnd)</td>
                    <td>Thông tin</td>
                </tr>
            </thead>
            <tbody>
            <?php
                if (!empty($result_list)):
                    $can_store = false;
                    foreach ($result_list as $domain):
                        $price = get_phi_ten_mien($domain['domain']);
             ?>
             
                <tr class="<?php if($domain['status']): $can_store = true; ?>yes<?php else: ?>bad<?php endif; ?>">
                    <input type="hidden" name="save_domain[<?php echo $domain['domain']; ?>][prod_id]" value="<?php echo $domain['ID']; ?>"/>
                    <input type="hidden" name="save_domain[<?php echo $domain['domain']; ?>][prod_price]" value='<?php echo json_encode($price['json']); ?>'/>
                    <input type="hidden" name="save_domain[<?php echo $domain['domain']; ?>][prod_name]" value="<?php echo $domain['domain']; ?>"/>
                    
                    <td><?php if($domain['status']): ?><input type="checkbox" value="<?php echo $domain['domain']; ?>"  name="prod_has_choice[]"/><?php endif; ?></td>
                    <td class="td-bold"><?php echo $domain['domain']; ?></td>
                    <td><?php echo $price[0]; ?></td>
                    <td><?php echo $price[1]; ?></td>
                    <?php if($domain['status']): ?>
                        <td style="text-align: center;"><span class="result-domain yes"></span></td>
                    <?php else: ?>
                        <td>
                            <a href="#" id="view-whois" data-domain="<?php echo $domain['domain']; ?>"><span class="result-domain bad"></span></a>
                        </td>
                    <?php endif; ?>
                </tr>
             
             <?php
                    endforeach;
                endif;
            ?>
            
            </tbody>
        </table>
        <div class="bot-option">
                <input type="hidden" name="prod_type" value="ten-mien"/>
                <button type="submit" name="add_more">Đăng ký</button>
            </form>
        </div>
    </div>
<?php
        endif; 
    endif;