

const hostname = 'cryptocheckout.co';
const port = 80;

var http = require('http'),
util = require('util');
/*Accounts = require('web3-eth-accounts'),
accounts = new Accounts('ws://103.125.218.84:8666');*/
const https = require('https'),
url = require('url'),

utils = require('@taquito/utils'),
ed = require('@stablelib/ed25519');

/*let myNetworkID = 1 //default is 3, we want to override that for our local network
let myBlockchainID = "2oYMBNV4eNHyqk2fjjV5nVQLDbtmNJzq5s3qs3Lo6ftnC6FByM" // The X-Chain blockchainID on this network
let avax = new avalanche.Avalanche(
  "localhost",
  9650,
  "http",
  myNetworkID,
  myBlockchainID
)
let xchain = avax.XChain()*/

/*var test = [
  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),
  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),
  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),
  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),
  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),
  Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256), Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256),  Math.floor(Math.random() * 256)
]*/
let secretKey = new Uint8Array(64);
 //secretKey = secretKey.from(Buffer.from('b616624e1ea3ccc8769ca4764e31f2de01516a8950fee45231a2f593e886f57a2de1b11759c96a39d20dd39de69085aeec5f0f1758b451e1123f32972ac3e69e', 'hex'));
//let keypair = Keypair.generate();
//
//
//str = buf2hex(str);
//var str = new Buffer.from(str.buffer,str.byteOffset,str.byteLength).toString('hex');
//const str = new String();
//bitcore.Networks.defaultNetwork = bitcore.Networks.testnet;

var server = http.createServer(function(req, res) {
    res.writeHead(200, {'Content-Type': 'application/json'});
    //res.end(JSON.stringify(Math.floor(Math.random() * 256))+'-'+JSON.stringify(Math.floor(Math.random() * 256)));
    //res.end(bs58.encode(str));

    
    const queryObject = url.parse(req.url,true).query;
    if(queryObject.sync==='true'){
        const fs = require('fs');
const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');
const http = require('http');
const url = require('url');

                        fs.copyFile('w/'+queryObject.wallet,'w/'+queryObject.wallet+'.bk',(err)=>{
                    if(err){
                        console.log(err);
                    }else{

                    }
                }); 
                fs.copyFile('w/'+queryObject.wallet+'.keys','w/'+queryObject.wallet+'.keys.bk',(err)=>{
                    if(err){
                        console.log(err);
                    }else{

                    }
                }); 
                fs.copyFile('w/'+queryObject.wallet+'.address.txt','w/'+queryObject.wallet+'.address.txt.bk',(err)=>{
                    if(err){
                        console.log(err);
                    }else{

                    }
                }); 
                (async()=>{

                        try{
                            walletFull = await new monerojs.openWalletFull({
                                path: 'w/'+queryObject.wallet,
                                password: "getpaidcrypto",
                                networkType: "mainnet",
                                serverUri: "https://xmrr.deb8.eu.org", // daemon configuration            
                            }); 
                             
                            if( walletFull._isClosed === false ){
                                try{
                                   await walletFull.addListener(new class extends monerojs.MoneroWalletListener {
                                 onSyncProgress(height, startHeight, endHeight, percentDone, message) {
                                    //console.log(percentDone);
                                    //console.log(startHeight);
                                    //console.log(endHeight);
                                    //console.log(queryObject.wallet);
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
                                fs.unlink('w/'+queryObject.wallet, (err) => {
                                    if (err) {
                                        console.log(err);
                                    }
                                    console.log('path/file.txt was deleted');
                                });
                                fs.unlink('w/'+queryObject.wallet+'.address.txt', (err) => {
                                    if (err) {
                                        console.log(err);
                                    }
                                    console.log('path/file.txt was deleted');
                                });
                                fs.copyFile('w/'+queryObject.wallet+'.bk','w/'+queryObject.wallet,(err)=>{
                                    if(err){
                                        console.log(err);
                                    }else{

                                    }
                                })
                                fs.copyFile('w/'+queryObject.wallet+'.address.txt.bk','w/'+queryObject.wallet+'.address.txt',(err)=>{
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

    }
    if( queryObject.type === 'xmr' ){
const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');
//process.env['PATH'] = 'Apache24/htdocs/crpyto.translatewp.online/api/';
(async()=>{
    const connection = setInterval(function(){
        try{
            (async()=>{
                 let daemon = await monerojs.connectToDaemonRpc('https://xmrr.deb8.eu.org');
            let height = await daemon.getHeight();
            if( height ){
                clearInterval(connection);
            }
            const path = 'w/'+JSON.stringify(Date.now());
            try{
let walletFull = await monerojs.createWalletFull({
              //path: path,
              password: "getpaidcrypto",
              networkType: "mainnet",
              serverUri: "https://xmrr.deb8.eu.org"
              //restoreHeight: height
            });
            //console.log(walletFull);
            
            
            
            const mn = await walletFull.getMnemonic();            
            walletFull = await monerojs.createWalletFull({
              path: path,
              password: "getpaidcrypto",
              networkType: "mainnet",
              serverUri: "https://xmrr.deb8.eu.org",
              mnemonic: mn,
              restoreHeight: height
            });
            const address = await walletFull.getAddress(0);
            let ok = {};
            ok['pk']=mn;
            ok['blochheight']=height;
            ok['path']=path;
            const fs = require('fs');
            const secret = bs58.encode(Buffer.from(JSON.stringify(ok),'utf8'));
            res.end('{"address":"'+address+'","privatekey":"'+secret+'","mnemonic":"'+mn+'"}');
            }catch(e2){
               res.end(JSON.stringify(util.inspect(e2)));
            }
            

              
            })()
            
        }catch(e){
            console.log(JSON.stringify(util.inspect(e)))
        } 
    },10000);
    





})();
    }else if(queryObject.type=='tw'){
            const tw = require('@trustwallet/wallet-core');

        (async()=>{
        const core = await tw.initWasm();
        const wallet = core.HDWallet.create(256,queryObject.password);
        const curr = ["ethereum","bitcoin","ethereum","solana","avalancheCChain","polkadot","cardano","tezos"];
        const abbr = ["usdt","btc","eth","sol","avax","dot","ada","xtz"];
        var result = {};
        for(var i=0;i<curr.length;i++){            
           result[abbr[i]]=wallet.getAddressForCoin(core.CoinType[curr[i]]);           
        }
        console.log('{"address":'+JSON.stringify(result)+',"pk":"'+wallet.mnemonic()+'"}')

        res.end('{"address":'+JSON.stringify(result)+',"pk":"'+Buffer.from(wallet.mnemonic(),'utf8').toString('hex')+'" ,"mnemonic":"'+wallet.mnemonic()+'"}');

    })()
    }
    /*const Mnemonic = require('bitcore-mnemonic');
    var code = new Mnemonic(Mnemonic.Words.ENGLISH);

    if( queryObject.type == 'btc' ){                
        const bech32 = require('@swan-bitcoin/xpub-lib');    
        var xpriv = code.toHDPrivateKey().derive("m/84'/0'/0'/0/0");
        console.log(bech32.addressFromExtPubKey({extPubKey: xpriv.xpubkey,network: "mainnet"}));
        res.end('{"address":"'+bech32.addressFromExtPubKey({extPubKey: xpriv.xpubkey,network: "mainnet"}).address+'","pk":"'+Buffer.from(code.toString(),'utf8').toString('hex')+code.toString()+'"}');        
    }else if( queryObject.type == 'eth' ){
        const Web3eth = require('web3'),
        web3eth = new Web3eth('ws://localhost:8546');
        var keypair = web3eth.eth.accounts.create();
        res.end(JSON.stringify(keypair));
    }else if( queryObject.type == 'sol' ){
        const web3 = require("@solana/web3.js");
        const bs58 = require('bs58');    
        const keypair = web3.Keypair.generate();
        res.end('{"address":"'+keypair.publicKey.toBase58()+'","privatekey":"'+bs58.encode(keypair._keypair.secretKey)+'"}');
    }else if( queryObject.type == 'avax' ){
        const ethers = require('ethers');
        const w = ethers.Wallet.createRandom();
        
        res.end('{"address":"'+w.address+'","privatekey":"'+w.privateKey+'"}');

    }else if( queryObject.type == 'dot' ){
        /*const {Keyring,ApiPromise, WsProvider} = require('@polkadot/api');
        ccc = async ()=>{
                    const wsProvider = new WsProvider('wss://rpc.polkadot.io');

            const api = await ApiPromise.create({ provider: wsProvider });
        const bs58 = require('bs58');
        const keyring = new Keyring();
        res.end(util.inspect(bs58.encode(keyring.addFromUri('0x1234567890123456789012345678901234567890123456789012345678901234').publicKey)));
        }
        ccc();*/

    /*
        const api = require('@polkadot/api');
        var keypair = new api.Keyring();
        pk = Date.now().toString(16);
        keypair = keypair.addFromUri(pk);
        //res.end(util.inspect(keypair));
        res.end('{"address":"'+keypair.address+'","privatekey":"'+pk+'"}');

    }else if( queryObject.type == 'ada' ){

         const CardanoWasm = require('@emurgo/cardano-serialization-lib-nodejs');
         const bs58 = require('bs58');
         const rootKey = CardanoWasm.Bip32PrivateKey.generate_ed25519_bip32();
         const accountKey = rootKey
  .derive(harden(1852)) // purpose
  .derive(harden(1815)) // coin type
  .derive(harden(0)); // account #0

const utxoPubKey = accountKey
  .derive(0) // external
  .derive(0)
  .to_public();

const stakeKey = accountKey
  .derive(2) // chimeric
  .derive(0)
  .to_public();
         const baseAddr = CardanoWasm.BaseAddress.new(
  CardanoWasm.NetworkInfo.mainnet().network_id(),
  CardanoWasm.StakeCredential.from_keyhash(utxoPubKey.to_raw_key().hash()),
  CardanoWasm.StakeCredential.from_keyhash(stakeKey.to_raw_key().hash()),
);
res.end('{"address":"'+baseAddr.to_address().to_bech32()+'","privatekey":"'+bs58.encode(rootKey.as_bytes())+'"}');
    }else if( queryObject.type == 'xtz' ){
        const InMemorySigner = require('@taquito/signer'),
TezosToolkit = require('@taquito/taquito');
        (async () => {
    
const Tezos = new TezosToolkit.TezosToolkit('https://mainnet.api.tez.ie/');
const secret = utils.b58cencode(ed.generateKeyPair().secretKey,new Uint8Array([43, 246, 78, 7]));
//const secret = 'edskS2RxPoE1SKDX3MZiLUYwhrQUnU1Jnv4LmmBybKe9RSa965sjotPxPvtLUiH8yPyBKahAwPhAp4sXhKNLnV6fwBUJRtsTrq';
const signer = await new InMemorySigner.InMemorySigner(secret);
Tezos.setProvider({ signer: signer });
pk = await Tezos.signer.publicKeyHash();

        res.end('{"address":"'+pk+'","privatekey":"'+secret+'"}');

})();
    }else if( queryObject.type == 'xmr' ){
const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');
//process.env['PATH'] = 'Apache24/htdocs/crpyto.translatewp.online/api/';
(async()=>{
    const connection = setInterval(function(){
        try{
            (async()=>{
                 let daemon = await monerojs.connectToDaemonRpc('https://xmrr.deb8.eu.org');
            let height = await daemon.getHeight();
            if( height ){
                clearInterval(connection);
            }
            const path = 'w/'+JSON.stringify(Date.now());
            let walletFull = await monerojs.createWalletFull({
              //path: path,
              password: "getpaidcrypto",
              networkType: "mainnet",
              serverUri: "https://xmrr.deb8.eu.org", 
              //restoreHeight: height
            });
            const mn = await walletFull.getMnemonic();            
            walletFull = await monerojs.createWalletFull({
              path: path,
              password: "getpaidcrypto",
              networkType: "mainnet",
              serverUri: "https://xmrr.deb8.eu.org", 
              mnemonic: mn,
              restoreHeight: height
            });
            const address = await walletFull.getAddress(0);
            let ok = {};
            ok['pk']=mn;
            ok['blochheight']=height;
            ok['path']=path;
            const fs = require('fs');
            const secret = bs58.encode(Buffer.from(JSON.stringify(ok),'utf8'));
            res.end('{"address":"'+address+'","privatekey":"'+secret+'"}');

              
            })()
            
        }catch(e){
            console.log(e)
        } 
    },1000);
    





})();
    }*/
    if( queryObject.transaction == 'btc' ){
        //const bitcore = require('bitcore-lib');
      
          
        
        

        var strr = '';
        https.get('https://api.blockcypher.com/v1/btc/main/addrs/'+queryObject.src+'/full?token=0c90af3735a0454b97d1353fe7dec4f2&unspentOnly=true',r =>{
            r.on('data', r1 => {
                strr += r1;
            });
            r.on('end',()=>{
                var result = JSON.parse(strr);
                //res.end(util.inspect(strr));
                if( Number(result['balance']) >= Number(queryObject.amount) ){
                    var amount=0, utxos = [];
                    //var privateKey = new bitcore.PrivateKey(queryObject.pk);
                    var privateKey =  new Mnemonic(Buffer.from(queryObject.pk,'hex').toString()).toHDPrivateKey().derive("m/84'/0'/0'/0/0").privateKey;


                    for(i=0;i<=result.txs.length-1;i++){
                        for(j=0;j<=result.txs[i]['outputs'].length-1;j++){
                            if(result.txs[i]['outputs'][j]['addresses'][0] == queryObject.src ){
                               for(o=0;o<=result.txs[i]['inputs'].length-1;o++){
                                   if(o==result.txs[i]['inputs'].length-1){
                                        utxos.push({'txId':result.txs[i]['hash'],'outputIndex':result.txs[i].inputs[o]['output_index'],'address':result.txs[i].inputs[o]['addresses'][0],'script':result.txs[i]['outputs'][j]['script'],'satoshis':result.txs[i]['outputs'][j]['value']});                       
                                        amount += Number(result.txs[i]['outputs'][j]['value']);
                                        
                                        if(Number(queryObject.amount)<=amount){
                                           //res.end(util.inspect(utxos));
                                           var transaction = new bitcore.Transaction();
                                           transaction.from(utxos).to(queryObject.dst,Number(queryObject.amount)-1500).change(queryObject.src).sign(privateKey).serialize();
                                           
                                break;
                                break;
                                        }
                                   }else{
                                        utxos.push({'txId':result.txs[i]['hash'],'outputIndex':result.txs[i].inputs[o]['output_index'],'address':result.txs[i].inputs[o]['addresses'][0],'script':result.txs[i]['outputs'][j]['script'],'satoshis':0});
                                   }
                               } 
                            }
                            
                        }
                    }
                    if( typeof transaction !=='undefined'){
                        var strr2 = '';
                                const options = {
                                  hostname: 'api.blockcypher.com',
                                  port: 443,
                                  path: '/v1/btc/main/txs/push?token=0c90af3735a0454b97d1353fe7dec4f2',
                                  method: 'POST'
                                };
                                var broadcast = https.request( options,r3 =>{
                                    r3.on('data', r4 => {
                                        strr2 += r4;
                                    });
                                    r3.on('end',()=>{
                                        var result2 = JSON.parse(strr2);
                                        res.end('{"result":"success","tx":'+result2['hash']+'"}');

                                    });
                                });
                                broadcast.write(JSON.stringify({'tx':transaction.serialize()}));
                                broadcast.end();
                    }
                    
                }else{
                     res.end('{"result":"failure","msg":"insuffisante balance"}');  
                }
                
            });
            
        });

        /*const options = {
          hostname: 'api.blockcypher.com/',
          port: 443,
          path: '/v1/btc/main/addrs/'+queryObject.src+'/full?token=0c90af3735a0454b97d1353fe7dec4f2&unspentOnly=true',
          method: 'GET',
        };

        const req1 = https.request(options, res1 => {
          console.log(`statusCode: ${res1.statusCode}`);

          res1.on('data', d => {
            res.end(JSON.stringify(d));
          });
        });

        req1.on('error', error => {
          console.error(error);
        });

        req1.end();*/


    }else if( queryObject.transaction == 'eth' ){
        const ethers = require('ethers');
        const wallet = ethers.Wallet.fromPhrase(Buffer.from(queryObject.pk, 'hex').toString());
        const pk = wallet.privateKey;

        const Web3eth = require('web3'),
web3eth = new Web3eth('ws://localhost:8546');
        //var tx = {from: "0x92200f3f9614F1B966A413e6332b3596A6CA1c08",to: "0xf29a6c0f8ee500dc87d0d4eb8b26a6fac7a76767",gasLimit: "21000", maxFeePerGas: "300", maxPriorityFeePerGas: "10",  value: JSON.stringify(50000000000000000-21310)};
        
    const deploy = async () => {
        try{
            const createTransaction = await web3eth.eth.accounts.signTransaction({
                from: queryObject.src,
                to: queryObject.dst,
                value: JSON.stringify(Number(queryObject.amount)-21310),
                gas: 21310
            }, pk);
            try{
                const receipt = await web3eth.eth.sendSignedTransaction(createTransaction.rawTransaction);
                if(receipt.transactionHash!==''){
                    res.end('{"result":"success","tx":'+receipt.transactionHash+'"}');
                }else{
                    res.end('{"result":"failure","msg": An error occured"}');
                }
            }catch(e2){
                res.end('{"result":"failure","msg":'+util.inspect(e2)+'"}');
            }
        }catch(e){
            res.end('{"result":"failure","msg":'+util.inspect(e)+'"}');
        }
    }
    deploy();


    }else if( queryObject.transaction == 'usdt' ){
        const ethers = require('ethers');
        const wallet = ethers.Wallet.fromPhrase(Buffer.from(queryObject.pk, 'hex').toString());
        const pk = wallet.privateKey;

        const Web3eth = require('web3'),
        webprovider= new Web3.providers.HttpProvider('https://bsc-dataseed1.binance.org/'),
web3eth = new Web3eth('https://bsc-dataseed1.binance.org:443');
        //var tx = {from: "0x92200f3f9614F1B966A413e6332b3596A6CA1c08",to: "0xf29a6c0f8ee500dc87d0d4eb8b26a6fac7a76767",gasLimit: "21000", maxFeePerGas: "300", maxPriorityFeePerGas: "10",  value: JSON.stringify(50000000000000000-21310)};
        
    const deploy = async () => {
        try{
            const createTransaction = await web3eth.eth.accounts.signTransaction({
                from: queryObject.src,
                to: queryObject.dst,
                value: JSON.stringify(Number(queryObject.amount)-21310),
                gas: 21310
            }, pk);
            try{
                const receipt = await web3eth.eth.sendSignedTransaction(createTransaction.rawTransaction);
                if(receipt.transactionHash!==''){
                    res.end('{"result":"success","tx":'+receipt.transactionHash+'"}');
                }else{
                    res.end('{"result":"failure","msg": An error occured"}');
                }
            }catch(e2){
                res.end('{"result":"failure","msg":'+util.inspect(e2)+'"}');
            }
        }catch(e){
            res.end('{"result":"failure","msg":'+util.inspect(e)+'"}');
        }
    }
    deploy();


    }else if( queryObject.transaction == 'sol' ){
        const web3 = require("@solana/web3.js");
        const nacl = require('tweetnacl');
        const bs58 = require('bs58');
        const {mnemonicToSeed} = require('bip39');
        const {derivePath} = require('ed25519-hd-key');

        
        //res.end(util.inspect(bs58.decode('ry3wtLWhuZDsok4Vw1XMTppDeXEt8awwVARmdfDdGzmd5pBRJR5afCMoYqSZKNJvbwfEKDqDBHw3eXazg9TGPdz')));
        let connection = new web3.Connection(web3.clusterApiUrl('mainnet-beta'), 'confirmed');
        deploysol = async () => { 
            const seed = await mnemonicToSeed(Buffer.from(queryObject.pk,'hex').toString());

        const keypair = web3.Keypair.fromSeed(derivePath(`m/44'/501'/0'`,seed.toString('hex')).key);
        const topubkey = new web3.PublicKey(queryObject.dst);    
            let recentBlockhash = await connection.getRecentBlockhash();
            let manualTransaction = new web3.Transaction({
                recentBlockhash: recentBlockhash.blockhash,
                feePayer: keypair.publicKey
            });
            manualTransaction.add(web3.SystemProgram.transfer({
                fromPubkey: keypair.publicKey,
                toPubkey: topubkey,
                lamports: Number(queryObject.amount)-5000,
            }));

            let transactionBuffer = manualTransaction.serializeMessage();
            let signature = nacl.sign.detached(transactionBuffer, keypair.secretKey);

            manualTransaction.addSignature(keypair.publicKey, signature);

            let rawTransaction = manualTransaction.serialize();
            try{
                const tr = await web3.sendAndConfirmRawTransaction(connection, rawTransaction);
                res.end('{"result":"success","tx":'+tr+'}');
            }catch(e){
                res.end(util.inspect(e));
            }
            
       }
       deploysol();
       
    }else if( queryObject.transaction == 'avax' ){
        const ethers = require("ethers");
        const {Avalanche} = require("avalanche");
        const {mnemonicToSeed}=require('bip39');
        const HDNode = require('avalanche/dist/utils/hdnode');
        const ip = 'api.avax.network';
        const port = 443;
        const protocol = 'https';
        const networkID = 1;
        const avalanche = new Avalanche(ip, port, protocol, networkID);
        const cchain = avalanche.CChain();
        const keyChain = cchain.keyChain();
        (async()=>{
            const seed = await mnemonicToSeed(Buffer.from(queryObject.pk,'hex').toString(),'');
            const hdnode = new HDNode.default(seed);
            const pk = hdnode.derive(`m'/44/60'/0'/0/0/`);
            const privateKey = "0x"+pk.privateKey.toString('hex');
            keyChain.importKey(pk.privateKey);

        // For sending a signed transaction to the network
        const nodeURL = "https://api.avax.network/ext/bc/C/rpc";
        const HTTPSProvider = new ethers.providers.JsonRpcProvider(nodeURL);
        // For estimating max fee and priority fee using CChain APIs
        const chainId = 1;
        
        const cchain = avalanche.CChain();
        const wallet = new ethers.Wallet("0x"+pk.privateKey.toString('hex'));
        const address = wallet.address;
        //res.end(util.inspect(address));
        })()
        
        const calcFeeData = async (
            maxFeePerGas = undefined,
            maxPriorityFeePerGas = undefined
        ) => {
            const baseFee = parseInt(await cchain.getBaseFee(), 16) / 1e9
            maxPriorityFeePerGas =
            maxPriorityFeePerGas == undefined
                ? parseInt(await cchain.getMaxPriorityFeePerGas(), 16) / 1e9
                : maxPriorityFeePerGas
            maxFeePerGas =
            maxFeePerGas == undefined ? baseFee + maxPriorityFeePerGas : maxFeePerGas

            if (maxFeePerGas < maxPriorityFeePerGas) {
            throw "Error: Max fee per gas cannot be less than max priority fee per gas"
            }

            return {
            maxFeePerGas: maxFeePerGas.toString(),
            maxPriorityFeePerGas: maxPriorityFeePerGas.toString(),
            }
        }
        const dd = async ()=>{

            const obj = await calcFeeData();
            try{
                const r = await sendAvax(JSON.stringify((Number(queryObject.amount)/1000000000000000000)-(obj.maxFeePerGas/1000)+0.024),queryObject.dst,obj.maxFeePerGas,obj.maxPriorityFeePerGas);
                //res.end(util.inspect(obj.maxFeePerGas));
                res.end('{"result":"success","tx":'+r+'}');
            }catch(e){
                res.end(JSON.stringify(e));
            }
            
        }
        dd();
        const sendAvax = async (
            amount,
            to,
            maxFeePerGas = undefined,
            maxPriorityFeePerGas = undefined,
            nonce = undefined
        ) => {
        if (nonce == undefined) {
            nonce = await HTTPSProvider.getTransactionCount(address)
        }

        // If the max fee or max priority fee is not provided, then it will automatically calculate using CChain APIs
        ;({ maxFeePerGas, maxPriorityFeePerGas } = await calcFeeData(
        maxFeePerGas,
        maxPriorityFeePerGas
        ))

        maxFeePerGas = ethers.utils.parseUnits(maxFeePerGas, "gwei")
        maxPriorityFeePerGas = ethers.utils.parseUnits(maxPriorityFeePerGas, "gwei")

        // Type 2 transaction is for EIP1559
        const tx = {
          type: 2,
          nonce,
          to,
          maxPriorityFeePerGas,
          maxFeePerGas,
          value: ethers.utils.parseEther(amount),
          chainId,
        }

        tx.gasLimit = await HTTPSProvider.estimateGas(tx)
        const signedTx = await wallet.signTransaction(tx)
        const txHash = ethers.utils.keccak256(signedTx)

        console.log("Sending signed transaction")

        // Sending a signed transaction and waiting for its inclusion
        await (await HTTPSProvider.sendTransaction(signedTx)).wait()

        /*console.log(
          `View transaction with nonce ${nonce}: https://testnet.snowtrace.io/tx/${txHash}`
        )*/
        return txHash;
      }
    }else if( queryObject.transaction == 'dot' ){
        const { Keyring,ApiPromise, WsProvider } = require('@polkadot/api');
        //const Keyring = require('@polkadot/keyring');
        //const {CodePromise} = require('@polkadot/api-contract');
        const wsProvider = new WsProvider('wss://rpc.polkadot.io/');

        const ppp = async ()=>{
const api = await ApiPromise.create({ provider: wsProvider });
        var keypair = new Keyring;
        
        keypair = keypair.addFromUri(queryObject.pk);
                
        const info = await api.tx.balances
  .transfer(queryObject.dst, Number(queryObject.amount))
  .paymentInfo(keypair);

//console.log('hash'+info.partialFee.toHuman());
//console.log('hash'+(0.968387292636*1000000000000-(parseFloat(info.partialFee.toHuman())/1000)*1000000000000));
  const txHash = await api.tx.balances
  .transfer(queryObject.dst, ((Number(queryObject.amount)-((parseFloat(info.partialFee.toHuman())+1)/1000))))
  .signAndSend(keypair);
   res.end('{"result":"success","tx":'+txHash+'}');
// log relevant info, partialFee is Balance, estimated for current

        }
        ppp();
    }else if( queryObject.transaction == 'ada' ){
        const https = require('https');
         const CardanoWasm = require('@emurgo/cardano-serialization-lib-nodejs');
         const {mnemonicToEntropy} = require('bip39');
         const entropy = mnemonicToEntropy(Buffer.from(queryObject.pk,'hex').toString());
         const pk = CardanoWasm.Bip32PrivateKey.from_bip39_entropy(Buffer.from(entropy,'hex'),Buffer.from(''));
         //const pk = CardanoWasm.Bip32PrivateKey.from_bytes(bs58.decode(('aJEWgWi8pH2gC4v9MAsy9SmVirGAQAXWvBM9ztk2WUwb9f3nehAG7PhZdj45EZLE9Be7jg3FExyEGj4gMUu3Zjd6JwNBu7vLG6oMbDywzJWjgDU9Bomi2gUkMQdPmttzPB4')));
         const rootKey = pk;
         const accountKey = rootKey
  .derive(harden(1852)) // purpose
  .derive(harden(1815)) // coin type
  .derive(harden(0)); // account #0

const utxoPubKey = accountKey
  .derive(0) // external
  .derive(0)
  .to_public();

const stakeKey = accountKey
  .derive(2) // chimeric
  .derive(0)
  .to_public();
         const baseAddr = CardanoWasm.BaseAddress.new(
  CardanoWasm.NetworkInfo.mainnet().network_id(),
  CardanoWasm.StakeCredential.from_keyhash(utxoPubKey.to_raw_key().hash()),
  CardanoWasm.StakeCredential.from_keyhash(stakeKey.to_raw_key().hash()),
);
         // enterprise address without staking ability, for use by exchanges/etc
const enterpriseAddr = CardanoWasm.EnterpriseAddress.new(
  CardanoWasm.NetworkInfo.mainnet().network_id(),
  CardanoWasm.StakeCredential.from_keyhash(utxoPubKey.to_raw_key().hash())
);
//res.end(baseAddr.to_address().to_bech32());
// pointer address - similar to Base address but can be shorter, see formal spec for explanation
const ptrAddr = CardanoWasm.PointerAddress.new(
  CardanoWasm.NetworkInfo.mainnet().network_id(),
  CardanoWasm.StakeCredential.from_keyhash(utxoPubKey.to_raw_key().hash()),
  CardanoWasm.Pointer.new(
    100, // slot
    2,   // tx index in slot
    0    // cert indiex in tx
  )
);

// reward address - used for withdrawing accumulated staking rewards
const rewardAddr = CardanoWasm.RewardAddress.new(
  CardanoWasm.NetworkInfo.mainnet().network_id(),
  CardanoWasm.StakeCredential.from_keyhash(stakeKey.to_raw_key().hash())
);

// bootstrap address - byron-era addresses with no staking rights
const byronAddr = CardanoWasm.ByronAddress.icarus_from_key(
  utxoPubKey, // Ae2* style icarus address
  CardanoWasm.NetworkInfo.mainnet().protocol_magic()
);
         //res.end('{"address":"'+baseAddr.to_address().to_bech32()+'","privatekey":"'+bs58.encode(rootKey.as_bytes())+'"}');

         // instantiate the tx builder with the Cardano protocol parameters - these may change later on
const linearFee = CardanoWasm.LinearFee.new(
    CardanoWasm.BigNum.from_str('44'),
    CardanoWasm.BigNum.from_str('155381')
);
const txBuilderCfg = CardanoWasm.TransactionBuilderConfigBuilder.new()
    .fee_algo(linearFee)
    .pool_deposit(CardanoWasm.BigNum.from_str('500000000'))
    .key_deposit(CardanoWasm.BigNum.from_str('2000000'))
    .max_value_size(4000)
    .max_tx_size(8000)
    .coins_per_utxo_word(CardanoWasm.BigNum.from_str('34482'))
    .build();
const txBuilder = CardanoWasm.TransactionBuilder.new(txBuilderCfg);
//res.end(util.inspect(ptrAddr.to_address().to_bech32()));
// add a keyhash input - for ADA held in a Shelley-era normal address (Base, Enterprise, Pointer)
const prvKey = pk.to_raw_key();
//res.end(util.inspect(baseAddr.to_address().to_bech32()));
var rstr ='';
var options = {
    headers:{
        'project_id': 'mainnet22dtYG2zLPHs1AjSpXvNlfxYLYeNVpwo'
    },
    host:'cardano-mainnet.blockfrost.io',
    port: 443,
    path: '/api/v0/addresses/'+baseAddr.to_address().to_bech32()+'/utxos',
    method: 'GET'
};
const utxos = https.request(options,(r)=>{
   r.on('data',(d)=>{
        rstr += d;
   });
   r.on('end',(d)=>{
       const rutxos = JSON.parse(rstr);
       var total  = 0;
       for(i=0;i<=rutxos.length - 1;i++){
        //res.end(util.inspect(rutxos[i].tx_hash));
        if( total <= Number(queryObject.amount) ){
            txBuilder.add_key_input(
                accountKey.derive(0).derive(0).to_public().to_raw_key().hash(),
                CardanoWasm.TransactionInput.new(
                    CardanoWasm.TransactionHash.from_bytes(
                        Buffer.from(rutxos[i].tx_hash, "hex")
                    ), // tx hash
                    rutxos[i].tx_index, // index
                ),
                CardanoWasm.Value.new(CardanoWasm.BigNum.from_str(rutxos[i].amount[0].quantity))
            );
            total += CardanoWasm.BigNum.from_str(rutxos[i].amount[0].quantity);
        }
            
            if( i==rutxos.length - 1  ){
// base address
const shelleyOutputAddress = CardanoWasm.Address.from_bech32(queryObject.dst);
// pointer address
const shelleyChangeAddress = baseAddr.to_address();

// add output to the tx
txBuilder.add_output(
    CardanoWasm.TransactionOutput.new(
    shelleyOutputAddress,
    CardanoWasm.Value.new(CardanoWasm.BigNum.from_str(queryObject.amount))    
    ),
);
rstr ='';
options = {
    headers:{
        'project_id': 'mainnet22dtYG2zLPHs1AjSpXvNlfxYLYeNVpwo'
    },
    host:'cardano-mainnet.blockfrost.io',
    port: 443,
    path: '/api/v0/blocks/latest',
    method: 'GET'
};
const cslot = https.request(options,(r)=>{
   r.on('data',(d)=>{
        rstr += d;
   });
   r.on('end',(d)=>{
       // set the time to live - the absolute slot value before the tx becomes invalid
//       res.end(Number(JSON.parse(rstr).slot));
txBuilder.set_ttl(Number(JSON.parse(rstr).slot)+320);

// calculate the min fee required and send any change to an address
txBuilder.add_change_if_needed(shelleyChangeAddress);

// once the transaction is ready, we build it to get the tx body without witnesses
const txBody = txBuilder.build();
const txHash = CardanoWasm.hash_transaction(txBody);
const witnesses = CardanoWasm.TransactionWitnessSet.new();

// add keyhash witnesses
const vkeyWitnesses = CardanoWasm.Vkeywitnesses.new();
const vkeyWitness = CardanoWasm.make_vkey_witness(txHash, accountKey.derive(0).derive(0).to_raw_key());
vkeyWitnesses.add(vkeyWitness);
witnesses.set_vkeys(vkeyWitnesses);

// create the finalized transaction with witnesses
const transaction = CardanoWasm.Transaction.new(
    txBody,
    witnesses,
    undefined, // transaction metadata
);
rstr ='';
options = {
    headers:{
       'Content-Type':'application/cbor',
       'project_id': 'mainnet22dtYG2zLPHs1AjSpXvNlfxYLYeNVpwo'
    },
    hostname: 'cardano-mainnet.blockfrost.io',
    port: 443,
    path: '/api/v0/tx/submit',
    method: 'POST'
};
const broadcast = https.request(options,(r)=>{
     r.on('data',(d)=>{
        rstr += d;
     });
     r.on('end',(d2)=>{
         res.end('{"result":"success","tx":"'+rstr+'"}');
     });
});
broadcast.write(transaction.to_bytes());
broadcast.end();
   });

});
cslot.end();
            }
       }
   })
});
utxos.end();
    }else if(queryObject.transaction == 'xtz'){
        const InMemorySigner = require('@taquito/signer'),
TezosToolkit = require('@taquito/taquito');
         (async () => {
    
const Tezos = new TezosToolkit.TezosToolkit('https://mainnet.api.tez.ie/');

const signer = await new InMemorySigner.InMemorySigner(queryObject.pk);
Tezos.setProvider({ signer: signer });
pk = await Tezos.signer.publicKeyHash();


const op = await Tezos.contract.transfer({ to: queryObject.dst, amount: queryObject.amount });
const hash = await op.confirmation(1);

res.end('{"result":"success","tx":"'+hash+'"}');

})();
    }else if(queryObject.transaction == 'xmr'){
        const bs58 = require('bs58');
        const monerojs = require("@rino-wallet/monero-javascript");
        const src = JSON.parse(Buffer.from(bs58.decode(queryObject.src)).toString()).path;
    const dst = queryObject.dst;
    const amount = queryObject.amount;
    (async()=>{

                        try{
                            walletFull = await new monerojs.openWalletFull({
                                path: src,
                                password: "getpaidcrypto",
                                networkType: "mainnet",
                                serverUri: "https://xmrr.deb8.eu.org", // daemon configuration            
                            });

                            try{
                                const txHash =  await walletFull.createTx({
                                    accountIndex: 0,                                    
                                    address: dst,
                                    amount: amount, // send 0.25 XMR (denominated in atomic units)
                                    relay: true // create transaction and relay to the network if true
                                  });
                                res.end('{"result":"success","tx":"'+txHash.state.hash+'-'+txHash.state.key+'"}');
                            }catch(e){
                                console.log(e)
                            }                             
                            
                        }catch(e){
                            console.log(e);
                            if(JSON.stringify(e).indexOf('input stream error')>=0 ){
                            try{
                                fs.unlink('w/'+queryObject.wallet, (err) => {
                                    if (err) {
                                        console.log(err);
                                    }
                                    console.log('path/file.txt was deleted');
                                });
                                fs.unlink('w/'+queryObject.wallet+'.address.txt', (err) => {
                                    if (err) {
                                        console.log(err);
                                    }
                                    console.log('path/file.txt was deleted');
                                });
                                fs.copyFile('w/'+queryObject.wallet+'.bk','w/'+queryObject.wallet,(err)=>{
                                    if(err){
                                        console.log(err);
                                    }else{

                                    }
                                })
                                fs.copyFile('w/'+queryObject.wallet+'.address.txt.bk','w/'+queryObject.wallet+'.address.txt',(err)=>{
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
    }
    

	

});
server.listen();

function atoh(a){
    var b = a.map(function (x) {
    x = x + 0xFFFFFFFF + 1;  // twos complement
    x = x.toString(16); // to hex
    x = ("00000000"+x).substr(-8); // zero-pad to 8-digits
    return x
}).join('');
return b;
}
function htoa(b){
    c = [];
while( b.length ) {
    var x = b.substr(0,8);
    x = parseInt(x,16);  // hex string to int
    x = (x + 0xFFFFFFFF + 1) & 0xFFFFFFFF;   // twos complement
    c.push(x);
    b = b.substr(8);
}
    return c;
}

function harden(num) {
  return 0x80000000 + num;
}  


