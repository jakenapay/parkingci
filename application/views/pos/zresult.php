<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage Z-Reading Result</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <!-- Check if $zreading is not empty -->
        <?php if (!empty($zreading)): ?>
            <h3>Z-Reading Data</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through the zreading array and display each key-value pair -->
                    <?php foreach ($zreading as $key => $value): ?>
                        <?php if (is_array($value)): ?>
                            <!-- If value is an array (e.g., 'discounts'), loop through it -->
                            <tr>
                                <td colspan="2"><strong><?php echo $key; ?></strong></td>
                            </tr>
                            <?php foreach ($value as $subKey => $subValue): ?>
                                <tr>
                                    <td><?php echo $subKey; ?></td>
                                    <td>
                                        <?php echo is_array($subValue) ? implode(', ', $subValue) : $subValue; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td><?php echo $value; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data available for the selected date.</p>
        <?php endif; ?>
    </div>
</section>
