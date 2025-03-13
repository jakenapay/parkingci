
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Complimentary management 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>     
    </ol>
  </section>

    <!-- Small boxes (Stat box) -->
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('error')) : ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>
        

        <div class="box">
            <div class="box-header">                
                <div class="col-md-3 col-xs-3">        
                    <!-- <button class="btn btn-success" data-toggle="modal" data-target="#addEventModal">
                        <i class="fa fa-plus"></i> Create Event
                    </button>                 -->
                    <a class="btn btn-success" href="<?= base_url('complimentary/create');?>"><i class="fa fa-plus"></i> Create Ticket</a>
                </div>
                <div class="col-md-9 col-xs-9 text-right">
                    <form action="<?= base_url('Complimentary/getEvent');?>" method="GET" class="form-inline">
                        <div class="form-group mr-2">
                            <label class="sr-only" for="inputEventFilter">Event Name</label>
                            <input type="text" class="form-control rounded-0" id="inputEventFilter" style="width: 300px;" name="event_title" placeholder="Enter event name here...">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Print QR Codes</button>
                    </form>
                </div>            
            </div>
          <!-- /.box-header -->
        </div>

        <div class="box">
            <div class="box-header">
                <h1 class="box-title">QR Code Lists</h1>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="eventTable" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>QR Code</th>
                            <th>Event Name</th>
                            <th>Starting Date</th>
                            <th>Expiration Date</th>
                            <th>Is Used</th>
                            <th>Is Printed</th>

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

    </section>

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
