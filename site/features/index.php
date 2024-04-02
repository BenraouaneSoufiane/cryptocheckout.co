<?php

?>
<!doctype html>
<html style="background-color:white;font-family: Arial;">
<head  >
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png" />
    <link rel="stylesheet" href="../stylesheet.css">

    <script type="text/javascript" src="/jquery.min.js"></script>
     <title>CryptoCheckout | Features</title>
</head>
<body style="background-color:white;font-family: Arial;" >
<header>
         <div id="menu" style="position:relative;margin-right: auto;margin-left: auto;">
                    <a href="#" class="open-button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                <div id="logo">
                    <span id="spanlogo"></span>
                    <h3 id="logotext" >CryptoCheckout</h3>
                </div>
                <nav>
                    <ul>
                        <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/TOS-privacy" >How it's secure?</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/features" >Features</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/fees" >Fees</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/coming-next" >Coming
                        Next</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/changelog" >Changelog</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://twitter.com/CryptoCStatus" target="_black">Status<span id="odicon" style="width: 20px;height: 20px;position: relative;background-image: url('https://cryptocheckout.co/newtab.png');display: inline-block;background-repeat: no-repeat;top: 6px;left: 5px;margin-right: 5px;"></span></a>
                </p>
            </li>
                </ul>
                </nav>

            </div>
            </header>
    <div id="greeting" style="position: relative;width: 90%;margin-right:auto;margin-left:auto;margin-top:80px">
    <h1 id="mainheading" style="text-align:center">What makes us different</h1>
        <ul style="text-align: center">
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">CryptoCheckout button comes with onInit(e), onClick(e), onApprove(e) & onError(e) events which ease functionalities & customize styles</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Unlike other operators, we use the USDT Binance Smart Chain (BEP20), lowest fee per transaction/withdrawal, only 0.3$, that's encourage clients to pay by crypto currencies (other networks charge the user 1$)</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Quick start: no signup required, no ID verification required, almost 5 min to fully integrate our crypto payments button</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Sales notifications: includes amount currency & the address of the source of the transaction</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Decentralized: no private keys/mnemonic phrases stored/shared with us</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Universal: target any client who has crypto wallet, not only clients on such crypto platform</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Secure/Safe: we've DDos protection, we approve only transaction marked as success / exceed certain number of confirmations, we also block side/parallel trasactions comes from hackers that listen on the merchant address for incoming transaction</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Multilingual: languages supported are: ar, bn, zh, cs, en, da, nl, fr, de, he, hi, id, it, ja, ko, pl, pt, ru, sv, es, tr, uk, vi</li>
        <li style="text-align: center;font-size: 18px;line-height: 1.5;">Responsive</li>
        </ul>
    </div>
</body>
<footer>
     <script>
        (function($){
            var hidden = true;

            /* Hamburger menu animation */
    $('.open-button').click(function(){
      $(this).toggleClass('open');
      if(hidden==true){
        
        $('#menu p').show();
        $('#menu').css({'background-color':'white','position':'fixed','min-height':'100%','height':'100%','right':'20px'});
        $('#menu ul').css({'position':'relative','top':'150px'});
        $('body').css({'overflow':'hidden'})
        hidden = false;
      }else{
          $('#menu p').hide();
         $('#menu').css({'background-color':'white','position':'fixed','min-height':'200px','height':'200px'})
         $('body').css({'overflow':'scroll'})
          hidden=true;
      }
      
    });

   /* Menu fade/in out on mobile */
    $(".open-button").click(function(e){
        e.preventDefault();
        $(".mobile-menu").toggleClass('open');
    });
            $('#logo').on('click',function(){
                    window.location.assign('https://cryptocheckout.co');
                });
                //$('#greeting').css('top','75px');
                $('#greeting ul').css('list-style','none');
                $('#greeting ul li').css('margin-bottom','18px');
                $('#greeting p').css({'position':'relative','padding':'0','margin':'0'});
                $('#greeting #mainheading').css({'padding-bottom':'70px'});
            if (/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)) {
                $('#greeting label,#greeting p,#greeting li').css('font-size', '58px');
                $('#greeting').css({'top':'200px'});
                $('#mainheading').css({'font-size':'150px','text-align':'center'});
                $('#logo').css({'position':'relative','margin-left':'auto','margin-right':'auto'});
                        $('#spanlogo').css({'background-image':'url("https://cryptocheckout.co/cryptocheckout-m.png")','width':'200px','height':'200px'});
                        $('#logotext').hide();
                        $('#menu').css({'background-color':'white','position':'fixed','height':'200px','min-height':'200px'});
                    $('#greeting,#menu').css({'clear':'both'});
                    $('#menu nav ul').css({'display':'block'});
                    $('#menu').css({'opacity':'1','width':'100%'});
                       $('#paypal-button-container').css({'width':'80%'});
                    $('table tr').css({
                        'width': '100%'
                    });
                    $('#greeting,#test2,#api,#codeblock2,#codeblock3').css('width', '100%');
                    $('#codeblock3,#codeblock2').css('overflow-y', 'scroll');
                    $('#test5').css('width', '90%');

                    $('#woo,#shopify,#prestashop,#opencart').css({
                        'display': 'block', 'margin-right': 'auto', 'margin-left': 'auto', 'float': 'none', 'width': '200px', 'height': '200px'
                    });
                       $('#pp,#stripe,#square,#cryptocheckout,#binance,#coinbase').css({
                        'display': 'block', 'margin-right': 'auto', 'margin-left': 'auto', 'float': 'none', 'width': '200px', 'height': '200px'
                    });
                    $('#woo').css('background-image', 'url("https://cryptocheckout.co/woo-m.png")');
                                        $('#pp').css('background-image', 'url("https://cryptocheckout.co/paypal-m.png")');
                                                            $('#stripe').css('background-image', 'url("https://cryptocheckout.co/stripe-m.png")');
                                                                                $('#square').css('background-image', 'url("https://cryptocheckout.co/square-m.png")');
                                                                                                    $('#cryptocheckout').css('background-image', 'url("https://cryptocheckout.co/cryptocheckout-m.png")');
                  $('#binance').css('background-image', 'url("https://cryptocheckout.co/binance-m.png")');
                  $('#coinbase').css('background-image', 'url("https://cryptocheckout.co/coinbase-m.png")');
                    $('#shopify').css('background-image', 'url("https://cryptocheckout.co/shopify-m.png")');
                    $('#prestashop').css('background-image', 'url("https://cryptocheckout.co/prestashop-m.png")');
                    $('#opencart').css('background-image', 'url("https://cryptocheckout.co/opencart-m.png")');
                    $('td,th').css('font-size', '36px');
                    $('#cbtci').css({'background-image':'url("https://cryptocheckout.co/btc-m.png")','width':'150px','height':'150px'});$('#cethi').css({'background-image':'url("https://cryptocheckout.co/eth-m.png")','width':'150px','height':'150px'});$('#csoli').css({'background-image':'url("https://cryptocheckout.co/sol-m.png")','width':'150px','height':'150px'});$('#cdoti').css({'background-image':'url("https://cryptocheckout.co/dot-m.png")','width':'150px','height':'150px'});$('#cavaxi').css({'background-image':'url("https://cryptocheckout.co/avax-m.png")','width':'150px','height':'150px'});$('#cadai').css({'background-image':'url("https://cryptocheckout.co/ada-m.png")','width':'150px','height':'150px'});$('#cxtzi').css({'background-image':'url("https://cryptocheckout.co/xtz-m.png")','width':'150px','height':'150px'});$('#cxmri').css({'background-image':'url("https://cryptocheckout.co/xmr-m.png")','width':'150px','height':'150px'})

                 
                    //$('table').remove();
                    //$('#test6').append('');
                                        $('#menu').css({'position':'relative','width':'100%','height':'100%','min-height':'100%','width':'100%','z-index':'99999','min-width':'100%'})
                                        $('#menu p').css({'text-aligh':'center','clear':'both','display':'block','font-size':'64px'})
                                                          $('#menu p').hide();

                }else{
                    //$('#menu').prependTo('#greeting')
                    $('.open-button').hide();
                }
        
        })(jQuery);
    </script>
</footer>
</html>





