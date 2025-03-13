<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Data</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTable CSS for Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .form-container {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
        }

        .form-container .form-group {
            margin-right: 15px;
            /* Adjust spacing as needed */
        }
    </style>
    </style>
</head>

<body>

    <!-- Header Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="<?= base_url('ServerController'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('ServerController/getReportPerDay'); ?>">Summary</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mt-4">
            <div class="card-body text-center">
                <div class="col-lg-12">
                    <form action="<?= base_url('ServerController/records') ?>" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <select name="access" class="form-select" required>
                                    <option value="">Select Access Type</option>
                                    <option value="Plate">Plate</option>
                                    <option value="QR">QR</option>
                                    <option value="RFtag">RFTag</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Export</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Main Content Area -->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Parking Records</h6>

            </div>
            <div class="card-body">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Access Type</th>
                            <th>Parking Code</th>
                            <th>Gate ID</th>
                            <th>Gate Exit</th>
                            <th>Vehicle Category ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportData as $row): ?>
                            <tr>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $row['in_time']); ?></td>
                                <td><?php echo $row['out_time'] ? date('Y-m-d H:i:s', $row['out_time']) : ''; ?></td>
                                <td><?php echo $row['AccessType']; ?></td>
                                <td><?php echo $row['parking_code']; ?></td>
                                <td><?php echo $row['GateId']; ?></td>
                                <td><?php echo $row['GateEx']; ?></td>
                                <td><?php echo $row['vechile_cat_id']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5.3 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTable JS for Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>

</html>