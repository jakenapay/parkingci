<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="<?= base_url('assets/')?>dist/js/jquery-new.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f7fa;
        }
        .container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 90%;
            max-width: 1200px;
        }
        .row-title {
            font-size: 1.6em;
            color: #333;
            margin-bottom: 10px;
        }
        .row {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 250px; /* Adjust width as needed */
            box-sizing: border-box;
        }
        .card-title {
            font-size: 1.2em;
            color: #fff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
        }
        .card-title.entry {
            background-color: #007bff;
        }
        .card-title.exit {
            background-color: #dc3545;
        }
        .card-content {
            font-size: 1.4em;
            color: #333;
        }
        
        /* Media Queries */
        @media (max-width: 768px) {
            .card {
                width: 100%;
                max-width: 300px; /* Ensure cards don't become too wide on small screens */
            }
            .cards {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .row-title {
                font-size: 1.4em;
            }
            .card-title {
                width: 40px;
                height: 40px;
                font-size: 1em;
            }
            .card-content {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="row-title">Gate Counts Entry</div>
            <div class="cards">
                <div class="card">
                    <div class="card-title entry">G1</div>
                    <div class="card-content" id="entry-g1">Loading...</div>
                </div>
                <div class="card">
                    <div class="card-title entry">G2</div>
                    <div class="card-content" id="entry-g2">Loading...</div>
                </div>
                <div class="card">
                    <div class="card-title entry">G3</div>
                    <div class="card-content" id="entry-g3">Loading...</div>
                </div>
                <div class="card">
                    <div class="card-title entry">G4</div>
                    <div class="card-content" id="entry-g4">Loading...</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row-title">Gate Counts Exit</div>
            <div class="cards">
                <div class="card">
                    <div class="card-title exit">G1</div>
                    <div class="card-content" id="exit-g1">Loading...</div>
                </div>
                <div class="card">
                    <div class="card-title exit">G2</div>
                    <div class="card-content" id="exit-g2">Loading...</div>
                </div>
                <div class="card">
                    <div class="card-title exit">G3</div>
                    <div class="card-content" id="exit-g3">Loading...</div>
                </div>
                <div class="card">
                    <div class="card-title exit">G4</div>
                    <div class="card-content" id="exit-g4">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetchCounts(url, type) {
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                cache: false, // Prevent caching
                success: function(data) {
                    data.forEach(item => {
                        const gate = item.GateId || item.GateEx;
                        const count = item.count;
                        $(`#${type}-${gate.toLowerCase()}`).text(count);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        function updateCounts() {
            fetchCounts('<?= base_url('ServerController/getCountsbyEntry') ?>', 'entry');
            fetchCounts('<?= base_url('ServerController/getCountsbyExit') ?>', 'exit');
        }

        $(document).ready(function() {
            updateCounts(); // Initial fetch
            setInterval(updateCounts, 500); // Update every 30 seconds
        });
    </script>
</body>
</html>
