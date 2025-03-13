<style>
    /* General Styles */
    .content-wrapper {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
        padding: 20px;
    }

    /* Menu Styles */
    .menu {
        background-color: #2c3e50;
        border-radius: 8px;
        padding: 15px;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .menu h3 {
        margin-top: 0;
        font-size: 20px;
        color: #ecf0f1;
        border-bottom: 1px solid #34495e;
        padding-bottom: 10px;
    }

    .menu ul {
        list-style: none;
        padding-left: 0;
        margin-top: 15px;
    }

    .menu ul li {
        margin-bottom: 10px;
    }

    .menu ul li a {
        color: #bdc3c7;
        font-size: 16px;
        padding: 10px;
        display: block;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .menu ul li a:hover {
        background-color: #34495e;
        color: #ecf0f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Report Viewer Styles */
    .analysis-wrapper {
        background-color: #ecf0f1;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-left: 15px;
    }

    .analysis-wrapper h3 {
        font-size: 18px;
        border-bottom: 1px solid #bdc3c7;
        padding-bottom: 10px;
        color: #34495e;
    }

    .report-viewer {
        width: 300px;
        height: 400px;
        padding: 15px;
        background-color: white;
        border-radius: 8px;
        border: 1px solid #bdc3c7;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        transition: box-shadow 0.3s;
    }

    .report-viewer:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Date Filter Form */
    .date-filter-form {
        margin-top: 20px;
    }

    .date-filter-form input {
        width: 130px;
        padding: 8px;
        margin-right: 10px;
        border: 1px solid #bdc3c7;
        border-radius: 4px;
    }

    .date-filter-form button {
        padding: 8px 12px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .date-filter-form button:hover {
        background-color: #2980b9;
    }

    /* Breadcrumb Styles */
    .breadcrumb {
        background-color: transparent;
        padding-left: 0;
        margin-bottom: 20px;
    }

    .breadcrumb li a {
        color: #2980b9;
    }

    .breadcrumb li a:hover {
        color: #3498db;
    }
</style>

<!-- jQuery (for dynamic functionality) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Analysis
            <small>Manage report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <div class="row">
            <!-- Menu Section -->
            <div class="col-md-3">
                <div class="menu">
                    <h3>Reports Menu</h3>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#" data-report="Z-Reading">Z-Reading</a></li>
                        <li><a href="#" data-report="X-Reading">X-Reading</a></li>
                        <li><a href="#" data-report="E-Journal">E-Journal</a></li>
                    </ul>
                </div>
            </div>

            <!-- Report Viewer Section -->
            <div class="col-md-9">
                <div class="analysis-wrapper">
                    <h3>Report Viewer</h3>
                    <div class="report-viewer">
                        <p>Select a report from the menu to view the content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Click event handler for the menu items
        $('.menu ul li a').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Get the report type from the data-report attribute
            var reportType = $(this).data('report');

            // Update the report viewer with the selected report and add a date filter form
            $('.report-viewer').html(`
                <h4>` + reportType + ` Report</h4>
                <p>Details for the ` + reportType + ` report will be displayed here.</p>

                <form class="date-filter-form">
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start-date" required>
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end-date" required>
                    <button type="submit">Filter</button>
                </form>
            `);

            // Handle the date filter form submission
            $('.date-filter-form').submit(function(event) {
                event.preventDefault(); // Prevent the form from reloading the page

                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();

                // For now, just update the viewer with a placeholder message
                // You can replace this part with an AJAX call to fetch filtered data
                $('.report-viewer').append(`
                    <div class="filter-result">
                        <p>Filtering ` + reportType + ` Report from ` + startDate + ` to ` + endDate + `.</p>
                    </div>
                `);
            });
        });
    });
</script>
