const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');
const url = require('url');
const fs = require('fs');
//const queryObject = url.parse(req.url,true).query;
const mn = Buffer.from(bs58.decode('AYLGWu1CneVA6bEs8W9sfKRQ7VA9h62QWqDeyy2cedBQGJeT3fvDiEASrqvz2g7bHhtudZM6yYqGzsCt3rjLfN95ckknMuvZiQh3GSizZpNMHLMHAS8214gPM6227EnuFC6phxo6kpD12SHUbH7wToB9sFavkDNK9HmgbaxQFQxyvetnketubFkr661xfmC9ykfSSwyZ5sisvvjHroNvw1yxNcLRYbbXzHZd3BC6LnKm5yQJiJiMzs2fpt2VowHTxLQ1cZUYV6js7oCoASZjkYyZgpySfPgjuZ85BncdteHeAJchPv6BhVpJg')).toString();
//console.log(JSON.parse(mn).pk);

(async()=>{
   /*let daemon = await monerojs.connectToDaemonRpc("http://stagenet.xmr-tw.org:38081", "superuser", "abctesting123");
let height = await daemon.getHeight();*/

 /*walletFull = await monerojs.createWalletFull({
   path: "ss",
   password: "ziqsou2011",
   networkType: "stagenet",
   serverUri: "http://stagenet.xmr-tw.org:38081", // daemon configuration
   serverUsername: "superuser",
   serverPassword: "abctesting123"
});*/ 
//console.log(await walletFull.getMnemonic());
   /*walletFull = await monerojs.createWalletFull({
  path: 'rafina',
  password: "ziqsou2011",
  networkType: "stagenet",
  serverUri: "http://stagenet.xmr-tw.org:38081", 
  mnemonic: JSON.parse(mn).pk,
  restoreHeight: height
});*/
   const fs = require('fs');
//var old = fs.readFileSync('wallet.txt');
var isAdded = false;
//old = JSON.parse(old);
      try{
         walletFull = await monerojs.openWalletFull({
            path: JSON.parse(mn).path,
            password: "ziqsou2011",
            networkType: "stagenet",
            serverUri: "http://stagenet.xmr-tw.org:38081", // daemon configuration            
         });
         let tx = await walletFull.createTx({
           accountIndex: 0,  // source account to send funds from
           address: "73a4nWuvkYoYoksGurDjKZQcZkmaxLaKbbeiKzHnMmqKivrCzq5Q2JtJG1UZNZFqLPbQ3MiXCk2Q5bdwdUNSr7X9QrPubkn",
           amount: "9000000000000", // send 1 XMR (denominated in atomic units)
           relay: true // relay the transaction to the network
         });
         console.log(tx);
      }catch(e){
         console.log(e);
      }

/*
setInterval(function(){
   (async()=>{
      try{
         walletFull = await monerojs.openWalletFull({
            path: "rafina",
            password: "ziqsou2011",
            networkType: "stagenet",
            serverUri: "http://stagenet.xmr-tw.org:38081", // daemon configuration
            
         });

         console.log(await walletFull.getAddress(1));
         

         if( walletFull._isClosed === false ){
            try{
               await walletFull.addListener(new class extends monerojs.MoneroWalletListener {
                  onSyncProgress(height, startHeight, endHeight, percentDone, message) {
                     console.log(percentDone);
                     console.log(startHeight);
                     console.log(endHeight);
                     if(percentDone==1){
                        (async()=>{
                           console.log(await walletFull.getUnlockedBalance(0));
                        })()
                     }
                  }
               });
               //isAdded = true;
               try{
                  await walletFull.sync(); 
                  try{
                     await walletFull.close(true);
                  }catch(e){
                     console.log(e)
                  }                  
               }catch(e){
                  console.log(e);
               }                
            }catch(e){
               console.log(e);
            }              
         }
      }catch(e){
         console.log(e);
      } 
})()
},60000);*/
/*old[secret]=
fs.writeFileSync('wallet.txt',);*/
   //console.log(await walletFull.getAddress(0));
   /*await walletFull.addListener(new class extends monerojs.MoneroWalletListener {
  onSyncProgress(height, startHeight, endHeight, percentDone, message) {
     console.log(percentDone);
     console.log(startHeight);
     console.log(endHeight);
    if(percentDone==1){
      (async()=>{
         console.log(await walletFull.getUnlockedBalance(0));
      })()
    }
  }
});

      await walletFull.sync();*/

  
  


})()