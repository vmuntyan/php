<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tree Nodes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid main-tree">
        <div id="tree-container">
            <button id="create-root" class="btn btn-primary" style="display: none;">Create Root</button>
        </div>
    </div>

    <div id="confirmation-popup" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p id="popup-message"></p>
                    <p id="popup-timer" class="float-left">Time Left: 20s</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirm-delete">Yes</button>
                    <button type="button" class="btn btn-secondary" id="cancel-delete" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
