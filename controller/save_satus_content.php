<!-- Place inside the <head> of your HTML -->
<!--<script type="text/javascript" src="../../packages/lib/tinymce4.4/tinymce.min.js"></script>-->
<!--  Jquery -->
<!--<script src="../../packages/lib/jquery/jquery-3.0.0.min.js"></script>-->
<!--<script src="../../packages/lib/jquery/jquery-ui.min.js"></script>-->
JSPackage::JQUERY();
JSPackage::TINYMCE();
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        readonly : true,

        plugins: [
            "save advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste emoticons textcolor colorpicker textpattern autosave responsivefilemanager"
        ],
        toolbar1: "save | insertfile undo redo | styleselect | fontselect |  bold italic underline strikethrough | localautosave",
        toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor emoticons",
        image_advtab: true,
        save_enablewhendirty: true,
        paste_data_images: true,
        media_live_embeds: true,
        contenteditable: false,

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