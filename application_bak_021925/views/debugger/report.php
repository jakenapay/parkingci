<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>System Dry Run</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");

        body {
            font-family: "Roboto", sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            overflow: hidden;
            /* Prevent scrolling on the body */
            scroll-behavior: smooth;
        }

        .navbar {
            background: linear-gradient(135deg, #d04e8a, #f07f59);
            overflow: hidden;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 15px 0;
            display: flex;
            justify-content: center;
        }

        .navbar a {
            color: #fff;
            text-align: center;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: background-color 0.3s, transform 0.3s;
            border-radius: 8px;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .container {
            margin-top: 75px;
            max-width: 1920px;
            height: calc(100vh - 75px);
            box-sizing: border-box;
            overflow: hidden;
            background: linear-gradient(135deg, #2b2d42, #8d99ae);
        }

        h1 {
            text-align: center;
            font-size: 3.2em;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #f5f5f5;
            animation: fadeIn 2s ease-in-out;
        }

        .filter-container,
        .button-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .filter-container input,
        .button-container button {
            padding: 12px;
            border-radius: 8px;
            border: none;
            margin: 0 10px;
            font-size: 1em;
            outline: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .filter-container input {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .filter-container button,
        .button-container button {
            background-color: #59b9f0;
            color: #fff;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .table-container {
            border-radius: 12px;
            padding: 20px;
            margin: 25px;
            height: 430px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            background-color: rgba(0, 0, 0, 0.4);
            overflow: hidden;
            position: relative;
        }

        .table-header{
            width: 100%;
            text-align: end;
            padding: 0 0 15px 0;
        }

        
        .btn-export{
            background: #1679AB;
            text-decoration: none;
            padding: 0.500rem;
            border-radius: 5px;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
        }

        thead {
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tbody {
            display: block;
            height: 380px;
            overflow-y: scroll;
            width: 100%;
            margin-right: -16px; /* Hide the scrollbar by shifting content */
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        tr {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.454rem;
            text-align: center;
            /* border: 1px solid #ffffff; */
            /* text-align: left; */
        }

        tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        tr:last-child {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        tbody::-webkit-scrollbar {
            width: 0; /* Hide scrollbar in WebKit browsers */
            background: transparent; /* Optional: Hide scrollbar background */
        }

        tbody::-webkit-scrollbar-thumb {
            background-color: #283850;
            border-radius: 10px;
        }

        tbody::-webkit-scrollbar-thumb:hover {
            background-color: #283850;
        }

        tbody {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }

        /* CSS styles for table cell background colors */
        .motorcycle-cell {
            background-color: #1A4870; /* Yellow for Motorcycles */
            width: 100px;
        }

        .car-cell {
            background-color: #2F3645; /* Green for Cars */
        }

        .bus-truck-cell {
            background-color: #1679AB; /* Blue for Bus/Truck */
        }

        .form-dropdown{
            background: #ffffff;
            border-radius: 5px;
            padding: 0.500rem;
            outline: none;
            width: 200px;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="<?= base_url('servercontroller')?>">Home</a>
        <a href="<?= base_url('servercontroller/information')?>">Gate Counter</a>
        <a href="<?= base_url('servercontroller/searchRecord')?>">Search Entry</a>
        <a href="<?= base_url('servercontroller/records')?>">Search Entry</a>
    </nav>

    <div class="container">
        <h1>Dry Run Report</h1>

        <div class="table-container">
            <div class="table-header">
                <form action="<?= base_url('ServerController/exportReport');?>" method="get">
                    <select name="accesstype" id="accessType" class="form-dropdown">
                        <option value="All">All</option>
                        <option value="Plate">Plate</option>
                        <option value="QR">QR Ticket</option>
                        <option value="RFtag">Rftag</option>
                    </select>

                    <button class="btn-export">Export Data</button>
                </form>
            </div>
            <table id="report-table">
            <thead>
    <tr>
        <th>Date</th>
        <th>Plate</th>
        <th>QR</th>
        <th>RFTAG</th>
        <th>Moto</th>
        <th>Car</th>
        <th>B/T</th>
        <th>G1-En</th>
        <th>G2-En</th>
        <th>G3-En</th>
        <th>G4-En</th>
        <th>G1-Ex</th>
        <th>G2-Ex</th>
        <th>G3-Ex</th>
        <th>G4-Ex</th>
        <th>Entry</th>
        <th>Exit</th>
    </tr>
</thead>
<tbody>
    <?php if (!empty($reportData)): ?>
        <?php foreach ($reportData as $row): ?>
            <tr>
                <td><?= $row['date']; ?></td>
                <td><?= $row['plate_number_count']; ?></td>
                <td><?= $row['qr_count']; ?></td>
                <td><?= $row['rftag_count']; ?></td>
                <td class="motorcycle-cell"><?= $row['motorcycle_count']; ?></td>
                <td class="car-cell"><?= $row['car_count']; ?></td>
                <td class="bus-truck-cell"><?= $row['bus_truck_count']; ?></td>
                <td><?= $row['G1_count']; ?></td>
                <td><?= $row['G2_count']; ?></td>
                <td><?= $row['G3_count']; ?></td>
                <td><?= $row['G4_count']; ?></td>
                <td><?= $row['G1Ex_count']; ?></td>
                <td><?= $row['G2Ex_count']; ?></td>
                <td><?= $row['G3Ex_count']; ?></td>
                <td><?= $row['G4Ex_count']; ?></td>
                <td><?= $row['G1_count'] + $row['G2_count'] + $row['G3_count'] + $row['G4_count']; ?></td>
                <td><?= $row['G1Ex_count'] + $row['G2Ex_count'] + $row['G3Ex_count'] + $row['G4Ex_count']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="12">No data available for the selected dates.</td>
        </tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchReportData();
        });

        function fetchReportData() {
            fetch('ServerController/getReportPerDay')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#report-table tbody');
                    tbody.innerHTML = ''; // Clear existing rows

                    data.forEach(row => {
                        const tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td>${row.date}</td>
                            <td>${row.gate_in}</td>  <!-- Populate Entry (GateId) -->
                            <td>${row.gate_out}</td> <!-- Populate Exit (GateEx) -->
                            <td>${row.plate_number_count}</td>
                            <td>${row.qr_count}</td>
                            <td>${row.rftag_count}</td>
                            <td>${row.motorcycle_count}</td>
                            <td>${row.car_count}</td>
                            <td>${row.bus_truck_count}</td>
                            <td>${row.total_count}</td>
                        `;

                        tbody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error fetching report data:', error));
        }
    </script>
</body>

</html>