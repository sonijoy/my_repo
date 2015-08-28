(function($){
        $('body').prepend($('#header_navbar_php').html());
        $(document).ready(function(){           
                $('input#stream_key, input#rtmp_url').click(function(){
                        $(this).select();
                });
                $('#taxonomy-channel_cat input[type=checkbox]').click(function(){
                        var $this = $(this);
                        if($this.is(':checked')) {
                                $this.parents('ul').find('input[type=checkbox]').each(function(){
                                        $(this).attr('checked', false);
                                });
                                $this.attr('checked', true);
                        }
                });
                if($('#header-navbar').data('role') == 'channel'){
                        if($('input#title').val() != ''){
                                $('input#title').attr('readonly', true);
                        }
                }
        });
})(jQuery);