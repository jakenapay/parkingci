<?php
defined('BASEPATH') OR exit('No direct scripts allowed');


require(APPPATH.'libraries/phpqrcode/qrlib.php');
require(APPPATH.'libraries/fpdf/fpdf.php');

class Complimentary extends Admin_Controller
{

    public function __construct() {

        parent::__construct();

		$this->not_logged_in();
		$this->data['page_title'] = 'Parking';
        $this->load->model('Model_complimentary');
        // $this->load->library('form-validation');
    }


    public function index()
    {

        $this->data['complimentary_data'] = $this->Model_complimentary->getComplimentaryData();
        $this->render_template('complimentary/index', $this->data);
    }

    public function create() {
        $this->load->library('form_validation');
    
        $this->form_validation->set_rules('event_title', 'Event Name', 'required');
        $this->form_validation->set_rules('start_date', 'Starting Date', 'required');
        $this->form_validation->set_rules('end_date', 'Expiration Date', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
    
        if ($this->form_validation->run() == FALSE) {
            $this->render_template('complimentary/create', $this->data);
        } else {
            $c_data = [
                'eventName'         => $this->input->post('event_title'),
                'startingDate'      => $this->input->post('start_date'),
                'expirationDate'    => $this->input->post('end_date'),
                'quantity'          => $this->input->post('quantity')
            ];
    
            for ($i = 0; $i < intval($c_data['quantity']); $i++) {
                $organizationName = 'PICC';
                $serialNumber = mt_rand(00000000, 99999999);
    
                $qrData = $organizationName . "/" . $c_data['eventName'] . "/" . $serialNumber . "/" . $c_data['startingDate'] . "/" . $c_data['expirationDate'];
                $data = [
                    'qrcode'        => $qrData,
                    'event'         => $c_data['eventName'],
                    'start_date'    => $c_data['startingDate'],
                    'end_date'      => $c_data['expirationDate'],
                ];
                $this->Model_complimentary->createComplimentary($data);
            }
            
            redirect('complimentary');
        }
    }
    

    public function getEvent(){
        $tempDir = "qrcodes";
        $pdfDir = "qrpdf";
            
        $eventTitle = $this->input->get('event_title');
        $qrcodeData = $this->Model_complimentary->getEventData($eventTitle);
            
        if($qrcodeData){
            $pdf = new FPDF();
            $pdf->AddPage();
            
            $qrSize = 19.80;
            
            $maxWidth = $pdf->GetPageWidth();
            $maxHeight = $pdf->GetPageHeight();
            
            $numPerRow = floor($maxWidth / $qrSize);
            $numPerColumn = floor($maxHeight / $qrSize);
            
            $horizGap = ($maxWidth - $numPerRow * $qrSize) / ($numPerRow + 1);
            $vertGap = ($maxHeight - $numPerColumn * $qrSize) / ($numPerColumn + 1);
            
            $x = $horizGap;
            $y = $vertGap;
            
            foreach ($qrcodeData as $i => $row) {
                $codeContents = $row['qrcode'];
                $eventName = $row['event'];
                $fileName = $eventName. '_' . md5($codeContents) . '_' . $i . '.png';
                $pngAbsoluteFilePath = $tempDir . '/' . $fileName;
                $urlRelativeFilePath = $tempDir . '/' . $fileName;
            
                QRcode::png($codeContents, $pngAbsoluteFilePath);
            
                $pdf->Image($pngAbsoluteFilePath, $x, $y, $qrSize, $qrSize);
            
                $x += $qrSize + $horizGap;
                if ($x > $maxWidth - $qrSize) {
                    $x = $horizGap;
                    $y += $qrSize + $vertGap;
                }
            }
            
            $pdfFileName = $pdfDir . '/qrcodes_'.date('YmdHis').'.pdf';
            $pdf->Output($pdfFileName, 'F');

            $this->Model_complimentary->markAsPrinted($eventTitle);
            
            $this->data['pdfFileName'] = $pdfFileName;
            $this->render_template('complimentary/qr_download', $this->data);
        } else {
            $this->render_template('complimentary/error', $this->data);
        }
    }
    
    
    
    
    
}
