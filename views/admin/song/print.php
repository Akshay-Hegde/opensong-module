<section class="title">
    <h4><?php echo lang('opensong:Print settings') ?></h4>
</section>
<section class="item">
    <?php echo form_open(); ?>
    <div class="tabs">

        <ul class="tab-menu">
            <li><a href="#default-data"><span><?php echo lang('opensong:Print settings'); ?></span></a></li>
        </ul>

        <div class="form_inputs" id="default-data">
            <fieldset>
                <ul>
                    <li>
                        <label for="key"><?php echo lang('opensong:flatsharp'); ?></label>
                        <div class="input">
                            <input type="radio" name="key" value="sharp"><?php echo lang('opensong:sharp'); ?>
                            <input type="radio" name="key" value="flat"><?php echo lang('opensong:flat'); ?>
                        </div>
                    </li>
                    <li>
                        <label for="key"><?php echo lang('opensong:Transpose'); ?></label>
                        <div class="input">
                            <select name="transpose">
                                <option value="-5">-5</option>
                                <option value="-4">-4</option>
                                <option value="-3">-3</option>
                                <option value="-2">-2</option>
                                <option value="-1">-1</option>
                                <option value="0" selected="selected">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>

                            </select>

                        </div>
                    </li>

                    <li>
                        <?php
                        echo form_label(lang('opensong:Lyrics') . ' <span>*</span>', 'lyrics');
                        echo '<div class="input">' . form_textarea('lyrics', $song->lyrics, 'style="font-family:courier;" disabled="disabled"') . '</div>';
                        ?>
                    </li>

                    <li>
                        <div class="buttons">
                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save'=>'print',  'cancel'))); ?>
                        </div>

                    </li>
                </ul>
            </fieldset>
        </div>


    </div>
</section>

<?php echo form_close(); ?>