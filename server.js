const express = require('express');
const {parse} = require("nodemon/lib/cli");
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http);
var admins = [];
http.listen(8001, function () {
    console.log('listening on port 8001');
})

io.on('connection', function (socket) {
    socket.on('admin_connected', function (data) {
        admins[data.id] = socket.id;
        io.emit('update_admin_status', admins);
    });

    // socket.on('admin_is_online', function (data) {
    //     admins[data.id] = socket.id;
    //     socket.broadcast.emit('admin_is_online', data);
    // })


    socket.on('admin_is_typing', function (data) {
        var partner_id = admins[data.partner_id];
        io.to(`${admins[data.partner_id]}`).emit('admin_typing', data.admin_id)
    });

    socket.on('admin_stop_typing', function (data) {
        var partner_id = admins[data.partner_id];
        io.to(`${admins[data.partner_id]}`).emit('admin_stop_typing', data.admin_id)
    })


    socket.on('admin_send_message', function (data) {
        io.to(`${admins[data.receiver_id]}`).emit('send_message', data)
    })

    socket.on('disconnect', function () {
        var i = admins.indexOf(socket.id);
        admins.splice(i, 1, 0);
        io.emit('update_admin_status', admins);
    })


})
