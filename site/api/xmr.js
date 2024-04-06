const Binance = require('node-binance-api');
var binance = new Binance().options({
  APIKEY: 'qst2OnUjsTHaOazKX4AOjW77CPSt6UE6iDpiVUKEak12SaWK8dCs76d3HA92GH6h',
  APISECRET: 't9rWm91KlrcaCdWB4EUuIz1nXJnUP2Vno9H7Rqx48qMTKPW5TC5gXQf30F9xii0y'
});

var p1 = p2 = p3 = p4 = sellPrice = buyPrice = 0.00000000,  buy = false, sellOrderId = buyOrderId = 0;

    var l = setInterval(function(){
      if(typeof p == 'undefined' || p._destroyed===false  ){        
        var p = setInterval(function(){
          binance.prices('ETHBUSD', (error, ticker) => {
            try{
              if( typeof ticker.ETHBUSD !=='undefined' ){
                if(sellPrice!==0.00000000){
                  console.log(sellPrice);
                }
                if( buy === false ){
                  if(sellPrice!==0.00000000 && ticker.ETHBUSD < buyPrice-0.5 ){
                    binance.cancel("ETHBUSD", sellOrderId, (error, response, symbol) => {
                      console.info(symbol+" cancel response:", response);
                      if( error ){
                        
                      }else{
                        binance.sell("ETHBUSD", 0.037, parseFloat(ticker.ETHBUSD), {type:'LIMIT'}, (error, response) => {        
                          if( error ){
                            console.log('Sell error: '+error.statusMessage);                                                
                            //clearInterval(p);                      
                          }else if(typeof response.orderId !=='undefined'){         
                            console.info("Limit Sell response", response);                           
                            buy = false;
                            sellOrderId = response.orderId;
                            p1 = p2 = p3 = p4 = 0.00000000;
                            buyOrderId = 0;                          
                          }          
                        });
                      }                      
                    });
                  }
                  if( ticker.ETHBUSD < p1 ){
                    if(p2===0.00000000){
                      p2 = ticker.ETHBUSD;
                    }else if(ticker.ETHBUSD < p2){
                      if(p3===0.00000000){
                        p3 = ticker.ETHBUSD;            
                      }else if(ticker.ETHBUSD < p3){
                        if(p4===0.00000000){
                          p4 = ticker.ETHBUSD;                                                   
                        }else if(ticker.ETHBUSD < p4 || p1-p4 <= 0.29){
                          p2 = p3 = 0.00000000;                          
                          p1 = p4;
                          p4 = 0.00000000;                            
                        }else if(ticker.ETHBUSD >= p4 ){                            
                          console.log('p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n"+'price: '+ticker.ETHBUSD+"\n"+"dif: "+(p1-p4));  
                          binance.buy("ETHBUSD", 0.037, parseFloat(ticker.ETHBUSD), {type:'LIMIT'}, (error, response) => {        
                            if( error ){
                              console.log('Buy error: '+error.statusMessage);                                                
                              clearInterval(p);                      
                            }else if(typeof response.orderId !=='undefined'){         
                              console.info("Limit Buy response", response);                           
                              buy = true;
                              buyOrderId = response.orderId;
                              sellPrice = (parseFloat(ticker.ETHBUSD)+(30*(parseFloat(p1)-parseFloat(ticker.ETHBUSD))/100)).toFixed(2);                    
                              buyPrice = ticker.ETHBUSD;
                              sellOrderId = 0;
                            }          
                          });
                        }                                 
                      }else if( ticker.ETHBUSD > p3 ){
                        p1 = ticker.ETHBUSD;
                        p2 = p3 = p4 = 0.00000000;
                      }
                    }else if( ticker.ETHBUSD > p2){
                      p1 = ticker.ETHBUSD;
                      p2 = p3 = p4 = 0.00000000;
                    }        
                  }else if( ticker.ETHBUSD > p1 || p1 === 0.00000000){
                    if(p1===0.00000000){
                      p1 = ticker.ETHBUSD;
                    }else{
                      p1 = ticker.ETHBUSD;
                      p2 = p3 = p4 = 0.00000000;
                    }        
                  }
                  
                  console.log('p1: '+p1+"\n"+'p2: '+p2+"\n"+'p3: '+p3+"\n"+"p4: "+p4+"\n"+'price: '+ticker.ETHBUSD+"\n"+"dif: "+(p1-p4));  

                }else if( ticker.ETHBUSD < buyPrice-0.5 ){
                  binance.sell("ETHBUSD", 0.037, ticker.ETHBUSD, {type:'LIMIT'}, (error, response) => {        
                    if( error ){
                      console.log('Sell error: '+error.statusMessage);
                      if( ticker.ETHBUSD > buyPrice+0.5 && buyOrderId !== 0 ){
                        binance.cancel("ETHBUSD", buyOrderId, (error, response, symbol) => {
                          console.info(symbol+" cancel response:", response);
                          if( error ){

                          }else{
                            binance.buy("ETHBUSD", 0.037, parseFloat(ticker.ETHBUSD), {type:'LIMIT'}, (error, response) => {        
                              if( error ){
                                console.log('Buy error: '+error.statusMessage);                                                
                                clearInterval(p);                      
                              }else if(typeof response.orderId !=='undefined'){         
                                console.info("Limit Buy response", response);                           
                                buy = true;
                                buyOrderId = response.orderId;
                                sellPrice = (parseFloat(ticker.ETHBUSD)+(parseFloat(ticker.ETHBUSD)-buyPrice)).toFixed(2);                    
                                buyPrice = ticker.ETHBUSD;
                                sellOrderId = 0;                              
                              }          
                            });
                          }                          
                        });
                      }            
                      clearInterval(p);                      
                    }else if(typeof response.orderId !=='undefined'){         
                      console.info("Limit Sell response", response);
                      p1 = p2 = p3 = p4 = 0.00000000;
                      buy = false;
                      sellOrderId = response.orderId;
                      buyOrderId = 0;                    
                    }          
                  });
                }else{
                  binance.orderStatus("ETHBUSD", buyOrderId, (error, orderStatus, symbol) => {
                    if( orderStatus == 'FILLED' ){
                      binance.sell("ETHBUSD", 0.037, sellPrice, {type:'LIMIT'}, (error, response) => {        
                        if( error ){
                          console.log('Sell error: '+error.statusMessage);
                          if( ticker.ETHBUSD > buyPrice+0.5 && buyOrderId !== 0 ){
                            binance.cancel("ETHBUSD", buyOrderId, (error, response, symbol) => {
                              console.info(symbol+" cancel response:", response);
                              if( error ){

                              }else{
                                binance.buy("ETHBUSD", 0.037, parseFloat(ticker.ETHBUSD), {type:'LIMIT'}, (error, response) => {        
                                  if( error ){
                                    console.log('Buy error: '+error.statusMessage);                                                
                                    clearInterval(p);                      
                                  }else if(typeof response.orderId !=='undefined'){         
                                    console.info("Limit Buy response", response);                           
                                    buy = true;
                                    buyOrderId = response.orderId;
                                    sellPrice = (parseFloat(ticker.ETHBUSD)+(parseFloat(ticker.ETHBUSD)-buyPrice)).toFixed(2);                    
                                    buyPrice = ticker.ETHBUSD;
                                    sellOrderId = 0;                              
                                  }          
                                });
                              }                          
                            });
                          } 
                          //sellPrice = parseFloat(ticker.ETHBUSD);          
                          //clearInterval(p);                      
                        }else if(typeof response.orderId !=='undefined'){         
                          console.info("Limit Sell response", response);
                          p1 = p2 = p3 = p4 = 0.00000000;
                          buy = false;
                          sellOrderId = response.orderId;
                          buyOrderId = 0;                    
                        }          
                      });
                    }
                  });                  
                }                
              }
            }catch(e){
              clearInterval(p);
            }
          })
        },750);
      }      
    },3000);
