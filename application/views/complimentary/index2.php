<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PICC Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="<?= base_url();?>assets/css/custom-style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <ul class="sidebar">
        <!-- Your sidebar content goes here -->
    </ul>

    <div class="content">
        <h2>Event Management</h2>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                <button class="btn btn-success rounded-0 mb-3" data-toggle="modal" data-target="#addEventModal"><i class="fa-solid fa-plus"></i> Create Event</button>

                <div class="col-8">
                    <form action="<?= base_url('Complimentary/getEventList');?>" method="POST">
                        <div class="form-row align-items-center">
                            <div class="col-sm-3 my-1">
                                <label class="sr-only" for="inputEventFilter">Name</label>
                                <input type="text" class="form-control rounded-0" id="inputEventFilter" name="event_title" placeholder="Enter event name here...">
                            </div>
                            <div class="col-sm-3 my-1">
                                <button type="submit" class="btn btn-dark"><i class="fa-solid fa-print"></i> Filter Event</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="card-body">
                    <table id="eventTable" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Starting Date</th>
                            <th>Expiration Date</th>
                            <th>QR Image</th>
                            <th>Is Used</th>
                            <th>Is Printed</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($complimentary_data as $row): ?>
                                <tr>
                                    <td><?= $row->id ?></td>
                                    <td><?= $row->qrcode ?></td>
                                    <td><?= $row->event ?></td>
                                    <td><?= $row->start_date ?></td>
                                    <td><?= $row->end_date ?></td>
                                    <td><?= ($row->is_used == 1) ? 'Used' : 'Not Used' ?></td>
                                    <td><?= ($row->is_printed == 1) ? 'Printed' : 'Not Printed' ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm"><i class="fa-solid fa-pen-to-square"></i></button> | <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Event Modal -->
    <div class="modal rounded-0 fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog rounded-0" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form for adding events will go here -->
                    <form id="addEventForm" method="POST" action="<?= base_url('Complimentary/create')?>">
                        <div class="form-group">
                            <label for="inputEventTitle">Event Title</label>
                            <input type="text" class="form-control rounded-0" id="inputEventTitle" name="event_title" required>
                        </div>

                        <div class="form-group">
                            <label for="inputDateStart">Start Date</label>
                            <input type="date" class="form-control rounded-0" id="inputDateStart" name="start_date" required>
                        </div>

                        <div class="form-group">
                            <label for="inputDateEnd">Expiration Date</label>
                            <input type="date" class="form-control rounded-0" id="inputDateEnd" name="end_date" required>
                        </div>

                        <div class="form-group">
                            <label for="inputEventTitle">Quantity</label>
                            <input type="number" class="form-control rounded-0" id="inputQuantity" name="quantity" placeholder="0">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success rounded-0" id="saveEventBtn">Create Complimentray QR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Your custom script for DataTable initialization and QR code generation goes here -->
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#eventTable').DataTable();
        });
    </script>
</body>
</html>
