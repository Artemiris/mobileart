let imged = function () {
    let imgs = document.getElementsByClassName("img-preview");
    for (let img of imgs)
    {
        let imid = img.id.split(' ');
        let button = document.createElement('button');
        button.textContent = 'Редактировать превью';
        button.type = 'button';
        button.onclick = function (){
            $.fancybox.open(editorHTML(img.src, img.alt, imid[1], imid[2], imid[3]));
            startEditor(img, imid[0]);
        }
        img.after(button);
    }
}

let editorHTML = function (src, alt, src_author,src_copyright,src_license){
    src = src.replace('thumbnail_','');
    src_author = src_author === undefined?'':src_author;
    src_copyright = src_copyright === undefined?'':src_copyright;
    src_license = src_license === undefined?'':src_license;
    let str =
        `
            <div id="editor-image-container" class="row">
                <div class="pull-left">
                    <img id="image-to-edit" src="${src}" style="max-height: ${window.innerHeight * 0.8}px; max-width: ${window.innerWidth * 0.5}px" alt="${alt}">
                </div>
                <div id="editor-controls" class="pull-right" style="margin-left: 5px">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-xs-3">
                            <button id="crop" class="btn btn-primary" type="button">Сохранить</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Автор</label>
                                <input id="i_author" type="text" value=${src_author}>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Правообладатель</label>
                                <input id="i_copyright" type="text" value=${src_copyright}>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Лицензия</label>
                                <input id="i_license" type="text" value=${src_license}>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    return str;
}

let startEditor = function(originalImage, src_id){
    let image = document.getElementById("image-to-edit");
    let originalPath = originalImage.src.split('/');
    originalPath.splice(originalPath.length-1,1);
    originalPath = originalPath.join('/');

    if(image === undefined) return;
    const cropper = new Cropper(image, {
        aspectRatio: 8 / 5
    });
    let butCrop = document.getElementById('crop');
    butCrop.onclick = function () {
        let croppedimage = cropper.getCroppedCanvas().toDataURL("image/png");
        let ref = `${host}/manager/update-add-image`;
        console.log(src_id);
        $.ajax({
            'type' : 'POST',
            'url' : ref,
            'dataType' : 'json',
            'data' : {
                '_csrf': csrf_token,
                'imageData': croppedimage,
                'imageName': image.alt,
                'mainImage': !originalPath.includes('find_image'),
                'imageId': src_id,
                'imageAuthor': $('#i_author').val(),
                'imageCopyright': $('#i_copyright').val(),
                'imageLicense': $('#i_license').val()
            },
            'success' : function (item) {
                originalImage.src = `${originalPath}/thumbnail_${image.alt}?${new Date().getTime()}`;
                cropper.destroy();
                $.fancybox.destroy();
            }
        });
    }
}

imged();