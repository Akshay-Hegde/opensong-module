<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include __DIR__ . '\..\libraries\dompdfbeta\dompdf_config.inc.php';

require_once(__DIR__ . '\..\libraries\tcpdf\config/lang/pol.php');
require_once(__DIR__ . '\..\libraries\tcpdf\tcpdf.php');

/**
 * This is a sample module for PyroCMS
 *
 * @author Jerel Unruh - PyroCMS Dev Team
 * @website http://unruhdesigns.com
 * @package PyroCMS
 * @subpackage Sample Module
 */
class Admin extends Admin_Controller {

    protected $section = 'items';

    public function __construct() {

        parent::__construct();

        // Load all the required classes
        $this->load->model('opensong_m');
        $this->load->library('form_validation');
        $this->lang->load('opensong');
    }

    /**
     * List all items
     */
    public function index() {
        $items = $this->opensong_m->get_all();
        $this->template->title($this->module_details['name'])
                ->append_js('module::jquery.dataTables.min.js')
                ->append_js('module::dataTable.js')
                ->append_css('module::jquery.dataTables.css')
                ->build('admin/index', array('items' => $items));
    }


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
        $post = $this->input->post();

        if ($id && !empty($post)) {
            $this->load->model('opensong_m');
            $song = $this->opensong_m->get_by(array('id' => $id));
            $this->load->library('Opensong');
            $transpose = -1;
            $key = 'sharp';
            $html = '<font size="22"><b>' . $song->title ."</b></font> ";
            $html .= ' - <font size="12">' . $song->author ."</font>";
            $html .= "<hr><Br/>";
            $html .= $this->opensong->parse($song->lyrics,$post['transpose'],$post['key']);

            @ob_end_clean(); //resolved problem with generate PDF

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($song->author);
            $pdf->SetTitle($song->title);
            $pdf->SetSubject($song->title);
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);


//set margins
            //$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);

            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf->setLanguageArray('pl');

            $pdf->SetFont('freesans', '', 11);

            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '',false);

            $pdf->Output($song->title . '.pdf', 'I');
            exit;
        }
         $song = $this->opensong_m->get_by(array('id' => $id));
            $this->template
                ->set('song', $song)
                ->build('admin/song/print');
    }

    public function delete($id = 0) {

        if($id){
            if($this->opensong_m->delete($id))
                $this->session->set_flashdata('success', 'deleted');
            else
                $this->session->set_flashdata('error', 'no deleted');
            redirect('admin/opensong', "");

        } else
            redirect('admin/opensong', "");

    }

    public function edit($id = 0) {

        $post = $this->input->post();
        $action = $post['btnAction'];
        if ($id == 0 && empty($post)) {
            redirect('admin/opensong', "");
            $this->session->set_flashdata('error', 'error');
        }
        if (!empty($post)) {
            unset($post['id']);
            unset($post['btnAction']);
            if ($this->opensong_m->update($id, $post))
                $this->session->set_flashdata('success', 'success');
            else
                $this->session->set_flashdata('error', 'error');

            if($action == 'save_exit')
                redirect('admin/opensong');
        }


        $item = $this->opensong_m->get_by(array('id' => $id));

        if ($item != null) {
            $this->template
//                ->set('post', $post)
//		->append_js('module::jquery.fileupload.js')
//                ->append_js('module::jquery.iframe-transport.js')
//                ->append_js('module::jquery.fileupload-ui.js')
//                ->append_css('module::jquery.fileupload-ui.css')
                    //->append_js('module::jquery.form.js')
                    ->set('item', $item)
                    ->build('admin/song/edit','');
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


}
