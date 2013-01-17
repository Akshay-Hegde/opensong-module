<section class="title">
    <h4><?php echo lang('opensong:add') ?></h4>
</section>
<section class="item">
<?php echo form_open(); ?>
<div class="tabs">

    <ul class="tab-menu">
        <li><a href="#default-data"><span><?php echo lang('opensong:default'); ?></span></a></li>
        <li><a href="#optional-data"><span><?php echo lang('opensong:optional'); ?></span></a></li>
    </ul>

    <div class="form_inputs" id="default-data">
        <fieldset>
            <ul>
                <li>
                    <?php 
                        echo form_hidden('user_id',$this->current_user->id);
                    ?>
                </li>
                <li> 
                    <?php
                        echo form_label(lang('opensong:Title').' <span>*</span>', 'title');
                        echo '<div class="input">' . form_input('title') . '</div>'; 
                    ?> 
                </li>
                <li> 
                    <?php 
                        echo form_label(lang('opensong:Author').' <span>*</span>', 'author');
                        echo '<div class="input">' . form_input('author') . '</div>'; 
                    ?> 
                </li>
                <li> 
                    <?php 
                        echo form_label(lang('opensong:Copyright').' <span>*</span>', 'copyright');
                        echo '<div class="input">' . form_input('copyright') . '</div>'; 
                    ?> 
                </li>
                <li> 
                    <?php 
                        echo form_label(lang('opensong:Lyrics').' <span>*</span>', 'lyrics');
                        echo '<div class="input">' . form_textarea('lyrics','','style="font-family:courier;"') . '</div>'; 
                    ?> 
                </li>
                <li><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?></li>
            </ul>
        </fieldset>
    </div>
    <div class="form_inputs" id="optional-data">
        <fieldset>
            <ul>
                <h2>asdasda</h2>
            </ul>
        </fieldset>
    </div>
    
</div>
    </section>

<?php echo form_close(); ?>