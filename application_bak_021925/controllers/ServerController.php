<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ServerController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_server');
        $this->load->model('model_rfid');
        $this->load->model('model_parking');
    }

    public function index()
    {
        date_default_timezone_set("Asia/Manila");

        $data['reportData'] = $this->Model_server->getRecord();
    

        $this->load->view('debugger/index', $data);
    }

    public function searchRecord()
    {
        $this->load->view('debugger/search');
    }
    public function information()
    {
        $this->load->view('debugger/counter');
    }

    public function search()
    {
        $query = $this->input->get('query');
        $results = $this->Model_server->search_parking($query);
        echo json_encode($results);
    }

    public function getCounts()
    {
        $counts = $this->Model_server->getGateCounts();


        echo json_encode($counts);
    }

    public function getCountsbyEntry()
    {
        $counts = $this->Model_server->getGateCountsEntry();

        echo json_encode($counts);
    }

    public function getCountsbyExit()
    {
        $counts = $this->Model_server->getGateCountsExit();


        echo json_encode($counts);
    }

    public function getRftag()
    {
        $code = $this->input->get('code');
        $response = $this->model_parking->CheckRFTag($code);
        print_r($response);
    }

    public function getReportPerDay()
    {
        date_default_timezone_set("Asia/Manila");
        $data['reportData'] = $this->Model_server->getDatabyDate();
        $this->load->view('debugger/report', $data);
    }

    public function exportReport()
    {
        date_default_timezone_set("Asia/Manila");
        $data = $this->Model_server->getDatabyDate();


        $accessType = $this->input->get('accesstype');
        if ($accessType == "All") {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=dry_run_report_' . date('Y-m-d') . '.xls');

            echo "<table border='1'>";
            echo "<tr style='background-color: #D3D3D3;'>";
            echo "<th>Date</th>";
            echo "<th>Plate</th>";
            echo "<th>QR</th>";
            echo "<th>RF</th>";

            echo "<th style='background-color: #ADD8E6;'>Motorcycle</th>";
            echo "<th style='background-color: #ADD8E6;'>Car Count</th>";
            echo "<th style='background-color: #ADD8E6;'>Bus/Truck</th>";

            echo "<th>G1-Entry</th>";
            echo "<th>G2-Entry</th>";
            echo "<th>G3-Entry</th>";
            echo "<th>G4-Entry</th>";
            echo "<th>G1-Exit</th>";
            echo "<th>G2-Exit</th>";
            echo "<th>G3-Exit</th>";
            echo "<th>G4-Exit</th>";
            echo "<th>Entry</th>";
            echo "<th>Exit</th>";
            echo "</tr>";

            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>{$row['date']}</td>";
                echo "<td>{$row['plate_number_count']}</td>";
                echo "<td>{$row['qr_count']}</td>";
                echo "<td>{$row['rftag_count']}</td>";

                echo "<td style='background-color: #ADD8E6;'>{$row['motorcycle_count']}</td>";
                echo "<td style='background-color: #ADD8E6;'>{$row['car_count']}</td>";
                echo "<td style='background-color: #ADD8E6;'>{$row['bus_truck_count']}</td>";

                echo "<td>{$row['G1_count']}</td>";
                echo "<td>{$row['G2_count']}</td>";
                echo "<td>{$row['G3_count']}</td>";
                echo "<td>{$row['G4_count']}</td>";
                echo "<td>{$row['G1Ex_count']}</td>";
                echo "<td>{$row['G2Ex_count']}</td>";
                echo "<td>{$row['G3Ex_count']}</td>";
                echo "<td>{$row['G4Ex_count']}</td>";
                echo "<td>" . ($row['G1_count'] + $row['G2_count'] + $row['G3_count'] + $row['G4_count']) . "</td>";
                echo "<td>" . ($row['G1Ex_count'] + $row['G2Ex_count'] + $row['G3Ex_count'] + $row['G4Ex_count']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            exit;
        } else if ($accessType == "Plate") {
            $responseData = $this->Model_server->getDatabyAccessType($accessType);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=dry_run_report_' . date('Y-m-d') . '.xls');

            echo "<table border='1'>";

            // Row 1: Main header with two columns "Entry" and "Exit"
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='11'>RFTag Summary</th>";
            echo "</tr>";
            // Row 1: Main header with two columns "Entry" and "Exit"
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Date</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='4'>Entry</th>"; // Entry column with four sub-columns
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='4'>Exit</th>";  // Exit column with four sub-columns
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "</tr>";

            // Row 2: Sub-header with G1, G2, G3, G4 under both Entry and Exit
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G1</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G2</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G3</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G4</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G1</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G2</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G3</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G4</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Total Entry</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Total Exit</th>";
            echo "</tr>";

            // Fetch the data using your query
            $responseData = $this->Model_server->getDatabyAccessType($accessType);

            // Row 3 onwards: Data rows
            foreach ($responseData as $row) {
                echo "<tr>";
                echo "<td>{$row['date']}</td>";
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G1_count']}</td>";    // Entry G1 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G2_count']}</td>";    // Entry G2 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G3_count']}</td>";    // Entry G3 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G4_count']}</td>";    // Entry G4 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G1Ex_count']}</td>";  // Exit G1 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G2Ex_count']}</td>";  // Exit G2 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G3Ex_count']}</td>";  // Exit G3 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G4Ex_count']}</td>";  // Exit G4 count
                echo "<td>" . ($row['G1_count'] + $row['G2_count'] + $row['G3_count'] + $row['G4_count']) . "</td>";  // Total Entry
                echo "<td>" . ($row['G1Ex_count'] + $row['G2Ex_count'] + $row['G3Ex_count'] + $row['G4Ex_count']) . "</td>";  // Total Exit

                echo "</tr>";
            }

            echo "</table>";
            exit;



        } else if ($accessType == "QR") {
            $responseData = $this->Model_server->getDatabyAccessType($accessType);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=dry_run_report_' . date('Y-m-d') . '.xls');

            echo "<table border='1'>";

            // Row 1: Main header with two columns "Entry" and "Exit"
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='11'>RFTag Summary</th>";
            echo "</tr>";
            // Row 1: Main header with two columns "Entry" and "Exit"
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Date</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='4'>Entry</th>"; // Entry column with four sub-columns
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='4'>Exit</th>";  // Exit column with four sub-columns
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "</tr>";

            // Row 2: Sub-header with G1, G2, G3, G4 under both Entry and Exit
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G1</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G2</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G3</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G4</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G1</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G2</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G3</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G4</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Total Entry</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Total Exit</th>";
            echo "</tr>";

            // Fetch the data using your query
            $responseData = $this->Model_server->getDatabyAccessType($accessType);

            // Row 3 onwards: Data rows
            foreach ($responseData as $row) {
                echo "<tr>";
                echo "<td>{$row['date']}</td>";
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G1_count']}</td>";    // Entry G1 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G2_count']}</td>";    // Entry G2 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G3_count']}</td>";    // Entry G3 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G4_count']}</td>";    // Entry G4 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G1Ex_count']}</td>";  // Exit G1 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G2Ex_count']}</td>";  // Exit G2 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G3Ex_count']}</td>";  // Exit G3 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G4Ex_count']}</td>";  // Exit G4 count
                echo "<td>" . ($row['G1_count'] + $row['G2_count'] + $row['G3_count'] + $row['G4_count']) . "</td>";  // Total Entry
                echo "<td>" . ($row['G1Ex_count'] + $row['G2Ex_count'] + $row['G3Ex_count'] + $row['G4Ex_count']) . "</td>";  // Total Exit

                echo "</tr>";
            }

            echo "</table>";
            exit;


        } else if ($accessType == "RFtag") {
            $responseData = $this->Model_server->getDatabyAccessType($accessType);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=dry_run_report_' . date('Y-m-d') . '.xls');

            echo "<table border='1'>";

            // Row 1: Main header with two columns "Entry" and "Exit"
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='11'>RFTag Summary</th>";
            echo "</tr>";
            // Row 1: Main header with two columns "Entry" and "Exit"
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Date</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='4'>Entry</th>"; // Entry column with four sub-columns
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px' colspan='4'>Exit</th>";  // Exit column with four sub-columns
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "</tr>";

            // Row 2: Sub-header with G1, G2, G3, G4 under both Entry and Exit
            echo "<tr>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'></th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G1</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G2</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G3</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G4</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G1</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G2</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G3</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>G4</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Total Entry</th>";
            echo "<th style='background-color: #272727; color: #ffffff; line-spacing: 10px'>Total Exit</th>";
            echo "</tr>";

            // Fetch the data using your query
            $responseData = $this->Model_server->getDatabyAccessType($accessType);

            // Row 3 onwards: Data rows
            foreach ($responseData as $row) {
                echo "<tr>";
                echo "<td>{$row['date']}</td>";
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G1_count']}</td>";    // Entry G1 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G2_count']}</td>";    // Entry G2 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G3_count']}</td>";    // Entry G3 count
                echo "<td style='background-color: #0E8388; color: #ffffff; line-spacing: 10px'>{$row['G4_count']}</td>";    // Entry G4 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G1Ex_count']}</td>";  // Exit G1 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G2Ex_count']}</td>";  // Exit G2 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G3Ex_count']}</td>";  // Exit G3 count
                echo "<td style='background-color: #2E3840; color: #ffffff; line-spacing: 10px'>{$row['G4Ex_count']}</td>";  // Exit G4 count
                echo "<td>" . ($row['G1_count'] + $row['G2_count'] + $row['G3_count'] + $row['G4_count']) . "</td>";  // Total Entry
                echo "<td>" . ($row['G1Ex_count'] + $row['G2Ex_count'] + $row['G3Ex_count'] + $row['G4Ex_count']) . "</td>";  // Total Exit

                echo "</tr>";
            }

            echo "</table>";
            exit;



        } else {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=dry_run_report_' . date('Y-m-d') . '.xls');

            echo "<table border='1'>";
            echo "<tr style='background-color: #D3D3D3;'>";
            echo "<th>Date</th>";
            echo "<th>Plate</th>";
            echo "<th>QR</th>";
            echo "<th>RF</th>";

            echo "<th style='background-color: #ADD8E6;'>Motorcycle</th>";
            echo "<th style='background-color: #ADD8E6;'>Car Count</th>";
            echo "<th style='background-color: #ADD8E6;'>Bus/Truck</th>";

            echo "<th>G1-Entry</th>";
            echo "<th>G2-Entry</th>";
            echo "<th>G3-Entry</th>";
            echo "<th>G4-Entry</th>";
            echo "<th>G1-Exit</th>";
            echo "<th>G2-Exit</th>";
            echo "<th>G3-Exit</th>";
            echo "<th>G4-Exit</th>";
            echo "<th>Entry</th>";
            echo "<th>Exit</th>";
            echo "</tr>";

            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>{$row['date']}</td>";
                echo "<td>{$row['plate_number_count']}</td>";
                echo "<td>{$row['qr_count']}</td>";
                echo "<td>{$row['rftag_count']}</td>";

                echo "<td style='background-color: #ADD8E6;'>{$row['motorcycle_count']}</td>";
                echo "<td style='background-color: #ADD8E6;'>{$row['car_count']}</td>";
                echo "<td style='background-color: #ADD8E6;'>{$row['bus_truck_count']}</td>";

                echo "<td>{$row['G1_count']}</td>";
                echo "<td>{$row['G2_count']}</td>";
                echo "<td>{$row['G3_count']}</td>";
                echo "<td>{$row['G4_count']}</td>";
                echo "<td>{$row['G1Ex_count']}</td>";
                echo "<td>{$row['G2Ex_count']}</td>";
                echo "<td>{$row['G3Ex_count']}</td>";
                echo "<td>{$row['G4Ex_count']}</td>";
                echo "<td>" . ($row['G1_count'] + $row['G2_count'] + $row['G3_count'] + $row['G4_count']) . "</td>";
                echo "<td>" . ($row['G1Ex_count'] + $row['G2Ex_count'] + $row['G3Ex_count'] + $row['G4Ex_count']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            exit;
        }

    }
    public function records() {
        $startDate = $this->input->get('start_date');
        $endDate = $this->input->get('end_date');
        $access = $this->input->get('access');
    
        // Convert dates to UNIX timestamps
        $startTimestamp = strtotime($startDate . ' 00:00:00');
        $endTimestamp = strtotime($endDate . ' 23:59:59');
    
        // Fetch records based on the access type and date range
        $data = $this->Model_server->getRecordByAccessTypeAndDateRange($access, $startTimestamp, $endTimestamp);
    
        // print_r($data);
    
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=dry_run_report_' . date('Y-m-d') . '.xls');
    
        echo "<table border='1'>";
        echo "<tr style='background-color: #D3D3D3;'>";
        echo "<th>Date</th>";
        echo "<th>Gate Entry</th>";
        echo "<th>Gate Exit</th>";
        echo "<th>Access Type</th>";
        echo "<th>Code</th>";
        echo "<th>Vehicle</th>";
        echo "<th>Entry Time</th>";
        echo "<th>Out Time</th>";
        echo "</tr>";
    
        if (!empty($data)) {
            foreach ($data as $row) {
                $vehicleID = $row['vechile_cat_id'];
                $vehicle = "";
                if ($vehicleID == "1") {
                    $vehicle = "Motorcycle";
                } elseif ($vehicleID == "2") {
                    $vehicle = "Car";
                } elseif ($vehicleID == "3") {
                    $vehicle = "BUS/Truck";
                } else {
                    $vehicle = "Unknown";
                }
    
                echo "<tr>";
                echo "<td>{$row['date']}</td>";
                echo "<td>{$row['GateId']}</td>";
                echo "<td>{$row['GateEx']}</td>";
                echo "<td>{$row['AccessType']}</td>";
                echo "<td>{$row['parking_code']}</td>";
                echo "<td>{$vehicle}</td>";
                echo "<td>{$row['in_time']}</td>";
                echo "<td>{$row['out_time']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No records found for the selected range.</td></tr>";
        }
    
        echo "</table>";
        exit;
    }
    






}

