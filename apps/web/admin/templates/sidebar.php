<aside class="sidebar">
    
            <div class="logo"><i class="bxf bx-circuit-board" ></i> TECHNO ZONE</div>
            <nav class="menu">
                <a href="dashboard.php" class="<?= $page == 'dashboard' ? 'active' : '' ?>"><i class="bx bx-dashboard"></i> Dashboard</a>
                <a href="produkpage.php" class="<?= $page == 'produkPage' ? 'active' : '' ?>"><i class='bx bx-shopping-bag'></i> Produk</a>
                <a href="kategoripage.php" class="<?= $page == 'kategoriPage' ? 'active' : '' ?>"><i class="bx bx-horizontal-align-left"></i> Kategori</a>
                <a href="pesananPage.php" class="<?= $page == 'pesananPage' ? 'active' : '' ?>"><i class='bx bx-cart'></i>Pesanan</a>
                <a href="usersPage.php" class="<?= $page == 'usersPage' ? 'active' : '' ?>"><i class='bx bx-user'></i> Users</a>
            </nav>

            <a href="../logout.php" class="btn-logout">
                <i class="bx bx-arrow-out-left-square-half"></i> Logout
            </a>
        </aside>

        <main class="main-content">
