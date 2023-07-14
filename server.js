const express = require('express');
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http,{
    cors: {

        methods: ["GET", "POST"]
    }
});
var admins = [];
http.listen(5000, function () {
    console.log('listening on port 8002');
})

io.on('connection', function (socket) {
    socket.on('admin_connected', function (data) {
        admins[data.id] = socket.id;
        io.emit('update_admin_status', admins);
    });

    socket.on('admin_is_typing', function (data) {
        socket.to(`${admins[data.partner_id]}`).emit('admin_typing', data.admin_id)
    });

    socket.on('admin_stop_typing', function (data) {
        socket.to(`${admins[data.partner_id]}`).emit('admin_stop_type', data.partner_id)
    })


    socket.on('admin_send_message', function (data) {
        socket.to(`${admins[data.receiver_id]}`).emit('send_message', data)
    })

    socket.on('disconnect', function () {
        var i = admins.indexOf(socket.id);
        admins.splice(i, 1, 0);
        io.emit('update_admin_status', admins);
    })


})
