const http = require('http');
const fs = require('fs');
const url = require('url');
const bs58 = require('bs58');
const monerojs = require("@rino-wallet/monero-javascript");

const hostname = '127.0.0.1';
const port = 1997;
const server = http.createServer(function(req, res) {
    const queryObject = url.parse(req.url,true).query;    
    const src = JSON.parse(Buffer.from(bs58.decode(queryObject.src)).toString()).path;
    const dst = queryObject.dst;
    const amount = queryObject.amount;
    (async()=>{

                        try{
                            walletFull = await new monerojs.openWalletFull({
                                path: 'C:/Apache24/htdocs/getpaidcrypto.online/api/'+src,
                                password: "ziqsou2011",
                                networkType: "stagenet",
                                serverUri: "http://stagenet.xmr-tw.org:38081", // daemon configuration            
                            });

                            try{
                                const txHash =  await walletFull.createTx({
                                    accountIndex: 0,                                    
                                    address: dst,
                                    amount: amount, // send 0.25 XMR (denominated in atomic units)
                                    relay: true // create transaction and relay to the network if true
                                  });
                                console.log(txHash.state.hash+'-'+txHash.state.key);
                                res.end(txHash.state.hash+'-'+txHash.state.key);
                            }catch(e){
                                console.log(e)
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
server.listen(port,hostname);