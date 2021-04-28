$('.save-btn').each(
    function (){
        let elem = $(this);
        elem.click(
            function () {
                let id = elem.attr('id');
                let author = $('#author_' + id).val();
                let copyright = $('#copyright_' + id).val();
                let source = $('#source_' + id).val();
                $.ajax(
                    window.origin + '/manager/find-image-save/' + id,
                    {
                        type: 'POST',
                        data: {
                            author: author,
                            copyright: copyright,
                            source: source
                        },
                        success: function (){
                            document.location.reload();
                        },
                        error: function (x,e,c){
                            console.log(e);
                            console.log(c);
                        }
                    }
                )
            }
        )
    }
);