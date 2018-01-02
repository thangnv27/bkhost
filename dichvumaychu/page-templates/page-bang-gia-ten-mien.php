<?php
/*
  Template Name: Price Domain
 */

get_header();

$list_domain_vn = get_domain_by_group(431);
$list_domain_global = get_domain_by_group(433);

/* * **************************************************
  Language - change as needed to your own language and the whole script will transform to your language
 * ************************************************** */

$language = array(
    'invalid_domain' => 'Tên miền không hợp lệ (Chỉ được phép dùng chữ, số và dấu gạch ngang)',
    'tld_not_allowed' => 'TLD không cho phép', //appears when an invalid TLD is entered
    'fill_in_Captcha' => 'Vui lòng điền vào trường xác thực ở trên ',
    'captcha_nomatch' => 'Mã xác nhận không đúng. Vui lòng nhập lại',
    'bulk_checker' => 'Kiểm tra cùng lúc nhiều tên miền',
    'max_domains' => ' Số lượng tên miền kiểm tra tối đa: ',
    'save_as_text_file' => 'Lưu kết quả kiểm tra vào file text?',
    'only_available' => 'Available domains only',
    'check_availability' => 'Kiểm Tra',
    'processing' => 'Đang xử lý...',
    'emailed' => ' Emailed available domains...',
    'done' => '<div class="alert alert-success" role="alert">Xong</div>',
    'not_available' => '<span class="label bg-red">Đã được đăng ký</span>',
    'available' => '<span class="label bg-green">Chưa đăng ký</span>',
    'too_many' => 'Đã gửi quá nhiều tên miền',
    'going_to_check' => 'Số lượng tên miền kiểm tra: ',
    'done' => '<div class="alert alert-success" role="alert">Xong</div>',
    'intro_text' => 'Nhập danh sách tên miền để kiểm tra, mỗi tên miền trên một dòng.',
    'enter_captcha' => 'Vui lòng nhập mã xác nhận bên dưới:',
    'wrong_captcha' => ' Mã xác nhận không đúng. Vui lòng thử lại.',
    'current_status' => 'Now at domain (line): ',
    'completed' => '<div class="alert alert-success" role="alert"><strong>Xong!</strong> Hệ thống đã hoàn thành việc kiểm tra các tên miền.</div>'
);
?>
<div id="post-content">
    <div class="panel-bg">
        <div class="domain-content domain-page" style="background: #fff">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <h1 style="padding-left: 10px; padding-top: 10px; text-transform: uppercase; text-align: center; color: rgb(234, 108, 0); font-size: 24px;"><?php the_title(); ?></h1>
                    <div style="margin-bottom: 20px;text-align: center;padding: 10px">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
            <div class="top-toggle clearfix">
                <ul>
                    <li><a href="<?php bloginfo('url'); ?>/search-domains">Đăng ký tên miền<span class="r-res"></span></a></li>
                    <li class="active-tg"><a href="<?php bloginfo('url'); ?>/bang-gia-ten-mien"><span class="l-prc"></span>Bảng giá tên miền<span class="r-prc"></span></a><span class="prc-line"></span></li>
                </ul>
            </div>
            <div class="price-domain-table">
                <!-- BEGIN FORM-->
                <p style="max-width:98%; margin:0 auto 10px"><?php echo $language['intro_text']; ?></p>
                <form action="<?php bloginfo('url'); ?>/search-domains/" id="form-username" method="post">
                    <div class="form-group">
                        <textarea rows="5" class="form-control" id="domains" name="domains" style="max-width:98%; margin:auto"><?php echo (isset($_REQUEST['domains'])) ? $_REQUEST['domains'] : ""; ?></textarea>
                    </div>
                    <div class="form-group" style="text-align: center">
                        <button type="submit" class="btn btn-success" name="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?php echo $language['check_availability'] ?></button>
                    </div>
                </form>
                <!-- END FORM-->
                <?php if (isset($_POST['domains'])): ?>
                    <div class="table"><?php processSubmit(); ?></div>
                <?php endif; ?>
            </div>
            <div class="price-domain-table">

                <?php
                if (!empty($list_domain_vn)):
                    ?>

                    <div class="top-option" id="domain-vn">
                        <span>Tên miền Việt Nam</span>
                    </div>
                    <table class="table">
                        <thead>
                            <tr style="background: #ff9933">
                                <td style="color: #fff">Tên miền</td>
                                <td style="color: #fff">Phí khởi tạo</td>
                                <td style="color: #fff">Phí duy trì / năm</td>
                                <td style="color: #fff">Transfer về BKHOST</td>
                            </tr>
                        </thead>
                        <tbody>

            <?php foreach ($list_domain_vn as $domain): ?>

                                <tr>

                                    <td><?php echo $domain['name']; ?></td>
                <?php if ($domain['phi_khoi_tao'] === 'Free'): ?>
                                        <td><span class="free-price"></span></td>
                                    <?php elseif ($domain['phi_khoi_tao_giam_gia'] !== '0'): ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_khoi_tao_giam_gia']; ?> vnđ</span><span class="sub-price">(<?php echo $domain['phi_khoi_tao']; ?> vnđ)</span></td>
                                    <?php else: ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_khoi_tao']; ?> vnđ</span></span></td>
                                    <?php endif; ?>

                                    <?php if ($domain['phi_duy_tri'] === 'Free'): ?>
                                        <td><span class="free-price"></span></td>
                                    <?php elseif ($domain['phi_duy_tri_giam_gia'] !== '0'): ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_duy_tri_giam_gia']; ?> vnđ</span><span class="sub-price">(<?php echo $domain['phi_duy_tri']; ?> vnđ)</span></td>
                                    <?php else: ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_duy_tri']; ?> vnđ</span></span></td>
                                    <?php endif; ?>

                                    <?php if ($domain['phi_transfer_ve_vdo'] === 'Free'): ?>
                                        <td><span class="free-price"></span></td>
                                    <?php elseif (strtolower($domain['phi_transfer_ve_vdo_giam_gia']) == 'không được phép transfer'): ?>
                                        <td><span class="no-transfer">Không được phép transfer</span></td>
                                    <?php elseif ($domain['phi_transfer_ve_vdo_giam_gia'] !== '0'): ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_transfer_ve_vdo_giam_gia']; ?> vnđ</span><span class="sub-price">(<?php echo $domain['phi_transfer_ve_vdo']; ?> vnđ)</span></td>     
                                    <?php else: ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_transfer_ve_vdo']; ?> vnđ</span></span></td>
                                    <?php endif; ?>

                                </tr>

            <?php endforeach; ?>

                        </tbody>
                    </table>

            <?php
        endif;
        if (!empty($list_domain_global)):
            ?>

                    <div class="top-option bottom" id="domain-global">
                        <span>Tên miền Quốc Tế</span>
                    </div>
                    <table class="table">
                        <thead>
                            <tr style="background: #ff9933">
                                <td style="color: #fff">Tên miền</td>
                                <td style="color: #fff">Phí khởi tạo</td>
                                <td style="color: #fff">Phí duy trì / năm</td>
                                <td style="color: #fff">Transfer về BKHOST</td>
                            </tr>
                        </thead>
                        <tbody>
            <?php foreach ($list_domain_global as $domain): ?>
                                <tr>
                                    <td><?php echo $domain['name']; ?></td>
                <?php if ($domain['phi_khoi_tao'] === 'Free'): ?>
                                        <td><span class="free-price"></span></td>
                                    <?php elseif ($domain['phi_khoi_tao_giam_gia'] !== '0'): ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_khoi_tao_giam_gia']; ?> vnđ</span><span class="sub-price">(<?php echo $domain['phi_khoi_tao']; ?> vnđ)</span></td>
                                    <?php else: ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_khoi_tao']; ?> vnđ</span></span></td>
                                    <?php endif; ?>

                                    <?php if ($domain['phi_duy_tri'] === 'Free'): ?>
                                        <td><span class="free-price"></span></td>
                                    <?php elseif ($domain['phi_duy_tri_giam_gia'] !== '0'): ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_duy_tri_giam_gia']; ?> vnđ</span><span class="sub-price">(<?php echo $domain['phi_duy_tri']; ?> vnđ)</span></td>
                                    <?php else: ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_duy_tri']; ?> vnđ</span></span></td>
                                    <?php endif; ?>

                                    <?php if ($domain['phi_transfer_ve_vdo'] === 'Free'): ?>
                                        <td><span class="free-price"></span></td>
                                    <?php elseif (strtolower($domain['phi_transfer_ve_vdo']) == 'không được phép transfer'): ?>
                                        <td><span class="no-transfer">Không được phép transfer</span></td>
                                    <?php elseif ($domain['phi_transfer_ve_vdo_giam_gia'] !== '0'): ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_transfer_ve_vdo_giam_gia']; ?> vnđ</span><span class="sub-price">(<?php echo $domain['phi_transfer_ve_vdo']; ?> vnđ)</span></td>     
                                    <?php else: ?>
                                        <td><span class="primary-price"><?php echo $domain['phi_transfer_ve_vdo']; ?> vnđ</span></span></td>
                                    <?php endif; ?>

                                </tr>

            <?php endforeach; ?>
                        </tbody>
                    </table>
        <?php endif; ?>
            </div>

            <?php get_template_part('template', 'support'); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var placeholder = 'bkhost01.net\nbkhost02.com';
        $('#domains').val(placeholder).focus();
        $('#domains').focus(function () {
            if ($(this).val() === placeholder) {
                $(this).val('');
            }
        });
        $('#domains').blur(function () {
            if ($(this).val() === '') {
                $(this).val(placeholder);
            }
        });
    });
</script>
<?php get_footer(); ?>