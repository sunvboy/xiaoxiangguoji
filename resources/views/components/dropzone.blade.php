<!--START: dropzone upload image -->
<div class="flex justify-between items-center">
    <label class="form-label text-base font-semibold">Album Ảnh</label>
    <a href="javascript:void(0)" class="form-label text-base font-semibold text-danger" onclick="openKCFinderDropZone($(this))">Select Album</a>
</div>
<div class="dropzone dz-clickable" id="myDropzone">
    <div class="dz-message" data-dz-message="">
        <div class="text-lg font-medium">Drop files here or click to upload.</div>
        <div class="text-slate-500"> This is just a demo dropzone. Selected files are <span class="font-medium">not</span> actually uploaded. </div>
    </div>
</div>
@push('javascript')
<script src="{{asset('library/dropzone/dropzone.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('library/dropzone/dropzone.min.css')}}" type="text/css" />
<!-- sortable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script>
    $(function() {
        $("#myDropzone").sortable({
            items: '.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#myDropzone',
            distance: 20,
            tolerance: 'pointer'
        });
    })
</script>
<!-- end sortable -->
<?php
if (!empty(old('album'))) {
    $image_json = old('album');
} else if (!empty($detail)) {
    $image_json = json_decode($detail->image_json, TRUE);
}

?>
<script>
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = ".jpeg,.jpg,.png,.gif";
    var fileList = new Array;
    var i = 0;
    var callForDzReset = false;
    $("#myDropzone").dropzone({
        url: "{{route('dropzone_upload')}}",
        addRemoveLinks: true,
        maxFiles: 100,
        acceptedFiles: 'image/*',
        maxFilesize: 5,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + '-' + file.name;
        },
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        init: function() {
            myDropzone = this;
            /*update load image*/
            <?php if (!empty($image_json)) { ?>
                <?php foreach ($image_json as $key => $item) {
                    if (!empty($item != 'undefined')) { ?>
                        var mockFile = {
                            name: '<?php echo $item ?>',
                            size: <?php echo File::exists(base_path($item)) ? filesize(base_path($item)) : 0; ?>
                        };
                        myDropzone.emit("addedfile", mockFile);
                        myDropzone.emit("thumbnail", mockFile, '<?php echo url($item) ?>');
                        myDropzone.emit("complete", mockFile);
                        $(".dz-image").eq(<?php echo $key ?>).append('<input type="hidden" name="album[]" value="<?php echo $item ?>">')
                <?php  }
                } ?>
            <?php } ?>
            /*end:  update load image*/
            /*thêm path image khi upload thành công */
            this.on("success", function(file, serverFileName) {
                $(file.previewTemplate).find('.dz-remove').attr('data-path', serverFileName);
                $(file.previewTemplate).find('.dz-image').append(
                    '<input type="hidden" name="album[]" value="' + serverFileName + '">')
                file.serverFn = serverFileName;
                fileList[i] = {
                    serverFileName
                };
                i++;
            });
            /*END: thêm path image khi upload thành công*/
        },
        removedfile: function(file) {
            if ($('.dz-preview').length === 1) {
                $('.dz-message').removeClass('hidden');
            } else {
                $('.dz-message').addClass('hidden');
            }
            var fileRef;
            return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
    });

    function openKCFinderDropZone(field) {
        CKFinder.modal({
            chooseFiles: true,
            width: 1000,
            height: 700,
            top: 0,
            onInit: function(finder) {
                finder.on('files:choose', function(evt) {
                    evt.data.files.forEach(function(item, key) {
                        var file = item;
                        var url = escapeHtml(file.getUrl());
                        var mockFile = {
                            name: url,
                            size: file.attributes.size
                        };
                        myDropzone.emit("addedfile", mockFile);
                        myDropzone.emit("thumbnail", mockFile, url);
                        myDropzone.emit("complete", mockFile);
                        $(".dz-image img[src='" + url + "']").parent().parent().append('<input type="hidden" name="album[]" value="' + url + '">')
                    });
                });
            }
        });
    }
</script>
<style>
    .dropzone {
        min-height: 150px;
        border: 2px dashed rgb(226, 232, 240, 0.6);
        background: white;
        padding: 20px 20px;
    }

    .dz-image img {
        height: 120px;
        width: 120px;
        object-fit: cover;
    }
</style>
@endpush

<!-- end: dropzone upload image -->