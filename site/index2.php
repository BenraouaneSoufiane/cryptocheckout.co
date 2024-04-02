<?php

function sf_encode($obj, $pass)
{
    $new = base64_encode(json_encode($obj));
    for( $i =0;$i<=5;$i++){
        $new = substr_replace($new, $pass[$i], intval($pass[$i]), 0);
    }
    return $new;
}
if(!isset($_SESSION)) {
    session_start();
}
if(empty($_GET) &&  empty($_POST) && empty($_FILES)  ) {

    include 'captcha/CaptchaBuilderInterface.php';
    include 'captcha/CaptchaBuilder.php';
    include 'captcha/PhraseBuilderInterface.php';
    include 'captcha/PhraseBuilder.php';
}







if(isset($_GET['hash']) && isset($_GET['as']) && isset($_GET['type']) ) {


    date_default_timezone_set('Europe/London');
    $now = round(round(microtime(true)*1000)/1000);
    include "txtdb.php";
    $db = new TxtDb();
    $m = $db->select('merchants', array('as'=>$_GET['as']));
    $m = $m[array_keys($m)[0]];

    if($m['address'] !=='' && $m['address'][$_GET['type']] !== '' ) {
        switch ($_GET['type']) {
        case 'btc':
           
        
                $r = file_get_contents('https://api.blockcypher.com/v1/btc/main/addrs/'.$m['address'][$_GET['type']].'/full?token=0c90af3735a0454b97d1353fe7dec4f2');                
                           
            if($r == '' || $r == null ) {
                break;
            }
            $s = $db->select('pre-transactions', array('hash'=>$_GET['hash']));
            $s0=array_keys($s)[0];
            $t = $s[$s0];
            foreach( json_decode($r) as $i => $v ){
                if($i == 'txs' ) {
                    foreach( $v as $i2 => $v2 ){                       
                        if($v2->confirmed !==''   ) { 
                                            
                            if(strtolower(substr($v2->inputs[0]->addresses[0], 0, 3).substr($v2->inputs[0]->addresses[0], -3)) == $t['address'] && $v2->outputs[0]->addresses[0] == $m['address'][$_GET['type']] ) {                               
                                
                                if($v2->outputs[0]->value == $t['amount'] ) {                                       
                                    $db->update('pre-transactions', array('from'=>$v2->inputs[0]->addresses[0],'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)), $s0);
                                    mail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['amount'])/100000000, 6))."BTC from: ".$v2->inputs[0]->addresses[0].", the transaction id is: ".$v[$i2]->hash.", Best regards!");
                                    header('Content-type: application/json');
                                    echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$v[$i2]->hash)));
                                    die();
                                }
                                
                            }
                        }elseif($i2 == count($v)-1) { 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            die();
                        }
                    
                    }
                }
            }
            break;
        case 'eth':
            $r = file_get_contents('https://api.etherscan.io/api?module=account&action=txlist&address='.$m['address'][$_GET['type']].'&apikey=XQWRYGPUPM7YDPYEZ7UVIAAZG8NBU3CGUX');                
                           
            if($r == '' || $r == null ) {
                break;
            }
            $s = $db->select('pre-transactions', array('hash'=>$_GET['hash']));
            $s0=array_keys($s)[0];
            $t = $s[$s0];
            foreach( json_decode($r)->result as $i => $v ){
                                            
                if(intval($v->confirmations) > 0  && strtolower(substr($v->from, 0, 3).substr($v->from, -3)) == $t['address'] && $v->to == $m['address'][$_GET['type']] ) {                               
                                
                    if($v->value == $t['amount'] ) {                                       
                        $db->update('pre-transactions', array('from'=>$v->from,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)), $s0);
                        mail($m['notif'], "Payment received successfully", "Hello, you\'ve successfully received ".strval(round(floatval($t['amount'])/1000000000000000000, 6))."ETH from: ".$v->from.", the transaction id is: ".$v->hash.", Best regards!");
                        header('Content-type: application/json');
                        echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$v->hash)));
                        die();
                    }
                                
                            
                }elseif($i == count(json_decode($r)->result)-1) { 
                    echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                    die();
                }
                    
                
            }
            break;
        case 'sol':
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
                
            if($r == '' || $r == null ) {
                break;
            }
                
            $s = $db->select('pre-transactions', array('hash'=>$_GET['hash']));
            $s0=array_keys($s)[0];
            $t = $s[$s0];
            print_r(json_decode($r, true));
            //die();
            /*for( $i = 0;$i<=10;$i++){
            
            }*/
            /*foreach( json_decode($r) as $i => $v ){
                        print_r(array_keys(json_decode($r,true)));
                        die();
                        if( $v->dst == $m['address'][$_GET['type']] && $v->status == 'success'  && strtolower(substr($v->src,0,3).substr($v->src,-3)) == $t['address']  ){                               
                                
                                    if( $v->lamport == $t['amount'] ){                                       
                                        $db->update('pre-transactions',array('from'=>$v->src,'to'=>$m['address'][$_GET['type']],'completed'=>round(microtime(true)*1000)),$s0);
                                        mail($m['notif'],"Payment received successfully","Hello, you\'ve successfully received ".strval(round(floatval($t['amount'])/1000000000,6))."SOL from: ".$v->src.", the transaction id is: ".$v->txHash.", Best regards!" );
                                        header('Content-type: application/json');
                                        echo json_encode(array('result'=>'success','message'=>'Payment effectued successfully','transactionId'=>array('local'=>$_GET['hash'],'universal'=>$v->txHash)));
                                        die();
                                    }
                                
                            
                        }elseif($i == count(json_decode($r))-1){ 
                            echo json_encode(array('result'=>'failure','message'=>'We can\'t validate your transaction, try again'));
                            //die();
                        }
                    
                
            }*/
            break;
            
            
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
if(isset($_GET['as']) && !isset($_GET['hash'])) {
    include "txtdb.php";
    $db = new TxtDb();
    $as = $db->select('merchants', ['as'=>$_GET['as']]);
    if(!empty($as) ) {
        $str = '';
        $pk = $as[array_keys($as)[0]]['pk'];
        foreach($pk as $k => $v){
            $str .= 'Your '.$k.' address is: '.$as[array_keys($as)[0]]['address'][$k]."\n";
            //$str .= 'The associated private key is: '.$v."\n";            
        }
        $str .= 'Your associated account is: '.$_GET['as'].' used to doing transactions without providing address & private key';
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
if(isset($_GET['new']) && isset($_GET['email']) ) {
    if(filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) ) {
        if(isset($_GET['captcha']) ) {
            /* header('Content-type: application/json');
            echo json_encode(array('token'=>$_SESSION['phrase']));
            die();*/

            if($_GET['captcha'] == $_SESSION['phrase'] && $_SESSION['did']==false ) {
                $curr = explode(' ', $_GET['new']);
                $address = $privatekey = array();
                foreach( $curr as $k => $v ){
                    if($v == 'btc') {
                        $r0 = file_get_contents('http://127.0.0.1:3000/api/?type=btc&btctype=new');
                        $r = file_get_contents('http://127.0.0.1:3000/api/?type=btc&btctype=fromWIF&wif='.$r0);     
                        $privatekey['btc'] = $r0;
                        $address['btc'] = $r;
                        include 'phpqrcode/qrlib.php';
                        QRcode::png($r0, 'btc/'.$r0.'.png', QR_ECLEVEL_L, 4);
                    }elseif($v == 'eth' ) {
                        $r = file_get_contents('http://127.0.0.1:3000/api/?type=eth');
                        $address['eth'] = json_decode($r)->address;
                        $privatekey['eth'] = json_decode($r)->privateKey;
                    }elseif($v == 'sol' ) {
                        $r = file_get_contents('http://127.0.0.1:3000/api/?type=sol');
                        $address['sol'] = json_decode($r)->address;
                        $privatekey['sol'] = json_decode($r)->privatekey;
                    }
                }
    
                $as = substr(md5(strval(round(microtime(true)*1000))."ssecret"), 0, -28);
                include "txtdb.php";
                $db = new TxtDb();
                $db->insert('merchants', ['pk'=>$privatekey,'address'=>$address,'as'=>$as,'notif'=>$_GET['email']]);
                $obj = array();
                $obj['email']=$_GET['email'];
                $pass = substr(strval(round(microtime(true)*1000)), -6);
                $obj['confirmation'] = $pass;
                $r = file_get_contents('https://translate.hirak.site/update.php?text='.substr_replace(base64_encode(json_encode($obj)), 'S', 5, 0));
        
        
        
                if(json_decode($r)->result == 'true') {
                    header('Content-type: application/json');
                     $r = array('privatekey'=>array(),'address'=>$address,'as'=>$as);
                     echo json_encode(array('result'=>true,'msg'=>sf_encode($r, $pass)));        
                     $_SESSION['did']=true;
                     die();
        
                }else{
                    header('Content-type: application/json');
                    echo json_encode(array('result'=>false,'msg'=>'An error occured try again or report to: contact@hirak.site'));
                } 
        
            }else{
                header('Content-type: application/json');
                echo json_encode(array('result'=>false,'msg'=>'Wrong captcha or you already did, please note that the captcha is case sensive'));
                die();
            }
        }
        
    }else{
        header('Content-type: application/json');
        echo json_encode(array('result'=>false,'msg'=>'Invalid email'));
        die();
    }
    
}
    /*if( $_GET['new'] == 'register' ){
        
        
    }
    if( $_GET['new'] == 'exist' ){
        $r = file_get_contents('https://crypto.hirak.site/api/?type=fromWIF&wif='.$_GET['wif']);
        $as = substr(md5(strval(round(microtime(true)*1000))."ssecret"),0,-28);
        require("txtdb.php");
        $db = new TxtDb();
        $db->insert('merchants',['wif'=>$_GET['wif'],'address'=>$r,'as'=>$as,'notif'=>$_GET['email']]);
        header('Content-type: application/json');
        echo json_encode(array('wif'=>$_GET['wif'],'address'=>$r,'as'=>$as));
        die();
    }*/

if(isset($_GET['submit']) && strlen($_GET['submit'])==6 && isset($_GET['amount']) && floatval($_GET['amount'])!==0 && isset($_GET['type']) ) {
    include "txtdb.php";
    $db = new TxtDb();
    $hash = md5(strval(round(microtime(true)*1000).'cryptosafina'));
    if($_GET['type'] == 'btc' ) {
        $t = $db->select('pre-transactions', array('address'=>$_GET['submit'],'amount'=>$_GET['amount']*100000000));
    }elseif($_GET['type'] == 'eth' ) {
        $t = $db->select('pre-transactions', array('address'=>$_GET['submit'],'amount'=>$_GET['amount']*1000000000000000000));
    }elseif($_GET['type'] == 'sol' ) {
        $t = $db->select('pre-transactions', array('address'=>$_GET['submit'],'amount'=>$_GET['amount']*1000000000));
    }
    
    if(empty($t) ) {
        $db->insert('pre-transactions', array('hash'=>$hash,'address'=>$_GET['submit'],'amount'=>floatval($_GET['amount'])*100000000,'from'=>'','to'=>'','completed'=>'','issued'=>round(microtime(true)*1000)));
        header('Content-type: application/json');
        echo json_encode(array('result'=>$hash));
        die(); 
    }
}
if(isset($_GET['transaction']) ) {
    include "txtdb.php";
    $db = new TxtDb();
    $tr = $db->select('pre-transactions', array('hash'=>$_GET['transaction']));
    if(!empty($tr) ) {
        header('Content-type: application/json');
        echo json_encode($tr[array_keys($tr)[0]]);
        die();
    }
}

if(isset($_GET['source']) && isset($_GET['address']) && isset($_GET['amount']) ) {
    $r = file_get_contents('https://api.blockcypher.com/v1/btc/main/addrs/'.$_GET['address'].'/full');
    
    foreach( json_decode($r) as $i => $v ){
        if($i == 'txs' ) {
            foreach( $v as $i2 => $v2 ){
                if(substr($v2->address, 0, 3) == substr($_GET['source'], 0, 3) &&  substr($v2->address, -3) == substr($_GET['source'], -3)) {
                    foreach( json_decode($r)->outputs as $i3 => $v3 ){
                        if($v3->address == $_GET['address'] && $v3->value == floatval($_GET['amount'])*100000000 ) {
                            echo $v->mintTxid;
                            include "txtdb.php";
                            $db = new TxtDb();
                            $db->insert('transactions', ['transaction'=>$v->mintTxid,'from'=>$v2->address,'to'=>$v3->address,'amount'=>$_GET['amount'],'time'=>date('d-m-Y h:m:s')]);
                            $m=$db->select('merchants', array('as'=>$_GET['id']));
                            mail($m[array_keys($m)[0]]['notif'], "Payment effectued successfully", "Hello, you\'ve successfully recieved ".$_GET['amount']."btc from: ".$v2->address.", the transaction id is: ".$v->mintTxid.", Best regards!");
                        }
                    }
                }
            }
        }
    }
}
if(isset($_GET['source']) && isset($_GET['address']) && isset($_GET['amount']) ) {
    $r = file_get_contents('https://api.bitcore.io/api/BCH/mainnet/address/'.$_GET['address']);
    foreach( json_decode($r) as $i => $v ){
        $r = file_get_contents('https://api.bitcore.io/api/BCH/mainnet/tx/'.$v->mintTxid.'/coins');
        foreach( json_decode($r)->inputs as $i2 => $v2 ){
            if(substr($v2->address, 0, 3) == substr($_GET['source'], 0, 3) &&  substr($v2->address, -3) == substr($_GET['source'], -3)) {
                foreach( json_decode($r)->outputs as $i3 => $v3 ){
                    if($v3->address == $_GET['address'] && $v3->value == floatval($_GET['amount'])*100000000 ) {
                        echo $v->mintTxid;
                        include "txtdb.php";
                        $db = new TxtDb();
                        $db->insert('transactions', ['transaction'=>$v->mintTxid,'from'=>$v2->address,'to'=>$v3->address,'amount'=>$_GET['amount'],'time'=>date('d-m-Y h:m:s')]);
                    }
                }
            }
        }
    }
    
}

if(isset($_GET['address']) && isset($_GET['amount']) ) {
    include 'phpqrcode/qrlib.php';
    QRcode::png('bitcoin:'.$_GET['address'].'?amount='.$_GET['amount'], 'btc/'.$_GET['address'].$_GET['amount'].'.png', QR_ECLEVEL_L, 4);
    die();
}




if(isset($_GET['id']) && isset($_GET['div']) ){
    if(isset($_GET['lang']) ){
if($_GET['lang'] == 'ar' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'إدفع باستخدام العملات الرقمية','guide0'=>'سوف تدفع','guide1'=>'إلى ضمان ذلك أنت منظمة الصحة العالمية سوف أرسلت ال المال, منفضلك إدراج أولاً 3 شاركترز & آخر 3 شاركترز من الخاصبك بيتكوين العنوان','guide'=>'ادفع باستخدام qr أو أرسل المعاملة إلى العنوان التالي ، ثم انقر فوق لقد دفعت للانتقال إلى خطوة التحقق','ivepaid'=>'لقد دفعت','nextstep'=>'تحقّق','step2'=>'للتأكد من أنك من أرسلت الأموال ، يرجى إدخال أول 3 أحرف و 3 أحرف أخيرة من عنوان الخاص بك','success'=>'شكرا لك، تمت إثبات الدفع، جاري معالجة طلبك','failure'=>'لم نستطع إثبات دفعك يُرجى إعادة المحاولة','tryagain'=>'إعادة المحاولة','validating'=>'نحن نتأكد من المعاملة يرجى الإنتظار','thankyou'=>'شكرا لك','transactionid'=>'معرّف المعاملة','validationfailure'=>'عُذرا، لم نتمكن من العثور على معاملتك أو لم يتم تأكيدها بعد ، يرجى المحاولة مرة أخرى'));
}         
if($_GET['lang'] == 'bn' ) {             
    $sf = 'var messages ='.json_encode(array('pay'=>'ক্রিপ্টোকারেন্সি ব্যবহার করে পরিশোধ क्रिप्टोकरेंसी','guide0'=>'আপনি অর্থ প্রদান করতে যাচ্ছেন','guide1'=>'আপনি কে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, অনুগ্রহ করে আপনার বিটকয়েন ঠিকানার প্রথম 3টি অক্ষর এবং শেষ 3টি অক্ষর সন্নিবেশ করান','guide'=>'কিউআর ব্যবহার করে অর্থ প্রদান করুন বা পরবর্তী ঠিকানায় লেনদেন প্রেরণ করুন তারপরে যাচাইকরণের পদক্ষেপে যাওয়ার জন্য আমি অর্থ প্রদান করেছি ক্লিক করুন','ivepaid'=>'আমি দিয়েছি','nextstep'=>'বৈধতা দিন','step2'=>'আপনি যে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, দয়া করে আপনার ঠিকানার প্রথম 3 টি অক্ষর এবং 3 শেষ অক্ষর লিখুন','success'=>'আপনাকে ধন্যবাদ, অর্থ প্রদান সফলভাবে যাচাই করা হয়েছিল, আমরা আপনার আদেশ প্রক্রিয়া করছি','failure'=>'আমরা আপনার অর্থ প্রদান বৈধ করতে পারি না, আবার চেষ্টা করুন','tryagain'=>'আবার চেষ্টা কর','validating'=>'আমরা আপনার পেমেন্ট যাচাই করছি অনুগ্রহ করে অপেক্ষা করুন','thankyou'=>'ধন্যবাদ','transactionid'=>'লেনদেন নাম্বার','validationfailure'=>'দুঃখিত, আমরা আপনার লেনদেন খুঁজে পাচ্ছি না বা এটি এখনও নিশ্চিত হয়নি, অনুগ্রহ করে আবার চেষ্টা করুন'));
} 
if($_GET['lang'] == 'zh' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'使用比加密货币付款','guide0'=>'你 be的现在时复数或第二人称单数 去 到 薪资','guide1'=>'To 确定 那 你 谁 意志 send的过去式和过去分词 art.那 金钱, ad请\n使高兴 插入物\n插入 ad首先 hundred & 最后的 hundred 的 pro你的 比特币 住址','guide'=>'使用二维码付款或将交易发送到下一个地址，然后单击我已付款以跳至验证步骤','ivepaid'=>'我已经付了','nextstep'=>'证实','step2'=>'为了确保您汇款成功，请输入您的地址的前3个字符和最后3个字符','success'=>'谢谢您，付款已成功验证，我们正在处理您的订单','failure'=>'我们无法验证您的付款，请重试','tryagain'=>'尝试 ad再一次','validating'=>'(weare的常用口语形式) 确认 pro你的 付款 ad请\\n使高兴等待"','thankyou'=>'谢意 你','transactionid'=>'交易 遗传素质','validationfailure'=>'抱歉，我们找不到您的交易或仍未确认，请重试'));
} 
if($_GET['lang'] == 'cs' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'Plaťte pomocí Kryptoměny','guide0'=>'Vy AR být na zaplatit','guide1'=>'Na zajistit že vy který vůle přenášet v peníze, Potěšit vložit Nejprve 3 Charty & Poslední 3 Charty z Vaši adresa','guide'=>'Zaplaťte pomocí qr nebo odešlete transakci na další adresu a kliknutím na možnost Zaplatil jsem přejdete na krok ověření','ivepaid'=>'Zaplatil jsem','nextstep'=>'Ověřit','step2'=>'Abyste se ujistili, že jste odeslali peníze, zadejte prosím první 3 znak a 3 poslední znak své Bitcoinové adresy','success'=>'Děkujeme, platba byla úspěšně ověřena, zpracováváme vaši objednávku','failure'=>'Nemůžeme ověřit vaši platbu, zkuste to znovu','tryagain'=>'Snažit znovu','validating'=>'We\'re validating Vaši Platba Potěšit Čekat','thankyou'=>'Děkovat vy','transactionid'=>'Transakce ID','validationfailure'=>'Omlouváme se, vaši transakci nemůžeme najít nebo stále není potvrzena, zkuste to prosím znovu'));
} 
if($_GET['lang'] == 'da' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'Betale ved hjælp af Kryptovalutaer','guide0'=>'De er gå til betale','guide1'=>'Til sikre at De der vilje sendt den penge, behage Indsætte først 3 charcters & sidst 3 charcters af Deres adresse','guide'=>'Betal ved hjælp af qr eller send transaktion til næste adresse, og klik derefter på jeg har betalt for at springe til bekræftelsestrinet','ivepaid'=>'Jeg har betalt','nextstep'=>'Valider','step2'=>'For at sikre, at du, der sendte pengene, skal du indtaste de første 3 tegn og 3 sidste tegn i din Bitcoin-adresse','success'=>'Tak, betaling blev valideret med succes, vi behandler din ordre','failure'=>'Vi kan ikke validere din betaling. Prøv igen','tryagain'=>'Forsøge igen','validating'=>'We\'re validating Deres betaling behage vente','thankyou'=>'Takke De','transactionid'=>'Transaktion ID','validationfailure'=>'Beklager, vi kan ikke finde din transaktion, eller den er stadig ikke bekræftet. Prøv venligst igen'));
}
if($_GET['lang'] == 'en' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'Pay Using Cryptocurrencies','guide0'=>'You\'re going to pay','guide1'=>'To ensure that you who sent the money, please insert first 3 charcters & last 3 charcters of your address','guide'=>'Pay using this qr or send to the next address then click i\'ve paid','ivepaid'=>'I\'ve paid','nextstep'=>'Next step','step2'=>'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address','success'=>'Thank you, payment were validated successfully, we\'re processing your order','failure'=>'We can\'t validate your payment, please try again','tryagain'=>'Try again','validating'=>'We\'re validating your payment please wait','thankyou'=>'Thank you','transactionid'=>'Transaction ID','validationfailure'=>'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
}
if($_GET['lang'] == 'nl' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'Betalen met Cryptovaluta','guide0'=>'U bevinden olivier te betalen','guide1'=>'Te waarborgen waarin u who wil gestuurd het geld, alstublieft “verzet” eerste 3 tekens & laatste 3 tekens van uw sleutelvraag','guide'=>'Betaal met qr of verzend de transactie naar het volgende adres en klik vervolgens op ik heb betaald om naar de verificatiestap te gaan','ivepaid'=>'Ik heb betaald','nextstep'=>'Valideren','step2'=>'Om er zeker van te zijn dat u het geld heeft verzonden, voert u de eerste 3 tekens en de laatste 3 tekens van uw Bitcoin-adres in','success'=>'Bedankt, de betaling is succesvol gevalideerd, we verwerken uw bestelling','failure'=>'We kunnen uw betaling niet valideren, probeer het opnieuw','tryagain'=>'Proberen wederom','validating'=>'Klaar gevalideerd uw betaling alstublieft afwachten','thankyou'=>'Dank u','transactionid'=>'Transactie ID','validationfailure'=>'Sorry, we kunnen uw transactie niet vinden of deze is nog steeds niet bevestigd, probeer het opnieuw'));
} 
if($_GET['lang'] == 'fr' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'Payer en utilisant Crypto-monnaies','guide0'=>'Te sommes allume à payent','guide1'=>'Pour garantir que vous ce qui envoyéz le monnaie, veuillez enterer le premier 3 charcters & le dernier 3 charcters de votre address','guide'=>'Payer en utilisant qr ou envoyer la transaction à l\'adresse suivante puis cliquez sur j\'ai payé pour passer à l\'étape de vérification','ivepaid'=>'J\'ai payé','nextstep'=>'Valider','step2'=>'Pour vous assurer que vous qui avez envoyé l\'argent, veuillez entrer les 3 premiers caractères et les 3 derniers caractères de votre adresse Bitcoin','success'=>'Merci, le paiement a été validé avec succès, nous traitons votre commande', 'failure'=>'Nous ne pouvons pas valider votre paiement, veuillez réessayer','tryagain'=>'Réessayer','validating'=>'Veuillez patientez Nous validons votre paiement','thankyou'=>'Merçi','transactionid'=>'Référence de la transaction','validationfailure'=>'Désolé, nous ne trouvons pas votre transaction ou elle n\'est toujours pas confirmée, veuillez réessayer'));
} 
if($_GET['lang'] == 'de' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'Zahlen Sie mit Kryptowährungen','guide0'=>'Sie sind Going zu zahlen','guide1'=>'Zu sicherzustellen jenes Sie wer wollt schickte die Geld, erfreuen Einfügen zuerst 3 zeichen & zuletzt 3 zeichen von euer kaufen Adresse','guide'=>'Bezahlen Sie mit qr oder senden Sie die Transaktion an die nächste Adresse. Klicken Sie dann auf Ich habe bezahlt, um zum Überprüfungsschritt zu springen','ivpaid'=>'Ich habe bezahlt','nextstep'=>'Bestätigen','step2'=>'Um sicherzustellen, dass Sie das Geld gesendet haben, geben Sie bitte die ersten 3 Zeichen und 3 letzten Zeichen Ihrer Bitcoin-Adresse ein','success'=>'Vielen Dank, die Zahlung wurde erfolgreich validiert. Wir bearbeiten Ihre Bestellung','failure'=>'Wir können Ihre Zahlung nicht bestätigen. Bitte versuchen Sie es erneut','tryagain'=>'Versuchen wieder','validating'=>'We\'re validating euer Zahlung erfreuen warten','thankyou'=>'dank eschön','transactionid'=>'Transaktion ID','validationfailure'=>'Entschuldigung, wir können Ihre Transaktion nicht finden oder sie ist noch nicht bestätigt, bitte versuchen Sie es erneut'));
} 
if($_GET['lang'] == 'he' ) {
    $sf = 'var messages ='.json_encode(array('pay'=>'שלם באמצעות מטבעותקריפטוגרפיים','guide0'=>'אַתָּה עשיריתדונם עֲזִיבָה לִכְבוֹד שִׁלֵּם','guide1'=>"To הִבְטִיחַ שֶׁ אַתָּה מִי רָצָה נשלח במידהש_ כֶּסֶף, בְּבַקָּשָׁה דברשהוכנס קֹדֶםכֹּל 3 צ'ארטרים & הדברהאחרון 3 צ'ארטרים שֶׁל שלך ביטקוין פָּנָה",'guide'=>'שלם באמצעות qr או שלח עסקה לכתובת הבאה ואז לחץ על שילמתי כדי לעבור לשלב האימות','ivepaid'=>'שילמתי','nextstep'=>'לְאַמֵת','step2'=>'כדי להבטיח ששלחת את הכסף, אנא הזן 3 תווים ראשונים ושלוש תווים אחרונים של כתובת ה שלך','success'=>'תודה, התשלום אומת בהצלחה, אנו מעבדים את הזמנתך','failure'=>'איננו יכולים לאמת את התשלום שלך. נסה שוב','tryagain'=>'נִסָּיוֹן שׁוּב','validating'=>'אנחנו+פועלעזרלציוןהווה(צורהמקוצרתשלweare) validating שלך תַּשְׁלוּם בְּבַקָּשָׁה הַמְתָּנָה','thankyou'=>'הוֹדָה אַתָּה','transactionid'=>'עִסְקָה (פסיכואנליזה)סְתָמִי','validationfailure'=>'מצטערים, אנחנו לא יכולים למצוא את העסקה שלך או שהיא עדיין לא אושרה, אנא נסה שוב'));
} 
        if($_GET['lang'] == 'hi' ){
            $sf = 'var messages ='.json_encode(array('pay'=>'क्रिप्टो मुद्राएँ का उपयोग करके भुगतान करें','guide0'=>'आप हैं जारहाहै को भुगतान करें','guide1'=>'को सुनिश्चित करें कि आप कौन होगा भेजा गया द पैसा, कृपया। सम्मिलित करें पहले 3 charcters & अंतिम 3 charcters का आपका Bitcoin पता ','guide'=>'qr का उपयोग करके भुगतान करें या अगले पते पर लेन-देन भेजें फिर क्लिक करें मैंने सत्यापन चरण पर जाने के लिए भुगतान किया है','ivepaid'=>'मैंने भुगतान किया है','nextstep'=>'सत्यापित करें','step2'=>'यह सुनिश्चित करने के लिए कि आपने पैसा किसने भेजा है, कृपया अपने पते के पहले 3 चरित्र %