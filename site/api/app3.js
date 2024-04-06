const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');
const path = 'safina1669134816370';

(async()=>{
    
     const logbalance = setInterval(function(){    
       (async()=>{
        const walletFull = await monerojs.openWalletFull({
        path: path,
        password: path,
        networkType: "stagenet",
        serverUri: "http://node.sethforprivacy.com:38089"
    });
    const bl = await walletFull.getUnlockedBalance(0);
    console.log(bl); 
    await walletFull.close();
    
})()
},5000);
    })()


