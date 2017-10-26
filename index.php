<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 24.10.17
 * Time: 21:22
 */

?>
<!DOCTYPE html>
<html lang=ru>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Гостевая книга</title>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="/guest_book.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <h2 class="text-center">Гостевая книга</h2>
        <div class="col-xs-12" id="guest_book">
            <button class="dtn dtn-default pull-right" name="new_message">Добавить отзыв</button>
            <div class="clearfix"></div>
            <div class="col-xs-11 offset-1" data-id="0"></div><!-- Контейнер для дерева сообщений-->
        </div>
        <div id="message_dialog" class="modal fade" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="title">Введите сообщение\ответ</h4>
                    </div>
                    <div class="modal-body">
                        <div name="message"></div>
                        <form class="form-horizontal">
                            <input name="parent_id" type="hidden" value=""/>
                            <input name="id" type="hidden" value=""/>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Автор</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" name="author">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Сообщение</label>
                                <div class="col-xs-9">
                                    <textarea class="form-control" name="body"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" name="save" data-loading-text="Создание...">Создать</button>
                        <button class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
