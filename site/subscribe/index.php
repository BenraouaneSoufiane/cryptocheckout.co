<?php

require "../txtdb.php";
$db = new TxtDb();


function pp_access_token()
{
    define('PAYPAL_CLIENT_ID', 'AVyX7dPbFnfjWS2MwZJwzBpSThEVIxfMHI4TrY2NakTDtYbpY3M1lChB42a9WacS9v-bqWYrFFzK6EnZ');
    define('PAYPAL_SECRATE_KEY', 'EAlirF2Yu3FFZdGb9qQkXvl2yGZLrg5PNJAoAMeukoF0AZokXBGkhY492nf5x7xgiVDpZSVuWIQiivgp');
    // Get access token from PayPal client Id and secrate key
            $ch = curl_init();
            
            //curl_setopt($ch,CURLOPT_CAINFO ,"C:/xampp/perl/vendor/lib/Mozilla/CA/cacert.pem");
            curl_setopt($ch, CURLOPT_URL, "https://api.paypal.com/v1/oauth2/token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRATE_KEY);

            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Accept-Language: en_US";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $results = curl_exec($ch);
            $getresult = json_decode($results);
            return $getresult->access_token;
}

function get_net_amount($order_id)
{
    $ch = curl_init();
            
            //curl_setopt($ch,CURLOPT_CAINFO ,"C:/xampp/perl/vendor/lib/Mozilla/CA/cacert.pem");
            curl_setopt($ch, CURLOPT_URL, "https://api.paypal.com/v2/payments/captures/".$order_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $headers = array();
            $headers[] = "Content-Type: application/json";
            $headers[] = "Authorization: Bearer ".pp_access_token();

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $results = curl_exec($ch);
            $getresult = json_decode($results);
    if (isset($getresult->seller_receivable_breakdown->net_amount) && $getresult->seller_receivable_breakdown->net_amount !=='') {
        $net_amount = $getresult->seller_receivable_breakdown->net_amount->value;
        $gross_amount = $getresult->seller_receivable_breakdown->gross_amount->value;
        $currency = $getresult->seller_receivable_breakdown->gross_amount->currency_code;
    }else{
        $net_amount = 'non authorized';
        $gross_amount = 'non authorized';
    }
            
            return array($gross_amount,$net_amount,$currency);

}


if(isset($_GET['transactionId'])  ) {
    
    if(get_net_amount($_POST['transactionId']) == '1.00' ) {
        mail("visits@hirak.cc", "new subscription activated", "hello new visit from".$_SERVER['HTTP_REFERER'].json_decode(file_get_contents("http://iplocation.hirak.cc/?ip=".$_SERVER['REMOTE_ADDR']))->country.$_GET['link']);
        include "../txtdb.php";
        $db = new TxtDb();
        $token = md5('zirou'.strval(round(microtime(true)*1000)));
        $db->insert('tokens', ['token'=>$token]);
        header('Content-Type: application/json');
        echo json_encode(array('result'=>'success','token'=>$token));
        die();
    }else{
        header('Content-Type: application/json');
        echo json_encode(array('result'=>'failure'));
        die();
    }
}else{
    
    
    
    ?>
<!doctype html>
<html style="background-color:#bff4ed;font-family: Arial;">
<head>
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon.png" />
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <script type="text/javascript" src="/jquery.min.js"></script>
</head>
<body style="background-color:#bff4ed;font-family: Arial;" >
    <div id="greeting" style="position: relative;width: 55%;margin-right:auto;margin-left:auto;margin-top:80px">
        <h1 style="text-align: center">Here's to subscribe & unlock sending crypto from your address!</h1>
        <div id="test2" style="display: block;clear: both;width: 76%; margin-top: 50px; margin-right: auto; margin-left: auto" >
            <?php
            if(isset($_GET['pin']) ) {
                $pin = $db->select('merchants', array('pin'=>$_GET['pin']));
                if(!empty($pin) ) {
                    ?>
                    <p id="gwdesc" style="text-align: center;margin-bottom:20px;margin-top:0px">You've exceed the limit by:</p>
                    <?php
                }else{
                    ?>
                    <p id="gwdesc" style="text-align: center;margin-bottom:20px;margin-top:0px">We don't found that account pin:<?php echo $_GET['pin'] ?></p>
                    <?php
                }
            }
            ?>
            <p id="gwdesc" style="text-align: center;margin-bottom:20px;margin-top:0px">e</p>
            <label for="receivable">Please</label>
            <input id="receivable" type="text" maxlength="10" placeholder="Type how much receive in a month" style="margin-bottom: 20px;width: 89%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px"/>
            <select id="gwcurr" style="border: none;background-color: white;height: 45px;border-radius: 10px;bottom: 3.5px;position: relative;" >
                <option value="btc" default selected>BTC</option>
                <option value="eth">ETH</option>
                <option value="sol">SOL</option>
            </select>
            <label for="email">Your email (<a href="https://crypto.hirak.site/why" target="_blank">why?</a>)</label>
            <input id="email" type="email" placeholder="Your email address" style="width: 100%;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px"/>
            <button class="new" type="btc" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://crypto.hirak.site/btc.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="eth" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://crypto.hirak.site/eth.png');background-repeat: no-repeat;background-position: center"></button>
            <button class="new" type="sol" style="width:50px;font-size:16px;border: none;background-color: azure;height:50px;border-radius:25px;margin-top:20px;position:relative;background-image: url('https://crypto.hirak.site/sol.png');background-repeat: no-repeat;background-position: center"></button>
            <div class="captcha" style="width: 100px;margin-top: 20px;">
                    <?php
                    $captcha = new CaptchaBuilder();
                    $captcha->build();
                    $_SESSION['phrase']=$captcha->getPhrase();
                    if($_SESSION['did']!==true) {
                        $_SESSION['did']=false;
                    }
                    
                    ?>
                    <img style="display: block;  margin-right: auto;  margin-left: auto;  margin-top: 5px;border-radius: 10px" src="<?php echo $captcha->inline(); ?>" />
                    <input id="captcha" style="width: 100%;line-height: 2;font-size: 22px;margin-top: 5px;border: none;border-radius: 10px;" type="text" maxlength="5" placeholder="XXXXX"  />
                    
                </div>
            <div id="all" style="float:right;margin-bottom: 30px;width: 100%;font-size: 16px;border: none;background-color: azure;height: 50px;border-radius: 10px;margin-top: 20px;position: relative;" class="snippet" data-title=".dot-flashing">
                <p id="alltext" style="text-align: center;position:relative;right:10px">Generate</p><span id="allicon" style="width: 21px;height: 21px;background-image: url(https://crypto.hirak.site/right.png);position: relative;margin-right: auto;margin-left: auto;position: relative;display: block;left: 46px;bottom: 35px;"></span>
               <div class="stage" style="position:relative;top:20px;left:20px;margin-left:auto;margin-right:auto;display:block;width:10%">
                 <div class="dot-flashing"></div>
               </div>
            </div>
            <div id="paypal-button-container" style="position: relative; top:20px;clear:both"></div>
            <div id="cc" style="position: relative; margin-left: auto;margin-right: auto;display: block; width: 56%;margin-top:20px"></div>
            <div id="raddr"></div>
            <script>
                
            </script>
        </div>
        <script>
            var curr0 = fresponse = '',downlaod = appended = ppinitiated = false, receivable = cost = ourfee = 0, regex = new RegExp(/^\+?[0-9(),.-]+$/);
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
           
                (function($){
                    
                   $('.new').on('click', function(){
                        
                        btn = $(this);
                        if( btn.attr('disabled') !== true ){
                        if( $('#email').val() !=='' ){
                            if( isEmail($('#email').val()) ){
                                if( btn.attr('isgreen') == 'true' && curr0.length > 4 ){
                                    btn.css({'background-color':'azure','background-image':'url(\'https://crypto.hirak.site/'+btn.attr('type')+'.png\''});
                                    btn.attr('isgreen','false');
                                    
                                    if( curr0.indexOf(btn.attr('type')+'+') >= 0 ){
                                        curr0 = curr0.replace(btn.attr('type')+'+','');
                                    }else{
                                        curr0 = curr0.replace(btn.attr('type'),'');
                                    }                                                                       
                                }else{
                                    btn.css({'background-color':'#5cd758','background-image':'url(\'https://crypto.hirak.site/check.png\''});
                                    btn.attr('isgreen','true');
                                    if( curr0.indexOf(btn.attr('type')) < 0 || curr0 =='' ){
                                        curr0 += btn.attr('type');
                                        if( curr0.length !== 0 && curr0.charAt(curr0.length-1) !=='+'){
                                            curr0 += '+';
                                        }
                                    }
                                    if( $('#receivable').val() !=='' && $('#receivable').val().match(regex) ){
                                       
                                        if( cost >= 50 && cost !== 0 && ( ppinitiated == false || receivable !== parseFloat($('#receivable').val()) ) ){
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
                                    $.get('https://crypto.hirak.site/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=pp',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://crypto.hirak.site/download.png\'');
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
                                      showbtn('cc',{usd:ourfee},function onApprove(transactionId){
                                          (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://crypto.hirak.site/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=cc',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://crypto.hirak.site/download.png\'');
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
                                      },function onError(error){});    
                                    }}
                                }
                                alert(curr0);
                            }else{
                                alert('Please insert valid email address');
                            }
                            
                            
                        }else{
                            alert('Email address is required');
                        }
                        }
                    });
                    $('#all').on('click',function(e){
                        if( downlaod == false ){
                            if( $('#email').val() !=='' ){
                                if( isEmail($('#email').val()) ){
                                    if( $('#captcha').val() !=='' && $('#captcha').val().length == 5 ){
if( curr0 !== '' ){
                                    $('#alltext,#allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://crypto.hirak.site/?new='+curr0+'&email='+$('#email').val()+'&captcha='+$('#captcha').val()+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val(),function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://crypto.hirak.site/download.png\'');
                                        downlaod = true;
                                        $('.new').remove();
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
                                    alert('Please insert valid email address');
                                }
                            }else{
                                alert('Email address is required');
                            }

                        }else if( $('#email').val() == '' ){
                            alert('Empty confirmation code');
                        }else if ($('#email').val().length == 6 ){
                            try{
                                window.location.assign('https://crypto.hirak.site/?as='+JSON.parse(('{"privatekey":'+(atob(sf_decode(fresponse,$('#email').val()))).substring(14)).replace("\n",''))['as']);

                            }catch(e){
                                alert('Wrong confirmation code');
                            }
                            
                           
                        }else{
                            alert('Wrong confirmation code');
                        }
                                                
                        
                    });
                    
                    $('#email').on('change',function(){
                       if( downlaod == true ){
                            email = $(this);
                            if( email.val().length == 6 ){
                                                           
                                try{
                                    let r = JSON.parse(('{"privatekey":'+(atob(sf_decode(fresponse,email.val()))).substring(14)).replace("\n", ""));

                                    if( appended == false){
                                    var y = 1;

                                        $.each( r[Object.keys(JSON.parse(('{"privatekey":'+(atob(sf_decode(fresponse,email.val()))).substring(14)).replace("\n", "")))[1]],function(i,j){                                
                                            $('#raddr').append('<p style="text-align: center" >Your '+i+' address is: <br/>'+j );
                                            
                                            if( y == Object.keys(r['address']).length ){
                                                 $('#raddr').append('<p style="text-align: center" >Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/app</p><br/>' );
                                                 $('#raddr').append('<p style="text-align: center; color: red" >Your PIN is: '+r['pin']+' used to send crypto on the site from your wallets, COPY PASTE IN TOP SECRET PLACE</p><br/>' );
                                                 appended = true;
                                            }
                                            y = y+1;
                                        });}
                                }catch(e){
                                    alert(e);
                                }                                
                            }
                            
                        }else if( $('#receivable').val() !=='' && $('#receivable').val().match(regex) ){
                            
                            
                           if( cost <= 50 && cost !== 0 ){
                               $('#all, .captcha').show();
                               $('#all .stage').hide();
                           }else{
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
                                    $.get('https://crypto.hirak.site/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+receivable+'&gwcurr='+$('#gwcurr').val()+'&pt=pp',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://crypto.hirak.site/download.png\'');
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
                                              showbtn('cc',{usd:ourfee},function onApprove(transactionId){
                                          (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://crypto.hirak.site/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=cc',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://crypto.hirak.site/download.png\'');
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
                                      },function onError(error){});
                                        }else{
                                            alert('Please select at least one currency to continue');
                                        }
                                   }else{
                                       alert('Please enter a valid email address to continue');
                                   }
                               }else{
                                   alert('Email is required');
                               }
                           }
                        }

                    })
                    $('#import').on('click', function(){
                        btn = $(this);
                       if( $('#wif').val() !=='' ){
                            if( $('#email').val() !=='' ){
                               btn.val('Working...');
                               $.get('https://crypto.hirak.site/?new=exist&email='+$('#email').val()+'&wif='+$('#wif').val(), function(response){
                                    if( response !=='' ){
                                        $('#test2').append('<p style="text-align: center" >Your WIF is: <br/>'+response.privatekey+'<br/>Your address Bitcoin address is: '+response.address+'<br/>Your ID associated with your new wallet is: '+response.as+'</p>');                          
                                    }
                                });
                            }else{
                                alert('Email is empty!');
                                alert('You have not set the email for payment notifications, you\'ll not know how many coins in your wallet!');
                                btn.val('Working...');
                                $.get('https://crypto.hirak.site/?new=exist&email='+$('#email').val()+'&wif='+$('#wif').val(), function(response){
                                    if( response !=='' ){
                                        $('#test2').append('<p style="text-align: center" >Your WIF is: <br/>'+response.privatekey+'<br/>Your address Bitcoin address is: '+response.address+'<br/>Your ID associated with your new wallet is: '+response.as+'</p>');                          
                                    }
                                });
                            }
                       }else{
                           alert('WIF is empty!');
                       } 
                    });
                    
                    $('#all, .captcha').hide();
                    $('#receivable').on('change',function(){
                        rinput = $(this);    
                        previousval = rinput.val();
                        if( $(this).val().match(regex) ){
                            receivable = parseFloat($(this).val());
                            rinput.val('Working, please wait...');
                            $('#gwcurr, #email, .new').attr('disabled','true');
                            $('#gwcurr').css('background-color','#dffaf6');
                            
                            rinput.attr('disabled','true');
                        $.get('https://rates.hirak.site/rate.php?from='+$('#gwcurr').val()+'&to=usd&token=6fd8404714f243391d3f125910b4338a',function(response){
                            cost = (receivable*parseFloat(response.rate.replace(',',''))).toFixed(2);
                            rinput.val(previousval);
                            rinput.removeAttr('disabled');
                            $('#gwcurr, #email, .new').removeAttr('disabled');
                            $('#gwcurr').css('background-color','white');
                           if( cost <= 50 && cost !== 0 ){
                               $('#all, .captcha').show();
                               $('#all .stage').hide();
                               alert('Please fill email field & select at least one currency & fill the captcha field');
                           }else{
                               if(cost >= 50 && cost < 100 ){
                                   ourfee = 1;
                               }else if( cost >= 100 && cost < 150 ){
                                   ourfee = 1.5;
                               }else if( cost >= 150 && cost < 400 ){
                                   ourfee = 2;
                               }else{
                                   ourfee = (0.5*receivable/100*parseFloat(response.rate.replace(',',''))).toFixed(2);
                               }
                               
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
                                    $.get('https://crypto.hirak.site/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=pp',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        $('#allicon').css('background-image','url(\'https://crypto.hirak.site/download.png\'');
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
                                      showbtn('cc',{usd:ourfee},function onApprove(transactionId){
                                          (function($){
                                            alert('Working please wait a moment...');
                                            $('#alltext, #allicon').hide();
                                    $('#all .stage').show();
                                    $.get('https://crypto.hirak.site/?new='+curr0+'&email='+$('#email').val()+'&transactionId='+transactionId+'&receivable='+$('#receivable').val()+'&gwcurr='+$('#gwcurr').val()+'&pt=cc',function(response){
                                        $('#all .stage').hide();
                                        $('#alltext, #allicon').show();
                                        if( response.result == true ){ 
                                        $('label[for="email"]').text('Confirmation code were sent to your email');
                                        $('#email').val('');
                                        $('#email').attr('placeholder','XXXXXX');
                                        $('#email').attr('maxlength',6);
                                        $('#email').attr('type','text');
                                        
                                        
                                        $('#allicon').css('background-image','url(\'https://crypto.hirak.site/download.png\'');
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
                                      },function onError(error){});      
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
                        }else{
                            alert('Please enter a valid number');
                        }
                        
                    });
                    
                    
                })(jQuery);
                
                
                
                
                    
                
                
            </script>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=AVyX7dPbFnfjWS2MwZJwzBpSThEVIxfMHI4TrY2NakTDtYbpY3M1lChB42a9WacS9v-bqWYrFFzK6EnZ&currency=USD" ></script>
    <div id="paypal-button-container" class="welcom" style="position: relative;margin-left: auto;margin-right: auto;width: 500px;margin-bottom: 50px;margin-top: 50px;"></div>
    <script>
    /*(function($){
        $(document).ready(function(){*/
            paypal.Buttons({
            locale: 'en_US',
            style: {
                color:  'blue',
                shape:  'pill',
                label:  'pay',
                height: 40,
            },
            createOrder: function(data, actions) {                      
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 1,
                        }
                    }]
                });                    
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    var transactionId = details.purchase_units[0].payments.captures[0].id;
                    (function($){
                        $.get('https://faceapi.hirak.cc/subscribe?transactionId='+transactionId, function(response){
                            if( response.result =='success' ){
                                alert('You have successfully unlock the quota limit, your token is '+response.token+', any issues: contact@hirak.cc,  thank you!');
                                $('#greeting').append(response.token);
                            }else{
                                alert('There is error to validate your payments, please contact contact@hirak.cc');
                            }
                        });
                    })(jQuery);
                });
            }
        }).render('#paypal-button-container');   

        /*});
        

        

        })(jQuery);*/
    </script>
</body>
<footer>
     <script>
        (function($){
            if( $(window).width() <= 1000 ){
                $('#greeting, #container, #greeting2, #paypal-button-container').css('width','90%');
                //$('#ip').css('width','100%');
                $('#container').css('margin-top','100px');
                //$('#uploader').css('margin-top','-50px');
                //$('#clicktoupload').css('top','200px');
            }
        
        })(jQuery);
    </script>
</footer>
</html>

    <?php

}



