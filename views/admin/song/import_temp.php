
<section class="title">
    <h4><?php echo lang('opensong:Import') ?></h4>
</section>
<section class="item">
    <div class="tabs">

        <ul class="tab-menu">
            <li><a href="#default-data"><span><?php echo lang('opensong:default'); ?></span></a></li>
        </ul>

        <div class="form_inputs" id="default-data">
            <fieldset>

                <form method="POST" id="importFile" enctype="multipart/form-data" action="<?php echo base_url() ?>/admin/opensong/upload"> 
                    <input id="fileupload" type="file" name="files"/>
                    <input type="submit"/>
                </form>


            </fieldset>
        </div>

    </div>
</section>

 <script> 
        // wait for the DOM to be loaded 
        $(document).ready(function() { 
            // bind 'myForm' and provide a simple callback function 
            $('#importFile').ajaxForm(function() { 
                console.log('Added')
            }); 
        }); 
    </script> 