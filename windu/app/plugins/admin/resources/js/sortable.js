$(document).ready(function(){
    var saveOrder = function(){
        var data = getOrder($('#sortableTreeList'));
        $("div.alert-waiting").hide();
        $("div.alert-top").hide();
        $("div.alert-waiting").show();
        $.ajax({
            cache: false,
            url: window.HOME + 'admin/do/content/saveFromJsList/',
            type: 'post',
            success: function( data ) {
                $("div.alert-top").show();
                $("div.alert-waiting").hide();
                $("div.alert-top").delay(3000).slideUp();
            },
            data: { data: data },
            error: function(){}
        });
    };

    $('#sortableTreeList').nestedSortable({
        disableNesting: 'no-nest',
        forcePlaceholderSize: true,
        handle: 'div',
        helper:	'clone',
        items: 'li',
        maxLevels: 30,
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 2,
        toleranceElement: '> div',
        update: saveOrder
    });

    var saveOrderGallery = function(){
        var data = getOrder($('#sortableTreeListGallery'));
        $("div.alert-waiting").hide();
        $("div.alert-top").hide();
        $("div.alert-waiting").show();
        $.ajax({
            url: window.HOME + 'admin/do/content/saveFromJsListGallery/',
            type: 'post',
            success: function( data ) {
                $("div.alert-top").show();
                $("div.alert-waiting").hide();
                $("div.alert-top").delay(2000).slideUp();
            },
            data: { data: data },
            error: function(){}
        });
    };

    $('#sortableTreeListGallery').nestedSortable({
        disableNesting: 'no-nest',
        forcePlaceholderSize: true,
        handle: 'div',
        helper:	'clone',
        items: 'li',
        maxLevels: 1,
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        update: saveOrderGallery
    });
    var saveOrderNews = function(){
        var data = getOrder($('#sortableTreeListNews'));
        $("div.alert-waiting").hide();
        $("div.alert-top").hide();
        $("div.alert-waiting").show();
        $.ajax({
            url: window.HOME + 'admin/do/content/saveFromJsListNews/',
            type: 'post',
            success: function( data ) {
                $("div.alert-top").show();
                $("div.alert-waiting").hide();
                $("div.alert-top").delay(3000).slideUp();
            },
            data: { data: data },
            error: function(){ }
        });
    };

    $('#sortableTreeListNews').nestedSortable({
        disableNesting: 'no-nest',
        forcePlaceholderSize: true,
        handle: 'div',
        helper:	'clone',
        items: 'li',
        maxLevels: 1,
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        update: saveOrderNews
    });

});




