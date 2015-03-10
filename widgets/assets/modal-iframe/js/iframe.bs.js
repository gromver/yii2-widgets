$(document).on('click.bs.modal.data-api', '[data-behavior="iframe"] a', function (e) {
    var $this = $(this)
    var $container = $this.parents('[data-behavior="iframe"]')
    var $iframe = $($container.data('iframe'))
    var targetName = 't' + Math.floor((Math.random() * 100000) + 1)
    $iframe.attr('name', targetName)
    $iframe.contents().find('html').empty()
    $iframe.replaceWith($iframe.clone())    //без этого работает только в FF
    $this.attr('target', targetName)
});

$(document).on('submit.bs.modal.data-api', '[data-behavior="iframe"] form', function (e) {
    var $this = $(this)
    var $container = $this.parents('[data-behavior="iframe"]')
    var $iframe = $($container.data('iframe'))
    var targetName = 't' + Math.floor((Math.random() * 100000) + 1)
    $iframe.attr('name', targetName)
    $iframe.contents().find('html').empty()
    $iframe.replaceWith($iframe.clone())    //без этого работает только в FF
    $this.attr('target', targetName)
});