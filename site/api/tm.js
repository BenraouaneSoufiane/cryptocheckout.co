const monerojs = require("@rino-wallet/monero-javascript");
const bs58 = require('bs58');
const pk = 'BSdQEwAP3kyuqiPdHGSH36XzCtMdDfRWuhY8JxDsDHXscRD5RY74D869uovi5Vh58PoRnebRNbcva19j5NoWmm5Khx5Do44zteLVL4uZcq5MapzUY3JAQZeTC5U6UcKXpVp1nrSJMi1vaEd937ZJoEyPQofcK1kCFK8izpproKvAMgTzHyAWPuFsBkC3Z6dcYiXkHMRPcQhF4Mpp2nJMqdaAEXtUhps5AkAmRaoHMEJevMQVKQ9K9vdMnHn1dWwxA134MpLXtSjfcWQBCAayM83sCAPtGGqCj1TGdcaCGbgYieMSKTLZTDrG9souRmq4RBBykAUc';
const mn = JSON.parse(Buffer.from(bs58.decode(pk)).toString())['mn'];
const height = JSON.parse(Buffer.from(bs58.decode(pk)).toString())['height'];
(async()=>{
	/*walletFull = await monerojs.createWalletFull({
              path: 'C:/Apache24/htdocs/crypto.translatewp.online/api/w/wallet',
              password: "ziqsou2011",
              networkType: "stagenet",
              serverUri: "http://stagenet.xmr-tw.org:38081", 
              mnemonic: mn,
              restoreHeight: height
            });*/
	
	/*keys={};
	keys['PrivateSpendKey']='148276414796803b7c2e0819fb989bc0711605530a503605f4ed155d8190a70e';
	keys['PrivateViewKey']='f56c19f2cb50c1e7861fffc171cb30070c3e09ff922380608bcb8424b1a3d603';
	keys['PublicSpendKey']='406321806bef1a1cef2439d9f760b24479631365469006c516ba901523c5d73b';
	keys['PublicViewKey']='fc34e6f06262ed47642b43c01b3608788a092f6785dbb35a751bcb4fc0450de8';
	const wkeys = Buffer.from(JSON.stringify(keys));*/
	walletFull = await monerojs.openWalletFull({
              path: 'C:/Apache24/htdocs/crypto.translatewp.online/api/w/wallet',
              password: "ziqsou2011",
              networkType: "stagenet",
              serverUri: "http://stagenet.xmr-tw.org:38081", 
              /*mnemonic: mn,
              restoreHeight: height*/
            });
	console.log(walletFull);
/*console.log(await walletFull.getPrivateSpendKey());
console.log(await walletFull.getPrivateViewKey());
console.log(await walletFull.getPublicSpendKey());
console.log(await walletFull.getPublicViewKey());*/

})()
