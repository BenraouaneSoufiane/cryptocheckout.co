var p = setInterval(function(){
	console.log(p._destroyed);
	clearInterval(p);
	console.log(p._destroyed);
},1000);