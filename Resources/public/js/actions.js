jQuery(document).ready(function ($) {

    // x-editable update after save
    var x_editable_update_after_save_list = $('.x-editable-update-after-save');
    if(x_editable_update_after_save_list.length){
        $.each(x_editable_update_after_save_list, function( index, x_editable_update_after_save ) {
            x_editable_update_after_save = $(x_editable_update_after_save);
            var a_editable = x_editable_update_after_save.parent().find('a.editable');
            if(a_editable.length){
                a_editable.editable('option', 'success', function(response, newValue) {
                    var x_editable_content = null;
                    if(newValue){
                        x_editable_content = a_editable.data('contentEditText');
                        x_editable_update_after_save.show();
                        var url_text = x_editable_update_after_save.data('urlText');
                        if(url_text || !x_editable_update_after_save.data('urlUpdate') || (x_editable_update_after_save.data('urlUpdate') && x_editable_update_after_save.data('urlUpdate') == true)){
                            var url = (response.hasOwnProperty('value') && response.value.hasOwnProperty('url')) ? response.value.url : newValue;
                            x_editable_update_after_save.attr('href', (url_text) ? url_text.replace(/%s/g, url) : url );
                        }
                        var content_text = x_editable_update_after_save.data('contentText');
                        if(content_text || (x_editable_update_after_save.data('contentUpdate') && x_editable_update_after_save.data('contentUpdate') == true)){
                            var name = (response.hasOwnProperty('value') && response.value.hasOwnProperty('name')) ? newValue : newValue;// @ todo replase newValue1 to response.value.name
                            name = name.split('/').pop();
                            x_editable_update_after_save.html( (content_text) ? content_text.replace(/%s/g, name) : name);
                        }
                    } else {
                        x_editable_content = a_editable.data('contentEmptyText');
                        x_editable_update_after_save.hide();
                    }
                    if(x_editable_content){
                        a_editable.html(x_editable_content);
                    }
                });
            }
        });
    }

    // clear button from x-editable
    var x_editable_update_button_clear_list = $('.x-editable-update-button-clear');
    if(x_editable_update_button_clear_list.length) {
        $.each(x_editable_update_button_clear_list, function (index, x_editable_update_button_clear) {
            $(x_editable_update_button_clear).click(function(e) {
                e.stopPropagation();
                var parent_div = $(this).parents('.box-update-button');
                var editable = parent_div.find('.editable');
                editable.editable('setValue', null)  //clear values
                    .editable('toggle')
                ;
            });
        });
    }
    var update_button_clear_list = $('.update-button-clear');
    if(update_button_clear_list.length) {
        $.each(update_button_clear_list, function (index, update_button_clear) {
            $(update_button_clear).click(function(e) {
                var parent_div = $(this).parents('.box-update-button');
                var file_upload = parent_div.find('.file-upload');
                if(file_upload.length) {
                    $.post(file_upload.fileupload('option', 'url'), {}, function(result){
                        var update_after_save = parent_div.find('.x-editable-update-after-save');
                        if(update_after_save && update_after_save.length){
                            update_after_save.hide();
                        }
                    });
                }
            });
        });
    }

    // file-upload from x-editable
    // @ todo http://stackoverflow.com/questions/18027364/symfony2file-upload-via-ajax ( http://malsup.com/jquery/form/ )
    var file_upload_list = $('.file-upload');
    if(file_upload_list.length){
        file_upload_list.fileupload({
            dataType: 'json',
            progress: function (e, data) {
                var parent_div = $(this).parents('.box-update-button');
                var progress_ulpoad = parent_div.find('.progress');
                if(progress_ulpoad && progress_ulpoad.length){
                    progress_ulpoad.remove();
                }
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $(parent_div).append('<div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' + progress +'" aria-valuemin="0" aria-valuemax="100" style="width: ' + progress + '%;">' + progress + '%</div></div>');
            },
            send: function (e, data) {
                var parent_div = $(this).parents('.box-update-button');
                var progress_ulpoad = parent_div.find('.progress');
                if(progress_ulpoad && progress_ulpoad.length){
                    progress_ulpoad.remove();
                }
                var progress = 0;
                $(parent_div).append('<div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' + progress +'" aria-valuemin="0" aria-valuemax="100" style="width: ' + progress + '%;">' + progress + '%</div></div>');
            },
            fail: function (e, data) {
                var parent_div = $(this).parents('.box-update-button');
                var progress_ulpoad = parent_div.find('.progress');
                if(progress_ulpoad && progress_ulpoad.length){
                    progress_ulpoad.remove();
                }
                $(parent_div).append('<div class="progress" style="color: red;">' + 'Ошибка при загрузке!' + '</div>');
                console.log('Ошибка при загрузке:', data);
            },
            done: function (e, data) {
                var parent_div = $(this).parents('.box-update-button');
                var progress_ulpoad = parent_div.find('.progress');
                if(progress_ulpoad && progress_ulpoad.length){
                    progress_ulpoad.remove();
                }
                var update_after_save = parent_div.find('.x-editable-update-after-save');
                if(update_after_save && update_after_save.length){
                    var content_text = update_after_save.data('contentText');
                    var value = data.result.value.name;
                    var url = data.result.value.url;
                    update_after_save
                        .html( (content_text) ? content_text.replace(/%s/g, value) : value)
                        .attr('href', url)
                        .show()
                    ;
                }
            }
        });
    }
});
