<?php
/*
  Template Name: ANAN Page
 */

get_header('home');
?>
<div class="main-slider"><!-- main slider -->
    <?php echo do_shortcode('[rev_slider home-slider]'); ?>
</div><!-- end main slider -->

<div id="page-wrap" class="page-container"><!-- page wrap -->
    <div class="an-wrapper">
        
        <!-- DOMAIN -->
        <script type="text/javascript">
            function kiemtrav() {
                var txt1 = jQuery("#domainNameSingleInput").val();
                if (txt1 == "") {
                    jAlert("Ten mien khong duoc de trong ", "");
                    return;
                } else if (txt1.length < 3) {
                    jAlert("Ten mien phai > 2 ky tu", "");
                    return;
                } else if (txt1.length > 63) {
                    jAlert("Ten mien phai < 63 ky tu", "");
                    return;
                } else {
                    jQuery("#submit-bulk-domain").submit();
                }
            }
            var rBlock = {
                'SpecialChar': /['\'\"\\#~`<>;']/g,
                'AllSpecialChar': /['@\'\"\\~<>;`&\/%$^*{}\[\]!|():,?+=#']/g,
                'NotNumbers': /[^\d]/g

            }
            function BlockChar(div, type) {
                div.value = div.value.replace(rBlock[type], '');
                div.value = div.value.replace(/ +/g, ' ');
            }
            function BlockCharhome(div, type) {
                div.value = div.value.replace(rBlock[type], '');
                div.value = div.value.replace(/ +/g, ' ');
                jQuery("#txt_search_new").hide();
            }
            function checkmanyDomain() {
                var txt1 = jQuery("#domainNameSingleInput").val();
                txt1 = $.trim(txt1);
                var array_domain = txt1.split('\n');
                //var total_domain = array_domain.length;
                if (txt1 === "") {
                    jAlert("Nhap ten mien can kiem tra", "");
                    return;
                }
                /*if (total_domain > 29) {
                    jAlert("Khong the kiem tra 29 ten mien cung 1 luc", "");
                    return;
                }*/
                jQuery("#submit-bulk-domain").submit();
            }
        </script>
        <style>
            .select_sale {
                display: none;
            }
            .show {
                display: block;
            }
        </style>
        <script>
            jQuery(document).ready(function () {
                jQuery(".tab_select li a").click(function () {
                    jQuery(".tab_select li a").removeClass("active");
                    jQuery(this).addClass("active");
                    jQuery(".select_sale").removeClass("show");
                    var tab_cur_1 = jQuery(this).attr('href');
                    if (tab_cur_1 !== "#tab1") {
                        jQuery("#saleoff").hide();
                    } else {
                        jQuery("#saleoff").show();
                    }
                    jQuery(tab_cur_1).addClass("show");
                    return false;
                });
                var txt_search1 = jQuery("#domainNameSingleInput").val();
                if (txt_search1 !== "") {
                    jQuery("#txt_search_new").hide();
                }
            });
        </script>
        <div class="an-domain"> 
            <form method="post" action="<?php bloginfo('url'); ?>/search-domains/" name="form1" id="submit-bulk-domain">
                <div class="search_new">
                    <div class="wrap bg_search1">
                        <div class="col2 col8">
                            <h3><img src="<?php echo THEME_IMG_URI; ?>/bkhost/search_icon2.png"><span>Chọn ít nhất 1 đuôi tên miền</span></h3>
                            <div class="select_domain">
                                <ul class="tab_select">
                                    <li><a class="active" href="#tab1"><img src="<?php echo THEME_IMG_URI; ?>/bkhost/tab_select_bullet.png">Sale off</a></li>
                                    <li><a href="#tab2">Phổ biến</a></li>
                                    <li><a href="#tab3">Quốc tế</a></li>
                                    <li><a href="#tab4">Việt Nam</a></li>
                                    <li><a href="#tab5">Mới</a></li>
                                </ul>
                                <div style="margin-top:3px; text-align:center; float:left; width:100%"><img src="<?php echo THEME_IMG_URI; ?>/bkhost/km.gif"></div>			

                                <ul class="select_sale" id="saleoff" style="display:block;">
                                    <li>
                                        <img src="<?php echo THEME_IMG_URI; ?>/bkhost/search_domain1.gif">
                                        <span>
                                            <input type="checkbox" checked="checked" id="saffoffcom" class="css-checkbox" value="com" name="ext[]">
                                            <label class="css-label-checkbox" for="saffoffcom"></label>
                                        </span>
                                    </li>
                                    <li>
                                        <img src="<?php echo THEME_IMG_URI; ?>/bkhost/search_domain2.gif">
                                        <span>
                                            <input type="checkbox" checked="checked" id="saffoffvn" class="css-checkbox" value="vn" name="ext[]">
                                            <label class="css-label-checkbox" for="saffoffvn"></label>
                                        </span>
                                    </li>
                                    <li>
                                        <img src="<?php echo THEME_IMG_URI; ?>/bkhost/search_domain3.gif">
                                        <span>
                                            <input type="checkbox" checked="checked" id="saffoffxyz" class="css-checkbox" value="xyz" name="ext[]">
                                            <label class="css-label-checkbox" for="saffoffxyz"></label>
                                        </span>
                                    </li>
                                </ul>
                                <ul class="select_sale show" id="tab1">  

                                    <li>
                                        <input type="checkbox" id="tab1info" class="css-checkbox" value="info" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1info"><strong>.info</strong> <b>139K</b> <font>278k</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab1provn" class="css-checkbox" value="pro.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1provn"><strong>.pro.vn</strong> <b>-30%</b> <font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab1pw" class="css-checkbox" value="pw" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1pw"><strong>.pw</strong> <b>24K</b> <font>2380k</font></label>
                                    </li>
                                    <!-- cot 2-->
                                    <li>
                                        <input type="checkbox" id="tab1biz" class="css-checkbox" value="biz" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1biz"><strong>.biz</strong> <b>139K</b> <font>280k</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab1comvn" class="css-checkbox" value="com.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1comvn"><strong>.com.vn</strong> <b>-30%</b> <font>700K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab1pics" class="css-checkbox" value="pics" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1pics"><strong>.pics</strong> <b>199K</b> <font>545k</font></label>
                                    </li>
                                    <!-- cot 3-->
                                    <li>
                                        <input type="checkbox" id="tab1net" class="css-checkbox" value="net" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1net"><strong>.net</strong> <b>260k</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tabnetvn" class="css-checkbox" value="net.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tabnetvn"><strong>.net.vn</strong> <b>-30%</b> <font>700k</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab1click" class="css-checkbox" value="click" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1click"><strong>.click</strong> <b>24K</b> <font>245k</font></label>
                                    </li>
                                    <!-- cot 4-->
                                    <li>
                                        <input type="checkbox" id="tab1mobi" class="css-checkbox" value="mobi" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1mobi"><strong>.mobi</strong> <b>99K</b><font>445k</font> </label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab1asia" class="css-checkbox" value="asia" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1asia"><strong>.asia</strong> <b>49K</b> <font>360k</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab1top" class="css-checkbox" value="top" name="ext[]">
                                        <label class="css-label-checkbox" for="tab1top"><strong>.top</strong> <b>49K</b><font>2380k</font> </label>
                                    </li>
                                </ul>
                                <!-- tab 2 -->
                                <ul class="select_sale" id="tab2">
                                    <li>
                                        <input type="checkbox" id="tab2vn" class="css-checkbox" value="vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2vn"><strong>.vn</strong>  <b>-30%</b><font>830K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2com.vn" class="css-checkbox" value="com.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2com.vn"><strong>.com.vn</strong>  <b>-30%</b><font>700K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2net.vn" class="css-checkbox" value="net.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2net.vn"><strong>.net.vn</strong>  <b>-30%</b><font>700K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2biz.vn" class="css-checkbox" value="biz.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2biz.vn"><strong>.biz.vn</strong>  <b>-30%</b><font>700K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2org.vn" class="css-checkbox" value="org.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2org.vn"><strong>.org.vn</strong>  <b>-30%</b><font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2gov.vn" class="css-checkbox" value="gov.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2gov.vn"><strong>.gov.vn</strong>  <b>-30%</b><font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2edu.vn" class="css-checkbox" value="edu.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2edu.vn"><strong>.edu.vn</strong>  <b>-30%</b><font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2com" class="css-checkbox" value="com" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2com"><strong>.com</strong>  <b>109K</b><font>260K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2net" class="css-checkbox" value="net" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2net"><strong>.net</strong>   <b>260K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2info" class="css-checkbox" value="info" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2info"><strong>.info</strong>  <b>139K</b><font>278K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2org" class="css-checkbox" value="org" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2org"><strong>.org</strong>   <b>270K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2biz" class="css-checkbox" value="biz" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2biz"><strong>.biz</strong>  <b>139K</b><font>280K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2mobi" class="css-checkbox" value="mobi" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2mobi"><strong>.mobi</strong>  <b>99K</b><font>445K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2xyz" class="css-checkbox" value="xyz" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2xyz"><strong>.xyz</strong>  <b>24K</b><font>285K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2pw" class="css-checkbox" value="pw" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2pw"><strong>.pw</strong>  <b>24K</b><font>245K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2co" class="css-checkbox" value="co" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2co"><strong>.co</strong>  <b>99k</b><font>605K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2club" class="css-checkbox" value="club" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2club"><strong>.club</strong>  <b>179k</b><font>385K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab2link" class="css-checkbox" value="link" name="ext[]">
                                        <label class="css-label-checkbox" for="tab2link"><strong>.link</strong>  <b>24K</b><font>245K</font></label>
                                    </li>
                                </ul>
                                <!-- tab 3-->
                                <ul class="select_sale" id="tab3">
                                    <li>
                                        <input type="checkbox" id="tab3com" class="css-checkbox" value="com" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3com"><strong>.com</strong>  <b>109K</b><font>260K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3net" class="css-checkbox" value="net" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3net"><strong>.net</strong>   <b>260K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3info" class="css-checkbox" value="info" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3info"><strong>.info</strong>  <b>139K</b><font>278K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3org" class="css-checkbox" value="org" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3org"><strong>.org</strong>   <b>270K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3biz" class="css-checkbox" value="biz" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3biz"><strong>.biz</strong>  <b>139K</b><font>280K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3mobi" class="css-checkbox" value="mobi" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3mobi"><strong>.mobi</strong>  <b>99k</b><font>445K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3xyz" class="css-checkbox" value="xyz" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3xyz"><strong>.xyz</strong>  <b>24K</b><font>285K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3pw" class="css-checkbox" value="pw" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3pw"><strong>.pw</strong>  <b>24K</b><font>245K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3co" class="css-checkbox" value="co" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3co"><strong>.co</strong>  <b>99k</b><font>605K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3me" class="css-checkbox" value="me" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3me"><strong>.me</strong>   <b>605K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3club" class="css-checkbox" value="club" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3club"><strong>.club</strong>  <b>179k</b><font>385K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3click" class="css-checkbox" value="click" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3click"><strong>.click</strong>   <b>245K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3us" class="css-checkbox" value="us" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3us"><strong>.us</strong>   <b>200K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3jp" class="css-checkbox" value="jp" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3jp"><strong>.jp</strong>   <b>1350K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3eu" class="css-checkbox" value="eu" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3eu"><strong>.eu</strong>   <b>245K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3ws" class="css-checkbox" value="ws" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3ws"><strong>.ws</strong>   <b>455K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3cc" class="css-checkbox" value="cc" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3cc"><strong>.cc</strong>   <b>460K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab3tv" class="css-checkbox" value="tv" name="ext[]">
                                        <label class="css-label-checkbox" for="tab3tv"><strong>.tv</strong>   <b>605K</b></label>
                                    </li>
                                </ul>
                                <!-- tab 4-->
                                <ul class="select_sale" id="tab4">
                                    <li>
                                        <input type="checkbox" id="tab4vn" class="css-checkbox" value="vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4vn"><strong>.vn</strong> <b>-30%</b><font>830K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4com.vn" class="css-checkbox" value="com.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4com.vn"><strong>.com.vn</strong> <b>-30%</b><font>700K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4net.vn" class="css-checkbox" value="net.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4net.vn"><strong>.net.vn</strong> <b>-30%</b><font>700K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4biz.vn" class="css-checkbox" value="biz.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4biz.vn"><strong>.biz.vn</strong> <b>-30%</b><font>700K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4org.vn" class="css-checkbox" value="org.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4org.vn"><strong>.org.vn</strong> <b>-30%</b><font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4gov.vn" class="css-checkbox" value="gov.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4gov.vn"><strong>.gov.vn</strong> <b>-30%</b><font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4info.vn" class="css-checkbox" value="info.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4info.vn"><strong>.info.vn</strong> <b>-30%</b><font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4health.vn" class="css-checkbox" value="health.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4health.vn"><strong>.health.vn</strong> <b>-30%</b><font>400K</font></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab4name.vn" class="css-checkbox" value="name.vn" name="ext[]">
                                        <label class="css-label-checkbox" for="tab4name.vn"><strong>.name.vn</strong>  <b>60K</b></label>
                                    </li>
                                </ul>
                                <!-- tab 5-->
                                <ul class="select_sale" id="tab5">
                                    <li>
                                        <input type="checkbox" id="tab5bike" class="css-checkbox" value="bike" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5bike"><strong>.bike</strong>  <b>685K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5clothing" class="css-checkbox" value="clothing" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5clothing"><strong>.clothing</strong>  <b>685K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5guru" class="css-checkbox" value="guru" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5guru"><strong>.guru</strong>  <b>685K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5singles" class="css-checkbox" value="singles" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5singles"><strong>.singles</strong>  <b>685K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5plumbing" class="css-checkbox" value="plumbing" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5plumbing"><strong>.plumbing</strong>  <b>685K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5camera" class="css-checkbox" value="camera" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5camera"><strong>.camera</strong>  <b>685K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5today" class="css-checkbox" value="today" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5today"><strong>.today</strong>  <b>455K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5company" class="css-checkbox" value="company" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5company"><strong>.company</strong>  <b>455K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5support" class="css-checkbox" value="support" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5support"><strong>.support</strong>  <b>455K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5email" class="css-checkbox" value="email" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5email"><strong>.email</strong>  <b>455K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5education" class="css-checkbox" value="education" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5education"><strong>.education</strong>  <b>455K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5technology" class="css-checkbox" value="technology" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5technology"><strong>.technology</strong>  <b>455K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5holdings" class="css-checkbox" value="holdings" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5holdings"><strong>.holdings</strong>  <b>1155K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5ventures" class="css-checkbox" value="ventures" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5ventures"><strong>.ventures</strong>  <b>1155K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5restaurant" class="css-checkbox" value="restaurant" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5restaurant"><strong>.restaurant</strong>  <b>1155K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5university" class="css-checkbox" value="university" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5university"><strong>.university</strong>  <b>1155K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5furniture" class="css-checkbox" value="furniture" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5furniture"><strong>.furniture</strong>  <b>1155K</b></label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="tab5engineering" class="css-checkbox" value="engineering" name="ext[]">
                                        <label class="css-label-checkbox" for="tab5engineering"><strong>.engineering</strong>  <b>1155K</b></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col1 col9">
                            <h3><img src="<?php echo THEME_IMG_URI; ?>/bkhost/search_icon1.png"><span>Nhập tên miền</span></h3>
                            <div class="box">
                                <div class="main">
                                    <div id="topSearchAreaBG"></div>
                                    <label id="txt_search_new">
                                        <span>- Nhập tên miền bạn muốn đăng ký<br>
                                            - Có thể đăng ký tối đa 30 tên miền<br>
                                            <strong>VD:</strong><br>
                                            bkhost01.com<br>
                                            bkhost02.net<br>
                                            bkhost03.org</span>
                                    </label>
                                    <textarea id="domainNameSingleInput" name="domains" placeholder="" onkeyup="BlockCharhome(this, 'AllSpecialChar')" style="color: rgb(153, 153, 153);"></textarea>
                                </div>
                                <p>Nhập tên miền trên từng dòng hoặc cách khoảng trắng để kiểm tra nhiều tên miền. Mỗi tên miền chỉ 63 kí tự</p>
                            </div>
                            <div class="bt_search">
                                <a href="javascript:checkmanyDomain();"><img src="<?php echo THEME_IMG_URI; ?>/bkhost/new_search_bt1.png"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Ho tro 247 -->
        <div class="an-homepage">
            <?php while (have_posts()): the_post(); ?>
                <?php the_content(); ?>  

            <?php endwhile; ?>
        </div>
        <!-- anan page -->
        
        <!-- MUC PRICE  -->
        <div class="an-priceslider">
            <section id="WelcomeBox" class="full-width">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center" style="margin-bottom: 20px">
                            <h2 class="BigHead">Dịch vụ lưu trữ tốt nhất cho bạn</h2>
                            <p class="DescText">Chúng tôi tự hào là nhà cung cấp tiên phong trong đầu tư và triển khai hệ thống ảo hóa Cloud Server tại Việt Nam.<br />
                                Với trên 5 năm kinh nghiệm trong lĩnh vực này, chúng tôi luôn mong muốn đem đến cho khách hàng những giá trị tốt nhất với chi phí tối ưu nhất.</p>
                        </div>
                        <div class="col-md-12 PricingTable owl-carousel">  
                            <div class="item">
                                <div class="panel">
                                    <!--
                                    <div class="SalesBadge">
                                            <strong class="BigText">20%</strong>
                                            <span class="SmallText">Sale Off</span>
                                    </div>
                                    -->
                                    <div class="FeaIcon">
                                        <img width="220" height="220" src="http://bkhost.vn/wp-content/uploads/2015/06/cloudserver.png" class="attachment-post-thumbnail wp-post-image" alt="cloudserver" />				                	</div>
                                    <div class="panel-heading">
                                        <strong>Web Hosting</strong>
                                        <span>Dịch vụ lưu trữ giúp duy trì hoạt động cho Website của bạn</span>
                                    </div>
                                    <div class="panel-body">
                                        <p>Giá chỉ từ</p>
                                        <p><strong class="NewPrice">25.000</strong></p>
                                        <p>(vnđ/tháng)</p>
                                        <p><a class="btn" href="http://bkhost.vn/hosting/hdh/linux">Xem chi tiết</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="panel">
                                    <!--
                                    <div class="SalesBadge">
                                            <strong class="BigText">20%</strong>
                                            <span class="SmallText">Sale Off</span>
                                    </div>
                                    -->
                                    <div class="FeaIcon">
                                        <img width="231" height="220" src="http://bkhost.vn/wp-content/uploads/2015/06/cloud-vps-icon-home.png" class="attachment-post-thumbnail wp-post-image" alt="cloud-vps-icon-home" />				                	</div>
                                    <div class="panel-heading">
                                        <strong>Cloud VPS</strong>
                                        <span>Trải nghiệm sức mạnh của máy chủ  ảo trên nền tảng điện toán đám mây</span>
                                    </div>
                                    <div class="panel-body">
                                        <p>Giá chỉ từ</p>
                                        <p><strong class="NewPrice">115.000</strong></p>
                                        <p>(vnđ/tháng)</p>
                                        <p><a class="btn" href="http://bkhost.vn/may-chu-ao-vps/may-chu/may-chu-vps-fpt">Xem chi tiết</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="panel">
                                    <!--
                                    <div class="SalesBadge">
                                            <strong class="BigText">20%</strong>
                                            <span class="SmallText">Sale Off</span>
                                    </div>
                                    -->
                                    <div class="FeaIcon">
                                        <img width="200" height="200" src="http://bkhost.vn/wp-content/uploads/2015/06/DomainGlobe1.png" class="attachment-post-thumbnail wp-post-image" alt="DomainGlobe" />				                	</div>
                                    <div class="panel-heading">
                                        <strong>Domain</strong>
                                        <span>Đại lý tên miền uy tín tại Việt Nam hệ thống quản lí DNS riêng biệt.</span>
                                    </div>
                                    <div class="panel-body">
                                        <p>Bắt đầu với</p>
                                        <p><strong class="NewPrice">250.000</strong></p>
                                        <p>(vnđ/năm)</p>
                                        <p><a class="btn" href="http://bkhost.vn/ten-mien/bang-gia-ten-mien-quoc-te.html/">Xem chi tiết</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="panel">
                                    <!--
                                    <div class="SalesBadge">
                                            <strong class="BigText">20%</strong>
                                            <span class="SmallText">Sale Off</span>
                                    </div>
                                    -->
                                    <div class="FeaIcon">
                                        <img width="220" height="220" src="http://bkhost.vn/wp-content/uploads/2015/06/Server-Rack.png" class="attachment-post-thumbnail wp-post-image" alt="Server-Rack" />				                	</div>
                                    <div class="panel-heading">
                                        <strong>Co-location</strong>
                                        <span>Bkhost là đối tác của các DC lớn trong nước VDC, FPT, VIETTEL, CMC</span>
                                    </div>
                                    <div class="panel-body">
                                        <p>Bắt đầu với</p>
                                        <p><strong class="NewPrice">1.500.000</strong></p>
                                        <p>(vnđ/tháng)</p>
                                        <p><a class="btn" href="http://bkhost.vn/cho-dat-may-chu/xem/cho-dat-may-chu-viettel">Xem chi tiết</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- CLOUD VPS -->
        <div class="an-cloudvps">	

            <div id="HomeCloudVPS">
                <div class="container">
                    <h4>Cloud VPS - Máy chủ ảo Cloud</h4>
                    <p class="SmText">Sản phẩm kết tinh từ công nghệ, tốc độ và hiệu năng vượt xa máy chủ ảo truyền thống</p>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div id="CloudSlider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all ui-slider-pips" aria-disabled="false"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 0%;"></div><a class="ui-slider-handle ui-state-default ui-corner-all first-packet-handle" href="#" style="left: 0%;"></a><span class="ui-slider-pip ui-slider-pip-0 ui-slider-pip-first ui-slider-pip-label ActivePack" style="left: 0%;"><span class="ui-slider-label first-label">Start</span></span><span class="ui-slider-pip ui-slider-pip-1 ui-slider-pip-label" style="left: 12.5%;"><span class="ui-slider-label">1</span></span><span class="ui-slider-pip ui-slider-pip-2 ui-slider-pip-label" style="left: 25%;"><span class="ui-slider-label">2</span></span><span class="ui-slider-pip ui-slider-pip-3 ui-slider-pip-label" style="left: 37.5%;"><span class="ui-slider-label">3</span></span><span class="ui-slider-pip ui-slider-pip-4 ui-slider-pip-label" style="left: 50%;"><span class="ui-slider-label">4</span></span><span class="ui-slider-pip ui-slider-pip-5 ui-slider-pip-label" style="left: 62.5%;"><span class="ui-slider-label">5</span></span><span class="ui-slider-pip ui-slider-pip-6 ui-slider-pip-label" style="left: 75%;"><span class="ui-slider-label">6</span></span><span class="ui-slider-pip ui-slider-pip-7 ui-slider-pip-label" style="left: 87.5%;"><span class="ui-slider-label">7</span></span><span class="ui-slider-pip ui-slider-pip-8 ui-slider-pip-last ui-slider-pip-label" style="left: 100%;"><span class="ui-slider-label">8</span></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="CloudPack-0" class="col-md-12 PackContent" style="display: block;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-512</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_0" checked="checked" name="managed" value="no">
                                            <label for="managedno_0">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_0" name="managed" value="yes">
                                            <label for="managedyes_0">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>200.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>180.000đ</strong>&nbsp;/tháng</li><li><strong>523.800đ</strong>&nbsp;/3 tháng</li><li><strong>1.015.200đ</strong>&nbsp;/6 tháng</li><li><strong>1.965.600đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">1</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">512 MB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">20 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">1</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-1" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-1GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_1" checked="checked" name="managed" value="no">
                                            <label for="managedno_1">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_1" name="managed" value="yes">
                                            <label for="managedyes_1">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>400.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>400.000đ</strong>&nbsp;/tháng</li><li><strong>1.164.000đ</strong>&nbsp;/3 tháng</li><li><strong>2.255.996đ</strong>&nbsp;/6 tháng</li><li><strong>4.368.000đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">1</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">1 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">40 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">1</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-2" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-2GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_2" checked="checked" name="managed" value="no">
                                            <label for="managedno_2">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_2" name="managed" value="yes">
                                            <label for="managedyes_2">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>600.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>600.000đ</strong>&nbsp;/tháng</li><li><strong>1.746.000đ</strong>&nbsp;/3 tháng</li><li><strong>3.384.000đ</strong>&nbsp;/6 tháng</li><li><strong>6.552.000đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">2</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">2 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">100 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">1</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-3" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-4GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_3" checked="checked" name="managed" value="no">
                                            <label for="managedno_3">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_3" name="managed" value="yes">
                                            <label for="managedyes_3">Yêu cầu Bkhost quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>1.200.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>1.200.000đ</strong>&nbsp;/tháng</li><li><strong>3.492.000đ</strong>&nbsp;/3 tháng</li><li><strong>6.768.000đ</strong>&nbsp;/6 tháng</li><li><strong>13.104.000đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">2</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">4 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">200 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">1</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-4" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-6GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_4" checked="checked" name="managed" value="no">
                                            <label for="managedno_4">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_4" name="managed" value="yes">
                                            <label for="managedyes_4">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>1.800.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>1.800.000đ</strong>&nbsp;/tháng</li><li><strong>5.238.000đ</strong>&nbsp;/3 tháng</li><li><strong>10.152.000đ</strong>&nbsp;/6 tháng</li><li><strong>19.656.000đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">4</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">6 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">250 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">2</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-5" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-8GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_5" checked="checked" name="managed" value="no">
                                            <label for="managedno_5">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_5" name="managed" value="yes">
                                            <label for="managedyes_5">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>2.400.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>2.400.000đ</strong>&nbsp;/tháng</li><li><strong>6.984.000đ</strong>&nbsp;/3 tháng</li><li><strong>13.536.000đ</strong>&nbsp;/6 tháng</li><li><strong>26.208.000đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">4</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">8 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">250 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">2</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-6" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-12GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_6" checked="checked" name="managed" value="no">
                                            <label for="managedno_6">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_6" name="managed" value="yes">
                                            <label for="managedyes_6">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>3.000.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>3.000.000đ</strong>&nbsp;/tháng</li><li><strong>8.730.000đ</strong>&nbsp;/3 tháng</li><li><strong>16.920.000đ</strong>&nbsp;/6 tháng</li><li><strong>32.760.000đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">4</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">12 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">300 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">2</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-7" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-16GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_7" checked="checked" name="managed" value="no">
                                            <label for="managedno_7">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_7" name="managed" value="yes">
                                            <label for="managedyes_7">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>3.600.000đ</strong>/tháng</p>
                                        <a href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" class="PriceTab" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<ul class='PriceVal'><li><strong>3.600.000đ</strong>&nbsp;/tháng</li><li><strong>10.476.000đ</strong>&nbsp;/3 tháng</li><li><strong>20.304.000đ</strong>&nbsp;/6 tháng</li><li><strong>39.312.000đ</strong>&nbsp;/12tháng</li></ul>">Bảng giá đầy đủ</a>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Đăng ký ngay">Đăng ký ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">6</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">16 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">350 GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">2</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CloudPack-8" class="col-md-12 PackContent" style="display: none;">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-2 PackName">Cloud-32GB</div>
                                    <div class="col-md-4 Managed">
                                        <!--
        
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedno_8" checked="checked" name="managed" value="no">
                                            <label for="managedno_8">Tôi tự quản trị VPS</label>
                                        </div>
                                        <div class="radio radio-cloud">
                                            <input type="radio" id="managedyes_8" name="managed" value="yes">
                                            <label for="managedyes_8">Yêu cầu BKHOST quản trị VPS</label>
                                        </div>
                                        -->
                                    </div>
                                    <div class="col-md-2 col-md-offset-2 Price">
                                        <p class="PriceNow"><strong>Liên hệ</strong></p>
                                        <p class="PriceTab" data-original-title="" title=""></p>
                                    </div>
                                    <div class="col-md-2 OrderNow">
                                        <a class="Btns" href="http://bkhost.vn/may-chu/may-chu-ao-cloud-vps.html" title="Liên hệ ngay">Liên hệ ngay&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 PackInfo">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <p class="Vlabel vCPU">vCPU</p>
                                                <p class="Value">6</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel RAM">Memory</p>
                                                <p class="Value">32GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Storage">SAN Storage</p>
                                                <p class="Value">500GB</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Bandwidth">Bandwidth</p>
                                                <p class="Value">Unlimited</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel IPAddr">IP Address</p>
                                                <p class="Value">2</p>
                                            </div>
                                            <div class="col-md-2">
                                                <p class="Vlabel Backup">Backup</p>
                                                <p class="Value">Hàng tuần</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php get_template_part('template', 'support'); ?>
        
        <div class="an-khachhangnew">	



            <div class="container customer-ops">
                <div class="text-footer">
                    <p>Chia sẻ của khách hàng sau khi sử dụng dịch vụ máy chủ ảo tại Bkhost</p>
                </div> <!-- end .text-footer -->
                <div class="clearfix list-ops">
                    <ul class="testimonials">        

                        <li class="item">
                            <a><img width="100" height="100" src="http://thuemaychuao.vn/wp-content/uploads/2015/03/tam-100x100.png" class="attachment-thumb-100-100 wp-post-image" alt="tam" /></a>
                            <div class="inner">
                                <p>Giang Trần</p>
                                <p>Hiện tại mình đang sử dụng VPS tại Bkhost nhận thấy máy chủ ảo tại đây đáp ứng đủ các yêu cầu về bảo mật, backup, mở rộng, tính sẵn sàng hơn nữa thủ tục nhanh gọn ,khởi tạo nhanh và ...</p>
                            </div> <!-- end .inner -->
                        </li> <!-- end .item -->
                        <li class="item">
                            <a><img width="100" height="100" src="http://thuemaychuao.vn/wp-content/uploads/2015/03/linh-100x100.png" class="attachment-thumb-100-100 wp-post-image" alt="linh" /></a>
                            <div class="inner">
                                <p>Phương Lê</p>
                                <p>Mình có thuê VPS tại Bkhost để chạy một số chương trình trên máy chủ ảo, cảm thấy chất lượng VPS khá tốt. Bkhost ghi điểm mạnh bởi đội ngũ nhân viên Support nhiệt tình và nhanh chóng. ...</p>
                            </div> <!-- end .inner -->
                        </li> <!-- end .item -->
                        <li class="item">
                            <a><img width="100" height="100" src="http://thuemaychuao.vn/wp-content/uploads/2015/03/toan-100x100.png" class="attachment-thumb-100-100 wp-post-image" alt="toan" /></a>
                            <div class="inner">
                                <p>An Nguyễn</p>
                                <p>Đã sử dụng nhiều VPS tại các đơn vị khác nhau nhưng đây là đơn vị duy nhất mình hài lòng bởi cấu hình VPS, tốc độ cũng như đội ngũ nhân viên kỹ thuật tại đây. Hy vọng sẽ có cơ hội hợp ...</p>
                            </div> <!-- end .inner -->
                        </li> <!-- end .item -->
                        <li class="item">
                            <a><img width="100" height="100" src="http://thuemaychuao.vn/wp-content/uploads/2015/03/nam-100x100.png" class="attachment-thumb-100-100 wp-post-image" alt="nam" /></a>
                            <div class="inner">
                                <p>Nam Nguyễn</p>
                                <p>Dịch vụ tốt, support nhanh, nhiều ưu đãi. VPS tại Bkhost chạy rất ổn định</p>
                            </div> <!-- end .inner -->
                        </li> <!-- end .item -->
                    </ul>        

                </div> <!-- end .list-ops -->
            </div>
        </div>
        <?php get_footer(); ?>