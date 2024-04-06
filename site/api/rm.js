const fs = require('fs');
const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');

                        try{
                         (async()=>{
                            walletFull = await monerojs.createWalletFull({
                                path: 'C:/Apache24/htdocs/getpaidcrypto.online/api/w/1679754320903',
                                password: "ziqsou2011",
                                networkType: "mainnet",
                                serverUri: "http://opennode.xmr-tw.org:18089", 
                                mnemonic: 'else omission gigantic dude rest thorn river taxi illness gawk lipstick glide binocular evaluate railway austere setup after austere candy rising sneeze sipped smelting binocular',
                                restoreHeight: 2849787
                            });
                        })();
                        }catch(e){
                          console.log(e);
                        }  
                        
                   