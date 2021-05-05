var expandInProgress = false;
var expandInterval;

$('.tasks-grid-main .btn[data-target]').on('click', function() {
    $($(this).attr('data-target')).modal('show');
    return false;
});

$('.tasks-grid-main .kv-expand-header-cell').on('click', function() {
    if (expandInProgress) {
        return false;
    }

    let self = $(this);
    let isCollapsed = true;

    if (self.hasClass('is-expanded')) {
        isCollapsed = false;
    }

    if (isCollapsed) {
        let glyph = self.find('.glyphicon');
        $(glyph).attr('class', 'glyphicon glyphicon-collapse-down');

        self.addClass('is-expanded');

        expandNextRow();
        expandInterval = setInterval(expandNextRow, 300);
    } else {
        let glyph = self.find('.glyphicon');
        $(glyph).attr('class', 'glyphicon glyphicon-expand');

        self.removeClass('is-expanded');
        $('.tasks-grid-main .kv-expand-row .kv-expand-icon.kv-state-collapsed').click()
    }

    return false;
});

function expandNextRow()
{
    let toExpandSelector = '.tasks-grid-main tr .kv-expand-row .kv-expand-icon.kv-state-expanded:not(.kv-state-disabled)';

    expandInProgress = true;

    let itemsToExpand = $(toExpandSelector)
    if (itemsToExpand.length == 0) {
        clearInterval(expandInterval);

        expandInProgress = false;

        return;
    } else {
        $(itemsToExpand[0]).click();
    }
}