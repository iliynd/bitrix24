

BX.ready(function() {

    var products = BX('group-disk');
    var btn = BX.findChild(products, {tag: 'a'}, true, true);
    $(document).on('click', '.list-group-item-action', function (event) {//Вешаем обработчик
        element = this;

        event.preventDefault() ;
        event.stopPropagation();

        var folderid = $(this).attr('data-folderid');
        var storageid = $(this).attr('data-storageid');
        var levelnum = $(this).attr('data-level');

        if (!levelnum)
            levelnum = 1;

        levelnum++;

        if (!folderid)
            return false;
        
        BX.ajax.post (
            '/local/components/iliynd/group.disk/ajax.php',
            {id: folderid, storage: storageid},
            function (result) {
                var json = BX.parseJSON(result);
                if (json) {
                    json.forEach(function(entry) {

                            if (!$("a[data-folderid='" + entry.ID +"']").data('folderid')) {


                                var icon = "<i class='fa fa-file mr-2'></i>";
                                if (entry.TYPE == 2)
                                    icon = "<i class='fa fa-folder mr-2'></i>";

                                var link = "#";
                                if (entry.TYPE == 3)
                                    link = "/disk-group/show/"+entry.ID;

                                $(element).after('<a href="#" style="padding-left: '+ levelnum * 20 + 'px" class="list-group-item list-group-item-action" data-canname="'+entry.CANNAME+'" data-parent="'+entry.PARENT+'" data-level="'+levelnum+'" data-folderid="'+entry.ID+'" data-storageid="'+entry.STORAGE+'" '+entry.ATTR+' >'+icon + entry.NAME+'</a>');
                            }
                    });
                };

            }
        );
    });


    $(document).on('click', 'a.list-group-item-action', function (event) {
        if (!$(this).attr('data-src'))
            return true;

            parent = this.getAttribute('data-parent');
            parents = [];
            while (parent) {
                parents.push($("a[data-folderid='" + parent +"']").text());
                parent = $("a[data-folderid='" + parent +"']").attr('data-parent');
            }

            parents = parents.reverse();
            link =  parents.join('/');

            if (link) {
                link = 'show/' + link + '/' + $(this).attr('data-canname');
            } else {
                link = 'show/' + $(this).attr('data-canname');
            }

            var url = window.location.toString();
            var pos = url.indexOf('show/');

            var ulrnew = '';
            if(pos != false)
                urlnew = url.substr(0, pos);

            history.pushState('', '', urlnew + link);

    });


    $(document).on('click', '.ui-viewer-close', function (event) {
        history.back();
    });

});



