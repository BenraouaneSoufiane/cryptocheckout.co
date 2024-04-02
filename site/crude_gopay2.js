function showbtn(amnt)
{
    amount = amnt;
    var fresponse = [];
    (function ($) {
        
        if(typeof amount !=='undefined' ) {
            $('#'+div).append('<div style="width:336px" id="cntnr0" ><button id="pay" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://crypto.hirak.site/favicon.png);display: block;margin-right: 10px;top: 5px"></span>'+messages.pay+'</button>');
            if(amount.usd !== '' && amount.usd !==null && amount.usd !== 0 ) {
                $.each(
                    curr,function (i,j) {  
                        if(j =='btc' ) {
                            if(typeof amount.btc !== 'undefined' && typeof address.btc !== 'undefined' ) {
                                $.get(
                                    'https://crypto.hirak.site/?address='+address.btc+'&amount='+amount.btc,function (response) {
                                        $('#cntnr0').append('<div id="cntnr" style="clear:both"><div type="'+j+'" id="'+j+'"><span class="cryptoicons" type="'+j+'" id="'+j+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://crypto.hirak.site/'+j+'.png\');float:left;background-position: center;background-repeat: no-repeat;"></span></div></div></div>');
                                        $('#cntnr0 #btc').append('<p class="guide0" type="'+j+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+amount.j+j.toUpperCase()+'</p><img id="qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://crypto.hirak.site/btc/'+address.btc+amount.btc+'.png" ><p id="address" type="'+j+'" style="display:none;text-align: center">'+address.btc+'</p>');
                                        guide0();
                                    }
                                );
                            }else if(typeof address.btc !== 'undefined' ) {
                                $.get(
                                    'https://rates.hirak.site/rate.php?from=usd&to=btc&token=6fd8404714f243391d3f125910b4338a',function (btcresponse) {
                                        $.get(
                                            'https://crypto.hirak.site/?address='+address.btc+'&amount='+Number(fresponse.rate).toFixed(6).toString(),function (response1) {
                                                if(btcresponse.to == 'BTC' ) {
                                                    $('#cntnr0').append('<div id="cntnr" style="clear:both" ><div type="'+btcresponse.to.toLowerCase()+'" id="'+btcresponse.to.toLowerCase()+'"><span class="cryptoicons" type="'+btcresponse.to.toLowerCase()+'" id="'+btcresponse.to.toLowerCase()+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://crypto.hirak.site/'+btcresponse.to.toLowerCase()+'.png\');float:left;background-position: center;background-repeat: no-repeat;"></span></div></div></div>');
                                                    $('#cntnr0 #'+btcresponse.to.toLowerCase()).append('<p class="guide0" type="'+btcresponse.to.toLowerCase()+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+Number(amount.usd)*Number(btcresponse.rate).toFixed(6).toString()+btcresponse.to+'</p><img id="qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://crypto.hirak.site/btc/'+address.btc+Number(btcresponse.rate).toFixed(6).toString()+'.png" ><p id="address" type="'+btcresponse.to.toLowerCase()+'" style="display:none;text-align: center">'+address.btc+'</p>');
                                                    guide0();
                                                }
                                    
                                            }
                                        ); 
                                    }
                                );                           
                            }
                        
                        }else if(typeof address[j] !== 'undefined' ) {
                
                            if(typeof amount.j !== 'undefined' ) {
                                $('#cntnr0').append('<div id="cntnr" style="clear:both" ><div type="'+j+'" id="'+j+'"><span class="cryptoicons" type="'+j+'" id="'+j+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://crypto.hirak.site/'+j+'.png\');float:left;background-position: center;background-repeat: no-repeat;"></span></div></div></div>');
                                $('#cntnr0 #'+j).append('<p class="guide0" type="'+j+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+amount.j+j.toUpperCase()+'</p><p id="address" type="'+j+'" style="display:none;text-align: center">'+address.j+'</p>');
                                guide0();
                            }else{
                                $.get(
                                    'https://rates.hirak.site/rate.php?from=usd&to='+j+'&token=6fd8404714f243391d3f125910b4338a',function (response) {
                                        $('#cntnr0').append('<div id="cntnr" style="clear:both" ><div type="'+response.to.toLowerCase()+'" id="'+response.to.toLowerCase()+'"><span class="cryptoicons" type="'+response.to.toLowerCase()+'" id="'+response.to.toLowerCase()+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://crypto.hirak.site/'+response.to.toLowerCase()+'.png\');float:left;background-position: center;background-repeat: no-repeat;"></span></div></div></div>');
                                        $('#cntnr0 #'+response.to.toLowerCase()).append('<p class="guide0" type="'+response.to.toLowerCase()+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+Number(amount.usd)*Number(response.rate).toFixed(6).toString()+response.to+'</p><p id="address" type="'+response.to.toLowerCase()+'" style="display:none;text-align: center">'+address[response.to.toLowerCase()]+'</p>');
                                        guide0();
                                    }
                                );
                            }
                        }

                    }
                );
                
            }

            /*$('.cryptoicons').on('click',function(){
               type = $(this).attr('type');
               
               $('#cntnr0 #'+type).append('<p id="guide1" style="display:block;text-align: left;float:left">'+messages.guide1+'</p>');
               $('#cntnr0 #'+type).append('<input id="source" style="display: inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="XXXXXX" maxlength=6/><button id="nextstep" style="position:relative;display:inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;left:10px"><span style="position: relative;display:inline-block;background-image: url(https://crypto.hirak.site/right.png);width:30px;height:18px;background-position:center;background-repeat: no-repeat"></span></button>');

            });*/
            $(document).ready(
                function () {

                }
            );
            
            
            $('#pay').on(
                'click',function (e) {
                    e.preventDefault();              
                    $('.cryptoicons, .guide0').show();               
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
function guide0(type)
{
    (function ($) {
        $('.guide0').on(
            'click',function () {
                type = $(this).attr('type');
                if($('#guide1').length !== 0 ) {
                     $('#guide1,#source,#nextstep').appendTo('#cntnr0 #'+type);
                }else{
                    $('#cntnr0 #'+type).append('<p id="guide1" style="display:block;text-align: left;float:left">'+messages.guide1+'</p>');
                    $('#cntnr0 #'+type).append('<input id="source" style="display: inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="XXXXXX" maxlength=6/><button id="nextstep" style="position:relative;display:inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;left:10px"><span style="position: relative;display:inline-block;background-image: url(https://crypto.hirak.site/right.png);width:30px;height:18px;background-position:center;background-repeat: no-repeat"></span></button>');
                }
                $('#nextstep').on(
                    'click',function (e) {
                        if($('#source').val() !=='' && $('#source').val().length == 6 ) {
                            $('.cryptoicons').remove();
                            $('#cntnr0 #'+type).prepend('<p id="guide3" style="text-align:center">Please pay then click i\'ve payed when complete to process to the confirmation step</p>');
                            $('#cntnr0 #'+type).prepend('<span id="'+type+'icon" style="width: 32px;height: 32px;display: block;background-image: url(\'https://crypto.hirak.site/'+type+'.png\');margin-right:auto;margin-left:auto"></span>');
                       
                            $.get(
                                'https://crypto.hirak.site/?submit='+$('#source').val()+'&amount='+amount[type]+'&curr='+type,function (response) {
                                    hash = response.result;
                                }
                            );
                            $('.guide0,#guide1,#source').remove();
                            $('#nextstep').remove();
                            $('#cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');
                            $('#cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://crypto.hirak.site/'+type+'.png);display: block;margin-right: 10px;top:5px"></span>'+messages.ivepaid+'</button>');
                            if(type == 'btc' ) {
                                $('#qr').show();
                                $('#qr').css('display','block');
                            }
                            $('[id="address"][type="'+type+'"]').show();
                       
                            $('button#ivepaid').on(
                                'click',function (e) {
                                    e.preventDefault();
                                    $('#qr,#address').remove();
                                    $('#guide3').text(messages.validating);
                                    $('button#ivepaid').attr('disabled','true');
                                    $('#loader').show();
                            

                                    $.get(
                                        'https://crypto.hirak.site/?hash='+hash+'&as='+as+'&type='+type,function (response) {
                                            if(response.result == 'success') {
                                                  $('#guide3').text(messages.thankyou+', '+messages.transactionid+': '+response.transactionId.universal);
                                                  $('#loader').remove();
                                                  $('button#ivepaid').remove();
                                                  onApprove(response.transactionId.local);
                                            }else{
                                                $('#loader').hide();
                                                $('#guide3').text(messages.validationfailure);
                                                $('button#ivepaid').text(messages.tryagain);
                                                $('button#ivepaid').removeAttr('disabled');
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
                $('#source').on(
                    'keypress',function (e) {
                        if(e.which == 13 ) {
                            if($('#source').val() !=='' && $(this).val().length == 6 ) {
                                $('.cryptoicons').remove();
                                $('#cntnr0 #'+type).prepend('<p id="guide3" style="text-align:center">Please pay then click i\'ve payed when complete to process to the confirmation step</p>');
                                $('#cntnr0 #'+type).prepend('<span id="'+type+'icon" style="width: 32px;height: 32px;display: block;background-image: url(\'https://crypto.hirak.site/'+type+'.png\');margin-right:auto;margin-left:auto"></span>');

                                $.get(
                                    'https://crypto.hirak.site/?submit='+$(this).val()+'&amount='+amount.type+'&curr='+type,function (response) {
                                        hash = response.result;
                                    }
                                );
                                $('.guide0,#guide1,#source').remove();
                                $('#nextstep').remove();
                                $('#cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');

                                $('#cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://crypto.hirak.site/favicon.png);display: block;margin-right: 10px;top:5px"></span>'+messages.ivepaid+'</button>');

                                if(type == 'btc' ) {
                                     $('#qr').show();
                                     $('#qr').css('display','block');
                                }
                                $('[id="address"][type="'+type+'"]').show();
                                $('button#ivepaid').on(
                                    'click',function (e) {
                                        e.preventDefault();
                                        $('#qr,#address').remove();
                                        $('#guide3').text(messages.validating);                            
                                        $('#loader').show();
                            
                                        $('button#ivepaid').attr('disabled','true');

                                        $.get(
                                            'https://crypto.hirak.site/?hash='+hash+'&as='+as+'&type='+type,function (response) {
                                                if(response.result == 'success') {
                                                    $('#guide3').text(messages.thankyou+', '+messages.transactionid+': '+response.transactionId.universal);
                                                    $('#loader').remove();
                                                    $('button#ivepaid').remove();
                                                    onApprove(response.transactionId.local);

                                                }else{
                                                    $('#loader').hide();
                                                    $('#guide3').text(messages.validationfailure);
                                                    $('button#ivepaid').text(messages.tryagain);
                                                    $('button#ivepaid').removeAttr('disabled');
                                                }
                                            }
                                        );
                                    }
                                );
                            }else{
                                alert('You must enter first 3 charcters & last 3 charcters of your Bitcoin address to continue');
                            }
                        }
                   
                    }
                );               
            }
        );
    })(jQuery);
}
