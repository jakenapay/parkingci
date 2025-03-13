<section class="content-wrapper">
    <section class="content-header">
        <h1>Parking
            <small>Manage billing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Receipt</h3>
                    </div>
                    <div class="box-body">
                        <!-- Receipt Content -->
                        <div class="receipt-wrapper">
                            <div class="receipt-header">
                                <h3 class="receipt-title">Parking Payment Receipt</h3>
                                <p><strong>Supplier Name:</strong> ABC Sales Machines Inc.</p>
                                <p><strong>Address:</strong> 123 Business St., Metro Manila</p>
                                <p><strong>TIN:</strong> 123-456-789-000</p>
                                <p><strong>Accreditation No.:</strong> 2024-00123</p>
                                <p><strong>PTU Number:</strong> PTU-2024-5678</p>
                                <p><strong>Date Issued:</strong> <?php echo date("m-d-Y H:i:s A"); ?></p>
                            </div>

                            <!-- Receipt Details -->
                            <div class="receipt-details">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Cashier</th>
                                        <td><?php echo $receipt['cashierName']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Terminal</th>
                                        <td><?php echo $receipt['terminal']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date and Time</th>
                                        <td><?php echo $receipt['dateAndTime']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>S/I</th>
                                        <td><?php echo $receipt['S/I']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Access Type</th>
                                        <td><?php echo $receipt['accessType']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Parking Code</th>
                                        <td><?php echo $receipt['parkingCode']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Category</th>
                                        <td><?php echo $receipt['vehicleCategory']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Entry Time</th>
                                        <td><?php echo $receipt['entryTime']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Time</th>
                                        <td><?php echo $receipt['paymentTime']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Parking Stay</th>
                                        <td><?php echo $receipt['parkingStay']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Discount Type</th>
                                        <td><?php echo $receipt['discountType']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Discount Amount</th>
                                        <td><?php echo number_format($receipt['discountAmount'], 2); ?> PHP</td>
                                    </tr>
                                    <tr>
                                        <th>Vatable Sale</th>
                                        <td><?php echo number_format($receipt['vatableSale'], 2); ?> PHP</td>
                                    </tr>
                                    <tr>
                                        <th>Non-VAT Sale</th>
                                        <td><?php echo number_format($receipt['nonVatSale'], 2); ?> PHP</td>
                                    </tr>
                                    <tr>
                                        <th>Zero-Rated Sale</th>
                                        <td><?php echo number_format($receipt['zeroRatedSale'], 2); ?> PHP</td>
                                    </tr>
                                    <tr>
                                        <th>Total Sales</th>
                                        <td><?php echo number_format($receipt['totalSales'], 2); ?> PHP</td>
                                    </tr>
                                    <tr>
                                        <th>Total VAT</th>
                                        <td><?php echo number_format($receipt['totalVAT'], 2); ?> PHP</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount Due</th>
                                        <td><?php echo number_format($receipt['totalAmountDue'], 2); ?> PHP</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Footer -->
                            <div class="receipt-footer">
                                <p>Thank you for using our parking services!</p>
                                <p>Have a great day!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
