<?php
if (isset($_SESSION['flash_alert'])) {
    $type = $_SESSION['flash_alert']['type'];
    $pesan = $_SESSION['flash_alert']['pesan'];
    echo '
    <div class="row
        <div class="col">
             <div class="alert alert-light-' . $type . ' alert-dismissible fade show" role="alert">
                ' . $pesan . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>';
}

unset($_SESSION['flash_alert']);
