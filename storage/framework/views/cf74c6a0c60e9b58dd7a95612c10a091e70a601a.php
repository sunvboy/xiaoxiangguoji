<?php
$keyword = $dataField->keyword;
$keyword_convert = str_replace('-', '_', $keyword);
$content =  '';
if ($errors->any()) {
    $content = old('config_colums_editor_' . $keyword_convert);
} else {
    if (!empty($detail)) {
        $ConfigPostmeta = \App\Models\ConfigPostmeta::select('meta_value')->where(['module_id' => $detail->id, 'module' => $module, 'config_colums_id' => $dataField->id])->first();
        if ($ConfigPostmeta) {
            $content = $ConfigPostmeta->meta_value;
        }
    }
}
?>
<div class="mt-3 box p-5">
    <label class="form-label text-base font-semibold"><?php echo $dataField->title ?></label>
    <textarea type="text" name="config_colums_editor_<?php echo $keyword_convert ?>" id="CkEditor<?php echo $dataField->id ?>" class="ck-editor form-control mt-3" placeholder="<?php echo $dataField->title ?>"><?php echo $content ?></textarea>
</div><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/components/field/editor.blade.php ENDPATH**/ ?>