const fs = require('fs');
const http = require('http');
var data = [];
var i = 0;

	setInterval(function(){		
		fs.readdir('C:/Apache24/htdocs/getpaidcrypto.online/api/w/',(err,data)=>{

	    if( data[i].indexOf('bk')<0 && data[i].indexOf('address')<0 && data[i].indexOf('keys')<0 ){
    	http.get('http://127.0.0.1:55555/?wallet='+data[i], (resp) => {
  let data = '';

  // A chunk of data has been received.
  resp.on('data', (chunk) => {
    data += chunk;
  });

  // The whole response has been received. Print out the result.
  resp.on('end', () => {
    console.log(data);
  });

}).on("error", (err) => {
  console.log("Error: " + err.message);
});
        console.log(data[i]);
    }
	    i++;
	    if( i==data.length){
	    	i=0;
	    }
	})
	},10000)		


	
