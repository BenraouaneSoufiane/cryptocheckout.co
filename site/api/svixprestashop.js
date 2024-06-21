const { Webhook } =  require("svix");
const express = require('express');
const app = express();
const PORT = 1234;

// For parsing application/json
//app.use(express.json());

// For parsing application/x-www-form-urlencoded
//app.use(express.urlencoded({ extended: true }));

app.post('/back.php', function (req, res) {
	console.log(req.body);
	console.log(req.query);
    const secret = "whsec_GDVsmNBfKzV9rnTglPyrY8VFuJY0uE3S";

// These were all sent from the server
/*
const payload = '{"test": 2432232314}';

const wh = new Webhook(secret);
// Throws on error, returns the verified content on success
const payload = wh.verify(payload, headers);*/
	res.send(req.query);
});

app.listen(PORT, function (err) {
	if (err) console.log(err);
	console.log("Server listening on PORT", PORT);
});





