<section class="content-wrapper">
    <section class="content-header">
        <h1>Reports
            <small>Terminal History</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                Treasury: John Doe
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-history"></i> Terminal History</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="terminalHistoryTable" class="table table-bordered table-hover table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th><i class="fa fa-terminal"></i> Terminal ID</th>
                            <th><i class="fa fa-calendar"></i> Transaction Date</th>
                            <th><i class="fa fa-user"></i> Cashier</th>
                            <th><i class="fa fa-info-circle"></i> Status</th>
                            <th><i class="fa fa-money"></i> Total Amount</th>
                            <th><i class="fa fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Terminal 1</td>
                            <td>2024-10-01 09:00:00</td>
                            <td>Alice Smith</td>
                            <td><span class="label label-success">Completed</span></td>
                            <td>2,500.00 PHP</td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Terminal 2</td>
                            <td>2024-10-01 10:30:00</td>
                            <td>Bob Johnson</td>
                            <td><span class="label label-warning">Pending</span></td>
                            <td>1,750.00 PHP</td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Terminal 3</td>
                            <td>2024-10-01 11:15:00</td>
                            <td>Jane Doe</td>
                            <td><span class="label label-success">Completed</span></td>
                            <td>3,200.00 PHP</td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Terminal 4</td>
                            <td>2024-10-01 12:00:00</td>
                            <td>Chris Evans</td>
                            <td><span class="label label-danger">Failed</span></td>
                            <td>0.00 PHP</td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <!-- Pagination links go here -->
                </ul>
            </div>
        </div>
    </section>
</section>
