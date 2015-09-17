var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);


app.all('/*', function (req, res, next) {
    // CORS headers
    res.header('Access-Control-Allow-Origin', 'http://doctorcrm.dev:2772');
    res.header("Access-Control-Allow-Origin", "*");
    res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
    res.header('Access-Control-Allow-Headers', '*');
    res.header('Access-Control-Allow-Headers', 'Content-type,Accept,X-Access-Token,X-Key, Content-Range, Content-Disposition, Content-Description');
    if (req.method == 'OPTIONS') {
        res.status(200).end();
    } else {
        next();
    }
});


/* run forever

 npm install forever -g

 forever start server.js

 */


var Client = require('node-rest-client').Client;

var client = new Client();

var args = {
    data: {user_phone: 22506794},
    headers: {"Content-Type": "application/json"}
};

client.post("http://chat.web.anypli.com/login_api", args, function (data, response) {

    console.log(data.user_found);

});


var users = [];

io.sockets.on('connection', function (socket) {

    console.log("new user connected ");


    socket.on('chat_init', function (user_id) {

        console.log("new logged ID ----->" + user_id);
        var user = new Object();
        user.id = user_id;
        user.socket = socket.id;
        users.push(user);
    });

    socket.on('disconnect', function () {
        var len = 0;

        for (var i = 0, len = users.length; i < len; ++i) {
            var p = users[i];

            if (p.socket == socket.id) {
                users.splice(i, 1);
                break;
            }
        }
    });

    socket.on('message', function (data, id_user) {

        console.log("new message to " + id_user);

        var len = 0;
        for (var i = 0, len = users.length; i < len; ++i) {
            var p = users[i];
            console.log("inside loop");
            if (p.id == id_user) {
                console.log("user found !");
                io.to(p.socket).emit('message', data);
                break;
            }
        }
    });


    socket.on('is_typing', function (name, id_user) {

        console.log(id_user + " is typing");

        var len = 0;
        for (var i = 0, len = users.length; i < len; ++i) {
            var p = users[i];
            console.log("inside loop");
            if (p.id == id_user) {
                console.log("user found !");

                io.to(p.socket).emit('is_typing', name);
                break;
            }
        }
    });

});