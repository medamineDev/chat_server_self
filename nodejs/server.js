var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);


app.all('/*', function (req, res, next) {
    // CORS headers
    /* res.header('Access-Control-Allow-Origin', 'http://doctorcrm.dev:2772');*/
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


var users = [];



var disconnect = function(user){

    var len = 0;

    for (var i = 0, len = users.length; i < len; ++i) {
        var p = users[i];

        /*if (p.socket == socket.id) {
            users.splice(i, 1);
            break;
        }*/
        if (p.id == user.id) {
            console.log(p.id+" user already exist !");
            users.splice(i, 1);
            break;
        }
    }

    //callback(true);
    users.push(user);

}

var is_user_connected = function (user) {

    console.log("checking already connected users !" + users.length);


    var user_exist = false;

 /*   var i = 0;
    while (user[i]) {
        var p = users[i];
        console.log(user.id + " trying to connect , already connected IDs ---->" + p.id);

        i++;
    }*/

    for (var i = 0, len = users.length; i < len; i++) {
        var p = users[i];

       console.log(user.id + " trying to connect , already connected IDs ---->" + p.id);

        if (p.id) {

            if (p.id == user.id) {
                console.log(p.id + "--->" + user.id + "user already connected ----> disconnect");

                users.splice(i, 1);
                user_exist = true;


            } else {
                user_exist = false;


            }

        }



    }

    return user_exist;

};

io.sockets.on('connection', function (socket) {


    socket.on('chat_init', function (user_id) {


        var user = new Object();
        user.id = user_id;
        user.socket = socket.id;

       /* if (!is_user_connected(user)) {

            console.log("new logged ID ----->" + user_id);
            users.push(user);

        }*/

        disconnect(user);
        //users.push(user);
        //users.push(user);
        //console.log("new user connected ");


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

    socket.on('message', function (data, logged_user_id, id_user) {

        console.log("new message  from" + logged_user_id + " to " + id_user);


        var args = {
            data: {id_sender: id_user, id_receiver: logged_user_id, message_body: data},
            headers: {"Content-Type": "application/json"}
        };
        /*http://chat.web.anypli.com/*/
        client.post("http://chat.web.anypli.com/send_msg_api", args, function (resp, response) {

            console.log(resp.msg);

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