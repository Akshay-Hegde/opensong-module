<!--<section class="title">
    <h4><?php echo lang('opensong:Import') ?></h4>
</section>
<section class="item">
    <div class="tabs">

        <ul class="tab-menu">
            <li><a href="#default-data"><span><?php echo lang('opensong:default'); ?></span></a></li>
        </ul>

        <div class="form_inputs" id="default-data">
            <fieldset>-->




<div id="fileupload">
    <form action="<?php echo base_url() ?>/admin/opensong/upload" method="POST" enctype="multipart/form-data">
        <div class="fileupload-buttonbar">
            <label class="fileinput-button">
                <span>Add files...</span>
                <?php echo form_upload('song[]') ?>
                <input type="file" name="userfile" multiple="" />
            </label>
            <button type="submit" class="start">Start upload</button>
            <button type="reset" class="cancel">Cancel upload</button>
            <button type="button" class="delete">Delete files</button>
        </div>
    </form>
    <div class="fileupload-content">
        <table class="files"></table>
        <div class="fileupload-progressbar"></div>
    </div>
    
</div>


<script id="template-upload" type="text/x-jquery-tmpl">
    <tr class="template-upload{{if error}} ui-state-error{{/if}}">
        <td class="preview"></td>
        <td class="name">${name}</td>
        <td class="size">${sizef}</td>
        {{if error}}
        <td class="error" colspan="2">Error:
            {{if error === 'maxFileSize'}}File is too big
            {{else error === 'minFileSize'}}File is too small
            {{else error === 'acceptFileTypes'}}Filetype not allowed
            {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
            {{else}}${error}
            {{/if}}
        </td>
        {{else}}
        <td class="progress"><div></div></td>
        <td class="start"><button>Start</button></td>
        {{/if}}
        <td class="cancel"><button>Cancel</button></td>
    </tr>
</script>
<script id="template-download" type="text/x-jquery-tmpl">
    <tr class="template-download{{if error}} ui-state-error{{/if}}">
        {{if error}}
        <td></td>
        <td class="name">${name}</td>
        <td class="size">${sizef}</td>
        <td class="error" colspan="2">Error:
            {{if error === 1}}File exceeds upload_max_filesize (php.ini directive)
            {{else error === 2}}File exceeds MAX_FILE_SIZE (HTML form directive)
            {{else error === 3}}File was only partially uploaded
            {{else error === 4}}No File was uploaded
            {{else error === 5}}Missing a temporary folder
            {{else error === 6}}Failed to write file to disk
            {{else error === 7}}File upload stopped by extension
            {{else error === 'maxFileSize'}}File is too big
            {{else error === 'minFileSize'}}File is too small
            {{else error === 'acceptFileTypes'}}Filetype not allowed
            {{else error === 'maxNumberOfFiles'}}Max number of files exceeded
            {{else error === 'uploadedBytes'}}Uploaded bytes exceed file size
            {{else error === 'emptyResult'}}Empty file upload result
            {{else}}${error}
            {{/if}}
        </td>
        {{else}}
        <td class="preview">
            {{if thumbnail_url}}
            <a href="${url}" target="_blank"><img width ="80"src="${thumbnail_url}"></a>
            {{/if}}
        </td>
        <td class="name">
            <a href="${url}"{{if thumbnail_url}} target="_blank"{{/if}}>${name}</a>
        </td>
        <td class="size">${sizef}</td>
        <td colspan="2"></td>
        {{/if}}
        <td class="delete">
            <button data-type="${delete_type}" data-url="${delete_url}">Delete</button>
        </td>
    </tr>
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>

<script>
    //this is the application.js file from the example code//
    $(document).ready(function ()
    {
        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload();
	
        // Enable iframe cross-domain access via redirect option:
        //	$('#fileupload').fileupload(
        //		'option',
        //		'redirect',
        //		window.location.href.replace(
        //			/\/[^\/]*$/,
        //			'./cors/result.html?%s'
        //			)
        //		);

        //Set your url localhost or your ndd (perrot-julien.fr)
        if (window.location.hostname === 'localhost') {
            //Load files
            // Upload server status check for browsers with CORS support:
            if ($.ajaxSettings.xhr().withCredentials !== undefined)
            {
                $.ajax({
                    url: '#',
                    dataType: 'json', 
				
                    success : function(data) {  

                        var fu = $('#fileupload').data('fileupload'), 
                        template;
                        fu._adjustMaxNumberOfFiles(-data.length);
                        template = fu._renderDownload(data)
                        .appendTo($('#fileupload .files'));
					
                        // Force reflow:
                        fu._reflow = fu._transition && template.length &&
                            template[0].offsetWidth;
                        template.addClass('in');
                        $('#loading').remove();
                    }

                }).fail(function () {
                    $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                        new Date())
                    .appendTo('#fileupload');
                });
            }
        } else {
            // Load existing files:
            $('#fileupload').each(function () {
                var that = this;
                $.getJSON(this.action, function (result) {
                    if (result && result.length) {
                        $(that).fileupload('option', 'done')
                        .call(that, null, {
                            result: result
                        });
                    }
                });
            });
        }


        // Open download dialogs via iframes,
        // to prevent aborting current uploads:
        $('#fileupload .files a:not([target^=_blank])').live('click', function (e) {
            e.preventDefault();
            $('<iframe style="display:none;"></iframe>')
            .prop('src', this.href)
            .appendTo('body');
        });
    });
			
</script>	


<!--
            </fieldset>
        </div>

    </div>
</section>-->

<?php echo form_close(); ?>
