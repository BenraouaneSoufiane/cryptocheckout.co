<?php

?>
<!doctype html>
<html style="background-color:white;font-family: Arial;">
<head  >
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png" />
    <link rel="stylesheet" href="../stylesheet.css">

    <script type="text/javascript" src="/jquery.min.js"></script>
     <title>CryptoCheckout | Changelog</title>
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
    <div id="greeting" style="position: relative;width: 55%;margin-right:auto;margin-left:auto;margin-top:80px">
        <h1 id="mainheading" style="text-align: center">What's changes</h1>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.00 20-04-2021 First release: Basic functions ( BTC & BCH only ), other crypto currencies will be added soon.</p><br/>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.10 25-04-2021. Add dynamic address, you're not obliged to each time include new address, adding payment notifications by email, adding wif import: you're not obliged to start new wallet</p><br/>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.11 10-01-2022. Update User interface</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.12 19-02-2022. Update/optimize script, update main functionality to enhance security (adding validation by time in backend, return/move 6 charcter of user's address to first step)</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.13 22-03-2022. Adding Ethereum & Solana</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.14 09-08-2022. Adding Polkadot, Cardano, Avalanche</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.15 28-03-2023. Adding Tezos, Monero, updating script: updating encryption of requests/responses between our server & the client</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.16 13-08-2023. Decentralize the app (sharing the mnemonic phrase with the user & add compatibility with other wallets like trustwallet, metamask...), making email not required</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.17 15-08-2023. Add DDos protection (it may affect site loading)</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.18 30-08-2023. Fix monero issues, add qr to other crypto currencies (was with btc only), add click to copy address</p>
         <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.19 08-10-2023. Update UI, add mobile support, correct server side validation (the issue is the price may change at the moment of transaction validation cause unseccessfull transaction, but now we attache the rate on the moment when user purchase something)</p>
          <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.20 12-01-2024. Add the USDT(BEP20)</p>
         <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.21 18-01-2024. Update the explorers's endpoints</p>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">V 1.22 25-02-2024. Make the CryptoCheckout fully decentralized, no private keys/mnemonic phrases stored/shared with us</p>
         
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





