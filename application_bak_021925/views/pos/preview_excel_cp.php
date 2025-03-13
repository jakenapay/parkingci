<style>
    .excel-container {
        width: 100%;
        height: calc(100vh - 175px); /* This ensures the container fits within the viewport */
        background: #ffffff;
        display: flex;
        flex-direction: column;
        overflow: hidden; /* Prevents accidental overflow on the parent */
    }

    .control-header {
        padding: 10px;
        background-color: #f4f4f4;
        border-bottom: 1px solid #ccc;
        text-align: right;
    }
    .table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        table-layout: fixed; /* Ensure consistent column widths */
    }

    .table thead {
        position: sticky;
        top: 0;
        background-color: #ffffff; /* Match the background color */
        z-index: 1; /* Ensure the thead stays above the tbody */
    }

    .table th {
        padding: 8px;
        border: 1px solid #ccc;
        text-align: left;
        border: 1px solid #272727;
        background: #f4f4f4; /* Optional: Different background for header */
    }

    th, td{
        /* width: 150px; */
        text-align: center;
        border: 1px solid #272727;
    }

    .table td {
        padding: 8px;
        border: 1px solid #ccc;
    }
    .xsls-container {
        width: 100%;
        height: 100%; /* Fill the available space of the parent */
        overflow: auto; /* Enable scrolling */
        white-space: nowrap; /* Prevent table content wrapping */
        box-sizing: border-box; /* Properly calculate dimensions with borders/padding */
    }


    .tab-content {
        flex: 1;
        padding: 20px;
        background-color: #ffffff;
        display: none;
    }

    .tab-content.active {
        flex: 1;
        display: block; /* Ensure active tab takes space */
        padding: 0; /* Remove padding to maximize scrollable area */
        overflow: hidden; /* Prevent overflow from affecting scroll behavior */
    }

    .tabs {
        display: flex;
        border-top: 1px solid #ccc;
        background-color: #f4f4f4;
        justify-content: start;
    }

    .tab {
        padding: 10px 20px;
        cursor: pointer;
        border: 1px solid transparent;
        border-top: none;
        margin-right: 5px;
    }

    .tab.active {
        background-color: #ffffff;
        border-color: #ccc;
        border-top: 1px solid #ffffff;
    }
</style>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage billing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <div class="excel-container">
            <div class="control-header">
                <button class="btn btn-success"> <i class="fa fa-download"></i> Export</button>
            </div>
            <div class="tab-content active">
                <div class="xsls-container">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th><i class="fa fa-arrow"></i></th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>F</th>
                                <th>G</th>
                                <th>H</th>
                                <th>I</th>
                                <th>J</th>
                                <th>K</th>
                                <th>L</th>
                                <th>M</th>
                                <th>N</th>
                                <th>O</th>
                                <th>P</th>
                                <th>Q</th>
                                <th>R</th>
                                <th>S</th>
                                <th>T</th>
                                <th>U</th>
                                <th>V</th>
                                <th>W</th>
                                <th>X</th>
                                <th>Y</th>
                                <th>Z</th>
                                <th>AA</th>
                                <th>AB</th>
                                <th>AC</th>
                                <th>AD</th>
                                <th>AE</th>
                                <th>AF</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="32" style="text-align: center;">Philippine International Convention Center</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="32" style="text-align: center;">PICC Complex, 1307 Pasay City, Metro Manila, Philippines</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="32" style="text-align: center;">001-114-766-00000</td>
                            </tr>   

                            <tr>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Touchpoint v1.0</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td>6</td>
                                <td>SN8CC58C01A989</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td>7</td>
                                <td>234290423</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td>8</td>
                                <td>TRM001</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    2024-11-28 22:43:09
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <td>10</td>
                            <td>10</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-content">
                <h3>Tab 2 Content</h3>
                <p>This is the content for Tab 2.</p>
            </div>
            <div class="tab-content">
                <h3>Tab 3 Content</h3>
                <p>This is the content for Tab 3.</p>
            </div>
            <div class="tab-content">
                <h3>Tab 4 Content</h3>
                <p>This is the content for Tab 4.</p>
            </div>
            <div class="tab-content">
                <h3>Tab 5 Content</h3>
                <p>This is the content for Tab 5.</p>
            </div>
            <div class="tabs">
                <div class="tab active" onclick="showTab(0)">E1</div>
                <div class="tab" onclick="showTab(1)">E2</div>
                <div class="tab" onclick="showTab(2)">E3</div>
                <div class="tab" onclick="showTab(3)">E4</div>
                <div class="tab" onclick="showTab(4)">E5</div>
            </div>
        </div>
    </div>
</section>

<script>
    function showTab(index) {
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');
        tabs.forEach((tab, i) => {
            tab.classList.toggle('active', i === index);
        });
        contents.forEach((content, i) => {
            content.classList.toggle('active', i === index);
        });
    }
</script>
