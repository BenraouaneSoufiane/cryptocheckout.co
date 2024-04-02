<?php

?>
<!doctype html>
<html style="background-color:white;font-family: Arial;">
<head  >
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png" />
    <link rel="stylesheet" href="../stylesheet.css">

    <script type="text/javascript" src="/jquery.min.js"></script>
     <title>CryptoCheckout | Fees</title>
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
         <h1 id="mainheading" style="text-align: center">Pricing</h1>
        <ul style="text-align: left;font-size:17px;line-height:1.5">There are two plans require you to pay in advance (unique flat fee), there are no fee per transaction/sale:
        <li>Free: 0.00$ 5 transactions/month</li>
        <li>Paid: 2.00$ Unlimited transactions/month</li>
        </ul><br/>
        
        <h1 style="text-align: center">What are transaction fees?</h1>
        
        <p style="text-align: left;font-size:17px;line-height:1.5">Depending of network you use, for the information, the standard fees per standard transaction are summarized in next table:</p><br/>
        <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
        <table>
  <tr>
    <th>Network</th>
    <th>Fee</th>
    <th>Pratical Fee</th>
  </tr>
  <tr>
    <td>Bitcoin</td>
    <td>min(required): <400 satoshis, recommanded: 2000 satoshis, works: 1000 satoshis</td>
    <td>0.00002 BTC</td>
  </tr>
  <tr>
    <td>Ethereum</td>
    <td>21310 wgei</td>
    <td>0.00003507 ETH</td>
  </tr>
  <tr>
    <td>Solana</td>
    <td>5000 lamports</td>
    <td>0.000005 SOL</td>
  </tr>
  <tr>
    <td>Avalanche</td>
    <td>maxfeepergas + 25 gwei</td>
    <td>Between 0.005 AVAX & 0.0005 AVAX</td>
  </tr>
  <tr>
    <td>Polkadot</td>
    <td>partialfee</td>
    <td>0.018 DOT</td>
  </tr>
  <tr>
    <td>Cardano</td>
    <td>minfee</td>
    <td>0.2 ADA</td>
  </tr>
</table><br/>
<p style="text-align: left;font-size:17px;line-height:1.5">So before send a transaction try to minus the network fee from the amount</p><br/>
        
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





