<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage e-Journal Report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content-center">
        <div class="custom-card">
            <div class="card-header">
                <h3 class="card-title">e-Journal Report Form</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url("touchpoint/ejournalGenerate"); ?>" method="POST"
                    id="generateReportForm">
                    <div class="form-group">
                        <label for="start-date">Start Date</label>
                        <input type="date" class="form-control" id="start-date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date</label>
                        <input type="date" class="form-control" id="end-date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="cashier">Cashier</label>
                        <select class="form-control" id="cashier" name="cashier" required>
                            <option selected disabled>Select Cashier</option>
                            <?php foreach ($cashiers as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['username']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="terminal">Terminal</label>
                        <select class="form-control" id="terminal" name="terminal" required>
                            <option selected disabled>Select Terminal</option>
                            <?php foreach ($terminals as $t): ?>
                                <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <a type="" id="previewReport" class="btn btn-secondary w-100 mt-3">Preview</a> -->
                    <button type="submit" id="confirmDownload" class="btn btn-primary">Download Report</button>
                </form>

                <!-- Preview Modal -->
                <div class="modal fade" id="previewModal" tabindex="-1" role="dialog"
                    aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-center">
                                <h5 class="modal-title" id="previewModalLabel">Preview e-journal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span> 
                                </button>
                            </div>
                            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                <pre id="previewContent"></pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('#previewReport').on('click', function () {
            const formData = $('#generateReportForm').serialize();  // Get form data

            // Send AJAX request for preview data
            $.ajax({
                url: '<?php echo base_url("touchpoint/ejournalPreview"); ?>',
                type: 'POST',
                data: formData,
                success: function (response) {
                    try {
                        const data = JSON.parse(response);

                        if (data.status === 'success' && data.previewData.length > 0) {
                            const padLength = 40; // Adjust padding length as needed
                            console.log("Preview Data:", data.previewData);
                            // Utility Functions
                            const formatDate = (date) => (date ? new Date(date).toLocaleString() : "");
                            const formatString = (value) => (value ? value.toString() : "");
                            const centerAlign = (value, totalLength) => {
                                if (!value) value = ""; // Default to an empty string if value is null or undefined
                                value = value.toString(); // Ensure value is treated as a string

                                // If the value length exceeds totalLength, return the value as-is
                                if (value.length >= totalLength) return value;

                                const padLeft = Math.floor((totalLength - value.length) / 2);
                                const padRight = totalLength - value.length - padLeft;

                                return ' '.repeat(padLeft) + value + ' '.repeat(padRight);
                            };

                            const generatePreviewText = (item) => {
                                return `
                    ${centerAlign("PICC", padLength)}
                    ${centerAlign(formatString(item.company_name), padLength)}
            ${centerAlign(formatString(item.company_address), padLength)}
                    ${centerAlign(`VAT REG TIN: ${formatString(item.tin)}`, padLength)}
                    ${centerAlign(`MIN: ${formatString(item.MIN)}`, padLength)}
                    ${centerAlign("SN: M8N0CV16T94434H", padLength)}
            ${centerAlign(formatString(item.telephone), padLength)}

                    ${centerAlign("TRAINING MODE", padLength)}

                    ${centerAlign(`Date and Time: ${formatDate(item.date_time)}`, padLength)}
                    ${centerAlign(`S/I: 00-${formatString(item.ornumber)}`, padLength)}
                    ${centerAlign(`Plate: ${formatString(item.parking_code)}`, padLength)}
                    ${centerAlign(`Vehicle: ${formatString(item.vehicle)}`, padLength)}

                    ${centerAlign("Sales Invoice", padLength)}


            Cashier: ${formatString(item.cashier_name).padEnd(padLength)}
            Terminal: ${formatString(item.terminal_name).padEnd(padLength)}
            -------------------------------------------------------
            Gate In: ${formatDate(item.in_time).padEnd(padLength)}
            Billing Time: ${formatDate(item.billing_time).padEnd(padLength)}
            Parking Time: ${formatString(item.total_time).padEnd(padLength)}
            Total Sales: ${formatString(item.earned_amount).padEnd(padLength)}
            vat(12%): ${formatString(item.vat).padEnd(padLength)}
            Total Amount Due: ${formatString(item.total_amount_due).padEnd(padLength)}
            -------------------------------------------------------
            Cash Received: ${formatString(item.cash_received).padEnd(padLength)}
            Cash Change: ${formatString(item.change).padEnd(padLength)}
            -------------------------------------------------------
            Vatable Sales: ${formatString(item.vatable_sales).padEnd(padLength)}
            Non-Vat Sales: ${formatString(item.non_vat).padEnd(padLength)}
            Vat-Exempt: ${formatString(item.vat_exempt).padEnd(padLength)}
            Zero-Rated Sales: ${formatString(item.zero_rated).padEnd(padLength)}
            Discount: ${formatString(item.discount).padEnd(padLength)}
            Payment Mode: ${formatString(item.paymode).padEnd(padLength)}

            BIR PTU NO: ${formatString(item.BIR_SN).padEnd(padLength)}
            PTU ISSUED DATE: ${formatString(item.issued_date).padEnd(padLength)}
            THIS SERVES AS YOUR SALES INVOICE

            =======================================================
        `;
                            };

                            let previewText = data.previewData.map(generatePreviewText).join("\n");

                            // Update preview modal content
                            $('#previewContent').html(previewText);
                            $('#previewModal').modal('show');
                        } else {
                            $('#previewContent').html('No preview data available.');
                            $('#previewModal').modal('show');
                        }

                    } catch (error) {
                        console.error('Error parsing response', error);
                        $('#previewContent').html('An error occurred while processing the data.');
                        $('#previewModal').modal('show');
                    }
                },
                error: function () {
                    $('#previewContent').html('Unable to fetch preview. Please try again later.');
                    $('#previewModal').modal('show');
                }
            });
        });
    });
</script>

<style>
    .content-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 200px);
    }

    .custom-card {
        width: 100%;
        max-width: 500px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        background-color: #fff;
    }

    .custom-card .card-header {
        background-color: #6e8efb;
        padding: 10px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-align: center;
    }

    .custom-card .card-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .form-control {
        border-radius: 5px;
        box-shadow: none;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(110, 142, 251, 0.5);
        border-color: #6e8efb;
    }

    .btn-primary {
        background-color: #6e8efb;
        border: none;
        border-radius: 5px;
    }
</style>
