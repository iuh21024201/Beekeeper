<head>
    <style>
        .main{
            display: flex;
        }
        .menu-container {
            margin-left: 20px;
        }
        .menu-item {
            margin-bottom: 20px;
            padding: 10px;
            text-align: center;
        }
        .sidebar {
            margin-left: 160px;
            width: 200px;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .sidebar div {
            margin-top: 10px; 
        }
        .sidebar a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        .sidebar a:hover {
            color: #ff4d4d;
        }
    </style>
</head>
<body>
    <h2>Thực đơn</h2>
    <div class="main">
        <div class="sidebar">
            <h3 style="color: #ff4d4d;">Danh mục</h3>
            <?php
                include_once("../../view/customer/vListLoaiMonAn.php");
            ?>
        </div>
        <div class="main-content">
            <!-- Search Form -->
            <form method="GET" action="index.php" style="margin-left: 500px; margin-bottom:10px;">
                <input type="hidden" name="action" value="thucdon" > 
                <input type="text" name="txtname" placeholder="Search...">
                <button type="submit" name="btnTimKiem" value="Tìm">Tìm</button>
            </form>
            <div class="menu-container">
                <?php
                    include_once("../../view/customer/vListSanPham.php");
                ?>
            </div>
        </div>
    </div>
</body>
</html>