<section class="title">
    <h4><?php echo lang('opensong:add') ?></h4>
</section>
<section class="item">
    <?php echo form_open(); ?>
    <div class="tabs">

        <table id="lists">
            <thead>
                <tr>
                    <th><?php echo lang('opensong:Title'); ?></th>
                    <th><?php echo lang('opensong:Author'); ?></th>
                    <th><?php echo lang('opensong:Copyright'); ?></th>
                    <th><?php echo lang('opensong:Actions'); ?></th>

                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($items as $item) {
                    echo '<tr>';
                    echo '<td>' . $item->title . '</td>';
                    echo '<td>' . $item->author . '</td>';
                    echo '<td>' . $item->copyright . '</td>';
                    echo '<td>'
                    . '<a href="' . base_url() . 'admin/opensong/edit/' . $item->id . '">' . lang('opensong:Edit') . '</a>' . ' '
                    . '<a href="' . base_url() . 'admin/opensong/delete/' . $item->id . '">' . lang('opensong:Delete') . '</a>' . ' '
                    . '<a href="' . base_url() . 'admin/opensong/print_song/' . $item->id . '">' . lang('opensong:PDF') . '</a>' . ' ' . '</td>';

                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
