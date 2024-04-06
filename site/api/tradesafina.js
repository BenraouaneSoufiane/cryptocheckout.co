const Binance = require('node-binance-api');
var binance = new Binance().options({
  APIKEY: 'qst2OnUjsTHaOazKX4AOjW77CPSt6UE6iDpiVUKEak12SaWK8dCs76d3HA92GH6h',
  APISECRET: 't9rWm91KlrcaCdWB4EUuIz1nXJnUP2Vno9H7Rqx48qMTKPW5TC5gXQf30F9xii0y'
});

var balance = p1 = p2 = p3 = p4 = sellPrice = 0.00000000, isset = risk = buy = false,t1 = t2 = sellOrderId = buyOrderId = 0;
var p4c = p3c = p2c = 0, p4s = true; var p4s = p3s = false;
    var l = setInterval(function(){

      if(typeof p == 'undefined' || p._destroyed===false  ){
        
          var p = setInterval(function(){
      binance.prices('BTCBUSD', (error, ticker) => {
if( p4s === true ){
      //console.info("Price of ETH: ", ticker.BTCBUSD);
      try{

        if( typeof ticker.BTCBUSD !=='undefined' ){
          

          if( buy === false  ){
if( ticker.BTCBUSD < p1 ){
        if(p2===0.00000000){
          p2 = ticker.BTCBUSD;
        }else if(ticker.BTCBUSD < p2){
          if(p3===0.00000000){
            p3 = ticker.BTCBUSD;            
          }else if(ticker.BTCBUSD < p3){
            if(p4===0.00000000){
              p4 = ticker.BTCBUSD;
            }else{
                //console.log('p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n"+'price: '+ticker.BTCBUSD+"\n"+"dif: "+(p1-p4));  
                //p1 = ticker.BTCBUSD;
                //p1 = p2 = p3 = p4 = 0.00000000;
                               
            }            
          }else{
            p1 = ticker.BTCBUSD;
            p2 = p3 = p4 = 0.00000000;
          }
        }else{
          p1 = ticker.BTCBUSD;
          p2 = p3 = p4 = 0.00000000;
        }        
      }else{
        if(p1===0.00000000){
          p1 = ticker.BTCBUSD;
        }else{
          p1 = ticker.BTCBUSD;
          p2 = p3 = p4 = 0.00000000;
        }        
      }

      if(p1 !== 0.00000000 && p4 !== 0.00000000  ){
        
                 /*console.log('quantity:'+parseFloat(parseFloat(balance/parseFloat(ticker.BTCBUSD)).toFixed(5)));
                 console.log('price:'+parseFloat(ticker.BTCBUSD));
                 console.log('sellPrice:'+parseFloat((parseFloat((p1-p4)/2)+parseFloat(p4)).toFixed(5)));*/
binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
          
        }else{
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
          binance.buy("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
            if( error){
              console.log(error.statusMessage);
              if(error.statusMessage === 'Bad Request'){
                (async()=>{
                await binance.useServerTime();
                binance.balance((error, balances) => {
                    if ( error )  {
                      console.log(error.statusMessage+'balance!');
                    }else{
                      binance.buy("BTCBUSD", 0.0029-parseFloat(balances.BUSD.available).toFixed(4), parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
                        if( error){
                          console.log(error.statusMessage);
                          if(error.statusMessage === 'Bad Request'){
                            clearInterval(p);
                            p1 = p2 = p3 = p4 = 0.00000000;
                          }else if( typeof response.orderId !== 'undefined' ){
                            console.info("Limit Buy response", response);
                            console.info("Buy order id: " + response.orderId);
                            buyPrice = ticker.BTCBUSD;
                            sellPrice = parseFloat((parseFloat((p1-p4))+parseFloat(p4)).toFixed(2));
                            buyOrderId = response.orderId;
                            buy = true;              
                          }
                        }
                      });                    
                    }
                    
                });
                })()
                                  
              }
            }
            if( typeof response.orderId !== 'undefined' ){
              console.info("Limit Buy response", response);
              console.info("Buy order id: " + response.orderId);
              buyPrice = ticker.BTCBUSD;
              sellPrice = parseFloat((parseFloat((p1-p4))+parseFloat(p4)).toFixed(2));
              buyOrderId = response.orderId;
              buy = true;              
            }             
            
          });
        }else if( parseFloat(ticker.BTCBUSD) < sellPrice-3 ){
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            //p1 = p2 = p3 = p4 = 0.00000000;
            buy = true;
            }catch(e){
              console.log(e);
            }
            
          })()
        }}});
          //binance.buy("BTCBUSD", balances.BUSD.available/ticker.BTCBUSD, ticker.BTCBUSD);
           
          
          
          

          
          
          
        
        
        
      }
      if(p4c === 10 && p4 === 0.00000000 ){
         p4s = false;
         p4c = 0;
      }
      if( p4 === 0.00000000 ){
          p4c = p4c + 1;
      }
      
      console.log('price: '+ticker.BTCBUSD+"\n"+"dif: "+(p1-p2)+"\n"+'p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n");
    }else if( buy === true && ticker.BTCBUSD > sellPrice && sellPrice !== 0.00000000 ){
         binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
            }catch(e){
              console.log(e);
            }
            
          })()
          
        }else{
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
          console.log('Now it is more than p1-p4/2');
        console.log('price p1-p4/2: '+sellPrice);
        console.log('price market: '+ticker.BTCBUSD);   
      binance.sell("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type:'LIMIT'}, (error, response) => {
        console.info("Limit Buy response", response);
        console.info("Sell order id: " + response.orderId);
        console.log('dif: '+(p1-p2));
        if(typeof response.orderId !=='undefined'){         
          
          p1 = p2 = p3 = p4 = 0.00000000;
          buy = false;
          p4c = 0;
        }        
      }); 
        }else if((buy ===false && parseFloat(ticker.BTCBUSD)<(sellPrice-3) && sellPrice !== 0.00000000 ) || (parseFloat(ticker.BTCBUSD)>buyPrice && buy===true && buyPrice !== 0.00000000) ){
          if(buy === true ){
(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            binance.buy("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
            if( error){
              console.log(error.statusMessage);
              if(error.statusMessage === 'Bad Request'){
                (async()=>{
                await binance.useServerTime();
                binance.balance((error, balances) => {
                    if ( error )  {
                      console.log(error.statusMessage+'balance!');
                    }else{
                      binance.buy("BTCBUSD", 0.0029-parseFloat(balances.BUSD.available).toFixed(4), parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
                        if( error){
                          console.log(error.statusMessage);
                          if(error.statusMessage === 'Bad Request'){
                            clearInterval(p);
                            p1 = p2 = p3 = p4 = 0.00000000;
                          }else if( typeof response.orderId !== 'undefined' ){
                            console.info("Limit Buy response", response);
                            console.info("Buy order id: " + response.orderId);
                            buyPrice = ticker.BTCBUSD;
                            sellPrice = (parseFloat(ticker.BTCBUSD)+parseFloat((p1-p4))).toFixed(2);
                            buyOrderId = response.orderId;
                            buy = true;              
                          }
                        }
                      });                    
                    }
                    
                });
                })()
                                  
              }
            }
            if( typeof response.orderId !== 'undefined' ){
              console.info("Limit Buy response", response);
              console.info("Buy order id: " + response.orderId);
              buyPrice = ticker.BTCBUSD;
              sellPrice = (parseFloat(ticker.BTCBUSD)+parseFloat((p1-p4))).toFixed(2);
              buyOrderId = response.orderId;
              buy = true;              
            }             
            
          });
            }catch(e){
              console.log(e);
            }
            
          })()
          }else{
            (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = true;
            }catch(e){
              console.log(e);
            }
            
          })()
          }
          
          
        }
        }
        
        
      });
            
    }else if( buy === true && sellPrice !== 0.00000000 && parseFloat(ticker.BTCBUSD)<(sellPrice-3)){
      binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;            
            buy = false;
            clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
            }catch(e){
              console.log(e);
            }
            
          })()
        }else{
          
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
      binance.sell("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type:'LIMIT'}, (error, response) => {
        console.info("Limit Buy response", response);
        console.info("Sell order id: " + response.orderId);
        if(typeof response.orderId !=='undefined'){
          p4s = false;
          p1 = p2 = p3 = p4 = 0.00000000;
          buy = false;
        }        
      });
        console.log('Still not more than p1-p4/2');
        console.log('price p1-p4/2 '+sellPrice);
        console.log('price market: '+ticker.BTCBUSD);
      }}});
    }
    

  }else if( buy === false ){
    clearInterval(p);
/*(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
            }catch(e){
              console.log(e);
            }
            
          })()*/
        }
      }catch(e){
        console.log(e);
        if( buy === false ){
        /*(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
            }catch(e){
              console.log(e);
            }
            
          })()*/
          clearInterval(p);
        }
      }
      
        

      }else if( p3s === true ){
try{

        if( typeof ticker.BTCBUSD !=='undefined' ){
          

          if( buy === false  ){
if( ticker.BTCBUSD < p1 ){
        if(p2===0.00000000){
          p2 = ticker.BTCBUSD;
        }else if(ticker.BTCBUSD < p2){
          if(p3===0.00000000){
            p3 = ticker.BTCBUSD;            
          }else if(ticker.BTCBUSD < p3){
            if(p4===0.00000000){
              p4 = ticker.BTCBUSD;
            }else{
                //console.log('p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n"+'price: '+ticker.BTCBUSD+"\n"+"dif: "+(p1-p4));  
                //p1 = ticker.BTCBUSD;
                //p1 = p2 = p3 = p4 = 0.00000000;
                               
            }            
          }else{
            p1 = ticker.BTCBUSD;
            p2 = p3 = p4 = 0.00000000;
          }
        }else{
          p1 = ticker.BTCBUSD;
          p2 = p3 = p4 = 0.00000000;
        }        
      }else{
        if(p1===0.00000000){
          p1 = ticker.BTCBUSD;
        }else{
          p1 = ticker.BTCBUSD;
          p2 = p3 = p4 = 0.00000000;
        }        
      }

      if(p1 !== 0.00000000 && p3 !== 0.00000000  ){
        
                 /*console.log('quantity:'+parseFloat(parseFloat(balance/parseFloat(ticker.BTCBUSD)).toFixed(5)));
                 console.log('price:'+parseFloat(ticker.BTCBUSD));
                 console.log('sellPrice:'+parseFloat((parseFloat((p1-p4)/2)+parseFloat(p4)).toFixed(5)));*/
binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
          
        }else{
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
          binance.buy("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
            if( error){
              console.log(error.statusMessage);
              if(error.statusMessage === 'Bad Request'){
                (async()=>{
                await binance.useServerTime();
                binance.balance((error, balances) => {
                    if ( error )  {
                      console.log(error.statusMessage+'balance!');
                    }else{
                      binance.buy("BTCBUSD", 0.0029-parseFloat(balances.BUSD.available).toFixed(4), parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
                        if( error){
                          console.log(error.statusMessage);
                          if(error.statusMessage === 'Bad Request'){
                            clearInterval(p);
                            p1 = p2 = p3 = p4 = 0.00000000;
                          }else if( typeof response.orderId !== 'undefined' ){
                            console.info("Limit Buy response", response);
                            console.info("Buy order id: " + response.orderId);
                            buyPrice = ticker.BTCBUSD;
                            sellPrice = parseFloat((parseFloat((p1-p3))+parseFloat(p3)).toFixed(2));
                            buyOrderId = response.orderId;
                            buy = true;              
                          }
                        }
                      });                    
                    }
                    
                });
                })()
                                  
              }
            }
            if( typeof response.orderId !== 'undefined' ){
              console.info("Limit Buy response", response);
              console.info("Buy order id: " + response.orderId);
              buyPrice = ticker.BTCBUSD;
              sellPrice = parseFloat((parseFloat((p1-p3))+parseFloat(p3)).toFixed(2));
              buyOrderId = response.orderId;
              buy = true;              
            }             
            
          });
        }else if( parseFloat(ticker.BTCBUSD) < sellPrice-3 ){
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            //p1 = p2 = p3 = p4 = 0.00000000;
            buy = true;
            }catch(e){
              console.log(e);
            }
            
          })()
        }}});
          //binance.buy("BTCBUSD", balances.BUSD.available/ticker.BTCBUSD, ticker.BTCBUSD);
           
          
          
          

          
          
          
        
        
        
      }
      if(p3c === 10 && p3 === 0.00000000 ){
         p3s = false;
         p3c = 0;
      }
      if( p3 === 0.00000000 ){
          p3c = p3c + 1;
      }
      
      console.log('price: '+ticker.BTCBUSD+"\n"+"dif: "+(p1-p2)+"\n"+'p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n");
    }else if( buy === true && ticker.BTCBUSD > sellPrice && sellPrice !== 0.00000000 ){
         binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
            }catch(e){
              console.log(e);
            }
            
          })()
          
        }else{
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
          console.log('Now it is more than p1-p4/2');
        console.log('price p1-p4/2: '+sellPrice);
        console.log('price market: '+ticker.BTCBUSD);   
      binance.sell("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type:'LIMIT'}, (error, response) => {
        console.info("Limit Buy response", response);
        console.info("Sell order id: " + response.orderId);
        console.log('dif: '+(p1-p2));
        if(typeof response.orderId !=='undefined'){         
          
          p1 = p2 = p3 = p4 = 0.00000000;
          buy = false;
          p3c = 0;
        }        
      }); 
        }else if((buy ===false && parseFloat(ticker.BTCBUSD)<(sellPrice-3) && sellPrice !== 0.00000000 ) || (parseFloat(ticker.BTCBUSD)>buyPrice && buy===true && buyPrice !== 0.00000000) ){
          if(buy === true ){
(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            binance.buy("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
            if( error){
              console.log(error.statusMessage);
              if(error.statusMessage === 'Bad Request'){
                (async()=>{
                await binance.useServerTime();
                binance.balance((error, balances) => {
                    if ( error )  {
                      console.log(error.statusMessage+'balance!');
                    }else{
                      binance.buy("BTCBUSD", 0.0029-parseFloat(balances.BUSD.available).toFixed(4), parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
                        if( error){
                          console.log(error.statusMessage);
                          if(error.statusMessage === 'Bad Request'){
                            clearInterval(p);
                            p1 = p2 = p3 = p4 = 0.00000000;
                          }else if( typeof response.orderId !== 'undefined' ){
                            console.info("Limit Buy response", response);
                            console.info("Buy order id: " + response.orderId);
                            buyPrice = ticker.BTCBUSD;
                            sellPrice = (parseFloat(ticker.BTCBUSD)+parseFloat((p1-p2))).toFixed(2);
                            buyOrderId = response.orderId;
                            buy = true;              
                          }
                        }
                      });                    
                    }
                    
                });
                })()
                                  
              }
            }
            if( typeof response.orderId !== 'undefined' ){
              console.info("Limit Buy response", response);
              console.info("Buy order id: " + response.orderId);
              buyPrice = ticker.BTCBUSD;
              sellPrice = (parseFloat(ticker.BTCBUSD)+parseFloat((p1-p2))).toFixed(2);
              buyOrderId = response.orderId;
              buy = true;              
            }             
            
          });
            }catch(e){
              console.log(e);
            }
            
          })()
          }else{
            (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = true;
            }catch(e){
              console.log(e);
            }
            
          })()
          }
          
          
        }
        }
        
        
      });
            
    }else if( buy === true && sellPrice !== 0.00000000 && parseFloat(ticker.BTCBUSD)<(sellPrice-3)){
      binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;            
            buy = false;
            clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
            }catch(e){
              console.log(e);
            }
            
          })()
        }else{
          
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
      binance.sell("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type:'LIMIT'}, (error, response) => {
        console.info("Limit Buy response", response);
        console.info("Sell order id: " + response.orderId);
        if(typeof response.orderId !=='undefined'){
          
          p1 = p2 = p3 = p4 = 0.00000000;
          buy = false;
          p3s = false;
        }        
      });
        console.log('Still not more than p1-p4/2');
        console.log('price p1-p4/2 '+sellPrice);
        console.log('price market: '+ticker.BTCBUSD);
      }}});
    }
    

  }else if( buy === false ){
    clearInterval(p);
/*(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
            }catch(e){
              console.log(e);
            }
            
          })()*/
        }
      }catch(e){
        console.log(e);
        if( buy === false ){
        /*(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
            }catch(e){
              console.log(e);
            }
            
          })()*/
          clearInterval(p);
        }
      }
      }else {
        try{

        if( typeof ticker.BTCBUSD !=='undefined' ){
          

          if( buy === false  ){
if( ticker.BTCBUSD < p1 ){
        if(p2===0.00000000){
          p2 = ticker.BTCBUSD;
        }else if(ticker.BTCBUSD < p2){
          if(p3===0.00000000){
            p3 = ticker.BTCBUSD;            
          }else if(ticker.BTCBUSD < p3){
            if(p4===0.00000000){
              p4 = ticker.BTCBUSD;
            }else{
                //console.log('p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n"+'price: '+ticker.BTCBUSD+"\n"+"dif: "+(p1-p4));  
                //p1 = ticker.BTCBUSD;
                //p1 = p2 = p3 = p4 = 0.00000000;
                               
            }            
          }else{
            p1 = ticker.BTCBUSD;
            p2 = p3 = p4 = 0.00000000;
          }
        }else{
          p1 = ticker.BTCBUSD;
          p2 = p3 = p4 = 0.00000000;
        }        
      }else{
        if(p1===0.00000000){
          p1 = ticker.BTCBUSD;
        }else{
          p1 = ticker.BTCBUSD;
          p2 = p3 = p4 = 0.00000000;
        }        
      }

      if(p1 !== 0.00000000 && p2 !== 0.00000000  ){
        
                 /*console.log('quantity:'+parseFloat(parseFloat(balance/parseFloat(ticker.BTCBUSD)).toFixed(5)));
                 console.log('price:'+parseFloat(ticker.BTCBUSD));
                 console.log('sellPrice:'+parseFloat((parseFloat((p1-p4)/2)+parseFloat(p4)).toFixed(5)));*/
binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
          
        }else{
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
          binance.buy("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
            if( error){
              console.log(error.statusMessage);
              if(error.statusMessage === 'Bad Request'){
                (async()=>{
                await binance.useServerTime();
                binance.balance((error, balances) => {
                    if ( error )  {
                      console.log(error.statusMessage+'balance!');
                    }else{
                      binance.buy("BTCBUSD", 0.0029-parseFloat(balances.BUSD.available).toFixed(4), parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
                        if( error){
                          console.log(error.statusMessage);
                          if(error.statusMessage === 'Bad Request'){
                            clearInterval(p);
                            p1 = p2 = p3 = p4 = 0.00000000;
                          }else if( typeof response.orderId !== 'undefined' ){
                            console.info("Limit Buy response", response);
                            console.info("Buy order id: " + response.orderId);
                            buyPrice = ticker.BTCBUSD;
                            sellPrice = parseFloat((parseFloat((p1-p2))+parseFloat(p2)).toFixed(2));
                            buyOrderId = response.orderId;
                            buy = true;              
                          }
                        }
                      });                    
                    }
                    
                });
                })()
                                  
              }
            }
            if( typeof response.orderId !== 'undefined' ){
              console.info("Limit Buy response", response);
              console.info("Buy order id: " + response.orderId);
              buyPrice = ticker.BTCBUSD;
              sellPrice = parseFloat((parseFloat((p1-p2))+parseFloat(p2)).toFixed(2));
              buyOrderId = response.orderId;
              buy = true;              
            }             
            
          });
        }else if( parseFloat(ticker.BTCBUSD) < sellPrice-3 ){
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            //p1 = p2 = p3 = p4 = 0.00000000;
            buy = true;
            }catch(e){
              console.log(e);
            }
            
          })()
        }}});
          //binance.buy("BTCBUSD", balances.BUSD.available/ticker.BTCBUSD, ticker.BTCBUSD);
           
          
          
          

          
          
          
        
        
        
      }
      
      
      console.log('price: '+ticker.BTCBUSD+"\n"+"dif: "+(p1-p2)+"\n"+'p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n");
    }else if( buy === true && ticker.BTCBUSD > sellPrice && sellPrice !== 0.00000000 ){
         binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
            }catch(e){
              console.log(e);
            }
            
          })()
          
        }else{
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
          console.log('Now it is more than p1-p4/2');
        console.log('price p1-p4/2: '+sellPrice);
        console.log('price market: '+ticker.BTCBUSD);   
      binance.sell("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type:'LIMIT'}, (error, response) => {
        console.info("Limit Buy response", response);
        console.info("Sell order id: " + response.orderId);
        console.log('dif: '+(p1-p2));
        if(typeof response.orderId !=='undefined'){         
          p2c = 0;
          p1 = p2 = p3 = p4 = 0.00000000;
          buy = false;
        }        
      }); 
        }else if((buy ===false && parseFloat(ticker.BTCBUSD)<(sellPrice-3) && sellPrice !== 0.00000000 ) || (parseFloat(ticker.BTCBUSD)>buyPrice && buy===true && buyPrice !== 0.00000000) ){
          if(buy === true ){
(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            binance.buy("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
            if( error){
              console.log(error.statusMessage);
              if(error.statusMessage === 'Bad Request'){
                (async()=>{
                await binance.useServerTime();
                binance.balance((error, balances) => {
                    if ( error )  {
                      console.log(error.statusMessage+'balance!');
                    }else{
                      binance.buy("BTCBUSD", 0.0029-parseFloat(balances.BUSD.available).toFixed(4), parseFloat(ticker.BTCBUSD), {type: 'LIMIT'}, (error, response) => {
                        if( error){
                          console.log(error.statusMessage);
                          if(error.statusMessage === 'Bad Request'){
                            clearInterval(p);
                            p1 = p2 = p3 = p4 = 0.00000000;
                          }else if( typeof response.orderId !== 'undefined' ){
                            console.info("Limit Buy response", response);
                            console.info("Buy order id: " + response.orderId);
                            buyPrice = ticker.BTCBUSD;
                            sellPrice = (parseFloat(ticker.BTCBUSD)+parseFloat((p1-p2))).toFixed(2);
                            buyOrderId = response.orderId;
                            buy = true;              
                          }
                        }
                      });                    
                    }
                    
                });
                })()
                                  
              }
            }
            if( typeof response.orderId !== 'undefined' ){
              console.info("Limit Buy response", response);
              console.info("Buy order id: " + response.orderId);
              buyPrice = ticker.BTCBUSD;
              sellPrice = (parseFloat(ticker.BTCBUSD)+parseFloat((p1-p2))).toFixed(2);
              buyOrderId = response.orderId;
              buy = true;              
            }             
            
          });
            }catch(e){
              console.log(e);
            }
            
          })()
          }else{
            (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = true;
            }catch(e){
              console.log(e);
            }
            
          })()
          }
          
          
        }
        }
        
        
      });
            
    }else if( buy === true && sellPrice !== 0.00000000 && parseFloat(ticker.BTCBUSD)<(sellPrice-3)){
      binance.openOrders('BTCBUSD', (error, openOrders) => {
        if(error){
          console.log(error.statusMessage);
          (async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;            
            buy = false;
            clearInterval(p);
          p1 = p2 = p3 = p4 = 0.00000000;
            }catch(e){
              console.log(e);
            }
            
          })()
        }else{
          
if( openOrders.length  ===0 || typeof openOrders == 'undefined'){
      binance.sell("BTCBUSD", 0.0029, parseFloat(ticker.BTCBUSD), {type:'LIMIT'}, (error, response) => {
        console.info("Limit Buy response", response);
        console.info("Sell order id: " + response.orderId);
        if(typeof response.orderId !=='undefined'){
          
          p1 = p2 = p3 = p4 = 0.00000000;
          buy = false;
          p3s = true;
        }        
      });
        console.log('Still not more than p1-p4/2');
        console.log('price p1-p4/2 '+sellPrice);
        console.log('price market: '+ticker.BTCBUSD);
      }}});
    }
    

  }else if( buy === false ){
    clearInterval(p);
/*(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
            }catch(e){
              console.log(e);
            }
            
          })()*/
        }
      }catch(e){
        console.log(e);
        if( buy === false ){
        /*(async()=>{
            try{
console.info( await binance.cancelAll("BTCBUSD") );
            p1 = p2 = p3 = p4 = 0.00000000;
            buy = false;
            clearInterval(p);
            }catch(e){
              console.log(e);
            }
            
          })()*/
          clearInterval(p);
        }
      }
      }
    });

  
  },950);
      }
    },6000);
    

 




  



