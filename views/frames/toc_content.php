<!-- Place inside the <head> of your HTML -->
<?php

include ('../../../includes.php');

JSPackage::JQUERY();
JSPackage::TINYMCE();
?>

<script type="text/javascript">

    var baseURL = '';
    tinymce.init({
        selector: "textarea",
        plugins: [
            "save advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste emoticons textcolor colorpicker textpattern autosave"
        ],
        toolbar1: "save | insertfile undo redo | styleselect | fontselect |  bold italic underline strikethrough | localautosave",
        toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor emoticons",
        image_advtab: true,
        save_enablewhendirty: true,
        paste_data_images: true,
        media_live_embeds: true,
        relative_urls: false,
        convert_urls: false,
        remove_script_host : false,
        forced_root_block : "",
        force_br_newlines : false,
        force_p_newlines : false,

        save_onsavecallback: function () {
            var chapter_id = parent.grid_2.getSelectedRowId();
            var main_doc_id = parent.grid_1.getSelectedRowId();


            if(main_doc_id <0){
                parent.dhtmlx.alert("Select course to which you are updating the chapter and try again!");
                return;
            }

            if (chapter_id) {
                parent.tocContentCell.progressOn();

                var postData = {"notes": tinyMCE.activeEditor.getContent(), "id": chapter_id, "doc_id": main_doc_id};
                $.post("../../controller/chapters.php?action=3", postData, function (data) {
                    parent.tocContentCell.progressOff();
                    parent.dhtmlx.message(data.text);
                    parent.grid_2.updateFromXML('controller/chapters.php?action=1&id=' + main_doc_id,true,true);
                    parent.grid_archive.updateFromXML('controller/achived_chapters.php?action=1&id=' + main_doc_id,true,true);

                    parent.tab_2.progressOn();
                    $.get("../../controller/documents.php?action=2&id=" + data.doc_id, function (data_) {
                        parent.tab_2.attachHTMLString(data_);
                        parent.tab_2.showInnerScroll();
                        parent.tab_2.progressOff();
                   }, "json");
                }, 'json');
            } else {
                parent.dhtmlx.alert("No Row Selected!");
            }
        }
    });


</script>

<form method="post" action="somepage">
    <textarea name="content" id="content"  style="width:100%;height:<?= $_POST['height'] ?>"></textarea>
</form>