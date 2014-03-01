$('.sort').sortable({
    cursor: 'move',
    axis:   'y',
    stop: function(e, ui) {
        var href = '<?php echo site_url(SITE_AREA.'/content/menu/order'); ?>';
        $(this).sortable("refresh");
        sorted = $(this).sortable("serialize");
        $.ajax({
        type:   'POST',
        url:    href,
        data:   { sorted : sorted }

    });
    }
});