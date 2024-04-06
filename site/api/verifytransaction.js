const monerojs = require("@rino-wallet/monero-javascript"),
url = require('url'),
http = require('http'),
https = require('https'),
bs58 = require('bs58'),
fs = require('fs'),
hostname = '127.0.0.1',
port = 55550;
var rstr = '';
var txhash = '';
var server = http.createServer(function(req, res) {

 	const queryObject = url.parse(req.url,true).query;
	const wallet = JSON.parse(Buffer.from(bs58.decode(queryObject.wallet)).toString()).path;       

    res.writeHead(200, {'Content-Type': 'text/plain'});
    			

    (async()=>{
        try{
                 	
            walletFull = await monerojs.openWalletFull({
                path:  wallet,
                password: "getpaidcrypto",
                networkType: "mainnet",
                serverUri: "https://xmrr.deb8.eu.org", // daemon configuration            
            });                 
            try{
                txs = await walletFull.getTransfers({isIncoming: true});
                console.log(txs);
                for(i=0;i<txs.length;i++){

                    txhash = txs[i].state.tx.state.hash;
                    options = {
    
    hostname: 'community.rino.io',
    port: 443,
    path: '/explorer/stagenet/prove',
    method: 'POST'
};
const broadcast = https.request(options,(r)=>{
     r.on('data',(d)=>{
        rstr += d;
     });
     r.on('end',(d2)=>{
        if(rstr.indexOf('Outputs (2)')>=0){
            res.end('{"result":true,"txhash":"'+txhash+'"}');
        }
     });
});
broadcast.write('txhash='+txs[i].state.tx.state.hash+'&txprvkey='+queryObject.txprvkey+'&xmraddress='+queryObject.address);
broadcast.end();
                }
                //res.end(JSON.stringify(txs));
                
            }catch(e){
            	console.log(e);
            }         
        }catch(e){            
            console.log(e);
        } 
})()

});
server.listen(port,hostname);
