// import library
//"54zVgL6NcehBUtJqehgf7vdTBgckVRvCyKWfLt8BepfWdT3cotgRfEU9zPr5DqVmFmft2Y8qUtUUs5mkqovGrUA13nsfe5i"
//"54zVgL6NcehBUtJqehgf7vdTBgckVRvCyKWfLt8BepfWdT3cotgRfEU9zPr5DqVmFmft2Y8qUtUUs5mkqovGrUA13nsfe5i"
const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');

(async()=>{
//let daemon = await monerojs.connectToDaemonRpc('http://stagenet.xmr-tw.org:38081');
//let height = await daemon.getHeight();
const path = 'safina1669134816370';
/*let walletFull = await monerojs.createWalletFull({
  path: path,
  password: path,
  networkType: "stagenet",
  serverUri: "http://stagenet.xmr-tw.org:38081", 
  //restoreHeight: height
});


const address = await walletFull.getAddress(0);
const mn = await walletFull.getMnemonic();
const pk = await walletFull.getPrivateViewKey();
const sk = await walletFull.getPrivateSpendKey();
console.log(address);
console.log(mn);
console.log(pk);
console.log(sk);
console.log(height);
console.log(path); 
*/
 
walletFull = await monerojs.openWalletFull({
    path: path,
    password: path,
    networkType: "stagenet",
    serverUri: "http://node.sethforprivacy.com:38089"
});


const logbalance = setInterval(function(){    
       (async()=>{
                walletFull = await monerojs.openWalletFull({
                    path: path,
                    password: path,
                    networkType: "stagenet",
                    serverUri: "http://node.sethforprivacy.com:38089"
                });                
               await walletFull.sync(new class extends monerojs.MoneroWalletListener {
                    onSyncProgress(height, startHeight, endHeight, percentDone, message) {
                        //console.log(percentDone);
                        if( percentDone == 1 ){
                            (async()=>{                    
                                //console.log(height);
                                //const bl = await walletFull.getUnlockedBalance(0);
                                //console.log(bl); 
                                //console.log(percentDone);
                                                         
                                if(await walletFull.isClosed()===false){
                                    await walletFull.close(true);
                                    console.log(walletFull);
                                }                                                                
                            })()                     
                        }            
                    }
                });                        
        })()         
},15000);


/*await walletFull.addListener(new class extends monerojs.MoneroWalletListener {
  onOutputReceived(output) {
    let amount = output.getAmount();
    let txHash = output.getTx().getHash();
    let isConfirmed = output.getTx().isConfirmed();
    let isLocked = output.getTx().isLocked();
    fundsReceived = true;
    console.log(amount);
    console.log(txHash);
  }
});*/


/*
let createdTx = await walletFull.createTx({
  accountIndex: 0,
  address: '73a4nWuvkYoYoksGurDjKZQcZkmaxLaKbbeiKzHnMmqKivrCzq5Q2JtJG1UZNZFqLPbQ3MiXCk2Q5bdwdUNSr7X9QrPubkn',
  amount: "9500000000000", // send 0.25 XMR (denominated in atomic units)
  relay: false // create transaction and relay to the network if true
});
let fee = createdTx.getFee(); // "Are you sure you want to send... ?"
const tx = await walletFull.relayTx(createdTx);
console.log(tx)*/
/*const t = await walletFull.getTransfers();
console.log(t);*/
})()
