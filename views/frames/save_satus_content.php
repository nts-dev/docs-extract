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
        toolbar1: "save | insertfile  undo redo | styleselect | fontselect |  bold italic underline strikethrough | localautosave",
        toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor emoticons",
        image_advtab: true,
        save_enablewhendirty: true,
        paste_data_images: true,
        media_live_embeds: true,


        save_onsavecallback: function () {

                parent.statusContentCell.progressOn();
                var postData = {"notes": tinyMCE.activeEditor.getContent()};
                $.post("../../controller/chapters.php?action=5", postData, function (data) {
                    parent.statusContentCell.progressOff();
                    parent.dhtmlx.message(data.text);
                }, 'json');


        }

    });


</script>

<form method="post" action="somepage">
    <textarea name="content" id="content"  style="width:100%;height:<?= $_POST['height'] ?>"></textarea>
</form>