

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

                                    BX.insertAfter(BX.create('a', {
                                        attrs: {
                                            href: link,
                                            className: 'list-group-item list-group-item-action',
                                        },


                                        dataset: {
                                            folderid: entry.ID,
                                            storageid: entry.STORAGE,
                                            level: levelnum,
                                        },
                                        style: {
                                            'padding-left': levelnum * 20 + 'px',
                                        },
                                        html: icon + entry.NAME,
                                        }), element
                                    );

                                    if (entry.ATTR.dataviewertype) {
                                        $("a[data-folderid='" + entry.ID +"']").attr('data-viewer-type', entry.ATTR.dataviewertype);
                                        $("a[data-folderid='" + entry.ID +"']").attr('data-src', entry.ATTR.datasrc);
                                        $("a[data-folderid='" + entry.ID +"']").attr('data-viewer', '');                                        
                                    }

                                }

                        });
                    };

                });
            });
        
    var obImageView = BX.viewElementBind(
        'group-disk',
        {showTitle: true, lockScroll: false},
    );
});
