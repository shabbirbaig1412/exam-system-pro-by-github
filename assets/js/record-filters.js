jQuery(function($) {
    $('.esp-record-search').on('input', function() {
        var input = $(this), entity = input.data('record-search'), query = String(input.val() || '').toLowerCase();
        var wrapper = input.closest('.esp-saved-records'), rows = wrapper.find('tbody tr'), visible = 0;
        rows.each(function() { var match = !query || $(this).text().toLowerCase().indexOf(query) !== -1; $(this).toggle(match); if (match) visible++; });
        wrapper.find('.esp-record-count').text(visible + ' / ' + rows.length);
    }).trigger('input');
});
