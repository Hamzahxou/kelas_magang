<header class="mb-3">
    <div class="row">
        <div class="card">
            <div class="card-body py-4 px-4 d-flex justify-content-between align-items-between ">
                <a href="#" class="burger-btn d-block d-md-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
                <span class="d-none d-md-block"></span>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600"><?= $user['username'] ?></h6>
                                <p class="mb-0 text-sm text-gray-600"><?= $user['role'] ?></p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar">
                                    <?php
                                    if ($user['role'] != 'admin') {
                                        if ($detail_user_avatar['avatar'] != null) {
                                    ?>
                                            <img src="../assets/static/images/faces/<?= $detail_user_avatar['avatar'] ?>" alt="Profile">
                                        <?php
                                        } else {
                                        ?>
                                            <img src="../assets/static/images/faces/1.jpg" alt="Profile">
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Hello, <?= explode(' ', $user['username'])[0] ?></h6>
                        </li>
                        <?php if ($user['role'] != 'admin') { ?>
                            <li><a class="dropdown-item" href="<?= $url . '/' . $user['role'] . "/profile.php" ?>"><i class="icon-mid bi bi-person me-2"></i> profil saya</a></li>
                        <?php } ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="post">
                                <button type="submit" name="logout" class="dropdown-item ">logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</header>