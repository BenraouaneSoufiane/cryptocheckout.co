<?php

?>
<!doctype html>
<html style="background-color:white;font-family: Arial;">
<head  >
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png" />
    <link rel="stylesheet" href="../stylesheet.css">
    <script type="text/javascript" src="/jquery.min.js"></script>
     <title>CryptoCheckout | Our Security Standards</title>
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
        <h1 id="mainheading" style="text-align: center">Introduction</h1>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">This liteweight online tool allow you safely to accept crypto payments on your website quikly in three steps without sign up:</p><br/>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">Generate your merchant ID.</p><br/>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">Replace the ID with your merchant ID when including our script.</p><br/>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">Manage your revenues where ever your addresses are</p><br/>
        
        <h1 id="subheading" style="text-align: center">Transaction validation procedure/flow</h1>
        
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">1- Creating transaction with its data (amount, type of crypto currency, six characters of payer address address, ip, timestamp, cookie..) when user type the six chartcters of his address, marking it as pending, retreiving the transaction hash/ID, any other side/simultanous/parallele validations from other locations will ignored/blocked/discard (usally comes from spying on the merchant address on the blockchain explorers, & they try to simulate a payment process)</p><br/> 
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">2- Matching trancation amount & payed address with the received amount using the associated blochain explorer (this included also checking number of confirmation or status success depending on crypto currency type)</p><br/>             
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">3- If data matches, mark the transaction as completed, blacklist the transaction hash, send the local transaction hash/ID & the global transaction hash to the user</p><br/> 
        <!--<h1 style="text-align: center">Terms of service:</h1>
        <p style="text-align: center;font-size: 18px;line-height: 1.5;">
Don't use it for pornographic contents, alchool drinks/drugs, pokerring/betting.</p>-->
        
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
                $('#greeting #mainheading').css({'padding-bottom':'70px'});
                $('#greeting ul').css('list-style','none');
                $('#greeting ul li').css('margin-bottom','18px');
                $('#subheading').css({'font-size':'48px','text-align':'center'});
                $('#greeting p').css({'position':'relative','padding':'0','margin':'0'});

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





