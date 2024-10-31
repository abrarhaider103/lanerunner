<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$sql = "SELECT * FROM app_and_membership_mockup WHERE types = 'mob_app'";

$este = $adm->getThis1($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title><?php echo SITE_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="http://lanerunner.com/app/images/new/Favicon.png">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="css/bootstrap.css" rel="stylesheet">

    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/ckeditor.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <style>
        /* Hide the default select arrow */
select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  /* Add some padding to make room for custom arrow */
  padding-right: 30px;
  /* Add custom border and background */
  border: 1px solid #ced4da;
  background-color: #fff;
  /* Add some padding and margin */
  padding: 8px 12px;
  margin: 5px;
  /* Make text bold */
  font-weight: bold;
}

/* Style the custom arrow */
.select-wrapper::after {
  content: '\25BC'; /* Unicode character for down arrow */
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
}

/* Style when the select is focused */
select:focus {
  outline: none;
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Style when the select is hovered */
select:hover {
  border-color: #b3b3b3;
}

/* Style when the select is disabled */
select:disabled {
  background-color: #e9ecef;
  opacity: 0.65;
  cursor: not-allowed;
}

/* Style when the select is open */
select:open {
  background-color: #f8f9fa;
}

            #container {
                width: 1000px;
                margin: 20px auto;
            }
            .ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 200px;
            }
            .ck-content .image {
                /* Block images */
                max-width: 80%;
                margin: 20px auto;
            }
        </style>
</head>

<body class="loading" data-layout="topnav"
      data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": false}'>

<!-- Begin page -->
<div class="wrapper">

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            <?php include("topBar.php"); ?>
            <!-- end Topbar -->
            <!-- Start Content-->
            <div class="container-fluid">
                        <!-- end page title -->
                        <form  method="post" action="" id="app_and_mem">
                            <input type="hidden" name="market_text_encoded" id="market_text_encoded" value="">
                            <div class="row">
                                <div class="col-12 mt-5">
                                <select class="form-select" name="types" id="types">
                                <option value="mob_app" >Mobile Mockup 1</option>
                                <option value="mem">Mobile Mockup 2</option>
                                </select>
                                    <textarea name="editor1" id="editor1">
                                    <?php $text = urldecode($este->texto); echo $text; ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-info ml-2">Save</button>
                                </div>
                            </div>
                        </form>
                <!-- container -->
            </div>
            <!-- content -->
            <!-- Footer Start -->
            <?php include("footer.php"); ?>
            <!-- end Footer -->
        </div>

    </div>
    <!-- END wrapper -->


    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <!-- third party js -->

    <!-- third party js ends -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <script src='//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js'></script>

    <script src="../../app/assets/js/jquery.typeahead.min.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> -->

    <script>
        const myForm = $('#app_and_mem');

        $(document).ready(function() {
    $('#app_and_mem').submit(function(event) {
        event.preventDefault();
        const market_text = $("#editor1").val();
        const texto = encodeURIComponent(market_text);
        var types = $('#types').val();
        console.log('type',types);
        console.log('texto', texto);
        $.ajax({
            url: 'ajax/app_and_membership.php', // Endpoint to handle the AJAX request
            method: 'POST',
            data: {  types: types, market_text_encoded:texto }, // Data to send to the server
            success: function(response) {
                alert(response);
            }
        })
        // $(this).unbind('submit').submit();
    });
});

    </script>
<script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            let editor;
            CKEDITOR.ClassicEditor.create(document.getElementById("editor1"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Welcome to CKEditor 5!',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "superbuild" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'AIAssistant',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced',
                    'CaseChange'
                ]
            }).then( newEditor => {
        editor = newEditor;
    } );
        </script>
        <script>
$(document).ready(function() {
    function updateTextArea() {
        var types = $('#types').val();
        // console.log('valuesHL',valuesHL);
        $.ajax({
            url: 'ajax/app_and_membership_types.php', // Endpoint to handle the AJAX request
            method: 'POST',
            data: { types: types }, // Data to send to the server
            success: function(response) {
                // console.log('response',response);
                        try {
                            var decodedText = decodeURIComponent(response);
                            // console.log('Decoded text:', response);      
                            editor.setData(response);
                        } catch (e) {
                            console.error(e);
                        }
                    },
            error: function(xhr, status, error) {
                console.error(error); // Log any errors to the console
            }
        });
    }

    $('#types').change(function() {
        updateTextArea();
    });

});
</script>
</body>

</html>
