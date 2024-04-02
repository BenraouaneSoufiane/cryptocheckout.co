function showbtn(div,amnt,onApprove,onError){
    
    var fresponse = [], transactionId='',amount = amnt;
    (function($){
        
        if( typeof amount !=='undefined' ){
            $('#'+div).html('');
                                        $('#'+div).append('<div style="width:336px;clear:both;position:relative" id="cntnr0" ><button id="pay" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://cryptocheckout.co/favicon.png);display: block;margin-right: 10px;top: 5px"></span>'+messages.pay+'</button>');
              if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                            $('#'+div+' #cntnr0').css('width','100%');
        $('#'+div+' #cntnr0 #pay').css({'width':'100%','height':'150px','font-size':'42px'});
        $('#'+div+' #cntnr0 #pay span').css({'width':'100px','height':'100px','font-size':'42px','background-image':'url("https://cryptocheckout.co/gpc-m.png")'});
       

              }


              

                $.each(curr,function(i,j){                
                    //if( j =='btc' ){
                        
                        if( typeof amount[j] !== 'undefined' && typeof address[j] !== 'undefined' ){

                            $.get('https://cryptocheckout.co/?address='+address[j]+'&amount='+(parseFloat(amount[j])*parseFloat(amount.usd)).toFixed(6).toString()+'&curr='+j,function(response){
                                if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                                   $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both;width:100%;display:block;margin-right:auto;margin-left:auto"><div type="'+j+'" id="'+j+'"><span class="cryptoicons" type="'+j+'" id="'+j+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://cryptocheckout.co/'+j+'.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                                   $('#'+div+' #cntnr0 #'+j).append('<p class="guide0" type="'+j+'" style="display:inline-block;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+(parseFloat(amount[j])*parseFloat(amount.usd)).toFixed(6).toString()+j.toUpperCase()+'</p><img id="'+j+'qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://cryptocheckout.co/'+j+'/'+response.result+'.png" ><p id="address" type="'+j+'" style="display:none;text-align: center">'+address[j]+'<span class="copy" style="position relative;height:21px;width:21px;background-image: url(\'https://cryptocheckout.co/copy.png\');background-position: center;background-repeat: no-repeat;margin-left:20px;padding-top:7px;white-space: pre" type="'+j+'">     </span></p>');
                                }else{
                                    $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both"><div type="'+j+'" id="'+j+'"><span class="cryptoicons" type="'+j+'" id="'+j+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://cryptocheckout.co/'+j+'.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                                    $('#'+div+' #cntnr0 #'+j).append('<p class="guide0" type="'+j+'" style="display:inline-block;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+(parseFloat(amount[j])*parseFloat(amount.usd)).toFixed(6).toString()+j.toUpperCase()+'</p><img id="'+j+'qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://cryptocheckout.co/'+j+'/'+response.result+'.png" ><p id="address" type="'+j+'" style="display:none;text-align: center">'+address[j]+'<span class="copy" style="position relative;height:21px;width:21px;background-image: url(\'https://cryptocheckout.co/copy.png\');background-position: center;background-repeat: no-repeat;margin-left:20px;padding-top:7px;white-space: pre" type="'+j+'">     </span></p>');

                                }
                                $('.copy').on('click',function(){
                                    copy = $(this);
                                    navigator.clipboard.writeText($('[id="address"][type="'+copy.attr('type')+'"]').text().replace('     ',''));
                                    $(this).css('background-image','url(\'https://cryptocheckout.co/copysuccess.png\')');
                                    setTimeout(function(){
                                        copy.css('background-image','url(\'https://cryptocheckout.co/copy.png\')');
                                    },3000);
                                });
                                type = j;
                                guide0(div,type,amount);
                            });
                        }else if( typeof address[j] !== 'undefined' ){
                            $.get('https://rates.translatewp.online/rate.php?from=usd&to='+j+'&token=6fd8404714f243391d3f125910b4338a',function(rates){

                                $.get('https://cryptocheckout.co/?address='+address[j]+'&amount='+(parseFloat(amount.usd)*parseFloat(rates.rate)).toFixed(6).toString()+'&curr='+j,function(response1){
                                    if( rates.to == j.toUpperCase() ){
                                        if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                                        $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both;display:block;margin-right:auto;margin-left:auto;width:100%" ><div type="'+rates.to.toLowerCase()+'" id="'+rates.to.toLowerCase()+'"><span class="cryptoicons" type="'+rates.to.toLowerCase()+'" id="'+rates.to.toLowerCase()+'icon" style="display:inline-block;float:left;clear:both;width: 200px;height: 200px;display: none;background-image: url(\'https://cryptocheckout.co/'+rates.to.toLowerCase()+'-m.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                                        $('#'+div+' #cntnr0 #'+rates.to.toLowerCase()).append('<p class="guide0" type="'+rates.to.toLowerCase()+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;margin-right:auto;margin-left:auto;font-size:32px">'+messages.guide0+' '+(parseFloat(amount.usd)*parseFloat(rates.rate)).toFixed(6).toString()+rates.to+'</p><img id="'+j+'qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://cryptocheckout.co/'+j+'/'+response1.result+'.png" ><p id="address" type="'+rates.to.toLowerCase()+'" style="display:none;text-align: center">'+address[j]+'<span class="copy" style="position relative;height:21px;width:21px;background-image: url(\'https://cryptocheckout.co/copy.png\');background-position: center;background-repeat: no-repeat;margin-left:20px;padding-top:7px;white-space: pre" type="'+j+'">     </span></p>');                                                                                

                                        }else{
                                           $('#'+div+' #cntnr0').append('<div id="cntnr" style="clear:both" ><div type="'+rates.to.toLowerCase()+'" id="'+rates.to.toLowerCase()+'"><span class="cryptoicons" type="'+rates.to.toLowerCase()+'" id="'+rates.to.toLowerCase()+'icon" style="float:left;clear:both;width: 32px;height: 32px;display: none;background-image: url(\'https://cryptocheckout.co/'+rates.to.toLowerCase()+'.png\');float:left;background-position: center;background-repeat: no-repeat"></span></div></div></div>');
                                        $('#'+div+' #cntnr0 #'+rates.to.toLowerCase()).append('<p class="guide0" type="'+rates.to.toLowerCase()+'" style="display:none;text-align: center;position:relative;left:10px;bottom:10px;float:left">'+messages.guide0+' '+(parseFloat(amount.usd)*parseFloat(rates.rate)).toFixed(6).toString()+rates.to+'</p><img id="'+j+'qr" style="display:none;margin-right:auto;margin-left:auto;width:60%" src="https://cryptocheckout.co/'+j+'/'+response1.result+'.png" ><p id="address" type="'+rates.to.toLowerCase()+'" style="display:none;text-align: center">'+address[j]+'<span class="copy" style="position relative;height:21px;width:21px;background-image: url(\'https://cryptocheckout.co/copy.png\');background-position: center;background-repeat: no-repeat;margin-left:20px;padding-top:7px;white-space: pre" type="'+j+'">     </span></p>');                                                                                

                                        }

                                        $('.copy').on('click',function(){
                                            copy = $(this);
                                            navigator.clipboard.writeText($('[id="address"][type="'+copy.attr('type')+'"]').text().replace('     ',''));
                                            $(this).css('background-image','url(\'https://cryptocheckout.co/copysuccess.png\')');
                                            setTimeout(function(){
                                               copy.css('background-image','url(\'https://cryptocheckout.co/copy.png\')');
                                            },3000);
                                        });
                                        amount[j.toLowerCase()]=rates.rate;
                                        //amount[j.toLowerCase()]['usdprice']=amount.usdprice;
                                        guide0(div);
                                        type=j;
                                        guide0(div,type,amount);
                                    }
                                }); 
                            });                           
                        }
                        
      

                });
                
            


            $(document).ready(function(){

            });
            
            
            $('#'+div+' #pay').on('click',function(e){
               e.preventDefault();              
               $('#'+div+' .cryptoicons, #'+div+' .guide0').show();               
               $(this).remove();                              
               
            });
        }else{
            alert('Amount should not be empty');
        }
        
        
        


        
    })(jQuery);    
}


function guide0(div,type,amount){
    (function($){

     $('#'+div+' #'+type+' .guide0').on('click',function(){
               //type = $(this).attr('type');
               if( type =='xmr'){
 
                if($('#guide3').length<=0){
                      $('#xmricon').hide();
                      //$('#'+div+' #cntnr0 #'+type+' .guide0').css('font-size','45px');
                      if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                      $('#'+div+' #cntnr0 #'+type).prepend('<p id="guide3" style="clear:both;text-align:center;font-size:39px">Please pay then click i\'ve payed when complete to process to the confirmation step</p>');
                       $('#'+div+' #cntnr0 #'+type).append('<input id="pp" style="height: 100px;width: 100%;display: inline-block;line-height:2;font-size:39px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="Paste here the transaction key" maxlength=2000/>');
                         $('#'+div+' #cntnr0 #'+type+' .guide0').prependTo($('#'+div+' #cntnr0 #'+type));

                       $('#'+div+' #cntnr0 #'+type).prepend('<span id="'+type+'icon" type="top" style="width: 32px;height: 32px;display: block;background-image: url(\'https://cryptocheckout.co/'+type+'.png\');margin-right:auto;margin-left:auto;background-position: center;background-repeat: no-repeat"></span>');
 
                        $('#'+div+' #cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');
                       $('#'+div+' #cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:32px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;height:100px;"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://cryptocheckout.co/'+type+'.png);display: block;margin-right: 10px;top:5px;background-position: center;background-repeat: no-repeat"></span>'+messages.ivepaid+'</button>');
                       $('#'+div+' #cntnr0 #'+type+' #address').css('font-size','28px');
                       $('#'+type+' .guide0').css({'font-size':'32px','display':'inline-block'});
               
                $('#'+type+' .guide0').css({'font-size':'36px','display':'block'});
                      }else{
                          $('#'+div+' #cntnr0 #'+type).prepend('<p id="guide3" style="clear:both;text-align:center;">Please pay then click i\'ve payed when complete to process to the confirmation step</p>');
                       $('#'+div+' #cntnr0 #'+type).append('<input id="pp" style="width: 100%;display: inline-block;line-height:2;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="Paste here the transaction key" maxlength=2000/>');
                         $('#'+div+' #cntnr0 #'+type+' .guide0').prependTo($('#'+div+' #cntnr0 #'+type));

                       $('#'+div+' #cntnr0 #'+type).prepend('<span id="'+type+'icon" type="top" style="width: 32px;height: 32px;display: block;background-image: url(\'https://cryptocheckout.co/'+type+'.png\');margin-right:auto;margin-left:auto;background-position: center;background-repeat: no-repeat"></span>');
 
                        $('#'+div+' #cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');
                       $('#'+div+' #cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://cryptocheckout.co/'+type+'.png);display: block;margin-right: 10px;top:5px;background-position: center;background-repeat: no-repeat"></span>'+messages.ivepaid+'</button>');
                      }
       
                }
                       //$('#'+div+' .cryptoicons').remove();

                       $.get('https://cryptocheckout.co/?submit=123456&amount='+(parseFloat(amount[type.toLowerCase()])*parseFloat(amount.usd)).toFixed(6).toString()+'&curr='+type+'&rate='+amount[type.toLowerCase()],function(response){
                           hash = response.result;
                       });
                       //$('#'+div+' .guide0,#'+div);
                        $('#guide1,#'+div+' #source').remove();
                       $('#'+div+' #nextstep').remove();
                       //if( type == 'btc' ){
                         $('#'+div+' #'+type+'qr').show();
                         //$('#'+div+' #'+type+'qr').css('clear','both');
                         $('#'+div+' #'+type+'qr').css('display','block');
                       //}
                       $('[id="'+div+'"] [id="address"][type="'+type+'"]').show();





                       
                       $('#'+div+' button#ivepaid').on('click',function(e){
                            e.preventDefault();
                            $('#'+div+' #'+type+'qr,#'+div+' #address').remove();
                            $('#btc,#eth,#sol,#avax,#dot,#ada,#xtz').parent().remove();
                            $('#'+div+' #guide3').text(messages.validating);
                            $('#'+div+' button#ivepaid').attr('disabled','true');
                            $('#'+div+' #pp').attr('disabled','true');
                            $('#'+div+' #loader').show();
                            
                            //hash='976b619d5a98b37325cb1c9c308dccc8';
                            $.get('https://cryptocheckout.co/?hash='+hash+'&as='+as+'&type='+type+'&pp='+$('#pp').val(),function(response){
                                if(response.result == 'success'){
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
                            });
                        });
               }else{
                $('#guide3,#pp,#loader,[id="xmricon"][type="top"],#ivepaid').remove();
                $('#xmricon').show(); 
                $('#xmricon').prependTo($('#xmr'));
                                      $('#'+type+' .guide0').css({'font-size':'32px','display':'inline-block'});
               
                $('#'+type+' .guide0').css({'font-size':'36px','display':'block'});               
                                         $('#'+div+' #xmrqr').hide();

                       $('[id="'+div+'"] [id="address"][type="xmr"]').hide();

                if( $('#'+div+' #guide1').length !== 0 ){
                   
                    $('#'+div+' #guide1,#'+div+' #source,#'+div+' #nextstep').appendTo('#'+div+' #cntnr0 #'+type);
               }else{
                   if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                    $('#'+div+' #cntnr0 #'+type).append('<p id="guide1" style="display:block;text-align: left;float:left;font-size:28px">'+messages.guide1+'</p>');
                    $('#'+div+' #cntnr0 #'+type).append('<input id="source" style="display: block;line-height:2;font-size:32px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;height:100px;float:left" placeholder="XXXXXX" maxlength=6/><button id="nextstep" style="position:relative;display:inline-block;line-height:2;font-size:28px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;left:10px;float:left;width:100px;height:100px"><span style="position: relative;display:inline-block;background-image: url(https://cryptocheckout.co/right.png);width:30px;height:18px;background-position:center;background-repeat: no-repeat"></span></button>');
                   }else{
                       $('#'+div+' #cntnr0 #'+type).append('<p id="guide1" style="display:block;text-align: left;float:left">'+messages.guide1+'</p>');
                    $('#'+div+' #cntnr0 #'+type).append('<input id="source" style="display: inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue" placeholder="XXXXXX" maxlength=6/><button id="nextstep" style="position:relative;display:inline-block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue;left:10px"><span style="position: relative;display:inline-block;background-image: url(https://cryptocheckout.co/right.png);width:30px;height:18px;background-position:center;background-repeat: no-repeat"></span></button>');
                   }
                    $('#'+div+' #cntnr0 #source').on('change',function(){$(this).val($(this).val().substring(0,6))});$('#'+div+' #cntnr0 #source').on('keypress',function(){$(this).val($(this).val().substring(0,6))});$('#'+div+' #cntnr0 #source').on('input',function(){$(this).val($(this).val().substring(0,6))});
               }
               $('#nextstep').on('click',function(e){
                   if(type==$(this).parent().attr('id')){
                   if( $('#'+div+' #source').val() !=='' && $('#'+div+' #source').val().length == 6 ){
                       
                       $('#'+div+' .cryptoicons').remove();
                       $('#'+div+' #cntnr0 #'+type).prepend('<p id="guide3" style="text-align:center">Please pay then click I\'ve payed when complete to process to the confirmation step</p>');
                       $('#'+div+' #cntnr0 #'+type).prepend('<span id="'+type+'icon" style="width: 32px;height: 32px;display: block;background-image: url(\'https://cryptocheckout.co/'+type+'.png\');margin-right:auto;margin-left:auto;background-position: center;background-repeat: no-repeat"></span>');
                       $.get('https://cryptocheckout.co/?submit='+$('#'+div+' #source').val()+'&amount='+(parseFloat(amount[type.toLowerCase()])*parseFloat(amount.usd)).toFixed(6).toString()+'&curr='+type,function(response){
                           hash = response.result;
                       });
                       $('#'+div+' .guide0,#'+div+' #guide1,#'+div+' #source').remove();
                       $('#'+div+' #nextstep').remove();

                        $('#'+div+' #cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');
                        $('#'+div+' #cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://cryptocheckout.co/'+type+'.png);display: block;margin-right: 10px;top:5px;background-position: center;background-repeat: no-repeat"></span>'+messages.ivepaid+'</button>');
                        if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
                           $('#'+div+' #cntnr0 #'+type+' #ivepaid').css({'height':'100px','font-size':'32px'});
                            $('#'+div+' #guide3').css('font-size','28px');
                                                   $('[id="'+div+'"] [id="address"][type="'+type+'"]').css('font-size','28px')
                           
}
                 
                       //if( type == 'btc' ){
                         $('#'+div+' #'+type+'qr').show();
                         $('#'+div+' #'+type+'qr').css('display','block');
                       //}
                       $('[id="'+div+'"] [id="address"][type="'+type+'"]').show();
                       
                       $('#'+div+' button#ivepaid').on('click',function(e){
                            e.preventDefault();
                            $('#'+div+' #'+type+'qr,#'+div+' #address').remove();
                            $('#'+div+' #guide3').text(messages.validating);
                            $('#'+div+' button#ivepaid').attr('disabled','true');
                            $('#'+div+' #loader').show();
                            
                            //hash='ooYbw95dQrRn8UNz2JaEUAcvQbmAv2i3FJdDmqxnF8eVg6EGt26';
                            $.get('https://cryptocheckout.co/?hash='+hash+'&as='+as+'&type='+type,function(response){
                                if(response.result == 'success'){
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
                            });
                        });
                   }else{
                       alert('You must enter first 3 charcters & last 3 charcters of your address to continue');
                   }
               }
               });
               $('#'+div+' #cntnr0 #'+type+' #source').on('keypress',function(e){                          if(type==$(this).parent().attr('id')){    
                   if( e.which == 13 ){
                       if( $('#'+div+' #source').val() !=='' && $(this).val().length == 6 ){
                        $('#'+div+' .cryptoicons').remove();
                       $('#'+div+' #cntnr0 #'+type).prepend('<p id="guide3" style="text-align:center">Please pay then click I\'ve payed when complete to process to the confirmation step</p>');
                        $('#'+div+' #cntnr0 #'+type).prepend('<span id="'+type+'icon" style="width: 32px;height: 32px;display: block;background-image: url(\'https://cryptocheckout.co/'+type+'.png\');margin-right:auto;margin-left:auto"></span>');

                       $.get('https://cryptocheckout.co/?submit='+$(this).val()+'&amount='+(parseFloat(amount[type.toLowerCase()])*parseFloat(amount.usd)).toFixed(6).toString()+'&curr='+type+'&rate='+amount[type.toLowerCase()],function(response){
                           hash = response.result;
                       });
                        $('#'+div+' .guide0,#'+div+' #guide1,#'+div+' #source').remove();
                       $('#'+div+' #nextstep').remove();
                        $('#'+div+' #cntnr0 #'+type).append('<div id="loader" style="position: relative;margin-right: auto;margin-left: auto;width: 100%;display:none" class="loader loader--style1" title="0">  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" style="width:50%;height:50%;position:relative;margin-right:auto;margin-left:auto;display:block" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">  <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>  <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0    C22.32,8.481,24.301,9.057,26.013,10.047z">    <animateTransform attributeType="xml"      attributeName="transform"      type="rotate"      from="0 20 20"      to="360 20 20"      dur="0.5s"      repeatCount="indefinite"/>    </path>  </svg></div>');

           
                          $('#'+div+' #cntnr0 #'+type).append('<button id="ivepaid" style="position:relative;margin-left:auto;margin-right:auto;clear:both;display:block;line-height:2;font-size:22px;margin-top:5px;border:none;border-radius:10px;background-color:aliceblue"><span style="position: relative;display:block;float:left;width:32px;height:32px;background-image: url(https://cryptocheckout.co/'+type+'.png);display: block;margin-right: 10px;top:5px;background-position: center;background-repeat: no-repeat"></span>'+messages.ivepaid+'</button>'); 
if(/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)){
    $('#'+div+' #cntnr0 #'+type+' #ivepaid').css({'font-size':'28px','height':'100px'})
                           $('[id="'+div+'"] [id="address"][type="'+type+'"]').css('font-size','28px');
                                            $('#'+div+' #cntnr0 #'+type+' #guide3').css('font-size','28px');
                                                 
}


                       //if( type == 'btc' ){
                         $('#'+div+' #'+type+'qr').show();
                         $('#'+div+' #'+type+'qr').css('display','block');
                       //}
                       $('[id="'+div+'"] [id="address"][type="'+type+'"]').show();
                       $('#'+div+' button#ivepaid').on('click',function(e){
                            e.preventDefault();
                            $('#'+div+' #'+type+'qr,#'+div+' #address').remove();
                            $('#'+div+' #guide3').text(messages.validating);                            
                                $('#'+div+' #loader').show();
                            
                            $('#'+div+' button#ivepaid').attr('disabled','true');
                           // hash = 'ooYbw95dQrRn8UNz2JaEUAcvQbmAv2i3FJdDmqxnF8eVg6EGt26';
                            $.get('https://cryptocheckout.co/?hash='+hash+'&as='+as+'&type='+type,function(response){
                                if(response.result == 'success'){
                                    
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
                            });
                        });
                   }else{
                       alert('You must enter first 3 charcters & last 3 charcters of your address to continue');
                   }
                   }
                   }
                   
               });  
               }
                            
            });
    })(jQuery);
}
