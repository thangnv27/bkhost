<?php get_header(); ?>

<div class="order-content container domain-content">
    <div class="clear ss-panel">
        <h2>Đặt hàng thành công!</h2>
        <p>Xin chào <strong><?php echo $ho_ten; ?></strong>, chúng tôi đã nhận được đơn đặt hàng của bạn:</p>
        <ul>
            <li><p>Mã số: <strong><?php echo $ma_don_hang; ?></strong></p></li>
            <li><p>Thành tiền: <strong><?php echo number_format($total_price); ?> vnđ</strong></p></li>
            <li><p>VAT: <strong><?php echo number_format($vat_checkout); ?> vnđ</strong></p></li>
            <li><p>Tổng tiền: <strong><?php echo number_format($total_checkout); ?> vnđ</strong></p></li>
        </ul>
        <p>Chúng tôi sẽ phản hồi lại trong thời gian sớm nhất, cảm ơn bạn đã sử dụng dịch vụ tại BKHOST!</p>
    </div>
</div>

<?php get_footer(); ?>