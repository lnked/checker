var app = app || {};

(function(body){
    "use strict";

    app.update = {
        
        changeStatus: function($status, $row, responce) {
            var text = '<span class="table__error">Err</span>', status = false;

            if (responce.hasOwnProperty('http_code')) {
                if (responce.http_code == 200) {
                    status = true;
                    text = '<span class="table__success">Ok</span>';
                }
            }

            if (status) {
                $row.addClass('_active');
            }
            else {
                $row.addClass('_failed');
            }

            $status.html(text);
        },

        changeButton: function() {
            $('body').on('click', '.j-update-all', function(){
                $('#table').find('.j-change-item').filter(':checked').each(function(){
                    $(this).closest('tr').find('.j-update').trigger('click');
                });
            });
        },

        init: function() {
            var _this = this;

            _this.changeButton();

            $('body').on('click', '.j-update', function(){

                (function($button) {
                    var $button, $row, $status, action, domain;

                    $button.addClass('_active');

                    // #
                    $row = $button.closest('tr');

                    // #
                    $status = $row.find('.j-status');

                    // #
                    action = $button.attr('href');
                    domain = $button.data('domain');

                    $.ajax({
                        url: action,
                        type: 'GET',
                        dataType: 'JSON',
                        contentType: false,
                        processData: true,
                        success: function(responce){
                            $row.find('.j-change-item').prop('checked', false);

                            console.log("suc:", responce);

                            $button.removeClass('_active');
                            $button.addClass('_success');
                            
                            _this.changeStatus($status, $row, responce);
                        },
                        error: function(responce){
                            console.log("err:", responce);

                            $button.removeClass('_active');
                            $button.addClass('_failed');

                            _this.changeStatus($status, $row, responce);
                        }
                    });
                })($(this));

            });
        }

    };

})(document.body);