<?php








use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
function tounit($amount,$currency){
    if($currency == 'btc'){
        $decimal = 100000000;
    }elseif($currency=='eth' || $currency =='avax' ){
        $decimal = 1000000000000000000;
    }elseif($currency=='sol' || $currency=='xmr'){
        $decimal = 1000000000;
    }elseif($currency=='dot'){
        $decimal = 1000000000000;
    }elseif($currency=='ada'){
        $decimal = 1000000;
    }
    return $amount/$decimal;
}
function tomicrounit($amount, $currency){
    if($currency == 'btc'){
        $decimal = 100000000;
    }elseif($currency=='eth' || $currency =='avax' ){
        $decimal = 1000000000000000000;
    }elseif($currency=='sol' || $currency=='xmr'){
        $decimal = 1000000000;
    }elseif($currency=='dot'){
        $decimal = 1000000000000;
    }elseif($currency=='ada'){
        $decimal = 1000000;
    }
    return $amount*decimal;
}
function sendmail($to,$title,$object){

    $mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-relay.brevo.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'benrawane2012@gmail.com';                     //SMTP username
    $mail->Password   = 'Vc4FEADGRgU3CZWt';                               //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('noreplay@getpaidcrypto.online', 'GetPaidCrypto');
    $mail->addAddress($to);     //Add a recipient
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $title;
    $mail->Body    = $object;
    $mail->AltBody = $object;

    $mail->send();
    return 'Message has been sent';
} catch (Exception $e) {
    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}



$file=file('c-error.log');
$count = array();

$i=261;
foreach($file as $l => $d){
    if(strpos($d,'crypto-checkout-woocommerce.zip')!==false){
        $i=$i+1;
    }
    if(strpos($d, $_SERVER['REMOTE_ADDR'])!==false){
       preg_match("/\[(.*?)\]/", $d,$match);
       //print_r($match);
       $count[]=strtotime($match[1]);
    }
}
$requests = 0;
for($j=0;$j<count($count)-1;$j++){
    if($count[$j+1]-$count[$j]==0 && ($count[$j]==$count[$j+1] || $count[$j+1]==$count[$j]-1 || $count[$j+1]==$count[$j]+1 )){
        $requests = $requests+1;
    }else{
        $requests = 0;
    }
}
if($requests>10){
   die();
}


//print_r($count);
function cryptoJsAesEncrypt($passphrase, $value){
    $salt = openssl_random_pseudo_bytes(8);
    $salted = '';
    $dx = '';
    while(strlen($salted)<48){
        $dx = md5($dx.$passphrase.$salt,true);
        $salted .= $dx;
    }
    $key = substr($salted,0,32);
    $iv = substr($salted,32,16);
    $iterations = 999;
    $encrypted_data = openssl_encrypt($value, 'aes-256-cbc', $key, true, $iv);
    $data = array('ct'=>base64_encode($encrypted_data),'iv'=>bin2hex($iv),'s'=>bin2hex($salt));
    return $data;
}
function sofiane_encrypt($text,$key){
    $msgEncrypted = mcrypt_encrypt(MCRYPT_RIJNDEAL_256, $key, $text, MCRYPT_MODE_CBC, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDEAL_256, MCRYPT_MODE_CBC),MCRYPT_RAND));
    $msgBase64 = trim(base64_encode($msgEncrypted));
    return $msgBase64;
}
function cryptoJsAesDecrypt($passphrase, $jsonString){
    $jsondata = json_decode($jsonString, true);
    $salt = hex2bin($jsondata["s"]);
    $ct = base64_decode($jsondata["ct"]);
    $iv  = hex2bin($jsondata["iv"]);
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

function EVP_BytesToKey($salt, $password) {
    $bytes = '';
    $last = '';

    // 32 bytes key + 16 bytes IV = 48 bytes.
    while(strlen($bytes) < 48) {
        $last = hash('md5', $last . $password . $salt, true);
        $bytes.= $last;
    }
    return $bytes;
} 
function generate_pin(){
    $alph = array('a','B','c','D','e','F','g','H','i');
    $new = strval(round(microtime(true)*1000)-1600000000000);
    $number = $new[10];
    $new = base64_encode($new);
    $new = str_replace('=','',substr_replace( $new, $alph[$number], intval($number), 0));
    return $new;
}
function sf_encode($obj, $pass){
    $new = base64_encode(json_encode($obj));
    for( $i =0;$i<=5;$i++){
        $new = substr_replace( $new, $pass[$i], intval($pass[$i]), 0);
    }
    return $new;
}



if(!isset($_SESSION)){
    session_start();

}

if( isset($_GET['test']) ){

    
     parse_str(str_replace('/?','',cryptoJsAesDecrypt(session_id(),base64_decode($_GET['test']))));
  //print_r(parse_url(str_replace('/?','',cryptoJsAesDecrypt(session_id(),base64_decode($_GET['test'])))));
  //die();
//echo $_SESSION['phrase'];
     //print_r( cryptoJsAesDecrypt(session_id(),base64_decode($_GET['test'])));
     //die();
    
        //echo $_SESSION['phrase'];
        //die();
        if( ( $captcha == $_SESSION['phrase'] && $_SESSION['did']==true ) || $_SESSION['did']==false ){
         
    
    
        $curr = explode(' ',$new);
        $address = $privatekey = array();

        $r = file_get_contents('http://127.0.0.1:55000/api/?password='.$password);
        $r = json_decode($r,true);
        $address = $r['address'];
        $privatekey['alltypes'] = $r['pk'];
        //include 'phpqrcode/qrlib.php';
        //QRcode::png($r0, 'btc/'.$r['btc'].'.png', QR_ECLEVEL_L, 4);
        
        $r = file_get_contents('http://127.0.0.1:55000/api/?type=xmr');
        $address['xmr'] = json_decode($r,true)['address'];
        $privatekey['xmr']= json_decode($r,true)['privatekey'];
        $xmrmnemonic = json_decode($r,true)['mnemonic'];
        $as = substr(md5(strval(round(microtime(true)*1000))."ssecret"),0,-26);
        require("txtdb.php");
        $db = new TxtDb();
        $pin = generate_pin();
        
        $db->insert('merchants',['pk'=>$privatekey,'address'=>$address,'as'=>$as,'notif'=>$email,'pin'=>$pin,'stamp'=>round(microtime(true)*1000)]);
        $obj = array();
        $obj['email']=$email;
        $pass = substr(strval(round(microtime(true)*1000)),-6);
        $obj['confirmation'] = $pass;
            if(!empty($email) ){
                if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
           $r = sendmail($email,'Confirmation','Hello, this is the confirmation code: '.$pass);
           if( $r === 'Message has been sent' ){
            header('Content-type: application/json');
             
             $r = array('mnemonic'=>array('alltypes'=>hex2bin($privatekey['alltypes']),'xmr'=>$xmrmnemonic),'address'=>$address,'as'=>$as,'pin'=>$pin);
            
                echo json_encode(array('result'=>true,'msg'=>sf_encode($r,$pass)));        
                $_SESSION['did']=true;
                die(); 
             }else{
                header('Content-type: application/json');
                echo json_encode(array('result'=>false,'msg'=>'Invalid email'));
                die();
    }
            }
             }else{
                $r = array('mnemonic'=>array('alltypes'=>hex2bin($privatekey['alltypes']),'xmr'=>$xmrmnemonic),'address'=>$address,'as'=>$as,'pin'=>$pin);
header('Content-type: application/json');
echo json_encode(array('result'=>true,'msg'=>base64_encode(json_encode(cryptoJsAesEncrypt(session_id(),json_encode($r))))));        
                $_SESSION['did']=true;
                $_SESSION['phrase']='none';
                $_SESSION['inline']='none';
                die(); 
             }
                    
        }
        /*$r = file_get_contents('https://translate.translatewp.online/update.php?text='.substr_replace(base64_encode(json_encode($obj)), 'S', 5, 0));*/
        
        
        
        
    elseif($_SESSION['did']==true){
        header('Content-type: application/json');
        echo json_encode(array('result'=>false,'msg'=>$captcha.'Wrong captcha, please note that the captcha is case sensitive, try to clear getpaidcrypto.online cookies & history & try again'));
        die();
    }    
    
}
        
    
//print_r( session_id());
if(  empty($_GET) &&  empty($_POST) && empty($_FILES)  ){

require('captcha/CaptchaBuilderInterface.php');
require('captcha/CaptchaBuilder.php');
require('captcha/PhraseBuilderInterface.php');
require('captcha/PhraseBuilder.php');
}
function asteriskemail($email){
    $r = explode('@',$email);
    for($i=0;$i<=strlen($r[0]);$i++){
        $n .= '*';
        if( $i == strlen($r[0])-5 ){
            $n .= $r[0][$i+1].$r[0][$i+2].$r[0][$i+3].$r[0][$i+4];
            break;
        }
    }
    $n .= '@';
    for($i=0;$i<=strlen($r[1]);$i++){
        $n .= '*';
        if( $i == strlen($r[1])-5 ){
            $n .= $r[1][$i+1].$r[1][$i+2].$r[1][$i+3].$r[1][$i+4];
            break;
        }
    }
    return $n;
}

if( isset($_GET['action']) && $_GET['action'] == 'transfer' && $_GET['dst'] !=='' && $_GET['amount'] !=='' && $_GET['pin'] !=='' && $_GET['dstcurr'] !=='' ){
    require("txtdb.php");
    $db = new TxtDb();
    $pin = $db->select('merchants',array('pin'=>$_GET['pin']));
    
    if( !empty($pin) ){
        
        if( $_GET['dstcurr'] == 'btc' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=btc&amount='.strval(floatval($_GET['amount'])*100000000).'&src='.$pin[array_keys($pin)[0]]['address']['btc'].'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['btc'];
        }elseif( $_GET['dstcurr'] == 'eth' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=eth&amount='.strval(floatval($_GET['amount'])*1000000000000000000).'&src='.$pin[array_keys($pin)[0]]['address']['eth'].'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['eth'];
        }elseif( $_GET['dstcurr'] == 'sol' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=sol&amount='.strval(floatval($_GET['amount'])*1000000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['sol'];
        }elseif( $_GET['dstcurr'] == 'avax' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=avax&amount='.strval(floatval($_GET['amount'])*1000000000000000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['avax'];
        }elseif( $_GET['dstcurr'] == 'dot' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=dot&amount='.strval(floatval($_GET['amount'])*1000000000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['dot'];
        }elseif( $_GET['dstcurr'] == 'ada' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=ada&amount='.strval(floatval($_GET['amount'])*1000000).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['ada'];
        }elseif( $_GET['dstcurr'] == 'xtz' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=xtz&amount='.strval($_GET['amount']).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['xtz'];
        }elseif( $_GET['dstcurr'] == 'xmr' ){
            $url = 'http://127.0.0.1:55000/api/?transaction=xmr&amount='.strval($_GET['amount']).'&dst='.$_GET['dst'].'&pk='.$pin[array_keys($pin)[0]]['pk']['xmr'];
        }else{
            header('Content-Type: application/json');
            echo json_encode(array('result'=>'failure','msg'=>'We don\'t support currency: '.$_GET['dstcurr']));
            die();
        }
        if( json_decode($r)->result == true ){
            $obj = array();
            $obj['email']=$pin[array_keys($pin)[0]]['notif'];
            $pass = substr(strval(round(microtime(true)*1000)),-6);
            $obj['confirmation'] = $pass;
            sendmail($obj['email'],'Confirmation Code','Hello, your confirmation code is: '.$obj['confirmation']);
            /*$r = file_get_contents('https://translate.translatewp.online/update.php?text='.substr_replace(base64_encode(json_encode($obj)), 'S', 5, 0));*/
            $db->insert('sessions', array('confirmation'=>$pass,'url'=>$url));
            header('Content-Type: application/json');
            echo json_encode(array('result'=>'success','email'=>$pin[array_keys($pin)[0]]['notif']));
            die();
        }else{
            header('Content-Type: application/json');
            echo json_encode(array('result'=>'failure','msg'=>'An error occured'));
            die();
        }
        
    }else{
        header('Content-Type: application/json');
        echo json_encode(array('result'=>'failure','msg'=>'We don\'t found account associated with pin: '.$_GET['pin']));
        die();
    }
}elseif(isset($_GET['action']) && $_GET['action'] == 'confirmtransfer'){
    require("txtdb.php");
    $db = new TxtDb();
    $pass = $db->select('sessions', array('confirmation'=>$_GET['confirmation']));
    if( !empty($pass) ){
        header('Content-Type: application/json');
        echo file_get_contents($pass[array_keys($pass)[0]]['url']);
        die();
    }else{
        header('Content-Type: application/json');
        echo json_encode(array('result'=>'failure','msg'=>'Wrong confirmation code'));
        die();
    }
}


if( isset($_GET['hash']) && isset($_GET['as']) && isset($_GET['type']) ){

    date_default_timezone_set('Europe/London');
    $now = round(round(microtime(true)*1000)/1000);
    require("txtdb.php");
$db = new TxtDb();
$m = $db->select('merchants',array('as'=>$_GET['as']));
$m = $m[array_keys($m)[0]];

if( $m['address'] !=='' && $m['address'][$_GET['type']] !== '' ){
    $rate = floatval(json_decode(file_get_contents('http://rates.translatewp.online/rate.php?from=usd&to='.strtolower($t['curr'].'&token=6fd8404714f243391d3f125910b4338a')))->rate);
    $tounit = tounit(floatval($t['mcamount']),$t['curr']);
    $usdequivalent = $tounit/$rate;
    switch ($_GET['type']) {
        case 'btc':
           
        
                $r = file_get_contents('https://api.blockcypher.com/v1/btc/main/addrs/'.$m['address'][$_GET['type']].'/full?token=0c90af3735a0454b97d1353fe7dec4f2');                
                           
                if( $r == '' || $r == null ){
                    break;
                }
        $s = $db->select('pre-transactions',array('hash'=>$_GET['hash']));
        $s0=array_keys($s)[0];
        $t = $s[$s0];
        foreach( json_decode($r) as $i => $v ){
            if( $i == 'txs' ){
                foreach( $v as $i2 => $v2 ){                       
                        if( intval($v2->confirmations) >= 4   ){ 
                            foreach($v2->inputs as $i3 => $v3 ){
                                if( substr($v3->addresses[0],0,3).substr($v3->addresses[0],-3) == $t['address'] ){
                                    foreach($v2->outputs as $i4 => $v4 ){
                                        if( $v4->addresses[0] == $m['address'][$_GET['type']] ){                               
                                            if( $v4->value == $t['mcamount'] && empty($hashes) ){                                       
                                                $hashes = $db->select('hashes', ['hash'=>$v[$i2]['hash']]);
                                                if( empty($hashes) ){
                                                    $db->update('pre-transactions',array('from'=>$v3->addresses[0],'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                                    $db->insert('hashes',array('hash'=>$v[$i2]['hash'],'from'=>$v3->addresses[0],'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                                    sendmail($m['notif'],"Payment effectued successfully","Hello, you\'ve successfully recieved ".strval(floatval($t['mcamount'])/100000000)."BTC from: ".$v3->addresses[0].", the transaction id is: ".$v[$i2]->hash.", Best regards!");
                                                    header('Content-type: application/json');
                                                    echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$v[$i2]['hash'])));
                                                    
                                                    if( $usdequivalent <= 10 ){
                                                    $r = file_get_contents('127.0.0.1:55000/?transaction=btc&src='.$m['address']['btc'].'&pk='.$m['pk']['alltypes'].'&dst=1As4VCjXcLeion5kz2VE1imptHEpBP7rhj&amount='.round(floatval($t['mcamount'])*20/100));
                                                        die();
                                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                                     $r = file_get_contents('127.0.0.1:55000/?transaction=btc&src='.$m['address']['btc'].'&pk='.$m['pk']['alltypes'].'&dst=1As4VCjXcLeion5kz2VE1imptHEpBP7rhj&amount='.round(tomicrounit($rate,$t['curr'])));
                                                    die();
                                                    }else{
                                                        $r = file_get_contents('127.0.0.1:55000/?transaction=btc&src='.$m['address']['btc'].'&pk='.$m['pk']['alltypes'].'&dst=1As4VCjXcLeion5kz2VE1imptHEpBP7rhj&amount='.round(floatval($t['mcamount'])*1.5/100));
                                                        die();
                                                    } 
                                                       
                                                }
                                            }
                                
                                        }   
                                    }
                                }
                            }
                        }elseif($i2 == count($v)-1){ 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                        }
                    
                }
            }
        }
                break;
                case 'eth':
                $r = file_get_contents('https://api.etherscan.io/api?module=account&action=txlist&address='.$m['address'][$_GET['type']].'&apikey=XQWRYGPUPM7YDPYEZ7UVIAAZG8NBU3CGUX');                
                           
                if( $r == '' || $r == null ){
                    break;
                }
        $s = $db->select('pre-transactions',array('hash'=>$_GET['hash']));
        $s0=array_keys($s)[0];
        $t = $s[$s0];
        foreach( json_decode($r)->result as $i => $v ){
                                            
                        if( intval($v->confirmations) > 0  && substr($v->from,0,3).substr($v->from,-3) == $t['address'] && $v->to == $m['address'][$_GET['type']] ){                               
                                    if( $v->value == $t['mcamount'] ){                                       
                                        $hashes = $db->select('hashes', ['hash'=>$v['hash']]);
                                        if( empty($hashes) ){
                                            $db->update('pre-transactions',array('from'=>$v->from,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                            $db->insert('hashes',array('hash'=>$v['hash'],'from'=>$v->from,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                            sendmail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount'])/1000000000000000000,6))."ETH from: ".$v->from.", the transaction id is: ".$v['hash'].", Best regards!" );
                                            header('Content-type: application/json');
                                            echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$v->hash)));
                                            if( $usdequivalent <= 10 ){
                                                    $r = file_get_contents('127.0.0.1:55000/?transaction=eth&src='.$m['address']['eth'].'&pk='.$m['pk']['alltypes'].'&dst=0xBbA4Ef1F2749Bb679e35c357D26217761a061B73&amount='.round(floatval($t['mcamount'])*20/100));
                                                    die();
                                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                                     $r = file_get_contents('127.0.0.1:55000/?transaction=eth&src='.$m['address']['eth'].'&pk='.$m['pk']['alltypes'].'&dst=0xBbA4Ef1F2749Bb679e35c357D26217761a061B73&amount='.round(tomicrounit($rate,$t['curr'])));
                                                    die();
                                                    }else{
                                                       $r = file_get_contents('127.0.0.1:55000/?transaction=eth&src='.$m['address']['eth'].'&pk='.$m['pk']['alltypes'].'&dst=0xBbA4Ef1F2749Bb679e35c357D26217761a061B73&amount='.round(floatval($t['mcamount'])*1.5/100));
                                                        die();
                                                    }
                                            

                                        }
                                    }
                                
                            
                        }elseif($i == count(json_decode($r)->result)-1){ 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                        }
                    
                
            }
        break;
        case 'sol':
        header('Content-type: application/json');
                                            
            // Create a stream
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Accept: application/json\r\n".
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU iPad OS 5_0_1 like Mac OS X; en-us)   AppleWebKit/535.1+ (KHTML like Gecko) Version/7.2.0.0 Safari/6533.18.5\r\n" 
            
    ]
];

// DOCS: https://www.php.net/manual/en/function.stream-context-create.php
$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
// DOCS: https://www.php.net/manual/en/function.file-get-contents.php
$r = file_get_contents('https://public-api.solscan.io/account/solTransfers?account='.$m['address'][$_GET['type']].'&offset=0&limit=10', false, $context);
                         
                header('Content-type: application/json');
                
                if( $r == '' || $r == null ){
                    break;
                }
                
        $s = $db->select('pre-transactions',array('hash'=>$_GET['hash']));
        $s0=array_keys($s)[0];
        $t = $s[$s0];
        
        foreach( json_decode($r,true)['data'] as $i => $v ){
             
                        if( $v['dst'] == $m['address'][$_GET['type']] && $v['status'] == 'Success'  && substr($v['src'],0,3).substr($v['src'],-3) == $t['address']  ){                               
                                
                                    if( $v['lamport'] == $t['mcamount'] ){ 
                                        $hashes = $db->select('hashes', array('hash'=>$v['txHash']));
                                        if( empty($hashes) ){
                                            $db->update('pre-transactions',array('from'=>$v['src'],'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                            $db->insert('hashes',array('hash'=>$v['txHash'],'from'=>$v['src'],'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                            sendmail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount'])/1000000000,6))."SOL from: ".$v['src'].", the transaction id is: ".$v['txHash'].", Best regards!" );
                                            header('Content-type: application/json');
                                            echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$v['txHash'])));
                                            if( $usdequivalent <= 10 ){
                                                    $r = file_get_contents('127.0.0.1:55000/?transaction=sol&pk='.$m['pk']['alltypes'].'&dst=CwJHKBXMbBKrrKdSL7HWcjTkZ6H6yoccT9fovJEqYSpx&amount='.round(floatval($t['mcamount'])*20/100));
                                                     die(); 
                                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                                     $r = file_get_contents('127.0.0.1:55000/?transaction=sol&pk='.$m['pk']['alltypes'].'&dst=CwJHKBXMbBKrrKdSL7HWcjTkZ6H6yoccT9fovJEqYSpx&amount='.round(tomicrounit($rate,$t['curr'])));
                                                    die(); 
                                                    
                                                    }else{
                                                        $r = file_get_contents('127.0.0.1:55000/?transaction=sol&pk='.$m['pk']['alltypes'].'&dst=CwJHKBXMbBKrrKdSL7HWcjTkZ6H6yoccT9fovJEqYSpx&amount='.round(floatval($t['mcamount'])*1.5/100));
                                                     die();
                                                    }
                                              
                                        }
                                    }
                                
                            
                        }elseif($i == (count(json_decode($r,true)['data'])-1) ){ 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                        }
                    
                
            }
            break;
            case 'avax':
                 $r = file_get_contents('https://api-testnet.snowtrace.io/api?module=account&action=txlist&address='.$m['address'][$_GET['type']].'&startblock=1&endblock=99999999&sort=asc&apikey=WSFQCVHBKQKNPQC6V7UY22A2QX8Y8D2CV1');
                 $r = json_decode($r);

                 header('Content-type: application/json');
                
                if( $r == '' || $r == null ){
                    echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                }
                
        $s = $db->select('pre-transactions',array('hash'=>$_GET['hash']));
        $s0=array_keys($s)[0];
        $t = $s[$s0];

                 foreach ($r->result as $key => $value) {  

                     if( substr($value->from,0,3).substr($value->from,-3) == $t['address'] && $value->confirmations > 6 && $value->txreceipt_status == 1 && $value->value == $t['mcamount'] && $value->to == strtolower($m['address'][$_GET['type']]) ){

                               $hashes = $db->select('hashes', array('hash'=>$value->hash));
                                if( empty($hashes) ){
                                    $db->update('pre-transactions',array('from'=>$value->from,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                    $db->insert('hashes',array('hash'=>$value->hash,'from'=>$value->from,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                     sendmail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount'])/1000000000000000000,6))."AVAX from: ".$value->from.", the transaction id is: ".$value->hash.", Best regards!" );
                                    header('Content-type: application/json');
                                    echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$value->hash)));
                                    if( $usdequivalent <= 10 ){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=avax&pk='.$m['pk']['alltypes'].'&dst=0x689098722dF2689Ab0d23e71C663a412458FE02d&amount='.round(floatval($t['amount'])*20/100));
                                       die();
                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=avax&pk='.$m['pk']['alltypes'].'&dst=0x689098722dF2689Ab0d23e71C663a412458FE02d&amount='.round(tomicrounit($rate,$t['curr'])));
                                       die();                                                    
                                    }else{
                                        $r = file_get_contents('127.0.0.1:55000/?transaction=avax&pk='.$m['pk']['alltypes'].'&dst=0x689098722dF2689Ab0d23e71C663a412458FE02d&amount='.round(floatval($t['mcamount'])*1.5/100));
                                       die();
                                    }
                                       
                                }else{
                                   echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                                   die(); 
                                
                                    }
                     } elseif($key == (count($r->result)-1) ){ 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                        }             
                 }          
                 break;
            case 'dot':

            $postdata = http_build_query(
                array(
                    'address' => $m['address'][$_GET['type']],
                    'row' => 20,
                    'page'=> 1
                )
            );

            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"."X-API-Key: 9e00bb9f16d24b14a96091c22030bc3e\r\n",
                    'content' => $postdata
                )
            );

            $context  = stream_context_create($opts);

            $r = file_get_contents('https://polkadot.api.subscan.io/api/scan/transfers', false, $context);
                 $r = json_decode($r);

                 header('Content-type: application/json');
                
                if( $r == '' || $r == null ){
                    echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                }
                
        $s = $db->select('pre-transactions',array('hash'=>$_GET['hash']));
        $s0=array_keys($s)[0];
        $t = $s[$s0];

                 foreach ($r->data->transfers as $key => $value) {  

                     if( substr($value->from,0,3).substr($value->from,-3) == $t['address'] && $value->success == 1 && floatval($value->amount)*1000000000000 == $t['mcamount'] && $value->to == $m['address'][$_GET['type']] ){

                               $hashes = $db->select('hashes', array('hash'=>$value->hash));
                                if( empty($hashes) ){
                                    $db->update('pre-transactions',array('from'=>$value->from,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                    $db->insert('hashes',array('hash'=>$value->hash,'from'=>$value->from,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                     sendmail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount'])/1000000000000000000,6))."DOT from: ".$value->from.", the transaction id is: ".$value->hash.", Best regards!" );
                                    header('Content-type: application/json');
                                    echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$value->hash)));
                                    if( $usdequivalent <= 10 ){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=dot&pk='.$m['pk']['alltypes'].'&dst=5FgTyvXznnU682Xp4Ng3GZmn51MSMuaQT9yAaz6eJyq9E3Gv&amount='.round(floatval($t['mcamount'])*20/100));

                                       die();
                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=dot&pk='.$m['pk']['alltypes'].'&dst=5FgTyvXznnU682Xp4Ng3GZmn51MSMuaQT9yAaz6eJyq9E3Gv&amount='.round(tomicrounit($rate, $t['curr'])));

                                    die();                                                   
                                    }else{
                                        $r = file_get_contents('127.0.0.1:55000/?transaction=dot&pk='.$m['pk']['alltypes'].'&dst=5FgTyvXznnU682Xp4Ng3GZmn51MSMuaQT9yAaz6eJyq9E3Gv&amount='.round(floatval($t['mcamount'])*1.5/100));

                                       die();
                                    }
                                       
                                }else{
                                   echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                                   die(); 
                                }
                                    
                     } elseif($key == (count($r->result)-1) ){ 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                        }             
                 }          
                 break;
                 case 'ada':                 

            $opts = array('http' =>
                array(
                    'header'  => "project_id: mainnet22dtYG2zLPHs1AjSpXvNlfxYLYeNVpwo\r\n"
                )
            );

            $context  = stream_context_create($opts);

            $r = file_get_contents('https://cardano-mainnet.blockfrost.io/api/v0/addresses/'.$m['address'][$_GET['type']].'/utxos', false, $context);
                 $r = json_decode($r);
                 
                 //header('Content-type: application/json');
                
                if( $r == '' || $r == null ){
                    echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                }
                foreach ($r as $key1 => $value1) {

                $opts = array('http' =>
                array(
                    'header'  => "project_id: mainnet22dtYG2zLPHs1AjSpXvNlfxYLYeNVpwo\r\n"
                )
            );

            $context  = stream_context_create($opts);

            $r = file_get_contents('https://cardano-mainnet.blockfrost.io/api/v0/txs/'.$value1->tx_hash.'/utxos', false, $context);
                 $r = json_decode($r);
               
               
        $s = $db->select('pre-transactions',array('hash'=>$_GET['hash']));
        $s0=array_keys($s)[0];
        $t = $s[$s0];
               
                 foreach ($r->inputs as $key3 => $value3) {  

                     if( substr($value3->address,0,3).substr($value3->address,-3) == $t['address'] ){

                        foreach ($r->outputs as $key => $value) {

                        if(intval($value->amount[0]->quantity) == $t['mcamount'] && $value->amount[0]->unit == 'lovelace' && $value->address == $m['address'][$_GET['type']] ){
                             
                                $hashes = $db->select('hashes', array('hash'=>$value->hash));
                                if( empty($hashes) ){
                                    $db->update('pre-transactions',array('from'=>$value3->address,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                    $db->insert('hashes',array('hash'=>$r->hash,'from'=>$value3->address,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                     sendmail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount'])/1000000,6))."ADA from: ".$value3->address.", the transaction id is: ".$r->hash.", Best regards!" );
                                    header('Content-type: application/json');
                                    echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$r->hash)));
                                    if( $usdequivalent <= 10 ){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=ada&pk='.$m['pk']['alltypes'].'&dst=addr1q98m37hew4f28j22vc64k88mnmuvcjfyc5det3n9zkn92c4nlrewe7h6utq7qfmhp5pu2jndtwvky6w973dlqae4ldlsy367ex&amount='.round(floatval($t['mcamount'])*20/100));

                                      die();
                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=ada&pk='.$m['pk']['alltypes'].'&dst=addr1q98m37hew4f28j22vc64k88mnmuvcjfyc5det3n9zkn92c4nlrewe7h6utq7qfmhp5pu2jndtwvky6w973dlqae4ldlsy367ex&amount='.round(tomicrounit($rate, $t['curr'])));

                                    die();                                                 
                                    }else{
                                        $r = file_get_contents('127.0.0.1:55000/?transaction=ada&pk='.$m['pk']['alltypes'].'&dst=addr1q98m37hew4f28j22vc64k88mnmuvcjfyc5det3n9zkn92c4nlrewe7h6utq7qfmhp5pu2jndtwvky6w973dlqae4ldlsy367ex&amount='.round(floatval($t['mcamount'])*1.5/100));

                                      die();
                                    }   
                                }else{
                                   echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                                   die(); 
                                }
                                    
                     } elseif($key == (count($r->result)-1) ){ 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                        } 
                        }             
                           }}}
                 break;
            case 'xtz':
            $s = $db->select('pre-transactions',array('hash'=>$_GET['hash']));
        $s0=array_keys($s)[0];
        $t = $s[$s0];
            $r = file_get_contents('https://api.tzstats.com/explorer/account/'.$m['address'][$_GET['type']].'/op');
            $ops = json_decode($r)->ops;
            foreach( $ops as $key => $value ){
                
                if( $value->type == 'transaction' && $value->volume == $t['mcamount'] && substr($value->sender,0,3).substr($value->sender,-3) == $t['address'] && $value->receiver == $m['address'][$_GET['type']] ){
                    $hashes = $db->select('hashes', array('hash'=>$value->hash));
                    if( empty($hashes) ){
                        $db->update('pre-transactions',array('from'=>$value->sender,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                        $db->insert('hashes',array('hash'=>$r->hash,'from'=>$value->sender,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                            sendmail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".$t['mcamount']."XTZ from: ".$value->sender.", the transaction id is: ".$value->hash.", Best regards!" );
                        header('Content-type: application/json');
                        echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$value->hash)));
                        if( $usdequivalent <= 10 ){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=xtz&pk='.$m['pk']['alltypes'].'&dst=tz1itXTtKcca5EwyWjA4GXCYoNgQsYTtyZ3R&amount='.round(floatval($t['mcamount'])*20/100));
                                     die();
                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=xtz&pk='.$m['pk']['alltypes'].'&dst=tz1itXTtKcca5EwyWjA4GXCYoNgQsYTtyZ3R&amount='.round(tomicrounit($rate, $t['curr'])));
                                     die();                                                 
                                    }else{
                                        $r = file_get_contents('127.0.0.1:55000/?transaction=xtz&pk='.$m['pk']['alltypes'].'&dst=tz1itXTtKcca5EwyWjA4GXCYoNgQsYTtyZ3R&amount='.round(floatval($t['mcamount'])*1.5/100));
                        die();
                                    }
                           
                    }else{
                        echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                        die(); 
                    }
                    
                }
            }         
            break;
            case 'xmr':
                $r = file_get_contents('http://127.0.0.1:55550/?wallet='.$m['pk'][$_GET['type']].'&address='.$m['address'][$_GET['type']].'&txprvkey='.$_GET['pp']);
                if( json_decode($r)->result === true ){
$hashes = $db->select('hashes', array('hash'=>json_decode($r)->txhash));
                    if( empty($hashes) ){
                        $db->update('pre-transactions',array('from'=>'123456','to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                        $db->insert('hashes',array('hash'=>json_decode($r)->txhash,'from'=>'123456','to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                            sendmail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".strval(round(floatval($t['mcamount'])/1000000000,6))."XMR from someone, the transaction id is: ".json_decode($r)->txhash.", Best regards!" );
                        header('Content-type: application/json');
                        echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>json_decode($r)->txhash)));
                        if( $usdequivalent <= 10 ){
                                       $r = file_get_contents('127.0.0.1:55000/?transaction=xmr&pk='.$m['pk']['xmr'].'&dst=49pQsprZ2YX9cpLH9vUBeXWLLefMVdEM3dP9udJsnJ6oGdKkYEchtw1iYR4x1rbps5Gr6HLoE3KJVCaGUN7ixjufUM2YT4w&amount='.round(floatval($t['mcamount'])*20/100));
                                     die(); 
                                    }elseif($usdequivalent>10 && $usdequivalent <= 100){
                                      $r = file_get_contents('127.0.0.1:55000/?transaction=xmr&pk='.$m['pk']['xmr'].'&dst=49pQsprZ2YX9cpLH9vUBeXWLLefMVdEM3dP9udJsnJ6oGdKkYEchtw1iYR4x1rbps5Gr6HLoE3KJVCaGUN7ixjufUM2YT4w&amount='.round(tomicrounit($rate, $t['curr'])));
                        die();                                                  
                                    }else{
                                        $r = file_get_contents('127.0.0.1:55000/?transaction=xmr&pk='.$m['pk']['xmr'].'&dst=49pQsprZ2YX9cpLH9vUBeXWLLefMVdEM3dP9udJsnJ6oGdKkYEchtw1iYR4x1rbps5Gr6HLoE3KJVCaGUN7ixjufUM2YT4w&amount='.round(floatval($t['mcamount'])*1.5/100));
                        die(); 
                                    }
                          
                    }else{
                        echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                        die(); 
                    }
                }
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
if( isset($_GET['as']) && !isset($_GET['hash'])){
    require("txtdb.php");
    $db = new TxtDb();
    $as = $db->select('merchants',['as'=>$_GET['as']]);
    if( !empty($as) ){
        $str = '';
        $pk = $as[array_keys($as)[0]]['address'];
        foreach($pk as $k => $v){
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
if( isset($_GET['new']) && isset($_GET['email']) ){
    
    
    
}
    /*if( $_GET['new'] == 'register' ){
        
        
    }
    if( $_GET['new'] == 'exist' ){
        $r = file_get_contents('http://127.0.0.1:55000/api/?type=fromWIF&wif='.$_GET['wif']);
        $as = substr(md5(strval(round(microtime(true)*1000))."ssecret"),0,-28);
        require("txtdb.php");
        $db = new TxtDb();
        $db->insert('merchants',['wif'=>$_GET['wif'],'address'=>$r,'as'=>$as,'notif'=>$_GET['email']]);
        header('Content-type: application/json');
        echo json_encode(array('wif'=>$_GET['wif'],'address'=>$r,'as'=>$as));
        die();
    }*/

if( isset($_GET['submit']) && strlen($_GET['submit'])==6 && isset($_GET['amount']) && floatval($_GET['amount'])!==0 && isset($_GET['curr']) ){
    
         require("txtdb.php");
    $db = new TxtDb();
    $hash = md5(strval(round(microtime(true)*1000).'cryptosafina'));
    if($_GET['curr'] == 'btc'){
        $decimal = 100000000;
    }elseif($_GET['curr']=='eth' || $_GET['curr']=='avax' ){
        $decimal = 1000000000000000000;
    }elseif($_GET['curr']=='sol' || $_GET['curr']=='xmr'){
        $decimal = 1000000000;
    }elseif($_GET['curr']=='dot'){
        $decimal = 1000000000000;
    }elseif($_GET['curr']=='ada'){
        $decimal = 1000000;
    }
    if($_GET['curr']=='xmr'){
        $db->insert('pre-transactions',array('hash'=>$hash,'address'=>$_GET['submit'],'mcamount'=>floatval($_GET['amount'])*$decimal,'amount'=>$_GET['amount'],'from'=>'','to'=>'','completed'=>'','issued'=>round(microtime(true)*1000),'curr'=>$_GET['curr'],'ip'=>$_SERVER['REMOTE_ADDR'],'cookie'=>json_encode($_COOKIE)));
       header('Content-type: application/json');
       echo json_encode(array('result'=>$hash));
       die();
   }else{
$t = $db->select('pre-transactions',array('address'=>$_GET['submit'],'amount'=>$_GET['amount']*$decimal));
    if( empty($t) ){
       $db->insert('pre-transactions',array('hash'=>$hash,'address'=>$_GET['submit'],'mcamount'=>floatval($_GET['amount'])*$decimal,'amount'=>$_GET['amount'],'from'=>'','to'=>'','completed'=>'','issued'=>round(microtime(true)*1000),'curr'=>$_GET['curr'],'ip'=>$_SERVER['REMOTE_ADDR'],'cookie'=>json_encode($_COOKIE)));
       header('Content-type: application/json');
       echo json_encode(array('result'=>$hash));
       die(); 
    }elseif($t[array_keys($t)[0]]['ip']==$_SERVER['REMOTE_ADDR'] || $t[array_keys($t)[0]]['cookie']==json_encode($_COOKIE) ){
        header('Content-type: application/json');
       echo json_encode(array('result'=>$t[array_keys($t)[0]]['hash']));
       die();
    }
   }
    
    
    
}
if( isset($_GET['transaction']) ){
    require("txtdb.php");
    $db = new TxtDb();
    $tr = $db->select('pre-transactions',array('hash'=>$_GET['transaction']));
    if( !empty($tr) ){
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

if( isset($_GET['address']) && isset($_GET['amount']) ){
    include 'phpqrcode/qrlib.php';
    if($_GET['curr']=='btc'){
       $type = 'bitcoin';
    }elseif($_GET['curr']=='eth'){
       $type = 'ethereum';
    }elseif($_GET['curr']=='sol'){
       $type = 'solana';
    }elseif($_GET['curr']=='avax'){
       $type = 'avalanche';
    }elseif($_GET['curr']=='dot'){
       $type = 'polkadot';
    }elseif($_GET['curr']=='ada'){
       $type = 'cardano';
    }elseif($_GET['curr']=='xtz'){
       $type = 'tezos';
    }elseif($_GET['curr']=='xmr'){
       $type = 'monero';
    }else{
        $type = 'bitcoin';
        $_GET['curr'] = 'btc';
    }
    $h = md5('safina');
    QRcode::png($type.':'.$_GET['address'].'?amount='.$_GET['amount'], $_GET['curr'].'/'.$h.'.png', QR_ECLEVEL_L, 4);
    header('Content-Type: application/json');
    echo json_encode(array('result'=>$h));
    die();
}




if( isset($_GET['id']) && strpos($_SERVER['REQUEST_URI'],'crypto.js')!==false ){

    if( isset($_GET['lang']) ){
        if( $_GET['lang'] == 'ar' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'إدفع باستخدام العملات الرقمية','guide0'=>'سوف تدفع','guide1'=>'إلى ضمان ذلك أنت منظمة الصحة العالمية سوف أرسلت ال المال, منفضلك إدراج أولاً 3 شاركترز & آخر 3 شاركترز من الخاصبك بيتكوين العنوان','guide'=>'ادفع باستخدام qr أو أرسل المعاملة إلى العنوان التالي ، ثم انقر فوق لقد دفعت للانتقال إلى خطوة التحقق','ivepaid'=>'لقد دفعت','nextstep'=>'تحقّق','step2'=>'للتأكد من أنك من أرسلت الأموال ، يرجى إدخال أول 3 أحرف و 3 أحرف أخيرة من عنوان الخاص بك','success'=>'شكرا لك، تمت إثبات الدفع، جاري معالجة طلبك','failure'=>'لم نستطع إثبات دفعك يُرجى إعادة المحاولة','tryagain'=>'إعادة المحاولة','validating'=>'نحن نتأكد من المعاملة يرجى الإنتظار','thankyou'=>'شكرا لك','transactionid'=>'معرّف المعاملة','validationfailure'=>'عُذرا، لم نتمكن من العثور على معاملتك أو لم يتم تأكيدها بعد ، يرجى المحاولة مرة أخرى'));
        }         
        if( $_GET['lang'] == 'bn' ){             
            $sf = 'var messages ='.json_encode(array('pay'=>'ক্রিপ্টোকারেন্সি ব্যবহার করে পরিশোধ क्रिप्टोकरेंसी','guide0'=>'আপনি অর্থ প্রদান করতে যাচ্ছেন','guide1'=>'আপনি কে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, অনুগ্রহ করে আপনার বিটকয়েন ঠিকানার প্রথম 3টি অক্ষর এবং শেষ 3টি অক্ষর সন্নিবেশ করান','guide'=>'কিউআর ব্যবহার করে অর্থ প্রদান করুন বা পরবর্তী ঠিকানায় লেনদেন প্রেরণ করুন তারপরে যাচাইকরণের পদক্ষেপে যাওয়ার জন্য আমি অর্থ প্রদান করেছি ক্লিক করুন','ivepaid'=>'আমি দিয়েছি','nextstep'=>'বৈধতা দিন','step2'=>'আপনি যে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, দয়া করে আপনার ঠিকানার প্রথম 3 টি অক্ষর এবং 3 শেষ অক্ষর লিখুন','success'=>'আপনাকে ধন্যবাদ, অর্থ প্রদান সফলভাবে যাচাই করা হয়েছিল, আমরা আপনার আদেশ প্রক্রিয়া করছি','failure'=>'আমরা আপনার অর্থ প্রদান বৈধ করতে পারি না, আবার চেষ্টা করুন','tryagain'=>'আবার চেষ্টা কর','validating'=>'আমরা আপনার পেমেন্ট যাচাই করছি অনুগ্রহ করে অপেক্ষা করুন','thankyou'=>'ধন্যবাদ','transactionid'=>'লেনদেন নাম্বার','validationfailure'=>'দুঃখিত, আমরা আপনার লেনদেন খুঁজে পাচ্ছি না বা এটি এখনও নিশ্চিত হয়নি, অনুগ্রহ করে আবার চেষ্টা করুন'));
        } 
        if( $_GET['lang'] == 'zh' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'使用比加密货币付款','guide0'=>'你 be的现在时复数或第二人称单数 去 到 薪资','guide1'=>'To 确定 那 你 谁 意志 send的过去式和过去分词 art.那 金钱, ad请\n使高兴 插入物\n插入 ad首先 hundred & 最后的 hundred 的 pro你的 比特币 住址','guide'=>'使用二维码付款或将交易发送到下一个地址，然后单击我已付款以跳至验证步骤','ivepaid'=>'我已经付了','nextstep'=>'证实','step2'=>'为了确保您汇款成功，请输入您的地址的前3个字符和最后3个字符','success'=>'谢谢您，付款已成功验证，我们正在处理您的订单','failure'=>'我们无法验证您的付款，请重试','tryagain'=>'尝试 ad再一次','validating'=>'(weare的常用口语形式) 确认 pro你的 付款 ad请\\n使高兴等待"','thankyou'=>'谢意 你','transactionid'=>'交易 遗传素质','validationfailure'=>'抱歉，我们找不到您的交易或仍未确认，请重试'));
        } 
        if( $_GET['lang'] == 'cs' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Plaťte pomocí Kryptoměny','guide0'=>'Vy AR být na zaplatit','guide1'=>'Na zajistit že vy který vůle přenášet v peníze, Potěšit vložit Nejprve 3 Charty & Poslední 3 Charty z Vaši adresa','guide'=>'Zaplaťte pomocí qr nebo odešlete transakci na další adresu a kliknutím na možnost Zaplatil jsem přejdete na krok ověření','ivepaid'=>'Zaplatil jsem','nextstep'=>'Ověřit','step2'=>'Abyste se ujistili, že jste odeslali peníze, zadejte prosím první 3 znak a 3 poslední znak své Bitcoinové adresy','success'=>'Děkujeme, platba byla úspěšně ověřena, zpracováváme vaši objednávku','failure'=>'Nemůžeme ověřit vaši platbu, zkuste to znovu','tryagain'=>'Snažit znovu','validating'=>'We\'re validating Vaši Platba Potěšit Čekat','thankyou'=>'Děkovat vy','transactionid'=>'Transakce ID','validationfailure'=>'Omlouváme se, vaši transakci nemůžeme najít nebo stále není potvrzena, zkuste to prosím znovu'));
        } 
        if( $_GET['lang'] == 'da' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Betale ved hjælp af Kryptovalutaer','guide0'=>'De er gå til betale','guide1'=>'Til sikre at De der vilje sendt den penge, behage Indsætte først 3 charcters & sidst 3 charcters af Deres adresse','guide'=>'Betal ved hjælp af qr eller send transaktion til næste adresse, og klik derefter på jeg har betalt for at springe til bekræftelsestrinet','ivepaid'=>'Jeg har betalt','nextstep'=>'Valider','step2'=>'For at sikre, at du, der sendte pengene, skal du indtaste de første 3 tegn og 3 sidste tegn i din Bitcoin-adresse','success'=>'Tak, betaling blev valideret med succes, vi behandler din ordre','failure'=>'Vi kan ikke validere din betaling. Prøv igen','tryagain'=>'Forsøge igen','validating'=>'We\'re validating Deres betaling behage vente','thankyou'=>'Takke De','transactionid'=>'Transaktion ID','validationfailure'=>'Beklager, vi kan ikke finde din transaktion, eller den er stadig ikke bekræftet. Prøv venligst igen'));
        }
        if( $_GET['lang'] == 'en' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Pay Using Cryptocurrencies','guide0'=>'You\'re going to pay','guide1'=>'To ensure that you who sent the money, please insert first 3 charcters & last 3 charcters of your address','guide'=>'Pay using this qr or send to the next address then click i\'ve paid','ivepaid'=>'I\'ve paid','nextstep'=>'Next step','step2'=>'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address','success'=>'Thank you, payment were validated successfully, we\'re processing your order','failure'=>'We can\'t validate your payment, please try again','tryagain'=>'Try again','validating'=>'We\'re validating your payment please wait','thankyou'=>'Thank you','transactionid'=>'Transaction ID','validationfailure'=>'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
        }
        if( $_GET['lang'] == 'nl' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Betalen met Cryptovaluta','guide0'=>'U bevinden olivier te betalen','guide1'=>'Te waarborgen waarin u who wil gestuurd het geld, alstublieft “verzet” eerste 3 tekens & laatste 3 tekens van uw sleutelvraag','guide'=>'Betaal met qr of verzend de transactie naar het volgende adres en klik vervolgens op ik heb betaald om naar de verificatiestap te gaan','ivepaid'=>'Ik heb betaald','nextstep'=>'Valideren','step2'=>'Om er zeker van te zijn dat u het geld heeft verzonden, voert u de eerste 3 tekens en de laatste 3 tekens van uw Bitcoin-adres in','success'=>'Bedankt, de betaling is succesvol gevalideerd, we verwerken uw bestelling','failure'=>'We kunnen uw betaling niet valideren, probeer het opnieuw','tryagain'=>'Proberen wederom','validating'=>'Klaar gevalideerd uw betaling alstublieft afwachten','thankyou'=>'Dank u','transactionid'=>'Transactie ID','validationfailure'=>'Sorry, we kunnen uw transactie niet vinden of deze is nog steeds niet bevestigd, probeer het opnieuw'));
        } 
        if( $_GET['lang'] == 'fr' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Payer en utilisant Crypto-monnaies','guide0'=>'Te sommes allume à payent','guide1'=>'Pour garantir que vous ce qui envoyéz le monnaie, veuillez enterer le premier 3 charcters & le dernier 3 charcters de votre address','guide'=>'Payer en utilisant qr ou envoyer la transaction à l\'adresse suivante puis cliquez sur j\'ai payé pour passer à l\'étape de vérification','ivepaid'=>'J\'ai payé','nextstep'=>'Valider','step2'=>'Pour vous assurer que vous qui avez envoyé l\'argent, veuillez entrer les 3 premiers caractères et les 3 derniers caractères de votre adresse Bitcoin','success'=>'Merci, le paiement a été validé avec succès, nous traitons votre commande', 'failure'=>'Nous ne pouvons pas valider votre paiement, veuillez réessayer','tryagain'=>'Réessayer','validating'=>'Veuillez patientez Nous validons votre paiement','thankyou'=>'Merçi','transactionid'=>'Référence de la transaction','validationfailure'=>'Désolé, nous ne trouvons pas votre transaction ou elle n\'est toujours pas confirmée, veuillez réessayer'));
        } 
        if( $_GET['lang'] == 'de' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Zahlen Sie mit Kryptowährungen','guide0'=>'Sie sind Going zu zahlen','guide1'=>'Zu sicherzustellen jenes Sie wer wollt schickte die Geld, erfreuen Einfügen zuerst 3 zeichen & zuletzt 3 zeichen von euer kaufen Adresse','guide'=>'Bezahlen Sie mit qr oder senden Sie die Transaktion an die nächste Adresse. Klicken Sie dann auf Ich habe bezahlt, um zum Überprüfungsschritt zu springen','ivpaid'=>'Ich habe bezahlt','nextstep'=>'Bestätigen','step2'=>'Um sicherzustellen, dass Sie das Geld gesendet haben, geben Sie bitte die ersten 3 Zeichen und 3 letzten Zeichen Ihrer Bitcoin-Adresse ein','success'=>'Vielen Dank, die Zahlung wurde erfolgreich validiert. Wir bearbeiten Ihre Bestellung','failure'=>'Wir können Ihre Zahlung nicht bestätigen. Bitte versuchen Sie es erneut','tryagain'=>'Versuchen wieder','validating'=>'We\'re validating euer Zahlung erfreuen warten','thankyou'=>'dank eschön','transactionid'=>'Transaktion ID','validationfailure'=>'Entschuldigung, wir können Ihre Transaktion nicht finden oder sie ist noch nicht bestätigt, bitte versuchen Sie es erneut'));
        } 
        if( $_GET['lang'] == 'he' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'שלם באמצעות מטבעותקריפטוגרפיים','guide0'=>'אַתָּה עשיריתדונם עֲזִיבָה לִכְבוֹד שִׁלֵּם','guide1'=>"To הִבְטִיחַ שֶׁ אַתָּה מִי רָצָה נשלח במידהש_ כֶּסֶף, בְּבַקָּשָׁה דברשהוכנס קֹדֶםכֹּל 3 צ'ארטרים & הדברהאחרון 3 צ'ארטרים שֶׁל שלך ביטקוין פָּנָה",'guide'=>'שלם באמצעות qr או שלח עסקה לכתובת הבאה ואז לחץ על שילמתי כדי לעבור לשלב האימות','ivepaid'=>'שילמתי','nextstep'=>'לְאַמֵת','step2'=>'כדי להבטיח ששלחת את הכסף, אנא הזן 3 תווים ראשונים ושלוש תווים אחרונים של כתובת ה שלך','success'=>'תודה, התשלום אומת בהצלחה, אנו מעבדים את הזמנתך','failure'=>'איננו יכולים לאמת את התשלום שלך. נסה שוב','tryagain'=>'נִסָּיוֹן שׁוּב','validating'=>'אנחנו+פועלעזרלציוןהווה(צורהמקוצרתשלweare) validating שלך תַּשְׁלוּם בְּבַקָּשָׁה הַמְתָּנָה','thankyou'=>'הוֹדָה אַתָּה','transactionid'=>'עִסְקָה (פסיכואנליזה)סְתָמִי','validationfailure'=>'מצטערים, אנחנו לא יכולים למצוא את העסקה שלך או שהיא עדיין לא אושרה, אנא נסה שוב'));
        } 
        if( $_GET['lang'] == 'hi' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'क्रिप्टो मुद्राएँ का उपयोग करके भुगतान करें','guide0'=>'आप हैं जारहाहै को भुगतान करें','guide1'=>'को सुनिश्चित करें कि आप कौन होगा भेजा गया द पैसा, कृपया। सम्मिलित करें पहले 3 charcters & अंतिम 3 charcters का आपका Bitcoin पता ','guide'=>'qr का उपयोग करके भुगतान करें या अगले पते पर लेन-देन भेजें फिर क्लिक करें मैंने सत्यापन चरण पर जाने के लिए भुगतान किया है','ivepaid'=>'मैंने भुगतान किया है','nextstep'=>'सत्यापित करें','step2'=>'यह सुनिश्चित करने के लिए कि आपने पैसा किसने भेजा है, कृपया अपने पते के पहले 3 चरित्र और 3 अंतिम चरित्र दर्ज करें','success'=>'धन्यवाद, भुगतान सफलतापूर्वक सत्यापित किया गया, हम आपका आदेश संसाधित कर रहे हैं','failure'=>'हम आपके भुगतान को मान्य नहीं कर सकते, कृपया पुनः प्रयास करें','tryagain'=>'कोशिश करो फिरसे','validating'=>'हम आपके भुगतान की पुष्टि कर रहे हैं कृपया। रुको','thankyou'=>'धन्यवाद आप','transactionid'=>'लेन-देन आईडी','validationfailure'=>'क्षमा करें, हमें आपका लेन-देन नहीं मिला या अभी भी इसकी पुष्टि नहीं हुई है, कृपया पुनः प्रयास करें'));
        } 
        if( $_GET['lang'] == 'id' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Bayar menggunakan mata uang kripto','guide0'=>'Kamu akan membayar','guide1'=>'Untuk memastikan bahwa Anda yang akan mengirim uang, harap masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Anda','guide'=>'Bayar menggunakan qr atau kirim transaksi ke alamat berikutnya lalu klik saya sudah membayar untuk melompat ke langkah verifikasi','ivepaid'=>'Saya sudah membayar','nextstep'=>'Mengesahkan','step2'=>'Untuk memastikan anda yang mengirim uang, silahkan masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Bitcoin anda','success'=>'Terima kasih, pembayaran berhasil divalidasi, kami sedang memproses pesanan Anda','failure'=>'Kami tidak dapat memvalidasi pembayaran Anda, harap coba lagi','tryagain'=>'Coba lagi','validating'=>'Kami memvalidasi pembayaran Anda harap tunggu','thankyou'=>'Terima kasih','transactionid'=>'ID transaksi','validationfailure'=>'Maaf, kami tidak dapat menemukan transaksi Anda atau masih belum terkonfirmasi, silakan coba lagi'));
        } 
        if( $_GET['lang'] == 'it' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Paga usando Criptovalute','guide0'=>'Si essere partenza per pagare','guide1'=>'Per assicurare che si chi volere mandato il moneta, piacere inserire primo 3 & ultimo 3 di vostro indirizzo','guide'=>'Paga utilizzando qr o invia la transazione all\'indirizzo successivo, quindi fai clic su ho pagato per passare alla fase di verifica','ivepaid'=>'Ho pagato','nextstep'=>'Convalidare','step2'=>'Per assicurarti di aver inviato il denaro, inserisci i primi 3 caratteri e gli ultimi 3 caratteri del tuo indirizzo Bitcoin','success'=>'Grazie, il pagamento è stato convalidato con successo, stiamo elaborando il tuo ordine','failure'=>'Non possiamo convalidare il tuo pagamento, per favore riprova','tryagain'=>'Provare ancora','validating'=>'Stiamo convalidando il tuo pagamento piacere attesa','thankyou'=>'Ringraziare si','transactionid'=>'ID transazione','validationfailure'=>'Siamo spiacenti, non riusciamo a trovare la transazione o non è stata ancora confermata, riprova'));
        }
        if( $_GET['lang'] == 'ja' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'ビットコインを使用して支払う','guide0'=>'あーた いらっしゃる いらして にかけて 引合う','guide1'=>'送金者を確認するために、ビットコインアドレスの最初の3文字と最後の3文字を挿入してください','guide'=>'qrを使用して支払うか、トランザクションを次のアドレスに送信してから、[支払った]をクリックして確認ステップにジャンプします','ivepaid'=>'支払いました','nextstep'=>'検証','step2'=>'送金者が確実に送金できるように、アドレスの最初の3文字と最後の3文字を入力してください','success'=>'ありがとうございます。お支払いは正常に検証されました。ご注文を処理しています','failure'=>'お支払いを確認できません。もう一度お試しください','tryagain'=>'１発 も','validating'=>'俺たち いらっしゃる validate あなたの 勘定 お願いいたします お預け','thankyou'=>'あじゃじゃしたー','transactionid'=>'トランズアクションイード','validationfailure'=>'申し訳ありませんが、取引が見つからないか、まだ確認されていません。もう一度お試しください'));
        }
        if( $_GET['lang'] == 'ko' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'비트 코인으로 지불','guide0'=>'너 아르 가는중 내다','guide1'=>'송금한 사람이 맞는지 확인하려면 비트코인 ​​주소의 처음 3자리와 마지막 3자리를 입력하세요.','guide'=>'qr을 사용하여 결제하거나 다음 주소로 거래를 보낸 다음 결제 완료를 클릭하여 확인 단계로 이동합니다.','ivepaid'=>'나는 지불했다','nextstep'=>'확인','step2'=>'송금 한 사람을 확인하려면 주소의 처음 3 자 및 마지막 3자를 입력하십시오.','success'=>'감사합니다. 결제가 성공적으로 확인되었습니다. 주문을 처리하고 있습니다.','failure'=>'결제를 확인할 수 없습니다. 다시 시도하십시오.','tryagain'=>'애쓰다 다시','validating'=>'우리 are validate 당신의 지불 제발 기다리다','thankyou'=>'감사 너','transactionid'=>'거래 아이디','validationfailure'=>'죄송합니다. 거래를 찾을 수 없거나 아직 확인되지 않았습니다. 다시 시도해 주세요.'));
        }
        if( $_GET['lang'] == 'pl' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Płacić za pomocą Bitcoinów','guide0'=>'Zamierzasz zapłacić','guide'=>'Zapłać za pomocą qr lub wyślij transakcję na następny adres, a następnie kliknij Zapłaciłem, aby przejść do etapu weryfikacji','ivepaid'=>'Zapłaciłem','nextstep'=>'Uprawomocnić','step2'=>'Aby upewnić się, że wysłałeś pieniądze, wprowadź pierwsze 3 znaki i 3 ostatnie znaki adresu','success'=>'Dziękujemy, płatność została pomyślnie zweryfikowana, Twoje zamówienie jest przetwarzane','failure'=>'Nie możemy zweryfikować Twojej płatności, spróbuj ponownie','tryagain'=>'Próbować ponownie','validating'=>'My jesteś zatwierdzać twój płatność podobaćsię czekać','thankyou'=>'Dziękować ty','transactionid'=>'Interes ID','validationfailure'=>'Przepraszamy, nie możemy znaleźć Twojej transakcji lub nadal nie została ona potwierdzona, spróbuj ponownie'));
        }
        if( $_GET['lang'] == 'pt' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Pagar usando Bitcoin','guide0'=>'Você são acompanhado aquilotado prestaratenção','guide'=>'Pague usando qr ou envie a transação para o próximo endereço e clique em paguei para ir para a etapa de verificação','ivepaid'=>'Eu paguei','nextstep'=>'Validar','step2'=>'Para garantir que foi você quem enviou o dinheiro, digite os primeiros 3 caracteres e os 3 últimos caracteres do seu endereço','success'=>'Obrigado, o pagamento foi validado com sucesso, estamos processando seu pedido','failure'=>'Não podemos validar o seu pagamento, tente novamente','tryagain'=>'Injuriador outravez','validating'=>'ViaLáctea são validar tresfoliar entregacontrapagamento Porfavor aguardar','thankyou'=>'Reconhecimento você','transactionid'=>'Negócio ID','validationfailure'=>'Desculpe, não conseguimos encontrar sua transação ou ela ainda não foi confirmada. Tente novamente'));
        }
        if( $_GET['lang'] == 'ru' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Платить с помощью биткойнов','guide0'=>'Ты есть ход айда-ко возмездие','guide'=>'Оплатите с помощью qr или отправьте транзакцию на следующий адрес, затем нажмите Я заплатил, чтобы перейти к этапу проверки','ivepaid'=>'Я заплатил','nextstep'=>'Подтверждать','step2'=>'Чтобы убедиться, что вы отправили деньги, введите первые 3 символа и последние 3 символа вашего адреса','success'=>'Спасибо, оплата прошла успешно, мы обрабатываем ваш заказ','failure'=>'Мы не можем подтвердить ваш платеж, попробуйте еще раз','tryagain'=>'Отведывать вновь','validating'=>'Мы есть легализовать свой взнос нравиться выжидать','thankyou'=>'Благодарите ты','transactionid'=>'Ведение втрд','validationfailure'=>'К сожалению, мы не можем найти вашу транзакцию или она еще не подтверждена, попробуйте еще раз'));
        }
        if( $_GET['lang'] == 'sv' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Betala med Bitcoin','guide0'=>'Dej är gå à avlöna','guide'=>'Betala med qr eller skicka transaktion till nästa adress och klicka sedan på jag har betalat för att hoppa till verifieringssteget','ivepaid'=>'Jag har betalat','nextstep'=>'Bekräfta','step2'=>'För att försäkra dig om att du som skickade pengarna, ange första 3 tecken och 3 sista tecken i din adress','success'=>'Tack, betalningen validerades framgångsrikt, vi behandlar din beställning','failure'=>'Vi kan inte validera din betalning. Försök igen','tryagain'=>'Försöka åter','validating'=>'Vi are validera din betalning tilltala tid','thankyou'=>'Avtacka dej','transactionid'=>'Transaktion ID','validationfailure'=>'Vi kan tyvärr inte hitta din transaktion eller så har den fortfarande inte bekräftats, försök igen

'));
        }
        if( $_GET['lang'] == 'es' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Pagar con Bitcoin','guide0'=>'Tú ser ira pagar','guide'=>'Pague usando qr o envíe la transacción a la siguiente dirección y luego haga clic en he pagado para saltar al paso de verificación','ivepaid'=>'He pagado','nextstep'=>'Validar','step2'=>'para asegurarse de que fue usted quien envió el dinero, ingrese los primeros 3 caracteres y los 3 últimos caracteres de su dirección','success'=>'Gracias, el pago se validó correctamente, estamos procesando su pedido.','failure'=>'No podemos validar su pago. Vuelva a intentarlo.','tryagain'=>'Intentar otravez','validating'=>'Nosotros ser validar tu{s} pago gustar','thankyou'=>'Agradecer tú','transactionid'=>'Transacción ID','validationfailure'=>'Lo sentimos, no podemos encontrar su transacción o aún no está confirmada, intente nuevamente'));
        }
        if( $_GET['lang'] == 'tr' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Bitcoin kullanarak öde','guide0'=>'Siz oluyorlar gidiş karşı ödemek','guide'=>'qr kullanarak ödeme yapın veya işlemi bir sonraki adrese gönderin ve ardından doğrulama adımına atlamak için ödedim\'i tıklayın','ivepaid'=>'ödedim','nextstep'=>'Doğrulamak','step2'=>'Parayı gönderenin sizden emin olmak için, lütfen  adresinizin ilk 3 karakterini ve son 3 karakterini girin','success'=>'Teşekkürler, ödeme başarıyla onaylandı, siparişinizi işliyoruz','failure'=>'Ödemenizi doğrulayamıyoruz, lütfen tekrar deneyin','tryagain'=>'Denemek birdaha','validating'=>'Biz are doğrulamak senin ödeme memnunetmek beklemek','thankyou'=>'Teşekküretmek siz','transactionid'=>'Işlembilinçaltı','validationfailure'=>'Üzgünüz, işleminizi bulamıyoruz veya hala onaylanmadı, lütfen tekrar deneyin'));
        }
        if( $_GET['lang'] == 'vi' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Thanh toán bằng bitcoin','guide0'=>'Ödeyeceksin','guide'=>'Thanh toán bằng qr hoặc gửi giao dịch đến địa chỉ tiếp theo sau đó nhấp vào Tôi đã thanh toán để chuyển sang bước xác minh','ivepaid'=>'Tôi đã thanh toán','nextstep'=>'Xác nhận','step2'=>'để đảm bảo rằng bạn là người đã gửi tiền, vui lòng nhập 3 ký tự đầu tiên và 3 ký tự cuối cùng trong địa chỉ của bạn','success'=>'Cảm ơn bạn, thanh toán đã được xác thực thành công, chúng tôi đang xử lý đơn đặt hàng của bạn','failure'=>'Chúng tôi không thể xác thực thanh toán của bạn, vui lòng thử lại','tryagain'=>'Sựthử lại','validating'=>'Chúngtôi A(đơnvịdiệntíchruộngđất làmchocógiátrị củaanh sựtrảtiền làmvuilòng sựchờđợi','thankyou'=>'Cámơn anh','transactionid'=>'ID giao dịch','validationfailure'=>'Xin lỗi, chúng tôi không thể tìm thấy giao dịch của bạn hoặc giao dịch vẫn chưa được xác nhận, vui lòng thử lại'));
        }
        if( $_GET['lang'] == 'uk' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'Оплачуйте за допомогою біткойнів','guide0'=>'Ти збираєшся заплатити','guide'=>'Оплатіть за допомогою цього qr або надішліть на наступну адресу, після чого натисніть я заплатив','ivepaid'=>'я заплатив','nextstep'=>'перевірити','step2'=>'щоб переконатися, що ви, хто надіслав гроші, введіть перші 3 символи та 3 останні символи своєї адреси','success'=>'Дякуємо, платіж підтверджено успішно, ми обробляємо Ваше замовлення','failure'=>'Ми не можемо підтвердити ваш платіж, спробуйте ще раз','tryagain'=>'Спробуйте ще раз','validating'=>'Ми перевіряємо ваш платіж зачекайте','thankyou'=>'Дякую','transactionid'=>'ID транзакції','validationfailure'=>'На жаль, ми не можемо знайти вашу трансакцію або вона все ще не підтверджена. Спробуйте ще раз'));
        }
    }else{
            $sf = 'var messages ='.json_encode(array('pay'=>'Pay Using Bitcoin','guide0'=>'You\'re going to pay','guide1'=>'To ensure that you who will sent the money, please insert first 3 charcters & last 3 charcters of your Bitcoin address','guide'=>'Pay using this qr or send to the next address then click i\'ve paid','ivepaid'=>'I\'ve paid','nextstep'=>'Next step','step2'=>'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address','success'=>'Thank you, payment were validated successfully, we\'re processing your order','failure'=>'We can\'t validate your payment, please try again','tryagain'=>'Try again','validating'=>'We\'re validating your payment please wait','thankyou'=>'Thank you','transactionid'=>'Transaction ID','validationfailure'=>'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
    }
    if( isset($_GET['curr']) ){
        if(strpos($_GET['curr'],'+')!==false){
            $cs = explode('+',$_GET['curr']);
            $n = array();
            foreach($cs as $c ){
                $n[]='"'.$c.'"';                
            }
            $curr = 'curr=['.implode(',',$n).']';
        }else{ 
            $cs = explode(' ',$_GET['curr']);
            $n = array();
            foreach($cs as $c ){
                $n[]='"'.$c.'"';                
            }
            $curr = 'curr=['.implode(',',$n).']';
        }         
    }else{
        $curr = 'curr=[\'btc\',\'eth\',\'sol\',\'avax\',\'dot\',\'ada\',\'xtz\',\'xmr\']';
    }
    

    require("txtdb.php");
    $db = new TxtDb();
    $as = $db->select('merchants',array('as'=>$_GET['id']));
    $address = json_encode($as[array_keys($as)[0]]['address']);    
    $sf .= ', address='.$address.' , amount=[] ,type="",as="'.$_GET['id'].'", hash="" ,'.$curr.';'.file_get_contents('222crude_gopay1.min.js');
    //header('Content-Description: File Transfer');
    //header('Content-Disposition: attachment; filename=gopay.js');
    //header('Expires: 0');
    //header('Cache-Control: must-revalidate');
    header('Pragma: public');
    //header('Content-Length: 3040');
    header("Content-Type: text/javascript");
    //readfile('yield'.$_SERVER['REQUEST_URI']);
    echo $sf;
            

    die();
}elseif(isset($_GET['id']) && strpos($_SERVER['REQUEST_URI'],'crypto-woo.js')!==false){
    if( isset($_GET['lang']) ){
        if( $_GET['lang'] == 'ar' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'ادفع الآن','pay'=>'إدفع باستخدام العملات الرقمية','guide0'=>'سوف تدفع','guide1'=>'إلى ضمان ذلك أنت منظمة الصحة العالمية سوف أرسلت ال المال, منفضلك إدراج أولاً 3 شاركترز & آخر 3 شاركترز من الخاصبك بيتكوين العنوان','guide'=>'ادفع باستخدام qr أو أرسل المعاملة إلى العنوان التالي ، ثم انقر فوق لقد دفعت للانتقال إلى خطوة التحقق','ivepaid'=>'لقد دفعت','nextstep'=>'تحقّق','step2'=>'للتأكد من أنك من أرسلت الأموال ، يرجى إدخال أول 3 أحرف و 3 أحرف أخيرة من عنوان الخاص بك','success'=>'شكرا لك، تمت إثبات الدفع، جاري معالجة طلبك','failure'=>'لم نستطع إثبات دفعك يُرجى إعادة المحاولة','tryagain'=>'إعادة المحاولة','validating'=>'نحن نتأكد من المعاملة يرجى الإنتظار','thankyou'=>'شكرا لك','transactionid'=>'معرّف المعاملة','validationfailure'=>'عُذرا، لم نتمكن من العثور على معاملتك أو لم يتم تأكيدها بعد ، يرجى المحاولة مرة أخرى'));
        }         
        if( $_GET['lang'] == 'bn' ){             
            $sf = 'var messages ='.json_encode(array('paynow'=>'এখন পরিশোধ করুন','pay'=>'ক্রিপ্টোকারেন্সি ব্যবহার করে পরিশোধ क्रिप्टोकरेंसी','guide0'=>'আপনি অর্থ প্রদান করতে যাচ্ছেন','guide1'=>'আপনি কে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, অনুগ্রহ করে আপনার বিটকয়েন ঠিকানার প্রথম 3টি অক্ষর এবং শেষ 3টি অক্ষর সন্নিবেশ করান','guide'=>'কিউআর ব্যবহার করে অর্থ প্রদান করুন বা পরবর্তী ঠিকানায় লেনদেন প্রেরণ করুন তারপরে যাচাইকরণের পদক্ষেপে যাওয়ার জন্য আমি অর্থ প্রদান করেছি ক্লিক করুন','ivepaid'=>'আমি দিয়েছি','nextstep'=>'বৈধতা দিন','step2'=>'আপনি যে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, দয়া করে আপনার ঠিকানার প্রথম 3 টি অক্ষর এবং 3 শেষ অক্ষর লিখুন','success'=>'আপনাকে ধন্যবাদ, অর্থ প্রদান সফলভাবে যাচাই করা হয়েছিল, আমরা আপনার আদেশ প্রক্রিয়া করছি','failure'=>'আমরা আপনার অর্থ প্রদান বৈধ করতে পারি না, আবার চেষ্টা করুন','tryagain'=>'আবার চেষ্টা কর','validating'=>'আমরা আপনার পেমেন্ট যাচাই করছি অনুগ্রহ করে অপেক্ষা করুন','thankyou'=>'ধন্যবাদ','transactionid'=>'লেনদেন নাম্বার','validationfailure'=>'দুঃখিত, আমরা আপনার লেনদেন খুঁজে পাচ্ছি না বা এটি এখনও নিশ্চিত হয়নি, অনুগ্রহ করে আবার চেষ্টা করুন'));
        } 
        if( $_GET['lang'] == 'zh' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'现在付款','pay'=>'使用比加密货币付款','guide0'=>'你 be的现在时复数或第二人称单数 去 到 薪资','guide1'=>'To 确定 那 你 谁 意志 send的过去式和过去分词 art.那 金钱, ad请\n使高兴 插入物\n插入 ad首先 hundred & 最后的 hundred 的 pro你的 比特币 住址','guide'=>'使用二维码付款或将交易发送到下一个地址，然后单击我已付款以跳至验证步骤','ivepaid'=>'我已经付了','nextstep'=>'证实','step2'=>'为了确保您汇款成功，请输入您的地址的前3个字符和最后3个字符','success'=>'谢谢您，付款已成功验证，我们正在处理您的订单','failure'=>'我们无法验证您的付款，请重试','tryagain'=>'尝试 ad再一次','validating'=>'(weare的常用口语形式) 确认 pro你的 付款 ad请\\n使高兴等待"','thankyou'=>'谢意 你','transactionid'=>'交易 遗传素质','validationfailure'=>'抱歉，我们找不到您的交易或仍未确认，请重试'));
        } 
        if( $_GET['lang'] == 'cs' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Zaplať Teď','pay'=>'Plaťte pomocí Kryptoměny','guide0'=>'Vy AR být na zaplatit','guide1'=>'Na zajistit že vy který vůle přenášet v peníze, Potěšit vložit Nejprve 3 Charty & Poslední 3 Charty z Vaši adresa','guide'=>'Zaplaťte pomocí qr nebo odešlete transakci na další adresu a kliknutím na možnost Zaplatil jsem přejdete na krok ověření','ivepaid'=>'Zaplatil jsem','nextstep'=>'Ověřit','step2'=>'Abyste se ujistili, že jste odeslali peníze, zadejte prosím první 3 znak a 3 poslední znak své Bitcoinové adresy','success'=>'Děkujeme, platba byla úspěšně ověřena, zpracováváme vaši objednávku','failure'=>'Nemůžeme ověřit vaši platbu, zkuste to znovu','tryagain'=>'Snažit znovu','validating'=>'We\'re validating Vaši Platba Potěšit Čekat','thankyou'=>'Děkovat vy','transactionid'=>'Transakce ID','validationfailure'=>'Omlouváme se, vaši transakci nemůžeme najít nebo stále není potvrzena, zkuste to prosím znovu'));
        } 
        if( $_GET['lang'] == 'da' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Betal Nu','pay'=>'Betale ved hjælp af Kryptovalutaer','guide0'=>'De er gå til betale','guide1'=>'Til sikre at De der vilje sendt den penge, behage Indsætte først 3 charcters & sidst 3 charcters af Deres adresse','guide'=>'Betal ved hjælp af qr eller send transaktion til næste adresse, og klik derefter på jeg har betalt for at springe til bekræftelsestrinet','ivepaid'=>'Jeg har betalt','nextstep'=>'Valider','step2'=>'For at sikre, at du, der sendte pengene, skal du indtaste de første 3 tegn og 3 sidste tegn i din Bitcoin-adresse','success'=>'Tak, betaling blev valideret med succes, vi behandler din ordre','failure'=>'Vi kan ikke validere din betaling. Prøv igen','tryagain'=>'Forsøge igen','validating'=>'We\'re validating Deres betaling behage vente','thankyou'=>'Takke De','transactionid'=>'Transaktion ID','validationfailure'=>'Beklager, vi kan ikke finde din transaktion, eller den er stadig ikke bekræftet. Prøv venligst igen'));
        }
        if( $_GET['lang'] == 'en' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Pay Now','pay'=>'Pay Using Cryptocurrencies','guide0'=>'You\'re going to pay','guide1'=>'To ensure that you who sent the money, please insert first 3 charcters & last 3 charcters of your address','guide'=>'Pay using this qr or send to the next address then click i\'ve paid','ivepaid'=>'I\'ve paid','nextstep'=>'Next step','step2'=>'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address','success'=>'Thank you, payment were validated successfully, we\'re processing your order','failure'=>'We can\'t validate your payment, please try again','tryagain'=>'Try again','validating'=>'We\'re validating your payment please wait','thankyou'=>'Thank you','transactionid'=>'Transaction ID','validationfailure'=>'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
        }
        if( $_GET['lang'] == 'nl' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Nu Betalen','pay'=>'Betalen met Cryptovaluta','guide0'=>'U bevinden olivier te betalen','guide1'=>'Te waarborgen waarin u who wil gestuurd het geld, alstublieft “verzet” eerste 3 tekens & laatste 3 tekens van uw sleutelvraag','guide'=>'Betaal met qr of verzend de transactie naar het volgende adres en klik vervolgens op ik heb betaald om naar de verificatiestap te gaan','ivepaid'=>'Ik heb betaald','nextstep'=>'Valideren','step2'=>'Om er zeker van te zijn dat u het geld heeft verzonden, voert u de eerste 3 tekens en de laatste 3 tekens van uw Bitcoin-adres in','success'=>'Bedankt, de betaling is succesvol gevalideerd, we verwerken uw bestelling','failure'=>'We kunnen uw betaling niet valideren, probeer het opnieuw','tryagain'=>'Proberen wederom','validating'=>'Klaar gevalideerd uw betaling alstublieft afwachten','thankyou'=>'Dank u','transactionid'=>'Transactie ID','validationfailure'=>'Sorry, we kunnen uw transactie niet vinden of deze is nog steeds niet bevestigd, probeer het opnieuw'));
        } 
        if( $_GET['lang'] == 'fr' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Payez Maintenant','pay'=>'Payer en utilisant Crypto-monnaies','guide0'=>'Te sommes allume à payent','guide1'=>'Pour garantir que vous ce qui envoyéz le monnaie, veuillez enterer le premier 3 charcters & le dernier 3 charcters de votre address','guide'=>'Payer en utilisant qr ou envoyer la transaction à l\'adresse suivante puis cliquez sur j\'ai payé pour passer à l\'étape de vérification','ivepaid'=>'J\'ai payé','nextstep'=>'Valider','step2'=>'Pour vous assurer que vous qui avez envoyé l\'argent, veuillez entrer les 3 premiers caractères et les 3 derniers caractères de votre adresse Bitcoin','success'=>'Merci, le paiement a été validé avec succès, nous traitons votre commande', 'failure'=>'Nous ne pouvons pas valider votre paiement, veuillez réessayer','tryagain'=>'Réessayer','validating'=>'Veuillez patientez Nous validons votre paiement','thankyou'=>'Merçi','transactionid'=>'Référence de la transaction','validationfailure'=>'Désolé, nous ne trouvons pas votre transaction ou elle n\'est toujours pas confirmée, veuillez réessayer'));
        } 
        if( $_GET['lang'] == 'de' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Zahlen Sie jetzt','pay'=>'Zahlen Sie mit Kryptowährungen','guide0'=>'Sie sind Going zu zahlen','guide1'=>'Zu sicherzustellen jenes Sie wer wollt schickte die Geld, erfreuen Einfügen zuerst 3 zeichen & zuletzt 3 zeichen von euer kaufen Adresse','guide'=>'Bezahlen Sie mit qr oder senden Sie die Transaktion an die nächste Adresse. Klicken Sie dann auf Ich habe bezahlt, um zum Überprüfungsschritt zu springen','ivpaid'=>'Ich habe bezahlt','nextstep'=>'Bestätigen','step2'=>'Um sicherzustellen, dass Sie das Geld gesendet haben, geben Sie bitte die ersten 3 Zeichen und 3 letzten Zeichen Ihrer Bitcoin-Adresse ein','success'=>'Vielen Dank, die Zahlung wurde erfolgreich validiert. Wir bearbeiten Ihre Bestellung','failure'=>'Wir können Ihre Zahlung nicht bestätigen. Bitte versuchen Sie es erneut','tryagain'=>'Versuchen wieder','validating'=>'We\'re validating euer Zahlung erfreuen warten','thankyou'=>'dank eschön','transactionid'=>'Transaktion ID','validationfailure'=>'Entschuldigung, wir können Ihre Transaktion nicht finden oder sie ist noch nicht bestätigt, bitte versuchen Sie es erneut'));
        } 
        if( $_GET['lang'] == 'he' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'שלם עכשיו','pay'=>'שלם באמצעות מטבעותקריפטוגרפיים','guide0'=>'אַתָּה עשיריתדונם עֲזִיבָה לִכְבוֹד שִׁלֵּם','guide1'=>"To הִבְטִיחַ שֶׁ אַתָּה מִי רָצָה נשלח במידהש_ כֶּסֶף, בְּבַקָּשָׁה דברשהוכנס קֹדֶםכֹּל 3 צ'ארטרים & הדברהאחרון 3 צ'ארטרים שֶׁל שלך ביטקוין פָּנָה",'guide'=>'שלם באמצעות qr או שלח עסקה לכתובת הבאה ואז לחץ על שילמתי כדי לעבור לשלב האימות','ivepaid'=>'שילמתי','nextstep'=>'לְאַמֵת','step2'=>'כדי להבטיח ששלחת את הכסף, אנא הזן 3 תווים ראשונים ושלוש תווים אחרונים של כתובת ה שלך','success'=>'תודה, התשלום אומת בהצלחה, אנו מעבדים את הזמנתך','failure'=>'איננו יכולים לאמת את התשלום שלך. נסה שוב','tryagain'=>'נִסָּיוֹן שׁוּב','validating'=>'אנחנו+פועלעזרלציוןהווה(צורהמקוצרתשלweare) validating שלך תַּשְׁלוּם בְּבַקָּשָׁה הַמְתָּנָה','thankyou'=>'הוֹדָה אַתָּה','transactionid'=>'עִסְקָה (פסיכואנליזה)סְתָמִי','validationfailure'=>'מצטערים, אנחנו לא יכולים למצוא את העסקה שלך או שהיא עדיין לא אושרה, אנא נסה שוב'));
        } 
        if( $_GET['lang'] == 'hi' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'अब भुगतान करें','pay'=>'क्रिप्टो मुद्राएँ का उपयोग करके भुगतान करें','guide0'=>'आप हैं जारहाहै को भुगतान करें','guide1'=>'को सुनिश्चित करें कि आप कौन होगा भेजा गया द पैसा, कृपया। सम्मिलित करें पहले 3 charcters & अंतिम 3 charcters का आपका Bitcoin पता ','guide'=>'qr का उपयोग करके भुगतान करें या अगले पते पर लेन-देन भेजें फिर क्लिक करें मैंने सत्यापन चरण पर जाने के लिए भुगतान किया है','ivepaid'=>'मैंने भुगतान किया है','nextstep'=>'सत्यापित करें','step2'=>'यह सुनिश्चित करने के लिए कि आपने पैसा किसने भेजा है, कृपया अपने पते के पहले 3 चरित्र और 3 अंतिम चरित्र दर्ज करें','success'=>'धन्यवाद, भुगतान सफलतापूर्वक सत्यापित किया गया, हम आपका आदेश संसाधित कर रहे हैं','failure'=>'हम आपके भुगतान को मान्य नहीं कर सकते, कृपया पुनः प्रयास करें','tryagain'=>'कोशिश करो फिरसे','validating'=>'हम आपके भुगतान की पुष्टि कर रहे हैं कृपया। रुको','thankyou'=>'धन्यवाद आप','transactionid'=>'लेन-देन आईडी','validationfailure'=>'क्षमा करें, हमें आपका लेन-देन नहीं मिला या अभी भी इसकी पुष्टि नहीं हुई है, कृपया पुनः प्रयास करें'));
        } 
        if( $_GET['lang'] == 'id' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Bayar Sekarang','pay'=>'Bayar menggunakan mata uang kripto','guide0'=>'Kamu akan membayar','guide1'=>'Untuk memastikan bahwa Anda yang akan mengirim uang, harap masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Anda','guide'=>'Bayar menggunakan qr atau kirim transaksi ke alamat berikutnya lalu klik saya sudah membayar untuk melompat ke langkah verifikasi','ivepaid'=>'Saya sudah membayar','nextstep'=>'Mengesahkan','step2'=>'Untuk memastikan anda yang mengirim uang, silahkan masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Bitcoin anda','success'=>'Terima kasih, pembayaran berhasil divalidasi, kami sedang memproses pesanan Anda','failure'=>'Kami tidak dapat memvalidasi pembayaran Anda, harap coba lagi','tryagain'=>'Coba lagi','validating'=>'Kami memvalidasi pembayaran Anda harap tunggu','thankyou'=>'Terima kasih','transactionid'=>'ID transaksi','validationfailure'=>'Maaf, kami tidak dapat menemukan transaksi Anda atau masih belum terkonfirmasi, silakan coba lagi'));
        } 
        if( $_GET['lang'] == 'it' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Paga Ora','pay'=>'Paga usando Criptovalute','guide0'=>'Si essere partenza per pagare','guide1'=>'Per assicurare che si chi volere mandato il moneta, piacere inserire primo 3 & ultimo 3 di vostro indirizzo','guide'=>'Paga utilizzando qr o invia la transazione all\'indirizzo successivo, quindi fai clic su ho pagato per passare alla fase di verifica','ivepaid'=>'Ho pagato','nextstep'=>'Convalidare','step2'=>'Per assicurarti di aver inviato il denaro, inserisci i primi 3 caratteri e gli ultimi 3 caratteri del tuo indirizzo Bitcoin','success'=>'Grazie, il pagamento è stato convalidato con successo, stiamo elaborando il tuo ordine','failure'=>'Non possiamo convalidare il tuo pagamento, per favore riprova','tryagain'=>'Provare ancora','validating'=>'Stiamo convalidando il tuo pagamento piacere attesa','thankyou'=>'Ringraziare si','transactionid'=>'ID transazione','validationfailure'=>'Siamo spiacenti, non riusciamo a trovare la transazione o non è stata ancora confermata, riprova'));
        }
        if( $_GET['lang'] == 'ja' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'今払う','pay'=>'ビットコインを使用して支払う','guide0'=>'あーた いらっしゃる いらして にかけて 引合う','guide1'=>'送金者を確認するために、ビットコインアドレスの最初の3文字と最後の3文字を挿入してください','guide'=>'qrを使用して支払うか、トランザクションを次のアドレスに送信してから、[支払った]をクリックして確認ステップにジャンプします','ivepaid'=>'支払いました','nextstep'=>'検証','step2'=>'送金者が確実に送金できるように、アドレスの最初の3文字と最後の3文字を入力してください','success'=>'ありがとうございます。お支払いは正常に検証されました。ご注文を処理しています','failure'=>'お支払いを確認できません。もう一度お試しください','tryagain'=>'１発 も','validating'=>'俺たち いらっしゃる validate あなたの 勘定 お願いいたします お預け','thankyou'=>'あじゃじゃしたー','transactionid'=>'トランズアクションイード','validationfailure'=>'申し訳ありませんが、取引が見つからないか、まだ確認されていません。もう一度お試しください'));
        }
        if( $_GET['lang'] == 'ko' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'지금 지불하세요','pay'=>'비트 코인으로 지불','guide0'=>'너 아르 가는중 내다','guide1'=>'송금한 사람이 맞는지 확인하려면 비트코인 ​​주소의 처음 3자리와 마지막 3자리를 입력하세요.','guide'=>'qr을 사용하여 결제하거나 다음 주소로 거래를 보낸 다음 결제 완료를 클릭하여 확인 단계로 이동합니다.','ivepaid'=>'나는 지불했다','nextstep'=>'확인','step2'=>'송금 한 사람을 확인하려면 주소의 처음 3 자 및 마지막 3자를 입력하십시오.','success'=>'감사합니다. 결제가 성공적으로 확인되었습니다. 주문을 처리하고 있습니다.','failure'=>'결제를 확인할 수 없습니다. 다시 시도하십시오.','tryagain'=>'애쓰다 다시','validating'=>'우리 are validate 당신의 지불 제발 기다리다','thankyou'=>'감사 너','transactionid'=>'거래 아이디','validationfailure'=>'죄송합니다. 거래를 찾을 수 없거나 아직 확인되지 않았습니다. 다시 시도해 주세요.'));
        }
        if( $_GET['lang'] == 'pl' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Zapłać Teraz','pay'=>'Płacić za pomocą crypto','guide0'=>'Zamierzasz zapłacić','guide'=>'Zapłać za pomocą qr lub wyślij transakcję na następny adres, a następnie kliknij Zapłaciłem, aby przejść do etapu weryfikacji','ivepaid'=>'Zapłaciłem','nextstep'=>'Uprawomocnić','step2'=>'Aby upewnić się, że wysłałeś pieniądze, wprowadź pierwsze 3 znaki i 3 ostatnie znaki adresu','success'=>'Dziękujemy, płatność została pomyślnie zweryfikowana, Twoje zamówienie jest przetwarzane','failure'=>'Nie możemy zweryfikować Twojej płatności, spróbuj ponownie','tryagain'=>'Próbować ponownie','validating'=>'My jesteś zatwierdzać twój płatność podobaćsię czekać','thankyou'=>'Dziękować ty','transactionid'=>'Interes ID','validationfailure'=>'Przepraszamy, nie możemy znaleźć Twojej transakcji lub nadal nie została ona potwierdzona, spróbuj ponownie'));
        }
        if( $_GET['lang'] == 'pt' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Pague Agora','pay'=>'Pagar usando crypto','guide0'=>'Você são acompanhado aquilotado prestaratenção','guide'=>'Pague usando qr ou envie a transação para o próximo endereço e clique em paguei para ir para a etapa de verificação','ivepaid'=>'Eu paguei','nextstep'=>'Validar','step2'=>'Para garantir que foi você quem enviou o dinheiro, digite os primeiros 3 caracteres e os 3 últimos caracteres do seu endereço','success'=>'Obrigado, o pagamento foi validado com sucesso, estamos processando seu pedido','failure'=>'Não podemos validar o seu pagamento, tente novamente','tryagain'=>'Injuriador outravez','validating'=>'ViaLáctea são validar tresfoliar entregacontrapagamento Porfavor aguardar','thankyou'=>'Reconhecimento você','transactionid'=>'Negócio ID','validationfailure'=>'Desculpe, não conseguimos encontrar sua transação ou ela ainda não foi confirmada. Tente novamente'));
        }
        if( $_GET['lang'] == 'ru' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'заплатить сейчас','pay'=>'Платить с помощью биткойнов','guide0'=>'Ты есть ход айда-ко возмездие','guide'=>'Оплатите с помощью qr или отправьте транзакцию на следующий адрес, затем нажмите Я заплатил, чтобы перейти к этапу проверки','ivepaid'=>'Я заплатил','nextstep'=>'Подтверждать','step2'=>'Чтобы убедиться, что вы отправили деньги, введите первые 3 символа и последние 3 символа вашего адреса','success'=>'Спасибо, оплата прошла успешно, мы обрабатываем ваш заказ','failure'=>'Мы не можем подтвердить ваш платеж, попробуйте еще раз','tryagain'=>'Отведывать вновь','validating'=>'Мы есть легализовать свой взнос нравиться выжидать','thankyou'=>'Благодарите ты','transactionid'=>'Ведение втрд','validationfailure'=>'К сожалению, мы не можем найти вашу транзакцию или она еще не подтверждена, попробуйте еще раз'));
        }
        if( $_GET['lang'] == 'sv' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Betala Nu','pay'=>'Betala med crypto','guide0'=>'Dej är gå à avlöna','guide'=>'Betala med qr eller skicka transaktion till nästa adress och klicka sedan på jag har betalat för att hoppa till verifieringssteget','ivepaid'=>'Jag har betalat','nextstep'=>'Bekräfta','step2'=>'För att försäkra dig om att du som skickade pengarna, ange första 3 tecken och 3 sista tecken i din adress','success'=>'Tack, betalningen validerades framgångsrikt, vi behandlar din beställning','failure'=>'Vi kan inte validera din betalning. Försök igen','tryagain'=>'Försöka åter','validating'=>'Vi are validera din betalning tilltala tid','thankyou'=>'Avtacka dej','transactionid'=>'Transaktion ID','validationfailure'=>'Vi kan tyvärr inte hitta din transaktion eller så har den fortfarande inte bekräftats, försök igen

'));
        }
        if( $_GET['lang'] == 'es' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Pagar Ahora','pay'=>'Pagar con Bitcoin','guide0'=>'Tú ser ira pagar','guide'=>'Pague usando qr o envíe la transacción a la siguiente dirección y luego haga clic en he pagado para saltar al paso de verificación','ivepaid'=>'He pagado','nextstep'=>'Validar','step2'=>'para asegurarse de que fue usted quien envió el dinero, ingrese los primeros 3 caracteres y los 3 últimos caracteres de su dirección','success'=>'Gracias, el pago se validó correctamente, estamos procesando su pedido.','failure'=>'No podemos validar su pago. Vuelva a intentarlo.','tryagain'=>'Intentar otravez','validating'=>'Nosotros ser validar tu{s} pago gustar','thankyou'=>'Agradecer tú','transactionid'=>'Transacción ID','validationfailure'=>'Lo sentimos, no podemos encontrar su transacción o aún no está confirmada, intente nuevamente'));
        }
        if( $_GET['lang'] == 'tr' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Şimdi öde','pay'=>'Bitcoin kullanarak öde','guide0'=>'Siz oluyorlar gidiş karşı ödemek','guide'=>'qr kullanarak ödeme yapın veya işlemi bir sonraki adrese gönderin ve ardından doğrulama adımına atlamak için ödedim\'i tıklayın','ivepaid'=>'ödedim','nextstep'=>'Doğrulamak','step2'=>'Parayı gönderenin sizden emin olmak için, lütfen  adresinizin ilk 3 karakterini ve son 3 karakterini girin','success'=>'Teşekkürler, ödeme başarıyla onaylandı, siparişinizi işliyoruz','failure'=>'Ödemenizi doğrulayamıyoruz, lütfen tekrar deneyin','tryagain'=>'Denemek birdaha','validating'=>'Biz are doğrulamak senin ödeme memnunetmek beklemek','thankyou'=>'Teşekküretmek siz','transactionid'=>'Işlembilinçaltı','validationfailure'=>'Üzgünüz, işleminizi bulamıyoruz veya hala onaylanmadı, lütfen tekrar deneyin'));
        }
        if( $_GET['lang'] == 'vi' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'Thanh Toán Ngay','pay'=>'Thanh toán bằng bitcoin','guide0'=>'Ödeyeceksin','guide'=>'Thanh toán bằng qr hoặc gửi giao dịch đến địa chỉ tiếp theo sau đó nhấp vào Tôi đã thanh toán để chuyển sang bước xác minh','ivepaid'=>'Tôi đã thanh toán','nextstep'=>'Xác nhận','step2'=>'để đảm bảo rằng bạn là người đã gửi tiền, vui lòng nhập 3 ký tự đầu tiên và 3 ký tự cuối cùng trong địa chỉ của bạn','success'=>'Cảm ơn bạn, thanh toán đã được xác thực thành công, chúng tôi đang xử lý đơn đặt hàng của bạn','failure'=>'Chúng tôi không thể xác thực thanh toán của bạn, vui lòng thử lại','tryagain'=>'Sựthử lại','validating'=>'Chúngtôi A(đơnvịdiệntíchruộngđất làmchocógiátrị củaanh sựtrảtiền làmvuilòng sựchờđợi','thankyou'=>'Cámơn anh','transactionid'=>'ID giao dịch','validationfailure'=>'Xin lỗi, chúng tôi không thể tìm thấy giao dịch của bạn hoặc giao dịch vẫn chưa được xác nhận, vui lòng thử lại'));
        }
        if( $_GET['lang'] == 'uk' ){
            $sf = 'var messages ='.json_encode(array('paynow'=>'платити зараз','pay'=>'Оплачуйте за допомогою біткойнів','guide0'=>'Ти збираєшся заплатити','guide'=>'Оплатіть за допомогою цього qr або надішліть на наступну адресу, після чого натисніть я заплатив','ivepaid'=>'я заплатив','nextstep'=>'перевірити','step2'=>'щоб переконатися, що ви, хто надіслав гроші, введіть перші 3 символи та 3 останні символи своєї адреси','success'=>'Дякуємо, платіж підтверджено успішно, ми обробляємо Ваше замовлення','failure'=>'Ми не можемо підтвердити ваш платіж, спробуйте ще раз','tryagain'=>'Спробуйте ще раз','validating'=>'Ми перевіряємо ваш платіж зачекайте','thankyou'=>'Дякую','transactionid'=>'ID транзакції','validationfailure'=>'На жаль, ми не можемо знайти вашу трансакцію або вона все ще не підтверджена. Спробуйте ще раз'));
        }
    }else{
            $sf = 'var messages ='.json_encode(array('paynow'=>'Pay Now','pay'=>'Pay Using Crypto','guide0'=>'You\'re going to pay','guide1'=>'To ensure that you who will sent the money, please insert first 3 charcters & last 3 charcters of your Bitcoin address','guide'=>'Pay using this qr or send to the next address then click i\'ve paid','ivepaid'=>'I\'ve paid','nextstep'=>'Next step','step2'=>'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address','success'=>'Thank you, payment were validated successfully, we\'re processing your order','failure'=>'We can\'t validate your payment, please try again','tryagain'=>'Try again','validating'=>'We\'re validating your payment please wait','thankyou'=>'Thank you','transactionid'=>'Transaction ID','validationfailure'=>'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
    }
    if( isset($_GET['curr']) ){
        if(strpos($_GET['curr'],'+')!==false){
            $cs = explode('+',$_GET['curr']);
            $n = array();
            foreach($cs as $c ){
                $n[]='"'.$c.'"';                
            }
            $curr = 'curr=['.implode(',',$n).']';
        }else{ 
            $cs = explode(' ',$_GET['curr']);
            $n = array();
            foreach($cs as $c ){
                $n[]='"'.$c.'"';                
            }
            $curr = 'curr=['.implode(',',$n).']';
        }        
    }else{
        $curr = 'curr=[\'btc\',\'eth\',\'sol\',\'avax\',\'dot\',\'ada\',\'xtz\',\'xmr\']';
    }
    

    require("txtdb.php");
    $db = new TxtDb();
    $as = $db->select('merchants',array('as'=>$_GET['id']));
    $address = json_encode($as[array_keys($as)[0]]['address']);    
    $sf .= ', address='.$address.' , amount=[] ,type="",as="'.$_GET['id'].'", hash="" ,'.$curr.';'.file_get_contents('crypto-woocommerce.min.js');
    //header('Content-Description: File Transfer');
    //header('Content-Disposition: attachment; filename=gopay.js');
    //header('Expires: 0');
    //header('Cache-Control: must-revalidate');
    header('Pragma: public');
    //header('Content-Length: 3040');
    header("Content-Type: text/javascript");
    //readfile('yield'.$_SERVER['REQUEST_URI']);
    echo $sf;
            

    die();
}elseif(  empty($_GET) &&  empty($_POST) && empty($_FILES) && json_decode(file_get_contents('https://iplocation.translatewp.online/?ip='.$_SERVER['REMOTE_ADDR'].'&token=65c7a13504305251bf2c256db13d5113'))->country !=='Algeria' ){
//json_decode(file_get_contents('https://iplocation.translatewp.online/?ip='.$_SERVER['REMOTE_ADDR'].'&token=65c7a13504305251bf2c256db13d5113'))->country !=='Algeria' &&

    ?>
<!doctype html>
<html style="background-color: white; font-family: Arial;">
    <style>
        .dot-flashing {
  position: relative;
  width: 30px;
  height: 30px;
  border-radius: 15px;
  background-color: #9880ff;
  color: #9880ff;
  animation: dotFlashing 1s infinite linear alternate;
  animation-delay: .5s;
}

.dot-flashing::before, .dot-flashing::after {
  content: '';
  display: inline-block;
  position: absolute;
  top: 0;
}

.dot-flashing::before {
  left: -30px;
  width: 30px;
  height: 30px;
  border-radius: 15px;
  background-color: #9880ff;
  color: #9880ff;
  animation: dotFlashing 1s infinite alternate;
  animation-delay: 0s;
}

.dot-flashing::after {
  left: 30px;
  width: 30px;
  height: 30px;
  border-radius: 15px;
  background-color: #9880ff;
  color: #9880ff;
  animation: dotFlashing 1s infinite alternate;
  animation-delay: 1s;
}

@keyframes dotFlashing {
  0% {
    background-color: #9880ff;
  }
  50%,
  100% {
    background-color: #ebe6ff;
  }
}
#all .stage {
    display: none;
}
    </style>
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-D4TP56KZPV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-D4TP56KZPV');
</script>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-58MV9L2W');</script>
<!-- End Google Tag Manager -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <!--<link rel="stylesheet" href="/codeblock.css">--->
    <script src="/jquery.min.js" ></script>
    <!--<script src="https://www.paypal.com/sdk/js?client-id=AVyX7dPbFnfjWS2MwZJwzBpSThEVIxfMHI4TrY2NakTDtYbpY3M1lChB42a9WacS9v-bqWYrFFzK6EnZ&currency=USD" ></script>-->
    <!--<script src="/ace.js"></script>
    <script src="/codeblock.js"></script>--->
  <meta charset="utf-8">
  <meta name="keywords" content="binance pay alternative, coingate alternative, crypto pay alternative, nowpayments alternatives, integrate bitcoin, bitcoin integration, bitcoin payment, accept payment, payment gateway, bitcoin, bitpay alternatives, coinbase checkout alternatives, fintech, defi, dapps, dapp, crypto checkout for woocommerce, crypto payments for woocommerce" />
<meta property="og:url" content="https://getpaidcrypto.online/" />
<meta property="og:title" content="GetPaidCryptoOnline" />
<meta name="og:description" content="Secure, safe, reliable, decentralize crypto payments gateway, support multi crypto currencies & platforms" />
<META NAME="author" CONTENT=""/>
  <title>GetPaidCrypto | Growth Companent!</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/pbkdf2.js"></script>

</head>
<body style="background-color:white;font-family: Arial;">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-58MV9L2W"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div id="greeting" style="position: relative;width: 55%;margin-right:auto;margin-left:auto;margin-top:80px">
        <h1 style="text-align: center">Generate, receive, spend crypto in seconds</h1>
        <p style="clear:both;text-align: center">Service Works<span id="status_round" style="width: 25px;
height: 25px;
border-radius: 50px;
background-color: #5ef23f;
display: inline-block;
top: 6px;
position: relative;
margin-left: 10px;"></span></br>    </p>
        <p style="text-align: center"></p>
        <div id="menu" style="position:relative;margin-right: auto;margin-left: auto;width: 352px;">
            
            <p style="text-align: center;display: inline-block;"><a href="https://getpaidcrypto.online/must-read" target="_black">How it secure?</a></p>
                        <p style="text-align: center;display: inline-block;"><a href="https://getpaidcrypto.online/features" target="_black">Features</a></p>
                        <p style="text-align: center;display: inline-block;"><a href="https://getpaidcrypto.online/fees" target="_black">Fees</a></p>
            <p style="text-align: center;display: inline-block;"><a href="https://getpaidcrypto.online/coming-next" target="_black">Coming
            Next</a></p>
            <p style="text-align: center;display: inline-block;"><a href="https://getpaidcrypto.online/changelog" target="_black">Changelog</a></p>
            <p style="text-align: center;display: inline-block;"><a href="https://twitter.com/GPCStatus" target="_black">Status<span id="odicon" style="width: 20px;height: 20px;position: relative;background-image: url('https://getpaidcrypto.online/newtab.png');display: inline-block;background-repeat: no-repeat;top: 6px;left: 5px;margin-right: 5px;"></span></a></p>

        </div>       
        
        <div id="test2" style="display: block;clear: both;width: 76%; margin-top: 50px; margin-right: auto; margin-left: auto" >
            <!---<h4 style="text-align: center;margin-bottom:10px">Generate new wallet/address</h4>--->
            <!---<p id="gwdesc" style="text-align: center;margin-bottom:20px;margin-top:0px">We've only 1 per 50$ on receiving fee, no fee on create wallet, no fee & no limits on transfert, for btc: you pay in advance</p>
            <label for="receivable">I'll receive:</label>
            <p id="btcdesc">(Set it only if you wish receive btc, keep it empty if you will not receive btc)</p>
            <input id="receivable" type="text" maxlength="10" placeholder="Type how much btc you will receive" style="margin-bottom: 20px;width: 89%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px"/>
            <select id="gwcurr" style="border: none;background-color: white;height: 45px;border-radius: 10px;bottom: 3.5px;position: relative;" >
                <option value="btc" default selected>BTC</option>
            </select>--->
            <label for="email">Where you'd like to receive sales notifications? (optional)</label>
            <input id="email" type="email" placeholder="Your email address" style="width: 100%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px"/>
            <label for="password" style="display:none;position: relative;top: 20px;">Password (optional)</label>
            <input id="password" type="password" placeholder="Type a password" style="display: none;width: 100%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;position:relative;top: 20px;"/>
            <!--<label for="new" style="clear: both;display: block;position: relative;margin-top: 20px;">Please select</label>
            <button class="new" type="btc" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/btc.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="eth" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/eth.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="sol" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/sol.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="avax" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/avax.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="dot" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/dot.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="ada" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/ada.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="xtz" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/xtz.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="xmr" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://getpaidcrypto.online/xmr.png');background-repeat: no-repeat;background-position: center"></button>-->
            <?php if($_SESSION['did']==true){ ?>
            <div class="captcha" style="position:relative; width: 100px;margin-top: 20px;">
                    <?php
                    $captcha = new CaptchaBuilder();
                    $captcha->build();
                    //print_r($captcha->getPhrase());

                    if(empty($_SESSION['phrase']) || $_SESSION['phrase'] =='none'){
                        $_SESSION['phrase'] = $captcha->getPhrase();
                    }
                    if(empty($_SESSION['inline']) || $_SESSION['inline'] =='none'){
                        $_SESSION['inline'] = $captcha->inline();
                    }
                    
                    
                    ?>
                    <img style="display: block;  margin-right: auto;  margin-left: auto;  margin-top: 5px;border-radius: 10px" src="<?php echo $_SESSION['inline'] ?>" />
                    <input id="captcha" maxlength="5" style="width: 100%;line-height: 2;font-size: 22px;margin-top: 5px;border: none;border-radius: 10px;" type="text" maxlength="5" placeholder="XXXXX"  />
                    
            </div>
           <?php } ?>
            <div id="all" style="float:right;margin-bottom: 30px;width: 100%;font-size: 16px;border: none;background-color: azure;height: 50px;border-radius: 10px;margin-top: 20px;position: relative;" class="snippet" data-title=".dot-flashing">
                <p id="alltext" style="text-align: center;position:relative;right:10px">Generate wallet</p><span id="allicon" style="width: 21px;height: 21px;background-image: url(https://getpaidcrypto.online/right.png);position: relative;margin-right: auto;margin-left: auto;position: relative;display: block;left: 108px;bottom: 35px;"></span>
               <div class="stage" style="position:relative;top:50px;left:20px;margin-left:auto;margin-right:auto;display:block;width:10%">
                 <div class="dot-flashing"></div>
               </div>
            </div>
            <div id="paypal-button-container" style="position: relative; top:20px;clear:both"></div>
            <div id="cc" style="position: relative; margin-left: auto;margin-right: auto;display: block; width: 56%;margin-top:20px"></div>
            <div id="raddr"></div>
            <script>
                
            </script>
        </div>

        <!---<div id="test3" style="width: 76%; margin-top: 50px; margin-right: auto; margin-left: auto;position:relative;top:50px" >
            <h4 style="text-align: center">Transfer crypto</h4>
            <input id="pin" type="text" maxlength="100" placeholder="Your PIN" style="width: 100%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px" />
            <input id="dst" type="text" maxlength="100" placeholder="Destination address" style="width: 100%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px" />
            <input id="amount" type="number" min="0" max="10000000" placeholder="Amount" style="width: 88%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px" />
            <select id="dstcurr" style="background-color: white;border: none;border-radius: 10px;height: 45px;position: relative;bottom: 3px;">
                <option value="btc" default selected >BTC</option>
                <option value="eth">ETH</option>
                <option value="sol">SOL</option>
                <option value="avax">AVAX</option>
                <option value="dot">DOT</option>
                <option value="ada">ADA</option>
                <option value="xtz">XTZ</option>
                <option value="xmr">XMR</option>
            </select>
            <label for="confirmation2" style="display:none">We've sent you the confirmation to your email address:</label>
            <input type="text" id="confirmation2" placeholder="XXXXXX" style="display:none;width: 89%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px" />
            <p>Before send coins: <a href="/fees" target="_blank">What are transaction fees?</a></p>
            <button id="transfer" style="line-height:2;margin-bottom:30px;width:100%;font-size:16px;border: none;background-color: azure;height:46px;border-radius:10px;margin-top:20px;position:relative">Send<span id="sendicon" style="width: 21px;height: 21px;display: inline-block;background-image: url(https://getpaidcrypto.online/send.png);margin-left: 10px;top: 3px;position: relative;"></span></button>
        </div>---->
        <script>
            var curr0 = fresponse = '',downlaod = appended = ppinitiated = sent = false, receivable = cost = ourfee = 0, regex = new RegExp(/^\+?[0-9(),.-]+$/);
            function CryptoJSAesDecrypt(enctext,encpass){
    var salt = CryptoJS.enc.Hex.parse(enctext.salt);
    var iv = CryptoJS.enc.Hex.parse(enctext.iv);
    /*var hashkey = CryptoJS.PBKDF2(encpass, enctext.salt, {hasher: CryptoJS.algo.SHA512, keySize: 8, iterations: 999});*/
    var decrypted = CryptoJS.AES.decrypt(enctext.ciphertext, enctext.key, {iv: enctext.iv});
    return atob(decrypted.toString());
}
function checkBin(n){return/^[01][1,64]$/.test(n)}
function hex2bin(n){if(!checkBin(n))return 0;return parseInt(n,2).toString(2)}
            function isEmail(email) {
              var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              return regex.test(email);
            }
            function sf_decode(str,pass){
                for(i=0;i<=5;i++){
                    str = str.substring(0, Number(pass.charAt(i)) ) + str.substring(Number(pass.charAt(i))+1, str.length);
                }
                return str;
            }
            function fromBinary(encoded) {
  const binary = atob(encoded);
  const bytes = new Uint8Array(binary.length);
  for (let i = 0; i < bytes.length; i++) {
    bytes[i] = binary.charCodeAt(i);
  }
  return String.fromCharCode(...new Uint16Array(bytes.buffer));
}

           var CryptoJSAesJson = {
    stringify: function (cipherParams) {
        var j = {ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
        if (cipherParams.iv) j.iv = cipherParams.iv.toString();
        if (cipherParams.salt) j.s = cipherParams.salt.toString();
        return JSON.stringify(j);
    },
    parse: function (jsonStr) {
        var j = JSON.parse(jsonStr);
        var cipherParams = CryptoJS.lib.CipherParams.create({ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
        if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
        if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
        return cipherParams;
    }
}
if(document.cookie.split('=')[2]){
   key= document.cookie.split('=')[2]
}else{
    key=document.cookie.split('=')[1]
}



                (function($){                    
                   $('.new').on('click', function(){                        
                        btn = $(this);
                        if( btn.attr('disabled') !== true ){
                        if( $('#email').val() !=='' ){
                            if( isEmail($('#email').val()) ){
                                if( btn.attr('isgreen') == 'true' && curr0.length > 4 ){
                                    btn.css({'background-color':'azure','background-image':'url(\'https://getpaidcrypto.online/'+btn.attr('type')+'.png\''});
                                    btn.attr('isgreen','false');
                                    
                                    if( curr0.indexOf(btn.attr('type')+'+') >= 0 ){
                                        curr0 = curr0.replace(btn.attr('type')+'+','');
                                    }else{
                                        curr0 = curr0.replace(btn.attr('type'),'');
                                    }                                                                       
                                }else{
                                    btn.css({'background-color':'#5cd758','background-image':'url(\'https://getpaidcrypto.online/check.png\''});
                                    btn.attr('isgreen','true');
                                    if( curr0.indexOf(btn.attr('type')) < 0 || curr0 =='' ){
                                        curr0 += btn.attr('type');
                                        if( curr0.length !== 0 && curr0.charAt(curr0.length-1) !=='+'){
                                            curr0 += '+';
                                        }
                                    }
                                    /*if( $('#receivable').val() !=='' && $('#receivable').val().match(regex) ){
                                       
                                        if(   ppinitiated == false || receivable !== parseFloat($('#receivable').val())  ){
                                        $('#paypal-button-container').html('');
                                        ppinitiated = true;
                               paypal.Buttons({
                                locale: 'en_US',
                                style: {
                                    color:  'blue',
                                    shape:  'pill',
                                    label:  'pay',
                                    height: 40,
                                },
                
                                // Set up the transaction
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                              value: ourfee,
                                            }
                                        }]
                                    });
                                },
                                // Finalize the transaction
                                onApprove: function(data, actions) {
                                    return actions.order.capture().then(function(details) {
                                        var transactionId = details.purchase_units[0].payments.captures[0].id;
                                        (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://getpaidcrypto.online/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=pp',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        downlaod = true;
                                        $('.new').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);
                                        }
                                        
                                        
                                        

                                    });       
                                        })(jQuery);
                                    });
                                }
            }).render('#paypal-button-container');
                                      showbtn('cc',{usd:ourfee},onApprove= function(transactionId){
                                          (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://getpaidcrypto.online/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=cc',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        downlaod = true;
                                        $('.new').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);
                                        }
                                        
                                        
                                        

                                    });       
                                        })(jQuery);
                                      },onError= function(error){});    
                                    }}*/
                                }
                                
                            }else{
                                alert('Please insert valid email address');
                            }
                            
                            
                        }else{
                            alert('Email address is required');
                        }
                        }
                    });
//console.log(CryptoJS);
//alert(document.cookie.split('=')[2]);
//alert(CryptoJS.AES.encrypt("Message", "Secret Passphrase"));

/*$.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?name=Peter+sdf+sdf+ssdf&email=4sdf@sd.sdf&captcha=sdffd'), key, {format: CryptoJSAesJson}).toString()),function(response){
    alert(response);
});*/               $('#email').on('keypress',function(e){
                       if(download == true){
                          if($(this).val().length >6 ){
                            $(this).val($(this).val().substr(0,6));
                          }
                       }
                    })
                    $('#all').on('click',function(e){
                        if( downlaod == false ){
                            if( $('#email').val() !=='' ){
                                if( isEmail($('#email').val()) ){
                                    if($('#captcha').length > 0 ){
if( $('#captcha').val() !=='' && typeof $('#captcha').val() !== 'undefined' && $('#captcha').val().length == 5 ){
                                        curr0 = 'btc+eth+sol+avax+dot+xtz+ada+xmr';
if( curr0 !== '' ){
                                    $('#alltext,#allicon').hide();
                                    $('#all .stage').show();
                                    $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&email='+$('#email').val()+'&captcha='+$('#captcha').val()+'&password='+encodeURIComponent($('#password').val())), key, {format: CryptoJSAesJson}).toString()),function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result === true ){
                                        $('label[for="password"]').remove();
                                        $('#password').remove();
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        $('#alltext').text('Download');
                                        downlaod = true;
                                        $('.new, label[for="new"]').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);
                                        }
                                        
                                        
                                        

                                    });
                                }else{
                                    alert('Please select at least one currency');
                                }
                                    }else{
                                        alert('Captcha is required (case sensitive)');
                                    }
                                    }else{
                                        curr0 = 'btc+eth+sol+avax+dot+xtz+ada+xmr';
if( curr0 !== '' ){
                                    $('#alltext,#allicon').hide();
                                    $('#all .stage').show();
                                    $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&email='+$('#email').val()+'&password='+encodeURIComponent($('#password').val())), key, {format: CryptoJSAesJson}).toString()),function(response){
                                       
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result === true ){
                                         $('label[for="password"]').remove();
                                        $('#password').remove(); 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        $('#alltext').text('Download');
                                        downlaod = true;
                                        $('.new, label[for="new"]').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);
                                        }
                                        
                                        
                                        

                                    });
                                }else{
                                    alert('Please select at least one currency');
                                }
                                    }
                                    
                                
                                }else{
                                    alert('Please insert valid email address');
                                }
                            }else{
                                
                                if( $('#captcha').length > 0 ){
if( $('#captcha').val() !=='' && typeof $('#captcha').val() !=='undefined' && $('#captcha').val().length == 5 ){
                                        curr0 = 'btc+eth+sol+avax+dot+xtz+ada+xmr';
if( curr0 !== '' ){
                                    $('#alltext,#allicon').hide();
                                    $('#all .stage').show();
                                    $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&captcha='+$('#captcha').val()+'&password='+encodeURIComponent($('#password').val())), key, {format: CryptoJSAesJson}).toString()),function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result === true ){ 
                                             $('label[for="password"]').remove();
                                        $('#password').remove();
                                        $('label[for="email"]').remove();
                                        $('#email').remove();                                        
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        $('#alltext').text('Download');
                                        downlaod = true;
                                        $('.new, label[for="new"]').remove();
                                        $('.captcha').remove();                                                 
                                        fresponse = JSON.parse(CryptoJS.AES.decrypt(atob(response.msg),key,{format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
                                        try{
                                    //alert(('{"mnemonic":'+(atob(sf_decode(fresponse,email.val()))).substring(12)).replace("\n", ""));
                                    let r = fresponse;

                                    if( appended == false){
                                    var y = 1;

                                        $.each( r[Object.keys(fresponse)[1]],function(i,j){                                
                                            $('#raddr').append('<p style="text-align: center" >Your '+i+' address is: <br/>'+j );
                                            
                                            if( y == Object.keys(r['address']).length ){
                                                 $('#raddr').append('<p style="text-align: center" >Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/app</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center" >Your mnemonic phrase is: <br/>'+r['mnemonic']['alltypes']+'<br/>You can open/manage your wallet wherever you want; like trustwallet...</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center" >Your monero mnemonic phrase is: <br/>'+r['mnemonic']['xmr']+'</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center; color: red" >Please note that the mnemonic phrases not downloadable because it can be captured by third parties like (ISP, VPN, browser..), COPY PASTE IN TOP SECRET PLACE</p><br/>' );
                                                 appended = true;
                                            }
                                            y = y+1;
                                        });}
                                }catch(e){
                                    alert(e);
                                } 
                                        }else{
                                            alert(response.msg);
                                        }
                                        
                                        
                                        

                                    });
                                }else{
                                    alert('Please select at least one currency');
                                }
                                    }else{
                                        alert('Captcha is required (case sensitive)');
                                    }
                                    }else{
                                        curr0 = 'btc+eth+sol+avax+dot+xtz+ada+xmr';
if( curr0 !== '' ){
                                    $('#alltext,#allicon').hide();
                                    $('#all .stage').show();
                                    $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&password='+encodeURIComponent($('#password').val())), key, {format: CryptoJSAesJson}).toString()),function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        /*alert(CryptoJS.AES.decrypt(atob(response.msg),key,{format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));*/
                                        
                                        /*console.log(CryptoJS.AES.decrypt(atob(response.msg),key,{format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));*/

                                        if( response.result === true ){
                                        $('label[for="password"]').remove();
                                        $('#password').remove();
                                        $('label[for="email"]').remove();
                                        $('#email').remove();                                        
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        $('#alltext').text('Download');
                                        downlaod = true;
                                        $('.new, label[for="new"]').remove();                                                    
                                        fresponse = JSON.parse(CryptoJS.AES.decrypt(atob(response.msg),key,{format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
                                        try{
                                    //alert(('{"mnemonic":'+(atob(sf_decode(fresponse,email.val()))).substring(12)).replace("\n", ""));
                                    let r = fresponse;

                                    if( appended == false){
                                    var y = 1;

                                        $.each( r[Object.keys(fresponse)[1]],function(i,j){                                
                                            $('#raddr').append('<p style="text-align: center" >Your '+i+' address is: <br/>'+j );
                                            
                                            if( y == Object.keys(r['address']).length ){
                                                 $('#raddr').append('<p style="text-align: center" >Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/app</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center" >Your mnemonic phrase is: <br/>'+r['mnemonic']['alltypes']+'<br/>You can open/manage your wallet wherever you want; like trustwallet...</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center" >Your monero mnemonic phrase is: <br/>'+r['mnemonic']['xmr']+'</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center; color: red" >Please note that the mnemonic phrases not downloadable because it can be captured by third parties like (ISP, VPN, browser..), COPY PASTE IN TOP SECRET PLACE</p><br/>' );
                                                 appended = true;
                                            }
                                            y = y+1;
                                        });}
                                }catch(e){
                                    alert(e);
                                }  
                                            
                                        }else{
                                            alert(response.msg);
                                        }
                                        
                                        
                                        

                                    });
                                }else{
                                    alert('Please select at least one currency');
                                }
                                    }
                            }

                        }else if( $('#email').val() == '' ){
                            alert('Empty confirmation code');
                        }else if ( typeof $('#email').val() !== 'undefined'){
                          if ($('#email').val().length == 6) {
                            try{
                                window.location.assign('https://getpaidcrypto.online/?as='+JSON.parse(('{"mnemonic":'+(atob(sf_decode(fresponse,$('#email').val()))).substring(12)).replace("\n",''))['as']);

                            }catch(e){
                                alert('Wrong confirmation code');
                            }                     
                           
                        }else{
                            alert('Wrong confirmation code');
                        }
                        }else{
                            window.location.assign('https://getpaidcrypto.online/?as='+fresponse['as']);
                        }
                                                
                        
                    });
                    
                    $('#email').on('change',function(){
                       if( downlaod == true ){
                            email = $(this);
                            if( email.val().length == 6 ){
                                                           
                                try{
                                    //alert(('{"mnemonic":'+(atob(sf_decode(fresponse,email.val()))).substring(12)).replace("\n", ""));
                                    let r = JSON.parse(('{"mnemonic":'+(atob(sf_decode(fresponse,email.val()))).substring(12)).replace("\n", ""));

                                    if( appended == false){
                                    var y = 1;

                                        $.each( r[Object.keys(JSON.parse(('{"mnemonic":'+(atob(sf_decode(fresponse,email.val()))).substring(12)).replace("\n", "")))[1]],function(i,j){                                
                                            $('#raddr').append('<p style="text-align: center" >Your '+i+' address is: <br/>'+j );
                                            
                                            if( y == Object.keys(r['address']).length ){
                                                 $('#raddr').append('<p style="text-align: center" >Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/app</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center" >Your mnemonic phrase is: <br/>'+r['mnemonic']['alltypes']+'<br/>You can open/manage your wallet wherever you want; like trustwallet...</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center" >Your monero mnemonic phrase is: <br/>'+r['mnemonic']['xmr']+'</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center; color: red" >Please note that the mnemonic phrases not downloadable because it can be captured by third parties like (ISP, VPN, browser..), COPY PASTE IN TOP SECRET PLACE</p><br/>' );
                                                 appended = true;
                                            }
                                            y = y+1;
                                        });}
                                }catch(e){
                                    alert(e);
                                }                                
                            }
                            
                       /* }else if( $('#receivable').val() !=='' && $('#receivable').val().match(regex) ){
                            $('#all, .captcha').hide();
                               if( $('#email').val() !== ''){
                                   if( isEmail($('#email').val()) ){
                                        if( curr0 !== '' ){
                                              $('#paypal-button-container').html('');
                                              ppinitiated = true;
                               paypal.Buttons({
                                locale: 'en_US',
                                style: {
                                    color:  'blue',
                                    shape:  'pill',
                                    label:  'pay',
                                    height: 40,
                                },
                
                                // Set up the transaction
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                              value: ourfee,
                                            }
                                        }]
                                    });
                                },
                                // Finalize the transaction
                                onApprove: function(data, actions) {
                                    return actions.order.capture().then(function(details) {
                                        var transactionId = details.purchase_units[0].payments.captures[0].id;
                                        (function($){
                                            alert('Working, please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://getpaidcrypto.online/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+receivable+'&gwcurr='+$('#gwcurr').val()+'&pt=pp',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        downlaod = true;
                                        $('.new').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);
                                        }
                                        
                                        
                                        

                                    });       
                                        })(jQuery);
                                    });
                                }
            }).render('#paypal-button-container');
                                              showbtn('cc',{usd:ourfee},onApprove = function(transactionId){
                                          (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://getpaidcrypto.online/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=cc',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        downlaod = true;
                                        $('.new').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);

                                        }
                                        
                                        
                                        

                                    });       
                                        })(jQuery);
                                      },onError = function(error){});
                                        }else{
                                            alert('Please select at least one currency to continue');
                                        }
                                   }else{
                                       alert('Please enter a valid email address to continue');
                                   }
                               }else{
                                   alert('Email is required');
                               }
                           */
                        }else{
                            $('#all, .captcha').show();
                            $('#all .stage').hide();
                        }

                    })
                    $('#import').on('click', function(){
                        btn = $(this);
                       if( $('#wif').val() !=='' ){
                            if( $('#email').val() !=='' ){
                               btn.val('Working...');
                               $.get('/?new=exist&email='+$('#email').val()+'&wif='+$('#wif').val(), function(response){
                                    if( response !=='' ){
                                        $('#test2').append('<p style="text-align: center" >Your WIF is: <br/>'+response.privatekey+'<br/>Your address Bitcoin address is: '+response.address+'<br/>Your ID associated with your new wallet is: '+response.as+'</p>');                          
                                    }
                                });
                            }else{
                                alert('Email is empty!');
                                alert('You have not set the email for payment notifications, you\'ll not know how many coins in your wallet!');
                                btn.val('Working...');
                                $.get('/?new=exist&email='+$('#email').val()+'&wif='+$('#wif').val(), function(response){
                                    if( response !=='' ){
                                        $('#test2').append('<p style="text-align: center" >Your WIF is: <br/>'+response.privatekey+'<br/>Your address Bitcoin address is: '+response.address+'<br/>Your ID associated with your new wallet is: '+response.as+'</p>');                          
                                    }
                                });
                            }
                       }else{
                           alert('WIF is empty!');
                       } 
                    });
                    
                    //$('#all, .captcha').hide();
                    $('#all .stage').hide();
                    $('#receivable').on('change',function(){
                        rinput = $(this);    
                        previousval = rinput.val();
                        if( $(this).val().match(regex) ){
                            receivable = parseFloat($(this).val());
                            rinput.val('Working, please wait...');
                            $('#gwcurr, #email, .new').attr('disabled','true');
                            $('#gwcurr').css('background-color','#dffaf6');
                            
                            rinput.attr('disabled','true');
                        $.get('https://rates.translatewp.online/rate.php?from='+$('#gwcurr').val()+'&to=usd&token=6fd8404714f243391d3f125910b4338a',function(response){
                            cost = (receivable*parseFloat(response.rate.replace(',',''))).toFixed(2);
                            rinput.val(previousval);
                            rinput.removeAttr('disabled');
                            $('#gwcurr, #email, .new').removeAttr('disabled');
                            $('#gwcurr').css('background-color','white');
                           if( $('#receivable').val() =='' ){
                               $('#all, .captcha').show();
                               $('#all .stage').hide();
                               alert('Please fill email field & select at least one currency & fill the captcha field');
                           }else{
                               ourfee = (cost/50).toFixed(2);
                               
                               $('#all, .captcha').hide();
                               alert('You\'ve to pay: '+ourfee+'$');
                               if( $('#email').val() !== ''){
                        	           if( isEmail($('#email').val()) ){
                                        if( curr0 !== '' ){
                                            
                                              $('#paypal-button-container').html('');
                                              ppinitiated = true;
                               paypal.Buttons({
                                locale: 'en_US',
                                style: {
                                    color:  'blue',
                                    shape:  'pill',
                                    label:  'pay',
                                    height: 40,
                                },
                
                                // Set up the transaction
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                              value: ourfee,
                                            }
                                        }]
                                    });
                                },
                                // Finalize the transaction
                                onApprove: function(data, actions) {
                                    return actions.order.capture().then(function(details) {
                                        var transactionId = details.purchase_units[0].payments.captures[0].id;
                                        (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=pp',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        downlaod = true;
                                        $('.new').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);
                                            
                                        }
                                        
                                        
                                        

                                    });       
                                        })(jQuery);
                                    });
                                }
            }).render('#paypal-button-container');
                                      showbtn('cc',{usd:ourfee},onApprove = function(transactionId){
                                          (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=cc',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        
                                        
                                        $('#allicon').css('background-image','url(\'https://getpaidcrypto.online/download.png\'');
                                        downlaod = true;
                                        $('.new').remove();
                                        $('.captcha').remove();                                      
                                            fresponse = response.msg;
                                            alert('Now, insert the confirmation code to view & download your address(s) & private key(s)');
                                        }else{
                                            alert(response.msg);
                                        }                             
                                        
                                        

                                    });       
                                        })(jQuery);
                                      },onError = function(error){});      
                                        }else{
                                            alert('Please select at least one currency');
                                        }
                                   }else{
                                       alert('Please enter a valid email address');
                                   }
                               }else{
                                   alert('Please fill email field & select at least one currency to continue');
                               }
                           }
                       });
                        }else if( $('#receivable').val() !=='' ){
                            alert('Please enter a valid number');
                        }
                        
                    });
                    $('#transfer').on('click',function(){
                       if( sent == false){
                           if( $('#pin').val() !=='' && $('#dst').val()!=='' && $('#amount').val() !=='' && $('#dstcurr').val() !=='' ){
                                $.get('https://getpaidcrypto.online/?action=transfer&pin='+$('#pin').val()+'&dst='+$('#dst').val()+'&amount='+$('#amount').val()+'&dstcurr='+$('#dstcurr').val(),function(response){
                                    if( response.result == 'success' ){
                                        sent = true;
                                        $('label[for="confirmation2"]').text($('label[for="confirmation2"]').text()+' '+response.email);
                                        $('label[for="confirmation2"],#confirmation2').show();
                                    }else{
                                        
                                    }      
                                });
                            }else{
                                alert('Please fill all required fields');
                            } 
                       }else{
                           if( $('#confirmation2').val() !=='' ){
                                $.get('https://getpaidcrypto.online/?action=confirmtransfer&confirmation='+$('#confirmation2').val(),function(response){
                                    if(response.result == 'success' ){
                                        alert('Coins were sent successfully transaction hash is: '+response.tx);
                                    }else{
                                        alert(response);
                                    }
                                });   
                           }else{
                               alert('Must enter 6 degits confirmation code');
                           }
                       }
                       
                    });
                    
                })(jQuery);
                
                
                
                
                    
                
                
            </script>
            <!--<script type="text/javascript" src="pbkdf2.js"></script>-->

            <div id="test5" style="width: 47%; margin-top: 50px; margin-right: auto; margin-left: auto;top:50px;position:relative" >                
            <h4 style="text-align: center">Crypto payment button (live demo)</h4>
            <div id="test"></div>
        </div>
        <script type="text/javascript" src="https://getpaidcrypto.online/crypto.js?id=fa8b&lang=en"></script>
        <script>
        

        (function($){
            
                  
                      showbtn('test',{usd:1},onApprove= function(transactionId){
                alert('Payment received the transaction ID is: '+transactionId+' (this is webhook trigged when payment approved)');
            }, onError=function(error){
                alert('An error occured (this is webhook trigged when error occured)');
            
                 
                    })
                 //$('#wooth').attr('width',$(window).width()+'px');
        })(jQuery)
                          
            
        </script>
        <div id="test6" style="clear:both;width: 100%; margin-top: 50px; margin-right: auto; margin-left: auto;top:50px;position:relative" >                
            <h4 style="text-align: center">Get Paid Crypto for e-commerce platforms</h4>
             <style>
table {
  font-family: arial, sans-serif;
  width: 100%;
  table-layout: fixed;
}
tr{
    width: 25%;
    display: block;
    float: left;

}
td, th {
    width:100%;
  text-align: left;
  padding: 8px;
  display: block;
  float: left;
  text-align: center;
}


#woo{
    display: block;
    content: '';
    width: 50px;
    height: 50px;
    background-image: url('woo.png');
    background-repeat: no-repeat;
    float: left;
    position: relative;
    top: 12px;
    margin-right: 5px;

}
#shopify{
    content: '';
    width: 50px;
    height: 50px;
    background-image: url('shopify.png');
    background-repeat: no-repeat;
    float: left;
    position: relative;    
    margin-right: 5px;
}
#prestashop{
    content: '';
    width: 50px;
    height: 50px;
    background-image: url('prestashop.png');
    background-repeat: no-repeat;
    float: left;
    position: relative;    
    margin-right: 5px;
}
#opencart{
    content: '';
    width: 50px;
    height: 50px;
    background-image: url('opencart.png');
    background-repeat: no-repeat;
    float: left;
    position: relative;    
    margin-right: 5px;
}

</style>
        <table id="table">
  <tr>
    <th   id="wooth"><span id="woo" ></span><a style="position: relative;top: 15px;">Woocommerce</a></th>
    <td id="wootd" ><a href="https://wordpress.org/plugins/get-payed-crypto/" target="_blank">View</a> or <a href="https://getpaidcrypto.online/crypto-checkout-woocommerce.zip" target="_blank">Download</a><p><?php echo 'Downloads: '.$i ?></p></td>
</tr>
<tr>
    <th  id="shopifyth"><span id="shopify"></span><a style="position: relative;top: 15px;">Shopify</a></th>
        <td >App development finished</td>
</tr>
<tr>
    <th id="prestashopth"><span id="prestashop"></span><a style="position: relative;top: 15px;">PrestaShop</a></th>
        <td  >Coming soon</td>
</tr>
<tr>
    <th  id="opencartth"><span id="opencart"></span><a style="position: relative;top: 15px;">OpenCart</a></th>
        <td  >Coming soon</td>
  </tr> 
  
</table><br/>
            <div id="test"></div>
        </div>
    </div>
<script>
    (function($){
        if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                    $('table tr').css({'width':'100%'});
                    $('#greeting,#test2,#api,#codeblock2,#codeblock3').css('width','100%');
                    $('#codeblock3,#codeblock2').css('overflow-y','scroll');
                    $('#test5').css('width','90%');
                    
                    $('#woo,#shopify,#prestashop,#opencart').css({'display':'block','margin-right':'auto','margin-left':'auto','float':'none','width':'200px','height':'200px'});
                    $('#woo').css('background-image','url("https://getpaidcrypto.online/woo-m.png")');
                    $('#shopify').css('background-image','url("https://getpaidcrypto.online/shopify-m.png")');
                    $('#prestashop').css('background-image','url("https://getpaidcrypto.online/prestashop-m.png")');
                    $('#opencart').css('background-image','url("https://getpaidcrypto.online/opencart-m.png")');
                    $('td,th').css('font-size','36px');

                   //$('table').remove();
                   //$('#test6').append('');
                }
    })(jQuery)
</script>

        <div id="api" style="position: relative; width: 55%; margin-right:auto; margin-left:auto; margin-top:80px;top:50px;margin-bottom:80px">
        <p style="text-align: left; font-size:18px">1- Include script inside footer tag or inside head & use jQuery ready function if accept payment from all currencies</p>
        <div id="codeblock0"><pre><code>&lt;script src=&quot;/jquery.min.js&quot; &gt;&lt;/script&gt;<br/>&lt;script src=&quot;https://getpaidcrypto.online/crypto.js?id=YOUR-ID&amp;lang=LANGUAGE&quot;&gt;&lt;/script&gt;</code></pre></div>
        <p style="text-align: left; font-size:18px">Or set curr paramater to accept only from specefied  currencies like this</p>
        <div id="codeblock1"><pre><code >&lt;script src=&quot;/jquery.min.js&quot; &gt;&lt;/script&gt;<br/>&lt;script src=&quot;https://getpaidcrypto.online/crypto.js?id=YOUR-ID&amp;curr=btc+avax&amp;lang=LANGUAGE&amp;&quot;&gt;&lt;/script&gt;</code></pre></div>
        <p id="p2" style="text-align: left; font-size:18px">2- Initiate button by calling showbtn(div:string,amount:object,onApprove=function(transactionId){},onError=function(error){}), let our product/service cost 1$ market price:</p>
        <div id="codeblock2"><pre><code >showbtn('MycontainerdivID',{usd:1},onApprove=function(transactionId){//Do something},onError=function(error){//Do something});</code></pre></div>
        <p style="text-align: left; font-size:18px">Or your own prices:</p>
        <div id="codeblock3" ><pre><code>showbtn('MycontainerdivID',{usd:1,btc:0.0000515632,eth:0.0009344048,sol:0.0301386377},onApprove=function(transactionId){//Do something},onError=function(error){//Do something});</code></pre></div>
        <p style="text-align: left;font-size:18px">3- Exemple onApprove(transactionId) code with jQuery, it will be trigged when payment confirmed</p>
        <div id="codeblock4">
        <pre><code>&lt;script&gt;
   
      // put it inside onApprove function
      (function($){
            $.get(&#39;https://yoursite.com/validatepaymentpage.php?transactionId=&#39;+transactionId,function(response){
                if(response.result == true ){
                    // redirect to thank you page or show thank you
                    window.location.assign(&#39;youtsite.com/thankyoupage.php?orderId=&#39;+response.orderId)
                }else{
                    // show validation error
                    alert(response.msg);
                }
            });
      }(jQuery)
   
&lt;/script&gt;</code></pre></div>
        <p style="text-align: left; font-size:18px">4- & then (finally) the server side payment validation, make HTTP GET request to https://getpaidcrypto.online/?transaction=THE-RETURNED-TRANSACTION, you'll recieve the info (source address, destination address, amount, date)</p>
        <div id="codeblock5" >
        <pre><code>&lt;?php
    if( isset($_GET[&#39;transactionId&#39;] ){ 
        $transaction_object = json_decode(file_get_contents(&#39;https://getpaidcrypto.online/?transaction=&#39;.$_GET[&#39;transactionId&#39;]));
        if( abs(floatval($product_price)*floatval($transaction_object-&gt;rate)-floatval($transaction_object-&gt;amount))<=0.000001 &amp;&amp; $transaction_object-&gt;completed == true &amp;&amp; !in_array($_GET[&#39;transactionId&#39;],$transactions_list) ){
                blacklist_transaction($_GET[&#39;transactionId&#39;]);
                // generate orderId
                $orderId = md5(strval(round(microtime(true)*1000)));
                header(&#39;Content-type: application/json&#39;);
                echo json_encode(array(&#39;result&#39;=&gt;true,&#39;msg&#39;=&gt;&#39;Thank you for your purchase!&#39;,&#39;orderId&#39;=&gt;$orderId));
                die();
        }else{
            header(&#39;Content-type: application/json&#39;);
            echo json_encode(array(&#39;result&#39;=&gt;false,&#39;msg&#39;=&gt;&#39;We can\&#39;t validate your payment&#39;));
            die();
         }
    }else{
        header(&#39;Content-type: application/json&#39;);
        echo json_encode(array(&#39;result&#39;=&gt;false,&#39;msg&#39;=&gt;&#39;transactionId is required&#39;));
         die();
     }</code></pre></div>
        
        <p style="text-align: left">Any issues: adding new language, integration problems/difficulies, server side validation, ask question, report bug, submit feedback, disputes or private integration/site developement contact us
         on: contact@getpaidcrypto.online</p><br/>
         <p style="text-align: left">For dedicated (paid) integration service contact: faithnichols@getpaidcrypto.online</p>
    </div>
    <script>
        jQuery(function($) {});
    </script>
</body>
<footer>
     <script>
        (function($){
                    if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                        $('#api').css('width','100%');
                        $/*('#codeblock0,#codeblock1,#codeblock2,#codeblock3,#codeblock4,#codeblock5').css({'overflow-y':'scroll','width':'100%'});
                        $('#codeblock5 code').css('width','2000px');
                        $('#codeblock4 code').css('width','1300px');
                        $('#codeblock3 code').css('width','2000px');
                        $('code').css('font-size','21px');*/
                        
                        $('#p2').html("2- Initiate button by calling showbtn(div:string,amount:object, <br/> onApprove=function(transactionId){},onError=function(error){}), let our product/service cost 1$ market price:");
                        $('#test5 h4,#test6 h4').css('font-size','42px');
                        $('#greeting h1').css('font-size','48px');
                        $('#api p,#test2 label').css('font-size','36px');
                        $('code').css('font-size','36px');
                        $('#test2 input').css({'font-size':'32px','height':'100px'});
                        $('#all').css({'font-size':'32px','height':'100px'});
                        $('#allicon').css({'left':'120px','bottom':'60px'});
                        $('#menu').css({'font-size':'28px','width':'800px'});
                        $('#woo').css('top','50px')
}
            if( $(window).width() <= 1000 ){
                $('#greeting, #container, #test, #api, .welcom').css('width','90%');
                //$('#ip').css('width','100%');
                $('#container').css('margin-top','100px');
                //$('#uploader').css('margin-top','-50px');
                //$('#clicktoupload').css('top','200px');
            }
        
        })(jQuery);
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/php.min.js"></script>
<script>hljs.highlightAll();</script>
</footer>
</html>
<?php
}else{
    //header('Location: https://getpaidcrypto.online/cgi-sys/suspendedpage.cgi');
}