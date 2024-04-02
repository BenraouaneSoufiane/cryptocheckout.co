function showbtn(div,amnt,onApprove,onError)
{
    
    var fresponse = [], transactionId='',amount = amnt;
    (function ($) {
        
        if(typeof amount !=='undefined' ) {
            $('#'+div).html('');
            $('#'+div).append('<div style="width:336px" id="cntnr0" ><button id="pay" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://getpayedcrypto.online/favicon.png);display: block;margin-right: 10px;top: 5px"></span>'+messages.pay+'</button>');

                $.each(
                    curr,function (i,j) {                
                        //if( j =='btc' ){
                        
                        if(typeof amount[j] !== 'undefined' && typeof address[j] !== 'undefined' ) {
                            $.get(
                                'https://getpayedcrypto.online/?address='+address[j]+'&amount='+amount[j]+'&curr='+j,function (response) {
                                    $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both"><div type="'+j+'" id="'+j+'"><span class="cryptoicons" type="'+j+'" id="'+j+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://getpayedcrypto.online/'+j+'.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                                    $('#'+div+' #cntnr0 #'+j).append('<p class="guide0" type="'+j+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+amount[j]+j.toUpperCase()+'</p><img id="'+j+'qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://getpayedcrypto.online/'+j+'/'+address[j]+amount[j]+'.png" ><p id="address" type="'+j+'" style="display:none;text-align: center">'+address[j]+'<span class="copy" style="position relative;height:21px;width:21px;background-image: url(\'https://getpayedcrypto.online/copy.png\');background-position: center;background-repeat: no-repeat;margin-left:20px;padding-top:7px;white-space: pre" type="'+j+'">    </span></p>');
                                    $('.copy').on(
                                        'click',function () {
                                            copy = $(this);
                                            navigator.clipboard.writeText($('[id="address"][type="'+copy.attr('type')+'"]').text().replace('    ',''));
                                            $(this).css('background-image','url(\'https://getpayedcrypto.online/copysuccess.png\')');
                                            setTimeout(
                                                function () {
                                                    copy.css('background-image','url(\'https://getpayedcrypto.online/copy.png\')');
                                                },3000
                                            );
                                        }
                                    );
                                    type = j;
                                    guide0(div,type,amount);
                                }
                            );
                        }else if(typeof address[j] !== 'undefined' ) {
                            $.get(
                                'https://rates.translatewp.online/rate.php?from=usd&to='+j+'&token=6fd8404714f243391d3f125910b4338a',function (rates) {
                                    $.get(
                                        'https://getpayedcrypto.online/?address='+address[j]+'&amount='+parseFloat(rates.rate).toFixed(6).toString()+'&curr='+j,function (response1) {
                                            if(rates.to == j.toUpperCase() ) {
                                                $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both" ><div type="'+rates.to.toLowerCase()+'" id="'+rates.to.toLowerCase()+'"><span class="cryptoicons" type="'+rates.to.toLowerCase()+'" id="'+rates.to.toLowerCase()+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://getpayedcrypto.online/'+rates.to.toLowerCase()+'.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                                                $('#'+div+' #cntnr0 #'+rates.to.toLowerCase()).append('<p class="guide0" type="'+rates.to.toLowerCase()+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+(parseFloat(amount.usd)*parseFloat(rates.rate)).toFixed(6).toString()+rates.to+'</p><img id="'+j+'qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://getpayedcrypto.online/'+j+'/'+address[j]+parseFloat(rates.rate).toFixed(6).toString()+'.png" ><p id="address" type="'+rates.to.toLowerCase()+'" style="display:none;text-align: center">'+address[j]+'<span class="copy" style="position relative;height:21px;width:21px;background-image: url(\'https://getpayedcrypto.online/copy.png\');background-position: center;background-repeat: no-repeat;margin-left:20px;padding-top:7px;white-space: pre" type="'+j+'">    </span></p>');                                                                                
                                                $('.copy').on(
                                                    'click',function () {
                                                        copy = $(this);
                                                        navigator.clipboard.writeText($('[id="address"][type="'+copy.attr('type')+'"]').text().replace('    ',''));
                                                        $(this).css('background-image','url(\'https://getpayedcrypto.online/copysuccess.png\')');
                                                        setTimeout(
                                                            function () {
                                                                copy.css('background-image','url(\'https://getpayedcrypto.online/copy.png\')');
                                                            },3000
                                                        );
                                                    }
                                                );
                                                amount[j.toLowerCase()]=(parseFloat(amount.usd)*parseFloat(rates.rate)).toFixed(6).toString();guide0(div);
                                                type=j;
                                                guide0(div,type,amount);
                                            }
                                        }
                                    ); 
                                }
                            );                           
                        }
                        
                        /*}else if( typeof address[j] !== 'undefined' ){                
                        if( typeof amount[j] !== 'undefined' ){
                            $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both" ><div type="'+j+'" id="'+j+'"><span class="cryptoicons" type="'+j+'" id="'+j+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://getpayedcrypto.online/'+j+'.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                            $('#'+div+' #cntnr0 #'+j).append('<p class="guide0" type="'+j+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+amount.j+j.toUpperCase()+'</p><p id="address" type="'+j+'" style="display:none;text-align: center">'+address.j+'</p>');
                            type=j.toLowerCase();
                            guide0(div,type,amount);
                        }else{
                            $.get('https://rates.translatewp.online/rate.php?from=usd&to='+j+'&token=6fd8404714f243391d3f125910b4338a',function(response){
                                $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both" ><div type="'+response.to.toLowerCase()+'" id="'+response.to.toLowerCase()+'"><span class="cryptoicons" type="'+response.to.toLowerCase()+'" id="'+response.to.toLowerCase()+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://getpayedcrypto.online/'+response.to.toLowerCase()+'.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                                $('#'+div+' #cntnr0 #'+response.to.toLowerCase()).append('<p class="guide0" type="'+response.to.toLowerCase()+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+(parseFloat(amount.usd)*parseFloat(response.rate)).toFixed(6).toString()+response.to+'</p><p id="address" type="'+response.to.toLowerCase()+'" style="display:none;text-align: center">'+address[response.to.toLowerCase()]+'</p>');                                
                                amount[j.toLowerCase()]=(parseFloat(amount.usd)*parseFloat(response.rate)).toFixed(6).toString();
                                type=j.toLowerCase();
                                guide0(div,type,amount);

                            });
                        }
                        }*/

                    }
                );
                
            

            /*$('.cryptoicons').on('click',function(){
               type = $(this).attr('type');
               
               $('#cntnr0 #'+type).append('<p id="guide1" style="display:block;text-align: left;float:left">'+messages.guide1+'</p>');
               $('#cntnr0 #'+type).append('<input id="source" style="display: inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="XXXXXX" maxlength=6/><button id="nextstep" style="position:relative;display:inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;left:10px"><span style="position: relative;display:inline-block;background-image: url(https://getpayedcrypto.online/right.png);width:30px;height:18px;background-position:center;background-repeat: no-repeat"></span></button>');

            });*/
            $(document).ready(
                function () {

                }
            );
            
            
            $('#'+div+' #pay').on(
                'click',function (e) {
                    e.preventDefault();              
                    $('#'+div+' .cryptoicons, #'+div+' .guide0').show();               
                    $(this).remove();                              
               
                }
            );
        }else{
            alert('Amount should not be empty');
        }
        
        
        

        /*$('#gppay').on('click',function(e){
            e.preventDefault();
            $('#gppay').text('Please complete the payment process');
            window.open('https://altpay-eps.com/my-account?referer='+window.location.href+'&merchant_id='+GOPAYClientKey+'&amount='+amount+'&currency='+GOPAYCurrency+'&title='+transactionTitle+'&quantity='+quantity,'GoPay','menubar=1,resizable=0,width=450,height=1080,top=x,left=y');
            var x = screen.width/2 - 700/2;
            var y = screen.height/2 - 450/2;
            var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
            var eventer = window[eventMethod];
            var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
            
            // Listen to message from child window
            eventer(messageEvent,function(e) {
                if( e.data.transactionId !=='' && e.data.transactionId !== null && sent === false){
                    onApprove(e.data.transactionId);
                    $('#gppay').text('Payment effectued successfully');
                    sent = true;
                }
                if( e.data.close !=='' && e.data.transactionId ==='' ){
                    $('#gppay').text('Payment cancelled');
                    onClose();
                }
                
                console.log('origin: ', e.origin)     
                // Check if orign is proper
                console.log('parent received message!: ', e.data);
                console.log('event method: ',eventMethod+messageEvent);
            });
        });*/
        
    })(jQuery);    
}
function guide0(div,type,amount)
{
    (function ($) {

        $('#'+div+' #'+type+' .guide0').on(
            'click',function () {
                //type = $(this).attr('type');
                if(type =='xmr') {
                    $('#'+div+' .cryptoicons').remove();
                    $('#'+div+' #cntnr0 #'+type).prepend('<p id="guide3" style="text-align:center">Please pay then click i\'ve payed when complete to process to the confirmation step</p>');
                    $('#'+div+' #cntnr0 #'+type).append('<input id="pp" style="width: 100%;display: inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="Paste here the Transaction key" maxlength=2000/>');

                    $('#'+div+' #cntnr0 #'+type).prepend('<span id="'+type+'icon" style="width: 32px;height: 32px;display: block;background-image: url(\'https://getpayedcrypto.online/'+type+'.png\');margin-right:auto;margin-left:auto;background-position: center;background-repeat: no-repeat"></span>');
                    $.get(
                        'https://getpayedcrypto.online/?submit=123456&amount='+amount[type.toLowerCase()]+'&curr='+type,function (response) {
                            hash = response.result;
                        }
                    );
                        $('#'+div+' .guide0,#'+div+' #guide1,#'+div+' #source').remove();
                        $('#'+div+' #nextstep').remove();
                         $('#'+div+' #cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');
                        $('#'+div+' #cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://getpayedcrypto.online/'+type+'.png);display: block;margin-right: 10px;top:5px;background-position: center;background-repeat: no-repeat"></span>'+messages.ivepaid+'</button>');
                        //if( type == 'btc' ){
                          $('#'+div+' #'+type+'qr').show();
                          $('#'+div+' #'+type+'qr').css('display','block');
                        //}
                        $('[id="'+div+'"] [id="address"][type="'+type+'"]').show();
                       
                        $('#'+div+' button#ivepaid').on(
                            'click',function (e) {
                                e.preventDefault();
                                $('#'+div+' #'+type+'qr,#'+div+' #address').remove();
                                $('#'+div+' #guide3').text(messages.validating);
                                $('#'+div+' button#ivepaid').attr('disabled','true');
                                $('#'+div+' #pp').attr('disabled','true');
                                $('#'+div+' #loader').show();
                            
                                //hash='976b619d5a98b37325cb1c9c308dccc8';
                                $.get(
                                    'https://getpayedcrypto.online/?hash='+hash+'&as='+as+'&type='+type+'&pp='+$('#pp').val(),function (response) {
                                        if(response.result == 'success') {
                                              $('#'+div+' #guide3').text(messages.thankyou+', '+messages.transactionid+': '+response.transactionId.universal);
                                              $('#'+div+' #pp').remove();
                                              $('#'+div+' #loader').remove();
                                              $('#'+div+' button#ivepaid').remove();
                                              onApprove(response.transactionId.local);
                                        }else{
                                            $('#'+div+' #loader').hide();
                                            $('#'+div+' #guide3').text(messages.validationfailure);
                                            $('#'+div+' button#ivepaid').text(messages.tryagain);
                                            $('#'+div+' button#ivepaid').removeAttr('disabled');
                                            $('#'+div+' #pp').removeAttr('disabled');
                                            onError(response);
                                        }
                                    }
                                );
                            }
                        );
                }else{
                    if($('#'+div+' #guide1').length !== 0 ) {
                        $('#'+div+' #guide1,#'+div+' #source,#'+div+' #nextstep').appendTo('#'+div+' #cntnr0 #'+type);
                    }else{
                        $('#'+div+' #cntnr0 #'+type).append('<p id="guide1" style="display:block;text-align: left;float:left">'+messages.guide1+'</p>');
                        $('#'+div+' #cntnr0 #'+type).append('<input id="source" style="display: inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="XXXXXX" maxlength=6/><button id="nextstep" style="position:relative;display:inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;left:10px"><span style="position: relative;display:inline-block;background-image: url(https://getpayedcrypto.online/right.png);width:30px;height:18px;background-position:center;background-repeat: no-repeat"></span></button>');
                    }
                    $('#nextstep').on(
                        'click',function (e) {
                            if($('#'+div+' #source').val() !=='' && $('#'+div+' #source').val().length == 6 ) {
                                $('#'+div+' .cryptoicons').remove();
                                $('#'+div+' #cntnr0 #'+type).prepend('<p id="guide3" style="text-align:center">Please pay then click i\'ve payed when complete to process to the confirmation step</p>');
                                $('#'+div+' #cntnr0 #'+type).prepend('<span id="'+type+'icon" style="width: 32px;height: 32px;display: block;background-image: url(\'https://getpayedcrypto.online/'+type+'.png\');margin-right:auto;margin-left:auto;background-position: center;background-repeat: no-repeat"></span>');
                                $.get(
                                    'https://getpayedcrypto.online/?submit='+$('#'+div+' #source').val()+'&amount='+amount[type.toLowerCase()]+'&curr='+type,function (response) {
                                        hash = response.result;
                                    }
                                );
                                $('#'+div+' .guide0,#'+div+' #guide1,#'+div+' #source').remove();
                                $('#'+div+' #nextstep').remove();
                                 $('#'+div+' #cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');
                                $('#'+div+' #cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://getpayedcrypto.online/'+type+'.png);display: block;margin-right: 10px;top:5px;background-position: center;background-repeat: no-repeat"></span>'+messages.ivepaid+'</button>');
                                //if( type == 'btc' ){
                                 $('#'+div+' #'+type+'qr').show();
                                 $('#'+div+' #'+type+'qr').css('display','block');
                                //}
                                $('[id="'+div+'"] [id="address"][type="'+type+'"]').show();
                       
                                $('#'+div+' button#ivepaid').on(
                                    'click',function (e) {
                                        e.preventDefault();
                                        $('#'+div+' #'+type+'qr,#'+div+' #address').remove();
                                        $('#'+div+' #guide3').text(messages.validating);
                                        $('#'+div+' button#ivepaid').attr('disabled','true');
                                        $('#'+div+' #loader').show();
                            
                                        //hash='ooYbw95dQrRn8UNz2JaEUAcvQbmAv2i3FJdDmqxnF8eVg6EGt26';
                                        $.get(
                                            'https://getpayedcrypto.online/?hash='+hash+'&as='+as+'&type='+type,function (response) {
                                                if(response.result == 'success') {
                                                    $('#'+div+' #guide3').text(messages.thankyou+', '+messages.transactionid+': '+response.transactionId.universal);
                                                    $('#'+div+' #loader').remove();
                                                    $('#'+div+' button#ivepaid').remove();
                                                    onApprove(response.transactionId.local);
                                                }else{
                                                    $('#'+div+' #loader').hide();
                                                    $('#'+div+' #guide3').text(messages.validationfailure);
                                                    $('#'+div+' button#ivepaid').text(messages.tryagain);
                                                    $('#'+div+' button#ivepaid').removeAttr('disabled');
                                                    onError(response);
                                                }
                                            }
                                        );
                                    }
                                );
                            }else{
                                alert('You must enter first 3 charcters & last 3 charcters of your Bitcoin address to continue');
                            }
                        }
                    );
                    $('#'+div+' #cntnr0 #'+type+' #source').on(
                        'keypress',function (e) {                                
                            if(e.which == 13 ) {
                                if($('#'+div+' #source').val() !=='' && $(this).val().length == 6 ) {
                                    $('#'+div+' .cryptoicons').remove();
                                    $('#'+div+' #cntnr0 #'+type).prepend('<p id="guide3" style="text-align:center">Please pay then click i\'ve payed when complete to process to the confirmation step</p>');
                                    $('#'+div+' #cntnr0 #'+type).prepend('<span id="'+type+'icon" style="width: 32px;height: 32px;display: block;background-image: url(\'https://getpayedcrypto.online/'+type+'.png\');margin-right:auto;margin-left:auto"></span>');

                                    $.get(
                                        'https://getpayedcrypto.online/?submit='+$(this).val()+'&amount='+amount[type.toLowerCase()]+'&curr='+type,function (response) {
                                            hash = response.result;
                                        }
                                    );
                                    $('#'+div+' .guide0,#'+div+' #guide1,#'+div+' #source').remove();
                                    $('#'+div+' #nextstep').remove();
                                    $('#'+div+' #cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');

                                    $('#'+div+' #cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://getpayedcrypto.online/'+type+'.png);display: block;margin-right: 10px;top:5px;background-position: center;background-repeat: no-repeat"></span>'+messages.ivepaid+'</button>');

                                    //if( type == 'btc' ){
                                    $('#'+div+' #'+type+'qr').show();
                                    $('#'+div+' #'+type+'qr').css('display','block');
                                    //}
                                    $('[id="'+div+'"] [id="address"][type="'+type+'"]').show();
                                    $('#'+div+' button#ivepaid').on(
                                        'click',function (e) {
                                            e.preventDefault();
                                            $('#'+div+' #qr,#'+div+' #address').remove();
                                            $('#'+div+' #guide3').text(messages.validating);                            
                                            $('#'+div+' #loader').show();
                            
                                            $('#'+div+' button#ivepaid').attr('disabled','true');
                                            hash = 'ooYbw95dQrRn8UNz2JaEUAcvQbmAv2i3FJdDmqxnF8eVg6EGt26';
                                            $.get(
                                                'https://getpayedcrypto.online/?hash='+hash+'&as='+as+'&type='+type,function (response) {
                                                    if(response.result == 'success') {
                                    
                                                        $('#'+div+' #guide3').text(messages.thankyou+', '+messages.transactionid+': '+response.transactionId.universal);
                                                        $('#'+div+' #loader').remove();
                                                        $('#'+div+' button#ivepaid').remove();
                                                        onApprove(response.transactionId.local);

                                                    }else{
                                                        $('#'+div+' #loader').hide();
                                                        $('#'+div+' #guide3').text(messages.validationfailure);
                                                        $('#'+div+' button#ivepaid').text(messages.tryagain);
                                                        $('#'+div+' button#ivepaid').removeAttr('disabled');
                                                        onError(response);
                                                    }
                                                }
                                            );
                                        }
                                    );
                                }else{
                                       alert('You must enter first 3 charcters & last 3 charcters of your address to continue');
                                }
                            }
                   
                        }
                    );  
                }
                            
            }
        );
    })(jQuery);
}