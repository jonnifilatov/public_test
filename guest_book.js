/**
 * Created by jonni on 25.10.17.
 */
var guest_book;
$(document).ready(function () {
    guest_book = new GuestBook();
    guest_book.init();
});

var GuestBook = function () {
    this.block = $('#guest_book');
    this.can_send = true;
    this.message_dialog = new MessageDialog(this);
    $('button[name="new_message"]', this.block).on('click', $.proxy(this.message_dialog.add_message , this.message_dialog));
};

GuestBook.prototype = {
    constructor: GuestBook,

    init: function () {
        var $this = this;
        $.ajax({
             type: 'post',
            dataType: 'json',
            url: '/show_messages.php',
            success: function (resp) {
                 $this._op_result(resp);
            }
        });
    },

    access_timer: function () {
        var $this = this;
        this.can_send = false;
        setTimeout(function () {
            $this.can_send = true;
        }, 10000);
    },

    _op_result: function (resp) {
        if(resp.message_list != undefined){
            this.show_messages(resp.message_list);
        }
    },

    show_messages:function (message_list) {
        if(message_list.length > 0){
            for(var i in message_list)
                this.show_message(message_list[i]);
        }
    },

    show_message:function (message) {
        var id = message.id;
        var parent_id = message.parent_id;
        var element = $('<div class="col-xs-11 offset-1" data-id="' + id + '"></div>')
            .append($('<p>' + message.time + '</p>'))
            .append($('<p name="message_author" data-id="' + id + '">' + message.author + '</p>'))
            .append($('<p name="message_body" data-id="' + id + '">' + message.body + '</p>'))
            .append($('<p><a class="answer" data-parent="' + id + '">Ответить</a></p>'))
            .append($('<p><a class="edit" data-parent="' + id + '">Редактировать</a></p>'));
        element.appendTo($('div[data-id="' + parent_id + '"]', this.block));
        $('.answer', element).on('click', $.proxy(this.answer, this));
        $('.edit', element).on('click', $.proxy(this.edit, this));
    },

    message_data: function (element) {
        var parent_id =$(element.currentTarget).attr('data-parent'),
            result = {};
        var block = $('div[data-id="'+parent_id+'"]');
        result.message = $('p[name="message_body"][data-id="'+parent_id+'"]', block).text();
        result.author = $('p[name="message_author"][data-id="'+parent_id+'"]', block).text();
        result.parent_id = parent_id;
        return result;
    },

    answer: function (element) {
        var data = this.message_data(element);
        this.message_dialog.add_answer(data.parent_id, data.message);
    },

    edit: function (element) {
        var data = this.message_data(element);
        this.message_dialog.edit_message(data);
    },

    load_change: function (message) {
        $('p[name="message_body"][data-id="'+message.id+'"]', this.block).html(message.body);
    }
};

var MessageDialog = function (parent) {
    this.block = $('#message_dialog');
    this.guest_book = parent;
    $('button[name="save"]', this.block).on('click', $.proxy(this.save, this));
};

MessageDialog.prototype = {
    constructor: MessageDialog,

    add_message: function () {
        var data = {
            parent_id: 0,
            message: ''
        };
        this.show(data);
    },

    add_answer: function (parent_id, message) {
        var data = {
            parent_id: parent_id,
            message: message
        };
        this.show(data);

    },

    edit_message: function (data) {
        $('[name="id"]', this.block).val(data.parent_id);
        $('[name="parent_id"]', this.block).val('');
        $('[name="author"]', this.block).val(data.author).attr('disabled', true);
        $('[name="body"]', this.block).val(data.message);
        $('[name="message"]', this.block).html('');
        this.block.modal('show');
    },

    show: function (data) {
        $('[name="id"]', this.block).val('');
        $('[name="parent_id"]', this.block).val(data.parent_id);
        $('[name="author"]', this.block).val('').removeAttr('disabled');
        $('[name="body"]', this.block).val('');
        $('[name="message"]', this.block).html(data.message);
        this.block.modal('show');
    },

    save: function () {
        if(! this.guest_book.can_send){
            alert('данное действие пока не возможно');
            return false;
        }else{
            var data = {},
                $this = this;
            data.id = $('[name="id"]', this.block).val();
            data.parent_id = $('[name="parent_id"]', this.block).val();
            data.author = $('[name="author"]', this.block).val();
            data.body = $('[name="body"]', this.block).val();
            if(this.validate_data(data)){
                $.ajax({
                    async: true,
                    type: 'post',
                    dataType: 'json',
                    url: '/save_message.php',
                    data: {data_row: data},
                    success: function (resp) {
                        $this._op_result(resp);
                    }
                });
                this.block.modal('hide');
                this.guest_book.access_timer();
            }
        }
    },

    validate_data: function (data) {
        if(data.author.trim() == ''){
            alert('Введите своё имя!');
            return false;
        }
        if(data.body.trim() == ''){
            alert('Введите сообщение!');
            return false;
        }
        return true;
    },

    _op_result: function (resp) {
        if(resp.added_message != undefined){
            this.guest_book.show_message(resp.added_message)
        }
        if(resp.changed_message != undefined){
            this.guest_book.load_change(resp.changed_message);
        }
    }
};