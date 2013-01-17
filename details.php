<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Blog module
 *
 * @author Michal Szczur
 * @package OpenSong
 */
class Module_OpenSong extends Module {

    public $version = '0.2';

    public function info() {
        return array(
            'name' => array(
                'en' => 'OpenSong',
                'pl' => 'OpenSong'
            ),
            'description' => array(
                'en' => 'Create songs compatible with OpenSong files.',
                'pl' => 'Twórz piosenki kompatybilne z programem OpenSong'
            ),
            'frontend' => true,
            'backend' => true,
            'skip_xss' => true,
            'roles' => array(
                'add_song', 'edit_song', 'delete_song', 'export_html', 'export_pdf', 'export_xml'
            ),
            'menu' => 'content',
            'sections' => array(
                'songs' => array(
                    'name' => 'opensong:songs',
                    'uri' => 'admin/opensong',
                    'shortcuts' => array(
                        array(
                            'name' => 'opensong:asd',
                            'uri' => 'admin/opensong/create',
                            'class' => 'add'
                        ),
                    ),
                ),
                'categories' => array(
                    'name' => 'opensong:add',
                    'uri' => 'admin/opensong/add',
                    'shortcuts' => array(
                        array(
                            'name' => 'cat_create_title',
                            'uri' => 'admin/blog/categories/create',
                            'class' => 'add'
                        ),
                    ),
                ),
                'import' => array(
                    'name' => 'opensong:Import',
                    'uri' => 'admin/opensong/import',
                    'shortcuts' => array(
                        array(
                            'name' => 'opensong:Import',
                            'uri' => 'admin/opensong/import',
                            'class' => 'add'
                        ),
                    ),
                )
            ),
        );
    }

    public function install() {
        $this->dbforge->drop_table('opensong');

        $tables = array(
            'opensong' => array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
                'user_id' => array('type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => true),
                'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'author' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
                'copyright' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'hymn_number' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'presentation' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'ccli' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'capo' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'key' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'aka' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'key_line' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'user1' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'user2' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'user3' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'theme' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'time_sig' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
                'lyrics' => array('type' => 'TEXT')
            ),
        );

        return $this->install_tables($tables);
    }

    public function uninstall() {
        $this->dbforge->drop_table('opensong');
        // This is a core module, lets keep it around.
        return true;
    }

    public function upgrade($old_version) {
        return true;
    }

}
