<?php

//error_reporting(false);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
$i = file_get_contents('dcounter.json');
if (isset($_GET['download'])) {

    $cfile = fopen('dcounter.json', 'w');
    fwrite($cfile, intval($i) + 1);
    fclose($cfile);
    header('Location: https://downloads.wordpress.org/plugin/crypto-checkout-for-woocommerce.1.1.0.zip');
}
function tounit($amount, $currency)
{
    if ($currency == 'btc') {
        $decimal = 100000000;
    } elseif ($currency == 'eth' || $currency == 'avax' || $currency == 'usdt') {
        $decimal = 1000000000000000000;
    } elseif ($currency == 'sol' || $currency == 'xmr') {
        $decimal = 1000000000;
    } elseif ($currency == 'dot') {
        $decimal = 1000000000000;
    } elseif ($currency == 'ada') {
        $decimal = 1000000;
    } else {
        $decimal = 1;
    }
    return $amount / $decimal;
}
function tomicrounit($amount, $currency)
{
    if ($currency == 'btc') {
        $decimal = 100000000;
    } elseif ($currency == 'eth' || $currency == 'avax' || $currency == 'usdt') {
        $decimal = 1000000000000000000;
    } elseif ($currency == 'sol' || $currency == 'xmr') {
        $decimal = 1000000000;
    } elseif ($currency == 'dot') {
        $decimal = 1000000000000;
    } elseif ($currency == 'ada') {
        $decimal = 1000000;
    }
    return $amount * decimal;
}
function sendmail($to, $title, $object)
{

    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp-relay.brevo.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'benrawane2012@gmail.com'; //SMTP username
        $mail->Password = 'Vc4FEADGRgU3CZWt'; //SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('noreplay@cryptocheckout.co', 'CryptoCheckout');
        $mail->addAddress($to); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $title;
        $mail->Body = $object;
        $mail->AltBody = $object;

        $mail->send();
        return 'Message has been sent';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}


//print_r($count);
function cryptoJsAesEncrypt($passphrase, $value)
{
    $salt = openssl_random_pseudo_bytes(8);
    $salted = '';
    $dx = '';
    while (strlen($salted) < 48) {
        $dx = md5($dx.$passphrase.$salt, true);
        $salted .= $dx;
    }
    $key = substr($salted, 0, 32);
    $iv = substr($salted, 32, 16);
    $iterations = 999;
    $encrypted_data = openssl_encrypt($value, 'aes-256-cbc', $key, true, $iv);
    $data = array('ct' => base64_encode($encrypted_data), 'iv' => bin2hex($iv), 's' => bin2hex($salt));
    return $data;
}
function sofiane_encrypt($text, $key)
{
    $msgEncrypted = mcrypt_encrypt(MCRYPT_RIJNDEAL_256, $key, $text, MCRYPT_MODE_CBC, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDEAL_256, MCRYPT_MODE_CBC), MCRYPT_RAND));
    $msgBase64 = trim(base64_encode($msgEncrypted));
    return $msgBase64;
}
function cryptoJsAesDecrypt($passphrase, $jsonString)
{
    $jsondata = json_decode($jsonString, true);
    $salt = hex2bin($jsondata["s"]);
    $ct = base64_decode($jsondata["ct"]);
    $iv = hex2bin($jsondata["iv"]);
    $concatedPassphrase = $passphrase.$salt;
    $md5 = array();
    $md5[0] = md5($concatedPassphrase, true);
    $result = $md5[0];
    for ($i = 1; $i < 3; $i++) {
        $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
        $result .= $md5[$i];
    }
    $key = substr($result, 0, 32);
    $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
    return json_decode($data, true);
}

function EVP_BytesToKey($salt, $password)
{
    $bytes = '';
    $last = '';

    // 32 bytes key + 16 bytes IV = 48 bytes.
    while (strlen($bytes) < 48) {
        $last = hash('md5', $last . $password . $salt, true);
        $bytes .= $last;
    }
    return $bytes;
}
function generate_pin()
{
    $alph = array('a', 'B', 'c', 'D', 'e', 'F', 'g', 'H', 'i');
    $new = strval(round(microtime(true) * 1000) - 1600000000000);
    $number = $new[10];
    $new = base64_encode($new);
    $new = str_replace('=', '', substr_replace($new, $alph[$number], intval($number), 0));
    return $new;
}
function sf_encode($obj, $pass)
{
    $new = base64_encode(json_encode($obj));
    for ($i = 0; $i <= 5; $i++) {
        $new = substr_replace($new, $pass[$i], intval($pass[$i]), 0);
    }
    return $new;
}



if (!isset($_SESSION)) {
    session_start();

}
if($_GET['session']){
    header('Content-Type: application/json');
    echo json_encode(array('result'=>session_id()));
    die();
}

if(isset($_GET['presta'])){
    require_once('svix-webhooks/php/init.php');    
    $json = file_get_contents('php://input');
    $wh = new \Svix\Webhook('whsec_GDVsmNBfKzV9rnTglPyrY8VFuJY0uE3S');
    $header = array(
        'svix-id'  => getallheaders()['Svix-Id'],
        'svix-timestamp' => getallheaders()['Svix-Timestamp'],
        'svix-signature' => getallheaders()['Svix-Signature'],
    );
    $json = $wh->verify($json, $header);
    $as = substr(md5(strval(round(microtime(true) * 1000))."ssecret"), 0, -26);
        include "txtdb.php";
        $db = new TxtDb();
        $dbr = $db->select('merchants',array('as'=>$json['data']['subscription']['id']));
        if($dbr){            
            $db->update('merchants',['as'=>$json['data']['subscription']['id'],'data'=>json_decode($json),'address'=>array(),'notif'=>$json['data']['customer']['email'],'pk'=>array(),'end'=>$json['data']['subscription']['next_billing_at']],array_keys($dbr)[0]);               
        }else{
            $db->insert('merchants',['as'=>$json['data']['subscription']['id'],'data'=>json_decode($json),'address'=>array(),'notif'=>$json['data']['customer']['email'],'pk'=>array(),'end'=>$json['data']['subscription']['next_billing_at']]);
            /*$obj = array();
        $obj['email'] = $output['email'];
        $pass = substr(strval(round(microtime(true) * 1000)), -6);
        $obj['confirmation'] = $pass;
        if (!empty($output['email'])) {
            if (filter_var($output['email'], FILTER_VALIDATE_EMAIL)) {
                $r = sendmail($output['email'], 'Confirmation', 'Hello, somebody were register at cryptocheckout.co by this address, if you who did, folllow this link to confirm it: <a href="https://cryptocheckout.co/confirm.php?as='.$as.'" target="_blank" >https://cryptocheckout.co/confirm.php?as='.$as.'</a>');
                if ($r === 'Message has been sent') {
                    header('Content-type: application/json');

                    $r = array('mnemonic' => array('alltypes' => hex2bin($privatekey['alltypes']), 'xmr' => $xmrmnemonic), 'address' => $address, 'as' => $as, 'pin' => $pin);

                    echo json_encode($r);
                    if($output['plan'] !== 'paid') {
                        $_SESSION['did'] = true;
                        $_SESSION['phrase'] = 'none';
                        $_SESSION['inline'] = 'none';
                    }

                    die();
                } else {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => false, 'msg' => 'Invalid email'));
                    die();
                }
            }
        } else {
            $r = array('mnemonic' => array('alltypes' => hex2bin($privatekey['alltypes']), 'xmr' => $xmrmnemonic), 'address' => $address, 'as' => $as, 'pin' => $pin);
            header('Content-type: application/json');
            echo json_encode($r);
            if($output['plan'] !== 'paid') {
                $_SESSION['did'] = true;
                $_SESSION['phrase'] = 'none';
                $_SESSION['inline'] = 'none';
            }
            die();
        }*/
        }
        
}
if(isset($_GET['as']) && $_GET['type']=='presta'){
    include "txtdb.php";
        $db = new TxtDb();
        $dbr = $db->select('merchants',array('as'=>$_GET['as']));
        $shop_url = $dbr[array_keys($dbr)[0]]['data']['data']['customer']['meta_data']['shop_url'];
        $ns_record = dns_get_record(str_replace('https://','',str_replace('http://','',$shop_url)),DNS_NS) ? dns_get_record(str_replace('https://','',str_replace('http://','',$shop_url)),DNS_NS)[0]['target']:'404';
        if($ns_record!=='404'){
            $shop_ip = dns_get_record($ns_record,DNS_A)[0]['ip'];
        }else{
            $shop_ip = dns_get_record(str_replace('https://','',str_replace('http://','',$shop_url)),DNS_A)[0]['ip'];
        }

        if( $dbr && $_SERVER['REMOTE_ADDR']==$shop_ip){
            $data = file_get_contents('php://input');
            $db->update('merchants',['as'=>$_GET['as'],'data'=>$dbr[array_keys($dbr)[0]]['data'],'address'=>json_decode($data),'notif'=>$dbr[array_keys($dbr)[0]]['notif'],'pk'=>array(),'end'=>$dbr[array_keys($dbr)[0]]['end']],array_keys($dbr)[0]);               
        }


}
function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}
if(isset($_GET['woo'])){
    $r = file_get_contents('http://api.cryptocheckout.co:8080/?type=tw&password='.$output['password']);
            $r = json_decode($r, true);
            $address = $r['address'];
            $privatekey['alltypes'] = $r['pk'];
            //include 'phpqrcode/qrlib.php';
            //QRcode::png($r0, 'btc/'.$r['btc'].'.png', QR_ECLEVEL_L, 4);

            /*$r = file_get_contents('http://api.cryptocheckout.co/?type=xmr');
            $address['xmr'] = json_decode($r, true)['address'];
            $privatekey['xmr'] = json_decode($r, true)['privatekey'];
            $xmrmnemonic = json_decode($r, true)['mnemonic'];*/
            $as = substr(md5(strval(round(microtime(true) * 1000))."ssecret"), 0, -26);
        include "txtdb.php";
        $db = new TxtDb();
        $pin = generate_pin();

        $db->insert('merchants', ['pk' => $privatekey, 'address' => $address, 'as' => $as, 'notif' => $output['email'], 'pin' => $pin, 'stamp' => round(microtime(true) * 1000),'plan' => $plan,'tc' => 0,'confirmed' => false]);
        $obj = array();
        $obj['email'] = $output['email'];
        $pass = substr(strval(round(microtime(true) * 1000)), -6);
        $obj['confirmation'] = $pass;
        if (!empty($output['email'])) {
            if (filter_var($output['email'], FILTER_VALIDATE_EMAIL)) {
                $r = sendmail($output['email'], 'Confirmation', 'Hello, somebody were register at cryptocheckout.co by this address, if you who did, folllow this link to confirm it: <a href="https://cryptocheckout.co/confirm.php?as='.$as.'" target="_blank" >https://cryptocheckout.co/confirm.php?as='.$as.'</a>');
                if ($r === 'Message has been sent') {
                    header('Content-type: application/json');

                    $r = array('mnemonic' => array('alltypes' => hex2bin($privatekey['alltypes']), 'xmr' => $xmrmnemonic), 'address' => $address, 'as' => $as, 'pin' => $pin);

                    echo json_encode($r);
                    if($output['plan'] !== 'paid') {
                        $_SESSION['did'] = true;
                        $_SESSION['phrase'] = 'none';
                        $_SESSION['inline'] = 'none';
                    }

                    die();
                } else {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => false, 'msg' => 'Invalid email'));
                    die();
                }
            }
        } else {
            $r = array('mnemonic' => array('alltypes' => hex2bin($privatekey['alltypes']), 'xmr' => $xmrmnemonic), 'address' => $address, 'as' => $as, 'pin' => $pin);
            header('Content-type: application/json');
            echo json_encode($r);
            if($output['plan'] !== 'paid') {
                $_SESSION['did'] = true;
                $_SESSION['phrase'] = 'none';
                $_SESSION['inline'] = 'none';
            }
            die();
        }
}

if (isset($_GET['test'])) {


    parse_str(str_replace('/?', '', cryptoJsAesDecrypt($_GET['sessid'], base64_decode($_GET['test']))), $output);
    //print_r(parse_url(str_replace('/?','',cryptoJsAesDecrypt(session_id(),base64_decode($_GET['test'])))));
    //die();
    //echo $_SESSION['phrase'];
    //print_r( cryptoJsAesDecrypt(session_id(),base64_decode($_GET['test'])));
    //die();

    //echo $_SESSION['phrase'];
    //die();
    if ((strtolower($output['captcha']) == strtolower($_SESSION['phrase']) && $_SESSION['did'] == true) || $_SESSION['did'] == false) {



        $curr = explode(' ', $output['new']);
        $address = $privatekey = array();
        if($output['external'] == true) {
            $c = array('usdt','btc','eth','sol','dot','avax','ada','xtz','xmr');
            
            foreach($c as $currency) {
                if(!empty($output[$currency]) && check_address($currency, $output[$currency])) {
                    $address[$currency] = $output[$currency];
                } elseif(!empty($output[$currency]) ) {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => false, 'msg' => 'Some of your addresses not valid'));
                    die();
                } else {
                    $address[$currency] = $output[$currency];
                }
            }




        } else {



            $r = file_get_contents('http://api.cryptocheckout.co/?type=tw&password='.$output['password']);
            $r = json_decode($r, true);
            $address = $r['address'];
            $privatekey['alltypes'] = $r['pk'];
            //include 'phpqrcode/qrlib.php';
            //QRcode::png($r0, 'btc/'.$r['btc'].'.png', QR_ECLEVEL_L, 4);

            $r = file_get_contents('http://api.cryptocheckout.co/?type=xmr');
            $address['xmr'] = json_decode($r, true)['address'];
            $privatekey['xmr'] = json_decode($r, true)['privatekey'];
            $xmrmnemonic = json_decode($r, true)['mnemonic'];
        }
        $as = substr(md5(strval(round(microtime(true) * 1000))."ssecret"), 0, -26);
        include "txtdb.php";
        $db = new TxtDb();
        $pin = generate_pin();

        $db->insert('merchants', ['pk' => $privatekey, 'address' => $address, 'as' => $as, 'notif' => $output['email'], 'pin' => $pin, 'stamp' => round(microtime(true) * 1000),'plan' => $plan,'tc' => 0,'confirmed' => false]);
        $obj = array();
        $obj['email'] = $output['email'];
        $pass = substr(strval(round(microtime(true) * 1000)), -6);
        $obj['confirmation'] = $pass;
        if (!empty($output['email'])) {
            if (filter_var($output['email'], FILTER_VALIDATE_EMAIL)) {
                $r = sendmail($output['email'], 'Confirmation', 'Hello, somebody were register at cryptocheckout.co by this address, if you who did, folllow this link to confirm it: <a href="https://cryptocheckout.co/confirm.php?as='.$as.'" target="_blank" >https://cryptocheckout.co/confirm.php?as='.$as.'</a>');
                if ($r === 'Message has been sent') {
                    header('Content-type: application/json');

                    $r = array('mnemonic' => array('alltypes' => hex2bin($privatekey['alltypes']), 'xmr' => $xmrmnemonic), 'address' => $address, 'as' => $as, 'pin' => $pin);

                    echo json_encode(array('result' => true, 'msg' => base64_encode(json_encode(cryptoJsAesEncrypt($_GET['sessid'], json_encode($r))))));
                    if($output['plan'] !== 'paid') {
                        $_SESSION['did'] = true;
                        $_SESSION['phrase'] = 'none';
                        $_SESSION['inline'] = 'none';
                    }

                    die();
                } else {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => false, 'msg' => 'Invalid email'));
                    die();
                }
            }
        } else {
            $r = array('mnemonic' => array('alltypes' => hex2bin($privatekey['alltypes']), 'xmr' => $xmrmnemonic), 'address' => $address, 'as' => $as, 'pin' => $pin);
            header('Content-type: application/json');
            echo json_encode(array('result' => true, 'msg' => base64_encode(json_encode(cryptoJsAesEncrypt(session_id(), json_encode($r))))));
            if($output['plan'] !== 'paid') {
                $_SESSION['did'] = true;
                $_SESSION['phrase'] = 'none';
                $_SESSION['inline'] = 'none';
            }
            die();
        }

    }
    /*$r = file_get_contents('https://translate.cryptocheckout.co/update.php?text='.substr_replace(base64_encode(json_encode($obj)), 'S', 5, 0));*/




    elseif ($_SESSION['did'] == true) {
        header('Content-type: application/json');
        echo json_encode(array('result' => false, 'msg' => 'Wrong captcha, try again'));
        die();
    }

}


//print_r( session_id());
if (empty($_GET) && empty($_POST) && empty($_FILES)) {

    include 'captcha/CaptchaBuilderInterface.php';
    include 'captcha/CaptchaBuilder.php';
    include 'captcha/PhraseBuilderInterface.php';
    include 'captcha/PhraseBuilder.php';
}
function check_address($curr, $address)
{
    $url = "https://checkcryptoaddress.com/api/check-address";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $data = '{"address":"'.$address.'","currency":"'.$curr.'"}';


    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $resp = curl_exec($curl);
    curl_close($curl);

    if(json_decode($resp)->code == 200 && json_decode($resp)->data->isValid == true) {
        return true;
    } else {
        return false;
    }
}
function asteriskemail($email)
{
    $r = explode('@', $email);
    for ($i = 0; $i <= strlen($r[0]); $i++) {
        $n .= '*';
        if ($i == strlen($r[0]) - 5) {
            $n .= $r[0][$i + 1].$r[0][$i + 2].$r[0][$i + 3].$r[0][$i + 4];
            break;
        }
    }
    $n .= '@';
    for ($i = 0; $i <= strlen($r[1]); $i++) {
        $n .= '*';
        if ($i == strlen($r[1]) - 5) {
            $n .= $r[1][$i + 1].$r[1][$i + 2].$r[1][$i + 3].$r[1][$i + 4];
            break;
        }
    }
    return $n;
}

if (isset($_GET['action']) && $_GET['action'] == 'transfer' && $_GET['dst'] !== '' && $_GET['amount'] !== '' && $_GET['pin'] !== '' && $_GET['dstcurr'] !== '') {
    include "txtdb.php";
    $db = new TxtDb();
    $pin = $db->select('merchants', array('pin' => $_GET['pin']));

    if (!empty($pin)) {

        if ($_GET['dstcurr'] == 'btc') {
            $url = 'http://api.cryptocheckout.co/?transaction=btc&amount='.strval(floatval($_GET['amount']) * 100000000).'&src='.$pin[array_keys($pin)[0]]['address']['btc'].'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['btc'];
        } elseif ($_GET['dstcurr'] == 'eth') {
            $url = 'http://api.cryptocheckout.co/?transaction=eth&amount='.strval(floatval($_GET['amount']) * 1000000000000000000).'&src='.$pin[array_keys($pin)[0]]['address']['eth'].'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['eth'];
        } elseif ($_GET['dstcurr'] == 'sol') {
            $url = 'http://api.cryptocheckout.co/?transaction=sol&amount='.strval(floatval($_GET['amount']) * 1000000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['sol'];
        } elseif ($_GET['dstcurr'] == 'avax') {
            $url = 'http://api.cryptocheckout.co/?transaction=avax&amount='.strval(floatval($_GET['amount']) * 1000000000000000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['avax'];
        } elseif ($_GET['dstcurr'] == 'dot') {
            $url = 'http://api.cryptocheckout.co/?transaction=dot&amount='.strval(floatval($_GET['amount']) * 1000000000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['dot'];
        } elseif ($_GET['dstcurr'] == 'ada') {
            $url = 'http://api.cryptocheckout.co/?transaction=ada&amount='.strval(floatval($_GET['amount']) * 1000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['ada'];
        } elseif ($_GET['dstcurr'] == 'xtz') {
            $url = 'http://api.cryptocheckout.co/?transaction=xtz&amount='.strval($_GET['amount']).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['xtz'];
        } elseif ($_GET['dstcurr'] == 'xmr') {
            $url = 'http://api.cryptocheckout.co/?transaction=xmr&amount='.strval($_GET['amount']).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['xmr'];
        } elseif ($_GET['dstcurr'] == 'usdt') {
            $url = 'http://api.cryptocheckout.co/?transaction=usdt&amount='.strval(floatval($_GET['amount']) * 1000000000000000000).'&src='.$pin[array_keys($pin)[0]]['address']['eth'].'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['alltypes'];
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'failure', 'msg' => 'We don\'t support currency: '.$_GET['dstcurr']));
            die();
        }
        if (json_decode($r)->result == true) {
            $obj = array();
            $obj['email'] = $pin[array_keys($pin)[0]]['notif'];
            $pass = substr(strval(round(microtime(true) * 1000)), -6);
            $obj['confirmation'] = $pass;
            sendmail($obj['email'], 'Confirmation Code', 'Hello, your confirmation code is: '.$obj['confirmation']);
            /*$r = file_get_contents('https://translate.cryptocheckout.co/update.php?text='.substr_replace(base64_encode(json_encode($obj)), 'S', 5, 0));*/
            $db->insert('sessions', array('confirmation' => $pass, 'url' => $url));
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'success', 'email' => $pin[array_keys($pin)[0]]['notif']));
            die();
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'failure', 'msg' => 'An error occured'));
            die();
        }

    } else {
        header('Content-Type: application/json');
        echo json_encode(array('result' => 'failure', 'msg' => 'We don\'t found account associated with pin: '.$_GET['pin']));
        die();
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'confirmtransfer') {
    include "txtdb.php";
    $db = new TxtDb();
    $pass = $db->select('sessions', array('confirmation' => $_GET['confirmation']));
    if (!empty($pass)) {
        header('Content-Type: application/json');
        echo file_get_contents($pass[array_keys($pass)[0]]['url']);
        die();
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('result' => 'failure', 'msg' => 'Wrong confirmation code'));
        die();
    }
}


if (isset($_GET['hash']) && isset($_GET['as']) && isset($_GET['type'])) {

    date_default_timezone_set('Europe/London');
    $now = round(round(microtime(true) * 1000) / 1000);
    include "txtdb.php";
    $db = new TxtDb();
    $m = $db->select('merchants', array('as' => $_GET['as']));
    $m = $m[array_keys($m)[0]];

    if ($m['address'] !== '' && $m['address'][$_GET['type']] !== '') {
        $rate = floatval(json_decode(file_get_contents('http://rates.cryptocheckout.co/rate.php?from=usd&to='.strtolower($_GET['type'].'&token=6fd8404714f243391d3f125910b4338a')))->rate) / 2;


        $tounit = tounit(floatval($t['mcamount']), $t['curr']);
        $usdequivalent = $tounit / $rate;
        switch ($_GET['type']) {
            case 'btc':


                $r = file_get_contents('https://api.blockcypher.com/v1/btc/main/addrs/'.$m['address'][$_GET['type']].'/full?token=0c90af3735a0454b97d1353fe7dec4f2');

                if ($r == '' || $r == null) {
                    break;
                }
                $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                $s0 = array_keys($s)[0];
                $t = $s[$s0];
                foreach (json_decode($r) as $i => $v) {
                    if ($i == 'txs') {
                        foreach ($v as $i2 => $v2) {
                            if (intval($v2->confirmations) >= 4) {
                                foreach ($v2->inputs as $i3 => $v3) {
                                    if (substr($v3->addresses[0], 0, 3).substr($v3->addresses[0], -3) == $t['address']) {
                                        foreach ($v2->outputs as $i4 => $v4) {
                                            if ($v4->addresses[0] == $m['address'][$_GET['type']]) {
                                                if ($v4->value == $t['mcamount'] && empty($hashes)) {
                                                    $hashes = $db->select('hashes', ['hash' => $v[$i2]['hash']]);
                                                    if (empty($hashes)) {
                                                        $db->update('pre-transactions', array('from' => $v3->addresses[0], 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                                        $db->insert('hashes', array('hash' => $v[$i2]['hash'], 'from' => $v3->addresses[0], 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                                        sendmail($m['notif'], "Payment effectued successfully", "Hello, you\'ve successfully recieved ".strval(floatval($t['mcamount']) / 100000000)."BTC from: ".$v3->addresses[0].", the transaction id is: ".$v[$i2]->hash.", Best regards!");
                                                        header('Content-type: application/json');
                                                        echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $v[$i2]['hash'])));


                                                        $r = file_get_contents('http://api.cryptocheckout.co//?transaction=btc&src='.$m['address']['btc'].'&pk='.$m['pk']['alltypes'].'&dst=1As4VCjXcLeion5kz2VE1imptHEpBP7rhj&amount='.round(floatval($t['mcamount']) / 100));
                                                        die();


                                                    }
                                                }

                                            }
                                        }
                                    }
                                }
                            } elseif ($i2 == count($v) - 1) {
                                echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                                die();
                            }

                        }
                    }
                }
                break;
            case 'eth':
                $r = file_get_contents('https://api.etherscan.io/api?module=account&action=txlist&address='.$m['address'][$_GET['type']].'&apikey=XQWRYGPUPM7YDPYEZ7UVIAAZG8NBU3CGUX');

                if ($r == '' || $r == null) {
                    break;
                }
                $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                $s0 = array_keys($s)[0];
                $t = $s[$s0];
                foreach (json_decode($r)->result as $i => $v) {

                    if (intval($v->confirmations) > 0 && substr($v->from, 0, 3).substr($v->from, -3) == $t['address'] && $v->to == $m['address'][$_GET['type']]) {
                        if ($v->value == $t['mcamount']) {
                            $hashes = $db->select('hashes', ['hash' => $v['hash']]);
                            if (empty($hashes)) {
                                $db->update('pre-transactions', array('from' => $v->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                $db->insert('hashes', array('hash' => $v['hash'], 'from' => $v->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount']) / 1000000000000000000, 6))."ETH from: ".$v->from.", the transaction id is: ".$v['hash'].", Best regards!");
                                header('Content-type: application/json');
                                echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $v->hash)));


                                $r = file_get_contents('http://api.cryptocheckout.co//?transaction=eth&src='.$m['address']['eth'].'&pk='.$m['pk']['alltypes'].'&dst=0xBbA4Ef1F2749Bb679e35c357D26217761a061B73&amount='.round(floatval($t['mcamount']) / 100));
                                die();



                            }
                        }


                    } elseif ($i == count(json_decode($r)->result) - 1) {
                        echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                        die();
                    }


                }

                break;
            case 'usdt':
                $r = file_get_contents('https://api.bscscan.com/api?module=account&action=tokentx&address='.$m['address'][$_GET['type']].'&apikey=3B5GBAD8ER2W18BQ1I9JGR274BJG3FVTEB');
                
                if ($r == '' || $r == null) {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => 'failure', 'message' => $r));
                    break;
                    die();
                }
                $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                $s0 = array_keys($s)[0];
                $t = $s[$s0];
                if (empty(json_decode($r, true)['result'])) {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => 'failure', 'message' => ''));
                    break;
                    die();
                }
                foreach (json_decode($r)->result as $i => $v) {

                    if (intval($v->confirmations) > 0 && substr($v->from, 0, 3).substr($v->from, -3) == $t['address'] && $v->to == $m['address'][$_GET['type']]) {
                        if ($v->value == $t['mcamount']) {
                            $hashes = $db->select('hashes', ['hash' => $v['hash']]);
                            if (empty($hashes)) {
                                $db->update('pre-transactions', array('from' => $v->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                $db->insert('hashes', array('hash' => $v['hash'], 'from' => $v->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount']) / 1000000000000000000, 6))."USDT from: ".$v->from.", the transaction id is: ".$v['hash'].", Best regards!");
                                header('Content-type: application/json');
                                echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $v->hash)));



                                $r = file_get_contents('http://api.cryptocheckout.co//?transaction=usdt&src='.$m['address']['eth'].'&pk='.$m['pk']['alltypes'].'&dst=0xBbA4Ef1F2749Bb679e35c357D26217761a061B73&amount='.round(floatval($t['mcamount']) / 100));
                                die();



                            }
                        }


                    } elseif ($i == count(json_decode($r, true)['result']) - 1) {
                        header('Content-Type: application/json');
                        echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                        die();
                    }


                }

                // no break
            case 'sol':
                header('Content-type: application/json');

                // Create a stream
                $opts = [
                    "http" => [
                        "method" => "GET",
                        "header" => "Accept: application/json\r\n".
                        "User-Agent: Mozilla/5.0 (iPad; U; CPU iPad OS 5_0_1 like Mac OS X; en-us)   AppleWebKit/535.1+ (KHTML like Gecko) Version/7.2.0.0 Safari/6533.18.5\r\n".
                        "ApiKey: sk_live_12c5976c14994c3cbf9a762f9c031762\r\n"

                    ]
                ];

                // DOCS: https://www.php.net/manual/en/function.stream-context-create.php
                $context = stream_context_create($opts);

                // Open the file using the HTTP headers set above
                // DOCS: https://www.php.net/manual/en/function.file-get-contents.php
                $r = file_get_contents('https://api.solana.fm/v0/accounts/'.$m['address'][$_GET['type']].'/transfers', false, $context);

                header('Content-type: application/json');

                if ($r == '' || $r == null) {
                    break;
                }
                if (empty(json_decode($r, true)['results'])) {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => 'failure', 'message' => ''));
                    break;
                    die();
                }



                $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                $s0 = array_keys($s)[0];
                $t = $s[$s0];

                foreach (json_decode($r, true)['results'] as $i => $v) {

                    if ($v['data'][1]['destination'] == $m['address'][$_GET['type']] && $v['data'][1]['status'] == 'Successfull' && substr($v['data'][1]['source'], 0, 3).substr($v['data'][1]['source'], -3) == $t['address']) {

                        if ($v['data'][1]['amount'] == $t['mcamount']) {
                            $hashes = $db->select('hashes', array('hash' => $v['transactionHash']));
                            if (empty($hashes)) {
                                $db->update('pre-transactions', array('from' => $v['data'][1]['source'], 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                $db->insert('hashes', array('hash' => $v['transactionHash'], 'from' => $v['data'][1]['source'], 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount']) / 1000000000, 6))."SOL from: ".$v['data'][1]['source'].", the transaction id is: ".$v['transactionHash'].", Best regards!");
                                header('Content-type: application/json');
                                echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $v['transactionHash'])));



                                $r = file_get_contents('http://api.cryptocheckout.co//?transaction=sol&pk='.$m['pk']['alltypes'].'&dst=CwJHKBXMbBKrrKdSL7HWcjTkZ6H6yoccT9fovJEqYSpx&amount='.round(floatval($t['mcamount']) / 100));
                                die();


                            }
                        }


                    } elseif ($i == (count(json_decode($r, true)['results']) - 1)) {
                        echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                        die();
                    }


                }
                break;
            case 'avax':
                $r = file_get_contents('https://api-testnet.snowtrace.io/api?module=account&action=txlist&address='.$m['address'][$_GET['type']].'&startblock=1&endblock=99999999&sort=asc&apikey=WSFQCVHBKQKNPQC6V7UY22A2QX8Y8D2CV1');
                $r = json_decode($r);

                header('Content-type: application/json');

                if ($r == '' || $r == null) {
                    echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                    die();
                }

                $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                $s0 = array_keys($s)[0];
                $t = $s[$s0];

                foreach ($r->result as $key => $value) {

                    if (substr($value->from, 0, 3).substr($value->from, -3) == $t['address'] && $value->confirmations > 6 && $value->txreceipt_status == 1 && $value->value == $t['mcamount'] && $value->to == strtolower($m['address'][$_GET['type']])) {

                        $hashes = $db->select('hashes', array('hash' => $value->hash));
                        if (empty($hashes)) {
                            $db->update('pre-transactions', array('from' => $value->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                            $db->insert('hashes', array('hash' => $value->hash, 'from' => $value->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                            sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount']) / 1000000000000000000, 6))."AVAX from: ".$value->from.", the transaction id is: ".$value->hash.", Best regards!");
                            header('Content-type: application/json');
                            echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $value->hash)));

                            $r = file_get_contents('http://api.cryptocheckout.co//?transaction=avax&pk='.$m['pk']['alltypes'].'&dst=0x689098722dF2689Ab0d23e71C663a412458FE02d&amount='.round(floatval($t['mcamount']) / 100));
                            die();


                        } else {
                            echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                            die();

                        }
                    } elseif ($key == (count($r->result) - 1)) {
                        echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                        die();
                    }
                }
                break;
            case 'dot':

                $postdata = http_build_query(
                    array(
                        'address' => $m['address'][$_GET['type']],
                        'row' => 20,
                        'page' => 1
                    )
                );

                $opts = array('http' =>
                    array(
                        'method' => 'POST',
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n"."X-API-Key: 9e00bb9f16d24b14a96091c22030bc3e\r\n",
                        'content' => $postdata
                    )
                );

                $context = stream_context_create($opts);

                $r = file_get_contents('https://polkadot.api.subscan.io/api/scan/transfers', false, $context);
                $r = json_decode($r);

                header('Content-type: application/json');

                if ($r == '' || $r == null) {
                    echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                    die();
                }

                $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                $s0 = array_keys($s)[0];
                $t = $s[$s0];

                foreach ($r->data->transfers as $key => $value) {

                    if (substr($value->from, 0, 3).substr($value->from, -3) == $t['address'] && $value->success == 1 && floatval($value->amount) * 1000000000000 == $t['mcamount'] && $value->to == $m['address'][$_GET['type']]) {

                        $hashes = $db->select('hashes', array('hash' => $value->hash));
                        if (empty($hashes)) {
                            $db->update('pre-transactions', array('from' => $value->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                            $db->insert('hashes', array('hash' => $value->hash, 'from' => $value->from, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                            sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount']) / 1000000000000000000, 6))."DOT from: ".$value->from.", the transaction id is: ".$value->hash.", Best regards!");
                            header('Content-type: application/json');
                            echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $value->hash)));

                            $r = file_get_contents('http://api.cryptocheckout.co//?transaction=dot&pk='.$m['pk']['alltypes'].'&dst=5FgTyvXznnU682Xp4Ng3GZmn51MSMuaQT9yAaz6eJyq9E3Gv&amount='.round(floatval($t['mcamount']) / 100));

                            die();


                        } else {
                            echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                            die();
                        }

                    } elseif ($key == (count($r->result) - 1)) {
                        echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                        die();
                    }
                }
                break;
            case 'ada':

                $opts = array('http' =>
                    array(
                        'header' => "project_id: mainnet22dtYG2zLPHs1AjSpXvNlfxYLYeNVpwo\r\n"
                    )
                );

                $context = stream_context_create($opts);

                $r = file_get_contents('https://cardano-mainnet.blockfrost.io/api/v0/addresses/'.$m['address'][$_GET['type']].'/utxos', false, $context);
                $r = json_decode($r);

                //header('Content-type: application/json');


                if ($r == '' || $r == null) {
                    break;
                }
                if (json_decode($r, true)['status_code'] == '404') {
                    header('Content-type: application/json');
                    echo json_encode(array('result' => 'failure', 'message' => ''));
                    break;
                    die();
                }

                foreach ($r as $key1 => $value1) {

                    $opts = array('http' =>
                        array(
                            'header' => "project_id: mainnet22dtYG2zLPHs1AjSpXvNlfxYLYeNVpwo\r\n"
                        )
                    );

                    $context = stream_context_create($opts);

                    $r = file_get_contents('https://cardano-mainnet.blockfrost.io/api/v0/txs/'.$value1->tx_hash.'/utxos', false, $context);
                    $r = json_decode($r);


                    $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                    $s0 = array_keys($s)[0];
                    $t = $s[$s0];

                    foreach ($r->inputs as $key3 => $value3) {

                        if (substr($value3->address, 0, 3).substr($value3->address, -3) == $t['address']) {

                            foreach ($r->outputs as $key => $value) {

                                if (intval($value->amount[0]->quantity) == $t['mcamount'] && $value->amount[0]->unit == 'lovelace' && $value->address == $m['address'][$_GET['type']]) {

                                    $hashes = $db->select('hashes', array('hash' => $value->hash));
                                    if (empty($hashes)) {
                                        $db->update('pre-transactions', array('from' => $value3->address, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                        $db->insert('hashes', array('hash' => $r->hash, 'from' => $value3->address, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                                        sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount']) / 1000000, 6))."ADA from: ".$value3->address.", the transaction id is: ".$r->hash.", Best regards!");
                                        header('Content-type: application/json');
                                        echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $r->hash)));

                                        $r = file_get_contents('http://api.cryptocheckout.co//?transaction=ada&pk='.$m['pk']['alltypes'].'&dst=addr1q98m37hew4f28j22vc64k88mnmuvcjfyc5det3n9zkn92c4nlrewe7h6utq7qfmhp5pu2jndtwvky6w973dlqae4ldlsy367ex&amount='.round(floatval($t['mcamount']) / 100));

                                        die();

                                    } else {
                                        echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                                        die();
                                    }

                                } elseif ($key == (count($r->result) - 1)) {
                                    echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                                    die();
                                }
                            }
                        }
                    }
                }
                break;
            case 'xtz':
                $s = $db->select('pre-transactions', array('hash' => $_GET['hash']));
                $s0 = array_keys($s)[0];
                $t = $s[$s0];
                $r = file_get_contents('https://api.tzstats.com/explorer/account/'.$m['address'][$_GET['type']].'/op');
                $ops = json_decode($r)->ops;
                foreach ($ops as $key => $value) {

                    if ($value->type == 'transaction' && $value->volume == $t['mcamount'] && substr($value->sender, 0, 3).substr($value->sender, -3) == $t['address'] && $value->receiver == $m['address'][$_GET['type']]) {
                        $hashes = $db->select('hashes', array('hash' => $value->hash));
                        if (empty($hashes)) {
                            $db->update('pre-transactions', array('from' => $value->sender, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                            $db->insert('hashes', array('hash' => $r->hash, 'from' => $value->sender, 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                            sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".$t['mcamount']."XTZ from: ".$value->sender.", the transaction id is: ".$value->hash.", Best regards!");
                            header('Content-type: application/json');
                            echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => $value->hash)));

                            $r = file_get_contents('http://api.cryptocheckout.co//?transaction=xtz&pk='.$m['pk']['alltypes'].'&dst=tz1itXTtKcca5EwyWjA4GXCYoNgQsYTtyZ3R&amount='.round(floatval($t['mcamount']) / 100));
                            die();


                        } else {
                            echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                            die();
                        }

                    }
                }
                break;
            case 'xmr':
                $r = file_get_contents('http://api.cryptocheckout.co:55550/?wallet='.$m['pk'][$_GET['type']].'&address='.$m['address'][$_GET['type']].'&txprvkey='.$_GET['pp']);
                if (json_decode($r)->result === true) {
                    $hashes = $db->select('hashes', array('hash' => json_decode($r)->txhash));
                    if (empty($hashes)) {
                        $db->update('pre-transactions', array('from' => '123456', 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                        $db->insert('hashes', array('hash' => json_decode($r)->txhash, 'from' => '123456', 'to' => $m['address'][$_GET['type']], 'completed' => round(microtime(true) * 1000)), $s0);
                        sendmail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount']) / 1000000000, 6))."XMR from someone, the transaction id is: ".json_decode($r)->txhash.", Best regards!");
                        header('Content-type: application/json');
                        echo json_encode(array('result' => 'success', 'message' => 'Payment effectued successfully', 'transactionId' => array('local' => $_GET['hash'], 'universal' => json_decode($r)->txhash)));



                        $r = file_get_contents('http://api.cryptocheckout.co//?transaction=xmr&pk='.$m['pk']['xmr'].'&dst=49pQsprZ2YX9cpLH9vUBeXWLLefMVdEM3dP9udJsnJ6oGdKkYEchtw1iYR4x1rbps5Gr6HLoE3KJVCaGUN7ixjufUM2YT4w&amount='.round(floatval($t['mcamount']) / 100));
                        die();


                    } else {
                        echo json_encode(array('result' => 'failure', 'message' => 'We can\'t validate your transaction, try again'));
                        die();
                    }
                }
                // no break
            default:

                break;
        }

    }

}




if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

/*if( $_FILES  ){
$target_dir = __DIR__;
$target_file = basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Allow certain file formats
if( strpos($target_file,'php') !== false ) {
$msg = "Sorry, this format undefined.";
$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
$msg= "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
if (move_uploaded_file( $_FILES["file"]["tmp_name"], 'api/'.$target_file)) {
    $msg= "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
} else {
    $msg= "Sorry, there was an error uploading your file.";
}
}
}*/
if (isset($_GET['as']) && !isset($_GET['hash'])) {
    include "txtdb.php";
    $db = new TxtDb();
    $as = $db->select('merchants', ['as' => $_GET['as']]);
    if (!empty($as)) {
        $str = '';
        $pk = $as[array_keys($as)[0]]['address'];
        foreach ($pk as $k => $v) {
            $str .= 'Your '.$k.' address is: '.$as[array_keys($as)[0]]['address'][$k]."\n";
            //$str .= 'The associated private key is: '.$v."\n";
        }
        $str .= 'Your ID is: '.$_GET['as'].' used to accept crypto currencies payments on your site/app';
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=wallet.txt');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        //header('Content-Length: 3040');
        header("Content-Type: text/plain");
        //readfile('yield'.$_SERVER['REQUEST_URI']);
        echo $str;
        die();
    }
}
if (isset($_GET['new']) && isset($_GET['email'])) {
}
/*if( $_GET['new'] == 'register' ){
}
if( $_GET['new'] == 'exist' ){
    $r = file_get_contents('http://http://api.cryptocheckout.co//api/?type=fromWIF&wif='.$_GET['wif']);
    $as = substr(md5(strval(round(microtime(true)*1000))."ssecret"),0,-28);
    require("txtdb.php");
    $db = new TxtDb();
    $db->insert('merchants',['wif'=>$_GET['wif'],'address'=>$r,'as'=>$as,'notif'=>$_GET['email']]);
    header('Content-type: application/json');
    echo json_encode(array('wif'=>$_GET['wif'],'address'=>$r,'as'=>$as));
    die();
}*/

if (isset($_GET['submit']) && strlen($_GET['submit']) == 6 && isset($_GET['amount']) && floatval($_GET['amount']) !== 0 && isset($_GET['curr'])) {

    include "txtdb.php";
    $db = new TxtDb();
    $hash = md5(strval(round(microtime(true) * 1000).'cryptosafina'));
    if ($_GET['curr'] == 'btc') {
        $decimal = 100000000;
    } elseif ($_GET['curr'] == 'eth' || $_GET['curr'] == 'avax') {
        $decimal = 1000000000000000000;
    } elseif ($_GET['curr'] == 'sol' || $_GET['curr'] == 'xmr') {
        $decimal = 1000000000;
    } elseif ($_GET['curr'] == 'dot') {
        $decimal = 1000000000000;
    } elseif ($_GET['curr'] == 'ada') {
        $decimal = 1000000;
    }
    if ($_GET['curr'] == 'xmr') {
        $db->insert('pre-transactions', array('hash' => $hash, 'address' => $_GET['submit'], 'mcamount' => floatval($_GET['amount']) * $decimal, 'amount' => $_GET['amount'], 'from' => '', 'to' => '', 'completed' => '', 'issued' => round(microtime(true) * 1000), 'curr' => $_GET['curr'],'rate'=>$_GET['rate'], 'ip' => $_SERVER['REMOTE_ADDR'], 'cookie' => json_encode($_COOKIE)));
        header('Content-type: application/json');
        echo json_encode(array('result' => $hash));
        die();
    } else {
        $t = $db->select('pre-transactions', array('address' => $_GET['submit'], 'amount' => $_GET['amount'] * $decimal));
        if (empty($t)) {
            $db->insert('pre-transactions', array('hash' => $hash, 'address' => $_GET['submit'], 'mcamount' => floatval($_GET['amount']) * $decimal, 'amount' => $_GET['amount'], 'from' => '', 'to' => '', 'completed' => '', 'issued' => round(microtime(true) * 1000), 'curr' => $_GET['curr'],'rate'=>$_GET['rate'], 'ip' => $_SERVER['REMOTE_ADDR'], 'cookie' => json_encode($_COOKIE)));
            header('Content-type: application/json');
            echo json_encode(array('result' => $hash));
            die();
        } elseif ($t[array_keys($t)[0]]['ip'] == $_SERVER['REMOTE_ADDR'] || $t[array_keys($t)[0]]['cookie'] == json_encode($_COOKIE)) {
            header('Content-type: application/json');
            echo json_encode(array('result' => $t[array_keys($t)[0]]['hash']));
            die();
        }
    }



}
if (isset($_GET['transaction'])) {
    include "txtdb.php";
    $db = new TxtDb();
    $tr = $db->select('pre-transactions', array('hash' => $_GET['transaction']));
    if (!empty($tr)) {
        header('Content-type: application/json');
        echo json_encode($tr[array_keys($tr)[0]]);
        die();
    }
}

/*if( isset($_GET['source']) && isset($_GET['address']) && isset($_GET['amount']) ){
$r = file_get_contents('https://api.blockcypher.com/v1/btc/main/addrs/'.$_GET['address'].'/full');
foreach( json_decode($r) as $i => $v ){
    if( $i == 'txs' ){
        foreach( $v as $i2 => $v2 ){
            if( substr($v2->address,0,3) == substr($_GET['source'],0,3) &&  substr($v2->address,-3) == substr($_GET['source'],-3)){
                foreach( json_decode($r)->outputs as $i3 => $v3 ){
                    if( $v3->address == $_GET['address'] && $v3->value == floatval($_GET['amount'])*100000000 ){
                        echo $v->mintTxid;
                        require("txtdb.php");
                        $db = new TxtDb();
                        $db->insert('transactions', ['transaction'=>$v->mintTxid,'from'=>$v2->address,'to'=>$v3->address,'amount'=>$_GET['amount'],'time'=>date('d-m-Y h:m:s')]);
                        $m=$db->select('merchants', array('as'=>$_GET['id']));
                        mail($m[array_keys($m)[0]]['notif'],"Payment effectued successfully","Hello, you\'ve successfully recieved ".$_GET['amount']."btc from: ".$v2->address.", the transaction id is: ".$v->mintTxid.", Best regards!" );
                    }
                }
            }
        }
    }
}
}
if( isset($_GET['source']) && isset($_GET['address']) && isset($_GET['amount']) ){
$r = file_get_contents('https://api.bitcore.io/api/BCH/mainnet/address/'.$_GET['address']);
foreach( json_decode($r) as $i => $v ){
    $r = file_get_contents('https://api.bitcore.io/api/BCH/mainnet/tx/'.$v->mintTxid.'/coins');
    foreach( json_decode($r)->inputs as $i2 => $v2 ){
        if( substr($v2->address,0,3) == substr($_GET['source'],0,3) &&  substr($v2->address,-3) == substr($_GET['source'],-3)){
            foreach( json_decode($r)->outputs as $i3 => $v3 ){
                if( $v3->address == $_GET['address'] && $v3->value == floatval($_GET['amount'])*100000000 ){
                    echo $v->mintTxid;
                    require("txtdb.php");
                    $db = new TxtDb();
                    $db->insert('transactions', ['transaction'=>$v->mintTxid,'from'=>$v2->address,'to'=>$v3->address,'amount'=>$_GET['amount'],'time'=>date('d-m-Y h:m:s')]);
                }
            }
        }
    }
}
}*/

if (isset($_GET['address']) && isset($_GET['amount'])) {
    include 'phpqrcode/qrlib.php';
    if ($_GET['curr'] == 'btc') {
        $type = 'bitcoin';
    } elseif ($_GET['curr'] == 'eth') {
        $type = 'ethereum';
    } elseif ($_GET['curr'] == 'sol') {
        $type = 'solana';
    } elseif ($_GET['curr'] == 'avax') {
        $type = 'avalanche';
    } elseif ($_GET['curr'] == 'dot') {
        $type = 'polkadot';
    } elseif ($_GET['curr'] == 'ada') {
        $type = 'cardano';
    } elseif ($_GET['curr'] == 'xtz') {
        $type = 'tezos';
    } elseif ($_GET['curr'] == 'xmr') {
        $type = 'monero';
    } elseif ($_GET['curr'] == 'usdt') {
        $type = 'tether';
    } else {
        $type = 'bitcoin';
        $_GET['curr'] = 'btc';
    }
    $h = md5('safina');
    QRcode::png($type.':'.$_GET['address'].'?amount='.$_GET['amount'], $_GET['curr'].'/'.$h.'.png', QR_ECLEVEL_L, 4);
    header('Content-Type: application/json');
    echo json_encode(array('result' => $h));
    die();
}
