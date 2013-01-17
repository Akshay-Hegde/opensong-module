<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include __DIR__ . '/../libraries/dompdfbeta/dompdf_config.inc.php';

require_once(__DIR__ . '/../libraries/tcpdf/config/lang/pol.php');
require_once(__DIR__ . '/../libraries/tcpdf/tcpdf.php');

/**
 * This is a sample module for PyroCMS
 *
 * @author Jerel Unruh - PyroCMS Dev Team
 * @website http://unruhdesigns.com
 * @package PyroCMS
 * @subpackage Sample Module
 */
class OpenSongRemote extends Admin_Controller {

    protected $section = 'items';

    public function __construct() {

        parent::__construct();

        // Load all the required classes
        $this->load->model('opensong_m');
        $this->load->library('form_validation');
//        $this->lang->load('sample');
// We'll set the partials and metadata here since they're used everywhere
//        $this->template->append_js('module::admin.js')
//                ->append_css('module::admin.css');


        $this->lang->load('opensong');


    }

    /**
     * List all items
     */
    public function index() {
// here we use MY_Model's get_all() method to fetch everything
        $items = $this->opensong_m->get_all();
//        echo '<pre>';print_r((array) $items[0]);exit;
// Build the view with sample/views/admin/items.php
//         $this->data->items = & $items;
        $this->template->title($this->module_details['name'])
                ->append_js('module::jquery.dataTables.min.js')
                ->append_js('module::dataTable.js')
                ->append_css('module::jquery.dataTables.css')
                ->build('admin/index', array('items' => $items));
    }

//  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
//  `copyright` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `hymn_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `presentation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `ccli` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `capo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `aka` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `key_line` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `user1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `user2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `user3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `theme` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `time_sig` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `lyrics` text COLLATE utf8_unicode_ci NOT NULL,

    protected $validation_rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'opensong:Title',
            'rules' => 'trim|htmlspecialchars|required|max_length[255]'
        ),
        'author' => array(
            'field' => 'author',
            'label' => 'opensong:Author',
            'rules' => 'trim|alpha_dot_dash|max_length[255]'
        ),
        'copyright' => array(
            'field' => 'copyright',
            'label' => 'opensong:Copyright',
            'rules' => 'trim|alpha_dot_dash|max_length[255]'
        ),
        'lyrics' => array(
            'field' => 'lyrics',
            'label' => 'opensong:Lyrics',
            'rules' => 'trim|htmlspecialchars|required'
        )
//        array(
//            'field' => 'category_id',
//            'label' => 'lang:blog:category_label',
//            'rules' => 'trim|numeric'
//        ),
//        array(
//            'field' => 'keywords',
//            'label' => 'lang:global:keywords',
//            'rules' => 'trim'
//        ),
//        array(
//            'field' => 'intro',
//            'label' => 'lang:blog:intro_label',
//            'rules' => 'trim|required'
//        ),
//        array(
//            'field' => 'body',
//            'label' => 'lang:blog:content_label',
//            'rules' => 'trim|required'
//        ),
//        array(
//            'field' => 'type',
//            'rules' => 'trim|required'
//        ),
//        array(
//            'field' => 'status',
//            'label' => 'lang:blog:status_label',
//            'rules' => 'trim|alpha'
//        ),
//        array(
//            'field' => 'created_on',
//            'label' => 'lang:blog:date_label',
//            'rules' => 'trim|required'
//        ),
//        array(
//            'field' => 'created_on_hour',
//            'label' => 'lang:blog:created_hour',
//            'rules' => 'trim|numeric|required'
//        ),
//        array(
//            'field' => 'created_on_minute',
//            'label' => 'lang:blog:created_minute',
//            'rules' => 'trim|numeric|required'
//        ),
//        array(
//            'field' => 'comments_enabled',
//            'label' => 'lang:blog:comments_enabled_label',
//            'rules' => 'trim|numeric'
//        ),
//        array(
//            'field' => 'preview_hash',
//            'label' => '',
//            'rules' => 'trim'
//        )
    );

    public function add() {

        $post = $this->input->post();
        $action = $post['btnAction'];
        unset($post['btnAction']);

        if (!empty($post)) {
            $this->form_validation->set_rules($this->validation_rules);
            if ($this->form_validation->run()) {
                if ($this->opensong_m->insert($post))
                    $this->session->set_flashdata('success', 'success');
                else
                    $this->session->set_flashdata('error', 'error');
            } else {
                $this->session->set_flashdata('error', 'error');
            }
        } else {
            $post = new stdClass;
            $this->session->set_flashdata('error', 'error');
        }
        $this->template
                ->set('post', $post)
                ->build('admin/song/add');
    }

    public function print_song($id = 0) {
        if ($id) {
            $this->load->model('opensong_m');
            $song = $this->opensong_m->get_by(array('id' => $id));
            $this->load->library('opensong');
            $html = $this->opensong->parse($song->lyrics);

            @ob_end_clean(); //resolved problem with generate PDF

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('OpenSong');
            $pdf->SetTitle('asd');
            $pdf->SetSubject('TCPDF Tutorial');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');


//set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);

//set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
            $pdf->setLanguageArray('pl');

// ---------------------------------------------------------
// set font
            $pdf->SetFont('dejavusans', '', 10);

            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->Output('example_006.pdf', 'I');
            exit;
        }
    }

    public function edit($id = 0) {
        if ($id != 0) {
            echo 'delete' . ' ' . $id;
        }
    }

    public function import() {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->template->set_layout(FALSE);

        }
        $this->template
//                ->set('post', $post)
//		->append_js('module::jquery.fileupload.js')
//                ->append_js('module::jquery.iframe-transport.js')
//                ->append_js('module::jquery.fileupload-ui.js')
//                ->append_css('module::jquery.fileupload-ui.css')
                ->append_js('module::jquery.form.js')
                ->build('admin/song/import_temp');
    }

    public function upload() {
        $xml = simplexml_load_file($_FILES['files']['tmp_name']);
        $xml->user_id = $this->current_user->id;
        $this->opensong_m->insert($xml);
        var_dump($xml);
        exit;
    }

//
//    public function create() {
//// Set the validation rules from the array above
//        $this->form_validation->set_rules($this->item_validation_rules);
//
//// check if the form validation passed
//        if ($this->form_validation->run()) {
//// See if the model can create the record
//            if ($this->sample_m->create($this->input->post())) {
//// All good...
//                $this->session->set_flashdata('success', lang('sample.success'));
//                redirect('admin/sample');
//            }
//// Something went wrong. Show them an error
//            else {
//                $this->session->set_flashdata('error', lang('sample.error'));
//                redirect('admin/sample/create');
//            }
//        }
//
//        foreach ($this->item_validation_rules AS $rule) {
//            $this->data->{$rule['field']} = $this->input->post($rule['field']);
//        }
//
//// Build the view using sample/views/admin/form.php
//        $this->template->title($this->module_details['name'], lang('sample.new_item'))
//                ->build('admin/form', $this->data);
//    }
//
//    public function edit($id = 0) {
//        $this->data = $this->sample_m->get($id);
//
//// Set the validation rules from the array above
//        $this->form_validation->set_rules($this->item_validation_rules);
//
//// check if the form validation passed
//        if ($this->form_validation->run()) {
//// get rid of the btnAction item that tells us which button was clicked.
//// If we don't unset it MY_Model will try to insert it
//            unset($_POST['btnAction']);
//
//// See if the model can create the record
//            if ($this->sample_m->update($id, $this->input->post())) {
//// All good...
//                $this->session->set_flashdata('success', lang('sample.success'));
//                redirect('admin/sample');
//            }
//// Something went wrong. Show them an error
//            else {
//                $this->session->set_flashdata('error', lang('sample.error'));
//                redirect('admin/sample/create');
//            }
//        }
//
//// Build the view using sample/views/admin/form.php
//        $this->template->title($this->module_details['name'], lang('sample.edit'))
//                ->build('admin/form', $this->data);
//    }
//
//    public function delete($id = 0) {
//// make sure the button was clicked and that there is an array of ids
//        if (isset($_POST['btnAction']) AND is_array($_POST['action_to'])) {
//// pass the ids and let MY_Model delete the items
//            $this->sample_m->delete_many($this->input->post('action_to'));
//        } elseif (is_numeric($id)) {
//// they just clicked the link so we'll delete that one
//            $this->sample_m->delete($id);
//        }
//        redirect('admin/sample');
//    }
}