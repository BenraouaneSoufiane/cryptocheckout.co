const fs = require('fs');
const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');
const http = require('http');
const url = require('url');

const hostname = '127.0.0.1';
const port = 55555;

    var path = '';
    var w = [];
   

    //data = data;   
        
  
const server = http.createServer(function(req, res) {
const queryObject = url.parse(req.url,true).query;

                            
                    //if(walletFull._isClosed === true){
                fs.copyFile('C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet,'C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.bk',(err)=>{
                    if(err){
                        console.log(err);
                    }else{

                    }
                }); 
                fs.copyFile('C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.keys','C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.keys.bk',(err)=>{
                    if(err){
                        console.log(err);
                    }else{

                    }
                }); 
                fs.copyFile('C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.address.txt','C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.address.txt.bk',(err)=>{
                    if(err){
                        console.log(err);
                    }else{

                    }
                }); 
                (async()=>{

                        try{
                            walletFull = await new monerojs.openWalletFull({
                                path: 'C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet,
                                password: "ziqsou2011",
                                networkType: "mainnet",
                                serverUri: "http://opennode.xmr-tw.org:18089", // daemon configuration            
                            }); 
                             
                            if( walletFull._isClosed === false ){
                                try{
                                   await walletFull.addListener(new class extends monerojs.MoneroWalletListener {
                                 onSyncProgress(height, startHeight, endHeight, percentDone, message) {
                                    console.log(percentDone);
                                    console.log(startHeight);
                                    console.log(endHeight);
                                    console.log(queryObject.wallet);
                                    if(percentDone==1){
                                       (async()=>{                                            
                                            /*console.log('Address: '+JSON.stringify(await walletFull.getAddress(0)));
                                            console.log('Locked: '+JSON.stringify(await walletFull.getBalance(0)));
                                            console.log('Unlocked: '+JSON.stringify(await walletFull.getUnlockedBalance(0)));*/
                                            try{
                                                await walletFull.close(true);                                                
                                                //res.end('ok');
                                                                                                                                                                                                                                              
                                            }catch(e){
                                               console.log(e)
                                            }
                                        })()
                                     }
                                    }
                                 });
                        
                                    try{
                                       await walletFull.sync();                                    
                                    }catch(e){
                                       console.log(e);
                                    }                
                                }catch(e){
                                   console.log(e);
                                }              
                             }
                        }catch(e){
                            console.log(e);
                            if(JSON.stringify(e).indexOf('input stream error')>=0 ){
                            try{
                                fs.unlink('../../Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet, (err) => {
                                    if (err) {
                                        console.log(err);
                                    }
                                    console.log('path/file.txt was deleted');
                                });
                                fs.unlink('../../Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.address.txt', (err) => {
                                    if (err) {
                                        console.log(err);
                                    }
                                    console.log('path/file.txt was deleted');
                                });
                                fs.copyFile('C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.bk','C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet,(err)=>{
                                    if(err){
                                        console.log(err);
                                    }else{

                                    }
                                })
                                fs.copyFile('C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.address.txt.bk','C:/Apache24/htdocs/getpaidcrypto.online/api/w/'+queryObject.wallet+'.address.txt',(err)=>{
                                    if(err){
                                        console.log(err);
                                    }else{

                                    }
                                }) 

                            
                            }catch(e){
                                console.log(e);
                            }

                           }


                        } 
                        })()

            
       });
//server.timeout=3000000;
server.listen(port,hostname);
