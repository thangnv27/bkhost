<?php
/*
  Template Name: Domain
 */

$has_search = false;

if (isset($_POST['d_p']) && !empty($_POST['d_p'])) {
    $has_search = true;
}

get_header();
$list_domain_top = get_top_search();
$list_domain_vn = get_domain_vn();
$list_domain_global = get_domain_global();
?>
<div class="container domain-content domain-page">
    <div class="top-toggle clearfix">
        <ul>
            <li class="active-tg"><a href="<?php bloginfo('url'); ?>/kiem-tra-ten-mien">Đăng ký tên miền<span class="r-res"></span></a></li>
            <li><a href="<?php bloginfo('url'); ?>/bang-gia-ten-mien"><span class="l-prc"></span>Bảng giá tên miền<span class="r-prc"></span></a><span class="prc-line"></span></li>
        </ul>
    </div>
<?php
if ($has_search) {
    require_once(get_template_directory() . '/protected/views/result-search.php');
}
?>

    <div class="clearfix domain-action">
        <form id="fr-domain-action" method="POST">
            <div class="col-left input-domain">
                <label class="lb-title"><span>1</span> Nhập các tên miền cần kiểm tra</label>
                <textarea name="d_text"></textarea>
                <label class="note">Lưu ý: Các tên miền cách nhau dấu cách (space) " " nếu bạn kiểm tra nhiều tên miền.</label>
            </div>
            <div class="col-left list-domain">
                <label class="lb-title"><span>2</span> Chọn loại tên miền</label>
                <label class="group-label-domain">Tên miền phổ biến</label>
                <div class="clearfix">

<?php
if (!empty($list_domain_top)):
    foreach ($list_domain_top as $index => $current_domain):
        ?>

                            <label class="domain-type">
                                <input type="checkbox" name="d_type[<?php echo $index; ?>]" value="<?php echo $current_domain; ?>" checked="1"/>
        <?php echo $current_domain; ?>
                            </label>

                                <?php
                            endforeach;
                        endif;
                        ?>

                </div>
                <label class="group-label-domain clearfix">Tên miền Việt Nam</label>
                <div class="clearfix">

<?php
if (!empty($list_domain_vn)):
    foreach ($list_domain_vn as $index => $current_domain):
        ?>

                            <label class="domain-type">
                                <input type="checkbox" name="d_type[<?php echo $index; ?>]" value="<?php echo $current_domain; ?>"/>
        <?php echo $current_domain; ?>
                            </label>

                                <?php
                            endforeach;
                        endif;
                        ?>

                </div>
                <label class="group-label-domain clearfix">Tên miền Quốc tế</label>
                <div class="clearfix">

<?php
if (!empty($list_domain_global)):
    foreach ($list_domain_global as $index => $current_domain):
        ?>

                            <label class="domain-type">
                                <input type="checkbox" name="d_type[<?php echo $index; ?>]" value="<?php echo $current_domain; ?>"/>
        <?php echo $current_domain; ?>
                            </label>

                                <?php
                            endforeach;
                        endif;
                        ?>

                </div>
            </div>
            <div class="col-left check-domain">
                <label class="lb-title"><span>1</span> Click để kiểm tra</label>
                <input type="hidden" name="d_p" value="p"/>
                <button type="submit">Kiểm tra</button>
            </div>
        </form>
    </div>

</div>

<?php get_footer();