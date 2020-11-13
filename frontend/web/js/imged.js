let imged = function () {
    let imgs = document.getElementsByClassName("img-preview");
    for (let img of imgs)
    {
        let button = document.createElement('button');
        button.textContent = 'Редактировать превью';
        button.type = 'button';
        button.onclick = function (){
            $.fancybox.open(editorHTML(img.src, img.alt));
            startEditor(img);
        }
        img.after(button);
    }
}

let editorHTML = function (src, alt){
    src = src.replace('thumbnail_','');
    let str =
        `
            <div id="editor-image-container" class="row">
                <div class="pull-left">
                    <img id="image-to-edit" src="${src}" style="max-height: ${window.innerHeight * 0.8}px; max-width: ${window.innerWidth * 0.5}px" alt="${alt}">
                </div>
                <div id="editor-controls" class="pull-right">
                    <div class="col-xs-3">
                        <button id="crop" class="btn-default" type="button">Сохранить</button>
                        <button id="posrot" class="btn-default" type="button">Повернуть +</button>
                        <button id="negrot" class="btn-default" type="button">Повернуть -</button>
                    </div>
                </div>
            </div>
        `;
    return str;
}

let startEditor = function(originalImage){
    let image = document.getElementById("image-to-edit");
    let originalPath = originalImage.src.split('/');
    originalPath.splice(originalPath.length-1,1);
    originalPath = originalPath.join('/');

    if(image === undefined) return;
    const cropper = new Cropper(image, {
        aspectRatio: 8 / 5
    });
    let rotPos = document.getElementById('posrot');
    rotPos.onclick = function () {
        cropper.rotate(45);
    }
    let rotNeg = document.getElementById('negrot');
    rotNeg.onclick = function () {
        cropper.rotate(-45);
    }
    let butCrop = document.getElementById('crop');
    butCrop.onclick = function () {
        let croppedimage = cropper.getCroppedCanvas().toDataURL("image/png");
        let ref = `${host}/manager/update-add-image`;
        $.ajax({
            'type' : 'POST',
            'url' : ref,
            'dataType' : 'json',
            'data' : {
                '_csrf': csrf_token,
                'imageData': croppedimage,
                'imageName': image.alt,
                'mainImage': !originalPath.includes('find_image')
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