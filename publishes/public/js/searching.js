/**
 * 搜索功能
 *
 * @authro xiaohui.lam
 * @license MIT(https://github.com/xiaohuilam/searching/)
 */

$(document).ready(function () {
    $form = $(
        '<form id="search-show">' +
        '    <ul class="dropdown-menu no-border" style="position: absolute; width: 78vw; border:0; padding: 0; margin-top:0;">' +
        '        <table class="table table-responsive table-bordered" style="margin-bottom: 0; border:0;">' +
        '            <tbody>' +
        '            </tbody>' +
        '        </table>' +
        '    </ul>' +
        '</form>'
    );
    $('body').append($form);

    $('#search-keyword').on('keydown', function (evt) {
        type = '';
        that = this;

        if (evt.keyCode == 13) {
            type = 'enter';
        } else if (evt.keyCode == 38) {
            type = 'up';
        } else if (evt.keyCode == 40) {
            type = 'down';
        }
        var $table = $('#search-show').find('table');

        switch (type) {
            case 'down':
                if (!$table.find('>tbody>tr.highlight').length) {
                    $table.find('>tbody>tr:first').addClass('highlight');
                    $table.find('>tbody>tr:first>td').addClass('bg-warning');
                    return;
                }
                $now = $table.find('>tbody>tr.highlight');
                $next = $now.next();
                if (!$next.is('tr')) {
                    $next = $table.find('>tbody>tr>td:first');
                }
                $next.addClass('highlight');
                $now.removeClass('highlight');
                $next.find('td').addClass('bg-warning');
                $now.find('td').removeClass('bg-warning');

                return;
                break;
            case 'up':
                if (!$table.find('>tbody>tr.highlight').length) {
                    $table.find('>tbody>tr:last').addClass('highlight');
                    $table.find('>tbody>tr:last>td').addClass('bg-warning');
                    return;
                }
                $now = $table.find('>tbody>tr.highlight');
                $prev = $now.prev();
                if (!$prev.is('tr')) {
                    $prev = $table.find('>tbody>tr>td:first');
                }
                $prev.addClass('highlight');
                $now.removeClass('highlight');
                $prev.find('td').addClass('bg-warning');
                $now.find('td').removeClass('bg-warning');

                return;
                break;
            case 'enter':
                $now = $table.find('>tbody>tr.highlight');
                if (!$now.length) {
                    return;
                }
                location.href = $now.find('td>a').attr('href');
                return;
                break;
            default:
                break;
        }

        if ('undefined' != typeof window.last_timeout) {
            clearTimeout(window.last_timeout);
        }
        if ('undefined' != typeof window.last_xhr) {
            window.last_xhr.abort();
            delete (window.last_xhr);
        }
        window.last_timeout = setTimeout(function () {
            var $form = $('#search-show');
            if (['xg', 'edit'].indexOf($(that).val()) !== -1) {
                if ('undefined' != typeof window.edit_url) {
                    $form.find('table tbody').html('<tr class="highlight"><th class="search-category" rowspan="11" style="width: 15%;">修改</th><td class="bg-warning" style="width: 85%;"><a href="' + window.edit_url + '">修改</a></td></tr>');
                    return;
                }
            }
            if ($(that).val().length == 0) {
                $form.find('table tbody').html('<tr><td>没有找到结果</td></tr>');
                $form.removeClass('open');
                return;
            }
            window.last_xhr = $.ajax({
                url: window.search_url,
                type: "GET",
                data: {
                    search: {
                        keyword: $(that).val()
                    }
                },
                dataType: 'json',
                success: function (json) {
                    $form.find('table tbody').html('');
                    $has_result = 0;

                    for (var key in json.data) {
                        try {
                            if (json.data[key].length == 0) {
                                continue;
                            }

                            $td = $('<th class="search-category"></th>');
                            $td.text(key);
                            $td.attr('rowspan', json.data[key].length);
                            $td.css({
                                width: '15%'
                            });

                            $tr = $('<tr></tr>');
                            $tr.append($td);
                            $form.find('table tbody').append($tr);

                            $(json.data[key]).each((i, cell) => {
                                $has_result = 1;
                                if (i > 0) {
                                    $tr = $('<tr></tr>');
                                    $form.find('table tbody').append($tr);
                                }
                                $link = $('<a></a>');
                                $link.attr('href', cell.link);
                                $link.text(cell.title);

                                $td = $('<td></td>');
                                $td.css({
                                    width: '85%'
                                });
                                $td.append($link);
                                if (cell.description) {
                                    $p = $('<span style="margin-left:30px"></spa>');
                                    $p.addClass('text-muted');
                                    $p.text(cell.description);
                                    $td.append($p);
                                }
                                $tr.append($td);
                            });
                        } catch (e) {
                            console.error(e);
                        }
                    }

                    if (!$has_result) {
                        $form.find('table tbody').html('<tr><td>没有找到结果</td></tr>');
                    }

                    $ul = $form.find('ul.dropdown-menu');
                    $ul.css({
                        width: ($('.navbar.navbar-default').width() + 2) + 'px',
                        position: 'absolute',
                        left: $('.navbar.navbar-default').offset().left + 'px',
                        top: ($('#search-keyword').offset().top + $('#search-keyword').outerHeight()) + 'px',
                    });
                    $form.addClass('open');
                    $('#search-keyword').popover('hide');

                    if ($has_result) {
                        $('#search-show .table tbody tr td').eq(0).addClass('bg-warning');
                        $('#search-show .table tbody tr').eq(0).addClass('highlight');
                    }
                }
            });
        }, 1);
    });

    $('body').on('click', function (evt) {
        if ($(evt.target).is('#search-keyword') || $(evt.target).parents().toArray().indexOf($('#search-show')[0]) > -1) {
            return;
        }
        $('#search-show').removeClass('open');
    });

    $('#search-keyword').on('focus', function (evt) {
        if (!$('#search-show').hasClass('open') && $(this).val().length) {
            $('#search-show').addClass('open');
        }
    });
});

$(document).on('keydown', function (evt) {
    // when ctrl+f || ctrl+p, focus on search input
    if (
        (evt.metaKey || evt.ctrlKey)
        &&
        (evt.keyCode == 80 || evt.keyCode == 70)
    ) {
        $('#search-keyword').focus();
        evt.stopPropagation();
        evt.preventDefault();
    }
});