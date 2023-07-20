const express = require('express');
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http, {
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
    });

    socket.on('i_open_our_chat', function (data) {

        socket.to(`${admins[data.partner_id]}`).emit('i_open_our_chat', {
            'me': +data.partner_id,
            'sender': +data.sender,
        })
    })

    socket.on('who_partner_you_chat', function (data) {
        socket.to(`${admins[data.partner_id]}`).emit('who_you_chat', {
            'partner_id': +data.partner_id,
            'sender_id': +data.sender_id,
        })
    });

    socket.on('i_chat_with', function (data) {
        socket.to(`${admins[data.sender]}`).emit('i_chat_with', data)
    })


})
