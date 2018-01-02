<?php
/*
 * Template Name: Search Domain
 */

get_header();
ini_set('display_errors', 'On');
/* * **************************************************
  C O N F I G U R A B L E    S E T T I N G S
 * *************************************************** */
include (dirname(__FILE__) . DIRECTORY_SEPARATOR . '../protected/rankcheck.php');
/* * **************************************************
  Multi Entry Domains Enquiry Maximum at One Time

  Set to -1 for unlimited. If you set to -1, uncomment set_time_limit below to allow the script more time
 * ************************************************** */
define('MAX_DOMAINS_AT_ONE_TIME', -1);
/* * **************************************************
  Allowed Domain TLDs = Set to NULL to allow any domain
  Examples:
  $allowedTLDs = null;  // to allow ALL domains
  $allowedTLDs = array("com","net","org");  // to allow only com, net and org domains.
  $allowedTLDs = array("com.sg");  // to allow only com.sg domain checking
 * ************************************************** */
$allowedTLDs = null;
/* * **************************************************
  Uncomment to make unlimited script execution time - not recommended for shared hosting
 * ************************************************** */
set_time_limit(0);
/* * **************************************************
  Email Options (via PHP's mail function)
  - $emailResults = Set to 'true' to transform this script into a email only script. Set it up as a cron job to check
  domain availability at every interval. The cron job for unix systems can be as follows:
  lynx -source "http://example.com"
  - $emailEmail 		= Specify your email address
  - $emailSubject 	= Specify the subject of the email
  - $emailFrom		= Specify the from field
  - $emailFile 		= Specify the file to read from. One domain per line. File should be readable by PHP
 * ************************************************** */
//$emailResults = false;
//$emailEmail = 'example.com';
//$emailSubject = 'Domains are available!';
//$emailFrom = 'me@mydomain.com';
//$emailFile = 'domains.txt';

/* * **************************************************
  Recaptcha prevents automated queries that can crash your server
  If true, shows Recaptcha Dialog Box. ALL settings below are REQUIRED
  ==> Register a free account at http://recaptcha.net/ if you don't have the required keys
 * ************************************************** */
define('ENABLE_RECAPTCHA', false); //set to false to disable, true to enable
define('RECAPTCHA_PRIVATE_KEY', ''); //substitute with private key
define('RECAPTCHA_PUBLIC_KEY', '');  // substitute with pubic key
define('RECAPTCHA_TOTAL_HITS', 3);  // how many checks are allowed per verified captcha. Set to -1 for unlimited

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

/* * **************************************************
  Other Options
  - $enableReferrerChecking 		= Set to 'true' to check referrers to be from your own domain. Prevents misuse. Set
  to false to disable this check.	Default: true
  - $enableFileSave				= Set to 'true' to allow a option to download the results as a text file
  - $enableGetHostByNameChecking 	= Set to 'true' to allow very fast checking of domain availability by utilizing
  the PHP gethostbyname function. Strongly recommended setting: true
  - $enableCheckDnsRRChecking 	= Set to 'true' to allow very fast checking of domain availability by utilizing
  the PHP checkdnsrr function. Strongly recommended setting: True.
  - $enableWhoisDomainChecking 	= Set to 'false' to skip querying WHOIS servers to confirm domain is truly available.
  Slows down checkups considerably. Recommended: True.
  - $showUpdatesEvery 			= Set to -1 to disable. Setting this to X values causes it to print an output line every
  X domain checkings. Useful to check how fast and where domain checking is
  - $enableAutoDomainDetection 	= Set to 'false' to restrict checks to only those TLDs listed in dnserver. Otherwise it
  will try to detect whois servers for those TLDs that dnservers.php does not have
 * ************************************************** */

$enableReferrerChecking = true;
$enableFileSave = true;
$enableGetHostByNameChecking = false;
$enableCheckDnsRRChecking = false;
$enableWhoisDomainChecking = true;
$showUpdatesEvery = -1;
$enableAutoDomainDetection = true;

/* * **************************************************
  N O N - C O N F I G U R A B L E    S E T T I N G S

  You should not change the below unless you know what you are doing
 * *************************************************** */
//to prevent other domains from misusing the AJAX script
$referrerDomain = '';
if ($enableReferrerChecking) {
    if (session_id() == '')
        session_start();

    if (!isset($_REQUEST['aj']))
        $_SESSION['IS_FROM_SAME_DOMAIN'] = 1;
    if (isset($_SERVER['HTTP_REFERER'])) {
        //extract referrer domain
        $referrerDomain = $_SERVER['HTTP_REFERER'];
        $referrerDomain = substr($referrerDomain, strpos($referrerDomain, "http://") + 7);
        $referrerDomain = substr($referrerDomain, 0, strpos($referrerDomain, "/"));
    }
}
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../protected/dnservers.php');
$error = '';

//telnet com.whois-servers.net 43 for whoising com server
//any updates here need to reflect in bulk_checker
function isDomainAvailable($R6629C5988EEFCD88EA6F77A2AE672B96, $R9DFAEDF5181E1A426FA8DBE71B349A26 = false) {
    global $ext, $error, $allowedTLDs, $language, $buffer, $enableGetHostByNameChecking, $enableCheckDnsRRChecking, $enableWhoisDomainChecking, $enableAutoDomainDetection;
    if ($enableWhoisDomainChecking == false)
        $enableAutoDomainDetection = false;
    $R6629C5988EEFCD88EA6F77A2AE672B96 = trim($R6629C5988EEFCD88EA6F77A2AE672B96);
    if (preg_match('/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)*[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?$/i', $R6629C5988EEFCD88EA6F77A2AE672B96) != 1) {
        $error = $language['invalid_domain'] . ' (' . $R6629C5988EEFCD88EA6F77A2AE672B96 . ')';
        return false;
    } preg_match('@^(http://www\.|http://|www\.)?([^/]+)@i', $R6629C5988EEFCD88EA6F77A2AE672B96, $R2BC3A0F3554F7C295CD3CC4A57492121);
    $buffer = '';
    $R6629C5988EEFCD88EA6F77A2AE672B96 = $R2BC3A0F3554F7C295CD3CC4A57492121[2];
    $R37D331C368B44BDD85AF95D9FFFFD202 = explode('.', $R6629C5988EEFCD88EA6F77A2AE672B96);
    $R33D3EC748433467E20D0947C3032E305 = '';
    if (count($R37D331C368B44BDD85AF95D9FFFFD202) == 3) {
        $R33D3EC748433467E20D0947C3032E305 = strtolower($R37D331C368B44BDD85AF95D9FFFFD202[1] . '.' . $R37D331C368B44BDD85AF95D9FFFFD202[2]);
    } else if (count($R37D331C368B44BDD85AF95D9FFFFD202) == 2) {
        $R33D3EC748433467E20D0947C3032E305 = strtolower($R37D331C368B44BDD85AF95D9FFFFD202[1]);
    } else {
        $error = $language['invalid_domain'];
        return false;
    } if ($allowedTLDs != null) {
        $R630663E4CF314AFD500B9B8E1AA95DF0 = count($allowedTLDs);
        $RDBF866E6293BB59E654033E299EC8CFE = false;
        for ($RA16D2280393CE6A2A5428A4A8D09E354 = 0; $RA16D2280393CE6A2A5428A4A8D09E354 < $R630663E4CF314AFD500B9B8E1AA95DF0; $RA16D2280393CE6A2A5428A4A8D09E354++) {
            if ($allowedTLDs[$RA16D2280393CE6A2A5428A4A8D09E354] === $R33D3EC748433467E20D0947C3032E305) {
                $RDBF866E6293BB59E654033E299EC8CFE = true;
                break;
            }
        } if (!$RDBF866E6293BB59E654033E299EC8CFE) {
            $error = $R33D3EC748433467E20D0947C3032E305 . $language['tld_not_allowed'];
            return false;
        }
    } $R019FB4DA0E10A95A57615147DF79F334 = false;
    if (!array_key_exists('.' . $R33D3EC748433467E20D0947C3032E305, $ext)) {
        if ($enableAutoDomainDetection === false) {
            $error = $language['unknown_tld'] . $R33D3EC748433467E20D0947C3032E305;
            return false;
        } $R019FB4DA0E10A95A57615147DF79F334 = true;
    } if ($R9DFAEDF5181E1A426FA8DBE71B349A26 === false) {
        if ($enableCheckDnsRRChecking) {
            if (function_exists('checkdnsrr')) {
                if (checkdnsrr($R6629C5988EEFCD88EA6F77A2AE672B96) !== false)
                    return false;
                if (checkdnsrr($R6629C5988EEFCD88EA6F77A2AE672B96, 'A') !== false)
                    return false;
            }
        } if ($enableGetHostByNameChecking) {
            $RE22CBD8984E1727D0A587413D72A88CF = gethostbyname($R6629C5988EEFCD88EA6F77A2AE672B96);
            if (($RE22CBD8984E1727D0A587413D72A88CF != $R6629C5988EEFCD88EA6F77A2AE672B96) && ($RE22CBD8984E1727D0A587413D72A88CF != '208.67.219.132')) {
                return false;
            }
        } if (!$enableWhoisDomainChecking) {
            return array('true', $R37D331C368B44BDD85AF95D9FFFFD202);
        }
    } $server = '';
    if (isset($_REQUEST['opendns'])) {
        echo '208.67.219.13';
        exit;
    } if ($R019FB4DA0E10A95A57615147DF79F334) {
        $RBD7EDCF7DA1CE9EA93A9B3BBD829FFBB = explode('.', $R33D3EC748433467E20D0947C3032E305);
        if (count($RBD7EDCF7DA1CE9EA93A9B3BBD829FFBB) > 1)
            $server = $RBD7EDCF7DA1CE9EA93A9B3BBD829FFBB[1] . '.whois-servers.net';
        else
            $server = $R33D3EC748433467E20D0947C3032E305 . '.whois-servers.net';
        $R7B8A9F2F48B874D40BD75BDD12F02557 = @gethostbyname($R33D3EC748433467E20D0947C3032E305 . '.whois-servers.net');
    } else {
        $server = $ext['.' . $R33D3EC748433467E20D0947C3032E305][0];
        $R7B8A9F2F48B874D40BD75BDD12F02557 = @gethostbyname($server);
    } if ($R33D3EC748433467E20D0947C3032E305 == 'es') {
        $error = 'Error: ES not supported. They don\'t have a public whois server :(';
        return false;
    } if ($R33D3EC748433467E20D0947C3032E305 == 'au') {
        $server = $ext['.com.au'][0];
        $R7B8A9F2F48B874D40BD75BDD12F02557 = @gethostbyname($server);
    } if ($R7B8A9F2F48B874D40BD75BDD12F02557 == $server) {
        $error = 'Error: Invalid extension - ' . $R33D3EC748433467E20D0947C3032E305 . '. Or server has outgoing connections blocked to ' . $server . '.  Domain does not have DNS entry, so chances are high it is available.';
        return false;
    } $RAD10634E7F72CAA071320F21AEE5930D = @fsockopen($server, 43, $R32D00070D4FFBCCE2FC669BBA812D4C2, $RE5840D3E86DCF8489051E4F70C757552, 10);
    if ($R32D00070D4FFBCCE2FC669BBA812D4C2 == '10060') {
        $error = 'Error: Invalid extension - ' . $R33D3EC748433467E20D0947C3032E305 . ' (or whois server is down). Domain does not have DNS entry, so chances are high it is available.';
        return false;
    } if (!$RAD10634E7F72CAA071320F21AEE5930D || ($RE5840D3E86DCF8489051E4F70C757552 != '')) {
        $error = 'Error: (' . $server . ') ' . $RE5840D3E86DCF8489051E4F70C757552 . ' (' . $R32D00070D4FFBCCE2FC669BBA812D4C2 . ')';
        return false;
    } fputs($RAD10634E7F72CAA071320F21AEE5930D, "$R6629C5988EEFCD88EA6F77A2AE672B96\r\n");
    while (!feof($RAD10634E7F72CAA071320F21AEE5930D)) {
        $buffer .= fgets($RAD10634E7F72CAA071320F21AEE5930D, 128);
    } fclose($RAD10634E7F72CAA071320F21AEE5930D);
    if ($R33D3EC748433467E20D0947C3032E305 == 'org')
        nl2br($buffer);
    if ($R019FB4DA0E10A95A57615147DF79F334) {
        if ((strpos($buffer, 'No match for') !== false) || (strpos($buffer, 'NOT Found') !== false) || (strpos($buffer, 'NOT FOUND') !== false) || (strpos($buffer, 'Not found: ') !== false) || (strpos($buffer, "No Found\n") !== false) || (strpos($buffer, 'NOMATCH') !== false) || (strpos($buffer, "AVAIL\n") !== false) || (strpos($buffer, 'No entries found') !== false) || (strpos($buffer, 'NO MATCH') !== false) || (strpos($buffer, 'No match') !== false) || (strpos($buffer, 'No such Domain') !== false) || (strpos($buffer, 'is free') !== false) || (strpos($buffer, 'FREE') !== false) || (strpos($buffer, 'No data Found') !== false) || (strpos($buffer, 'No Data Found') !== false) || ($buffer == "Available\n") || (strpos($buffer, 'No information about') !== false) || (strpos($buffer, 'no matching record') !== false) || (strpos($buffer, 'does not Exist in database') !== false) || (strpos($buffer, 'Status: AVAILABLE') !== false) || (strpos($buffer, 'not a registered domain') !== false)) {
            return array('true', $R37D331C368B44BDD85AF95D9FFFFD202);
        } return false;
    } else {
        if ((strpos($R33D3EC748433467E20D0947C3032E305, '.au') > 0) && ($buffer == "Not Available\n")) {
            return false;
        } if (preg_match('/' . $ext['.' . $R33D3EC748433467E20D0947C3032E305][1] . '/i', $buffer)) {
            return array('true', $R37D331C368B44BDD85AF95D9FFFFD202);
        } else {
            return false;
        }
    } return false;
}

function isDomainVnAvailable($domain) {
    $content = file_get_contents("http://www.whois.net.vn/whois.php?domain=" . $domain);
    $content = substr($content, strlen($content) - 1, 1);
    if($content === "0"){
        return true;
    }
    return false;
}

if ($language['tld_not_allowed'] === false) {
    echo '';
}

function processSubmit($isEmail = false) {
    global $language, $error, $showUpdatesEvery;

    if (ENABLE_RECAPTCHA) {
        $response = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
        if ($response->is_valid === false) {
            echo '<p style="color:red">' . $language['wrong_captcha'] . '</p>';
            return;
        }
    }

    $domains = explode("\n", $_POST['domains']);
    $numberOfDomains = count($domains);
    if (($numberOfDomains > MAX_DOMAINS_AT_ONE_TIME) && (MAX_DOMAINS_AT_ONE_TIME != -1)) {
        echo '<p>' . $language['too_many'] . '</p>';
    } else {
        $list_domain_top = get_top_search();
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . '../protected/tldextract.php');
        $newDomains = array();
        foreach ($domains as $domain) {
            $domain = strtolower(trim($domain));
            $tldextract = tldextract("http://" . $domain);
            if($tldextract->tld){
                $newDomains[] = $domain;
            } else {
                if (!empty($list_domain_top)){
                    foreach ($list_domain_top as $current_domain){
                        $newDomains[] = $tldextract->domain . $current_domain;
                    }
                } else {
                    $newDomains[] = $tldextract->domain . ".com";
                    $newDomains[] = $tldextract->domain . ".net";
                    $newDomains[] = $tldextract->domain . ".org";
                    $newDomains[] = $tldextract->domain . ".us";
                }
            }
        }
        
        if ($isEmail) { //email
            //do nothing
        } else if (isset($_POST['save'])) { //text file
            while (ob_get_level() !== 0)
                ob_end_clean();
            header('Content-type: text/plain');
            header('Content-Disposition: attachment; filename="domains.txt"');
        } else if (isset($_POST['csv'])) { //csv export
            while (ob_get_level() !== 0)
                ob_end_clean();
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=domains.csv");
            echo 'Tên miền ,Trạng thái ,Pagerank ,Alexa Rank';
            echo "\r\n";
        } else { //if downloading as HTML page
            echo '<p>' . $language['going_to_check'] . count($newDomains) . '</p>';
            echo '<div class="row">
                    <div class="cell fivecol"><span><b>Tên miền</b></span></div>
                    <div class="cell fivecol"><span><b>Trạng thái</b></span></div>
                    <div class="cell fivecol"><span><b>Pagerank</b></span></div>
                    <div class="cell fivecol"><span><b>Alexa Rank</b></span></div>
                    <div class="cell fivecol"><span><b>Phí khởi tạo</b></span></div>
                    <div class="cell fivecol"><span><b>Phí duy trì</b></span></div>
                    <div class="cell fivecol"><span><b>Thông tin</b></span></div>
                </div>';
            while (ob_get_level() !== 0)
                ob_end_flush();
        }
        flush();
        $counter = 0;
        foreach ($newDomains as $domain) {
            $counter++;
            if ((!isset($_POST['save'])) && (!isset($_POST['csv'])) && ($showUpdatesEvery != -1) && ($counter % $showUpdatesEvery == 0)) {
                echo '<b>' . $language['current_status'] . $domain . ' (' . $counter . ')</b><br>';
            }
            $domain = strtolower(trim($domain));
            $error = '';
            $domregistered = 'Registered';
            $success = 'Available';
            $result = false;
            if (strpos($domain, ".vn") !== FALSE) {
                $result = isDomainVnAvailable($domain);
            } else {
                $result = isDomainAvailable($domain);
            }

            //Alexa Rank Get
            $url = $domain;
            $xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url=' . $url);
            $rank = isset($xml->SD[1]->POPULARITY) ? $xml->SD[1]->POPULARITY->attributes()->TEXT : 0;
            $web = (string) $xml->SD[0]->attributes()->HOST;

            if ($rank == "") {
                //Nothing
            }
            //Page Rank Get
            $check = new pchecker;
            $prtest = "";
            $csvandsave = "";
            //If domains found carry on
            if ($domain != "") {
                // Grab page rank for each domain
                $pr = $check->getRank($domain);
                // How to display
                // If pagerank does not equal nothing display it as red
                if ($pr != 'N/A' || '0') {
                    $prtest .= "<a href='#' style='color:red;'>" . $pr . "</a>";
                    $csvandsave .= $pr;
                } else {
                    $prtest .= $pr;
                }
                //Nothing
            }

            if ($result === false) {
                if (!isset($_POST['onlyavailable'])) {
                    if (isset($_POST['save'])) {
                        echo htmlentities($domain) . ' ' . $domregistered . "\r\n";
                    }
                    if (isset($_POST['csv'])) {
                        echo $domain . ',' . $domregistered . ',' . $csvandsave . ',' . $rank;
                        echo "\r\n";
                    } elseif ($language['tld_not_allowed'] === true) {
                        echo '';
                    }
                    if ((!isset($_POST['save'])) && (!isset($_POST['csv']))) {
                        echo '<div class="row">
                                <div class="cellout fivecol"><span>' . htmlentities($domain) . '</span></div>
                                <div class="cellout fivecol"><span>' . $language['not_available'] . '</span></div>
                                <div class="cellout fivecol"><span>' . $prtest . '</span></div>
                                <div class="cellout fivecol"><span>' . number_format(intval($rank), 0, ',', '.') . '</span></div>
                                <div class="cellout fivecol"><span>0 vnđ</span></div>
                                <div class="cellout fivecol"><span>0 vnđ</span></div>
                                <div class="cellout fivecol"><span data-id="' . $domain . '" style="color:#fff;" class="btn btn-success .action-button1 open-modal" data-source="'.get_template_directory_uri().'/output.php">Xem thông tin</span></div>
                            </div>';
                    }
                    flush();
                }
            } else {
                if (isset($_POST['save'])) {
                    echo htmlentities($domain) . ' ' . $success . "\r\n";
                } else if (isset($_POST['csv'])) {
                    echo $domain . ',' . $success . ',' . $csvandsave . ',' . $rank;
                    echo "\r\n";
                } else {
                    $siteurl = get_bloginfo('url');
                    $_domain = htmlentities($domain);
                    $components = tldextract('http://' . $_domain);
                    $ext = $components->tld;
                    $ext_price = get_page_by_path($ext, OBJECT, 'ten-mien');
                    //$subTotal = intval(get_field('phi_khoi_tao', $ext_price->ID)) + get_field('phi_duy_tri', $ext_price->ID);
                    echo '<div class="row">
                        <div class="cellout fivecol"><span>' . $_domain . '</span></div>
                        <div class="cellout fivecol"><span>' . $language['available'] . '</span></div>
                        <div class="cellout fivecol"><span>' . $prtest . '</span></div>
                        <div class="cellout fivecol"><span>' . $rank . '</span></div>
                        <div class="cellout fivecol t_red"><span>' . number_format(intval(get_field('phi_khoi_tao', $ext_price->ID)), 0, ',', '.') . ' vnđ</span></div>
                        <div class="cellout fivecol t_red"><span>' . number_format(get_field('phi_duy_tri', $ext_price->ID), 0, ',', '.') . ' vnđ</span></div>';
                    echo <<<HTML
                        <div class="cellout fivecol">
                            <form method="POST" action="{$siteurl}/___order_add_to_cart">
                                <input type="hidden" value="{$ext_price->ID}" name="prod_id">
                                <input type="hidden" value="ten-mien" name="prod_type">
                                <input type="hidden" value="{$ext_price->ID}" id="prod_price_time_item_{$ext_price->ID}" name="prod_price">
                                <input type="hidden" value="1" name="prod_amount">
                                <input type="hidden" value="$_domain" name="prod_name">
                                <input type="hidden" value="{$siteurl}/gio-hang" name="ref_url">
                                <button name="add_more" type="submit" class="btn btn-danger">Đăng ký ngay</button>
                            </form>
                        </div>
                    </div>
HTML;
                }
            }
            flush();
        }
        /*if ((isset($_POST['save'])) || (isset($_POST['csv'])) && (!$isEmail))
            exit;
        else if (!$isEmail)
            echo '<br>' . $language['completed'] . '</p>';*/
    }
}
?>
<style type="text/css">
.modal-body {
    padding:20px;
    max-height: 600px;
    overflow: auto;
}
.table {width: 100%; height: 100%;}
.row:first-child {  }
.row {margin: 0; padding:10px; border-top: 1px solid #ddd;}

.cell {float: left; margin: 0; padding:0; padding-top:0px;}
.fivecol {width: 20%;}	

.cellout {float: left; margin: 0; padding:0; padding-top:0px;}
.fivecol {width: 14.2%;}

.nav-tabs > li, .nav-pills > li {
float:none;
display:inline-block;
*display:inline; /* ie7 fix */
zoom:1; /* hasLayout ie7 trigger */
}
.nav-tabs {
text-align:center;
}
.bg-red {
  background-color: #e02222 !important;
  background-image: none !important;
}
.bg-green {
  background-color: #35aa47 !important;
  background-image: none !important;
}
textarea[name=domains]{
    color: gray;
}
textarea[name=domains]:focus{
    color: #333;
}
</style>
<div class="modal fade" id="modalResult" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog"> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">THÔNG TIN TÊN MIỀN</h4>
      </div>
	  <div class="modal-body"></div>
    </div>
  </div>
</div>
<div id="post-content">
    <div class="panel-bg">
        <div class="domain-content domain-page" style="background: #fff">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <h1 style="padding-top: 10px; text-transform: uppercase; text-align: center; color: rgb(234, 108, 0); font-size: 24px;"><?php the_title(); ?></h1>
                    <div style="margin-bottom: 20px;text-align: center;padding: 10px">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
            <div class="top-toggle clearfix">
                <ul>
                    <li class="active-tg"><a href="<?php bloginfo('url'); ?>/search-domains">Đăng ký tên miền<span class="r-res"></span></a></li>
                    <li><a href="<?php bloginfo('url'); ?>/bang-gia-ten-mien"><span class="l-prc"></span>Bảng giá tên miền<span class="r-prc"></span></a><span class="prc-line"></span></li>
                </ul>
            </div>
            <div class="price-domain-table">
                <!-- BEGIN FORM-->
                <p style="max-width:98%; margin:0 auto 10px"><?php echo $language['intro_text']; ?></p>
                <form action="<?php bloginfo('url'); ?>/search-domains/" id="form-username" method="post">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" id="domains" name="domains" style="max-width:98%; margin:auto"><?php echo (isset($_REQUEST['domains'])) ? $_REQUEST['domains'] : ""; ?></textarea>
                    </div>
                    <div class="form-group" style="text-align: center">
                        <button type="submit" class="btn btn-success" name="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?php echo $language['check_availability'] ?></button>
                    </div>
                </form>
                <!-- END FORM-->
                <?php if(isset($_POST['domains'])):	?>
                    <div class="table"><?php processSubmit(); ?></div>
                <?php endif; ?>
            </div>

            <div class="t_tit_dactrung" style="margin-left: 0;width: 100%;border-color: #508093">
                <div class="t_tit_bg_green" style="background: #508093">
                    <!--<span class="t_icon_cloud"><img alt="ssd_hosting_32" src="<?php echo get_template_directory_uri(); ?>/assets/images/bkhost/t_icon_cl_ssd.png"></span>-->
                    <span class="t_text_tit_dactrung">Tư vấn lựa chọn tên miền (Domain)</span>
                </div>
            </div>
            <div class="t_nd_dactrung">
                <div class="t_br_yl" style="margin-left: 0;width: 100%">
                    <div class="t_bg_num1">1</div>
                    <div class="t_br_nd_dactrung">
                        <h4 style="margin: 0;color: #fd6d16">Domain càng ngắn càng tốt</h4><br />
                        <span style="font-weight: normal">Quý khách hãy chọn tên miền (Domain) ngắn nhất có thể (msn.com, hp.com…). Domain ngắn sẽ dễ nhớ, dễ gõ địa chỉ và dễ dàng khi cần thiết kế nhãn hiệu, logo…</span>
                    </div>
                </div>
                <div class="t_br_yl" style="margin-left: 0;width: 100%">
                    <div class="t_bg_num1">2</div>
                    <div class="t_br_nd_dactrung">
                        <h4 style="margin: 0;color: #fd6d16">Domain phải dễ nhớ</h4><br />
                        <span style="font-weight: normal">Quý khách sẽ dễ dàng để nhớ các Domain như Art.com, Yahoo.com, Amazon.com, Google.com,.... Những Domain khi phát âm dễ nghe thì sẽ dễ nhớ hơn. Hãy đọc to nhiều lần Domain mà Quý khách muốn đăng ký. Những Domain ngộ nghĩnh thì cũng dễ nhớ (Alibaba.com, Umbala.com…).</span>
                    </div>
                </div>
                <div class="t_br_yl" style="margin-left: 0;width: 100%">
                    <div class="t_bg_num1">3</div>
                    <div class="t_br_nd_dactrung">
                        <h4 style="margin: 0;color: #fd6d16">Domain không gây nhầm lẫn</h4><br />
                        <span style="font-weight: normal">Một Domain tốt là tên miền không gây nhầm lẫn với Domain sẵn có. Nếu Domain sẵn có là một thương hiệu đã được đăng ký thì Quý khách có thể gặp rắc rối khi sử dụng Domain tương tự. Domain phải dễ đọc khi phải đọc Domain qua điện thoại. Đừng dùng dấu gạch ngang ( – ) trong Domain.</span>
                    </div>
                </div>
                <div class="t_br_yl" style="margin-left: 0;width: 100%">
                    <div class="t_bg_num1">4</div>
                    <div class="t_br_nd_dactrung">
                        <h4 style="margin: 0;color: #fd6d16">Tên miền khó viết sai</h4><br />
                        <span style="font-weight: normal">Nếu mọi người có thể viết sai cái gì đó thì họ sẽ viết sai! Domain càng dài và càng phức tạp thì càng nhiều khả năng bị viết sai. Nếu Domain của doanh nghiệp Quý khách dài hoặc rắc rối thì Quý khách sẽ mất đi nhiều khách hàng.</span>
                    </div>
                </div>
                <div class="t_br_yl" style="margin-left: 0;width: 100%">
                    <div class="t_bg_num1">5</div>
                    <div class="t_br_nd_dactrung">
                        <h4 style="margin: 0;color: #fd6d16">Tên miền phải liên quan đến tên hoặc lĩnh vực hoạt động</h4><br />
                        <span style="font-weight: normal">Nếu như Quý khách không thể tìm được chính xác Domain cho doanh nghiệp của mình thì đừng bỏ cuộc. Hãy tìm một tên miền nói lên công việc chính hay mô tả tính độc đáo của doanh nghiệp. Nếu DN có tên là A và hoạt động là hotel thì tên thích hợp là www.Ahotel.com. Quý khách có thể dùng các Domain có đuôi là .biz, .info nếu không tìm được đuôi .com,.net,.org.</span>
                    </div>
                </div>
                <div class="t_br_yl" style="margin-left: 0;width: 100%">
                    <div class="t_bg_num1">6</div>
                    <div class="t_br_nd_dactrung">
                        <h4 style="margin: 0;color: #fd6d16">Tên miền càng ngắn càng tốt</h4><br />
                        <span style="font-weight: normal">Nếu khách hàng mục tiêu của Quý khách là toàn cầu thì Domain .com, .net sẽ có lợi cho Quý khách. Nếu Quý khách muốn nhấn mạnh doanh nghiệp Quý khách ở Việt Nam thì có thể xem xét để có một Domain quốc gia ( .vn, .com.vn…).hiệu, logo…</span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div style="height: 2px;background: #fff"></div>
            <?php get_template_part('template', 'support'); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click", ".open-modal", function(e) {
        $('#overlow').show();
        var id = $(this).data('id');
        e.preventDefault();
        $("#modalResult .modal-body").load($(this).data("source"), function(response, status, xhr) {
            if (status === "error") {
                console.log("unable to load content : " + xhr.status);
            } else {
                $.post("<?php echo get_template_directory_uri(); ?>/output.php", {
                    id: id
                })
                .done(function(data) {
                    $('#overlow').hide();
                    $("#modalResult").modal("show");
                    $('.modal-body').html(data);
                });
            }
        });
    });
    $(function (){
        var placeholder = 'bkhost01.net\nbkhost02.com';
        $('#domains').val(placeholder).focus();
        $('#domains').focus(function(){
            if($(this).val() === placeholder){
                $(this).val('');
            }
        });
        $('#domains').blur(function(){
            if($(this).val() ===''){
                $(this).val(placeholder);
            }    
        });
    });
</script>
<?php get_footer(); ?>