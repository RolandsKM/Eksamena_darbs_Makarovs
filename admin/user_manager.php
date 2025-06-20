<?php
require_once '../functions/AdminController.php';

if (isset($_GET['chart']) && $_GET['chart'] === 'bannedActive' && isset($_GET['period'])) {
    $period = $_GET['period'];
    try {
        $bannedCount = getBannedUsersCountByPeriod($period);
        $activeCount = getUsersCountByPeriod($period); 
        echo json_encode(['success' => true, 'banned' => $bannedCount, 'active' => $activeCount]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

if (isset($_GET['chart']) && $_GET['chart'] === 'newUsers' && isset($_GET['period'])) {
    $period = $_GET['period'];
    try {
        $newUsersData = getNewUsersCountByPeriod($period);
        echo json_encode(['success' => true, 'data' => $newUsersData]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    header('Content-Type: application/json');
    if (isset($_GET['count']) && $_GET['count'] === 'banned' && ($_GET['table'] ?? '') === 'all') {
        $period = $_GET['period'] ?? 'all';
        $statusFilter = $_GET['status'] ?? 'all'; 
        try {
            $bannedCount = getBannedUsersCountByPeriod($period, $statusFilter);
            echo json_encode(['success' => true, 'bannedCount' => $bannedCount]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    $table = $_GET['table'] ?? '';
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 5;
    $offset = ($page - 1) * $perPage;
    $statusFilter = $_GET['status'] ?? 'all'; 
    $sortField = $_GET['sort'] ?? 'created_at'; 
    $sortOrder = $_GET['order'] ?? 'DESC'; 

    try {
        if ($table === 'todays') {
            $total = getTodaysUsersCount($statusFilter);
            $users = getPaginatedTodaysUsers($perPage, $offset, $statusFilter, $sortField, $sortOrder);
        } elseif ($table === 'all') {
            $period = $_GET['period'] ?? 'all';
            $total = getUsersCountByPeriodTotal($period, $statusFilter);
            $users = getPaginatedUsersByPeriod($perPage, $offset, $period, $statusFilter, $sortField, $sortOrder);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid table']);
            exit;
        }

        echo json_encode([
            'success' => true,
            'users' => $users,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage
        ]);
    } catch (PDOException $e) {
     
    }
    exit;
}

try {

    $todaysUsers = getPaginatedTodaysUsers(5, 0);
    $todaysUsersCount = getTodaysUsersCount();
    $todaysBannedCount = getTodaysBannedUsersCount();
    $filterPeriod = $_GET['filter'] ?? 'all';
    $allUsers = getPaginatedUsersByPeriod(5, 0, $filterPeriod);
    $allUsersCount = getUsersCountByPeriodTotal($filterPeriod);
    $allBannedCount = getBannedUsersCountByPeriod($filterPeriod);

} catch (PDOException $e) {
  
    $todaysUsers = [];
    $todaysUsersCount = 0;
    $todaysBannedCount = 0;
    $allUsers = [];
    $allUsersCount = 0;
    $allBannedCount = 0;
}

?>



<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VBC Admin Dashboard | Lietotāju Pārvalde</title>
    <link rel="stylesheet" href="admin.css" defer />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --danger-color: #e74a3b;
            --success-color: #1cc88a;
            --text-color: #5a5c69;
            --border-color: #e3e6f0;
        }
        

.drop-table a{
   color:#fff;
}

    </style>
</head>
<body>
<div class="admin-layout">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <?php include 'header.php'; ?>

        <div class="container-fluid py-4">
   
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Lietotāju Pārvalde</h1>
                <div class="d-none d-sm-inline-block">
                
                </div>
            </div>

     
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Šodien Reģistrēti</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="todays-users-count"><?= $todaysUsersCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Šodien Bloķēti</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="todays-banned-count"><?= $todaysBannedCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-slash fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Kopā Lietotāji</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-users"><?= $allUsersCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Bloķēti Lietotāji</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="banned-users"><?= $allBannedCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-ban fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-3">
                <select id="filter-period" class="form-select form-select-sm me-2 filter-control">
                    <option value="all" <?= $filterPeriod === 'all' ? 'selected' : '' ?>>Visi</option>
                    <option value="week" <?= $filterPeriod === 'week' ? 'selected' : '' ?>>Šonedēļ</option>
                    <option value="month" <?= $filterPeriod === 'month' ? 'selected' : '' ?>>Šomēnes</option>
                    <option value="year" <?= $filterPeriod === 'year' ? 'selected' : '' ?>>Šogad</option>
                </select>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom-0 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 fw-semibold text-muted">Lietotāju Statuss & Jauno Lietotāju Dinamika</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="chart-container">
                                        <canvas id="bannedActiveChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="chart-container">
                                        <canvas id="newUsersChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold ">Šodien Reģistrētie Lietotāji</h6>
                    <div class="dropdown drop-table drop-table no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in" 
                            aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Eksportēt uz CSV</a></li>
                            <li><a class="dropdown-item" href="#">Drukāt</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Lietotājvārds</th>
                                    <th>E-pasts</th>
                                    <th>Reģistrācijas Laiks</th>
                                    <th>Statuss</th> <!-- Added status column -->
                                    <th class="text-center">Darbības</th>
                                </tr>
                            </thead>
                            <tbody id="todays-users-body">
                                <?php if (count($todaysUsers) === 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Nav šodien reģistrētu lietotāju.</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($todaysUsers as $user): ?>
                                        <tr class="<?= $user['banned'] ? 'table-danger' : '' ?>">
                                            <td><?= htmlspecialchars($user['username']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td><?= date('H:i', strtotime($user['registration_date'])) ?></td>
                                            <td>
                                                <?php if ($user['banned']): ?>
                                                    <span class="badge bg-danger">Bloķēts</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Aktīvs</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="user-details.php?id=<?= $user['ID_user'] ?>" 
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Apskatīt
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container" id="todays-users-pagination"></div>
                </div>
            </div>

     
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Visi Lietotāji</h6>
                    <div class="d-flex">

                        <div class="dropdown drop-table drop-table no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in" 
                                aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Eksportēt uz CSV</a></li>
                                <li><a class="dropdown-item" href="#">Drukāt</a></li>
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Lietotājvārds</th>
                                    <th>E-pasts</th>
                                    <th>Reģistrācijas Datums</th>
                                    <th>Statuss</th>
                                    <th class="text-center">Darbības</th>
                                </tr>
                            </thead>
                            <tbody id="all-users-body">
                                <?php foreach ($allUsers as $user): ?>
                                    <tr class="<?= $user['banned'] ? 'table-danger' : '' ?>">
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                                        <td>
                                            <?php if ($user['banned']): ?>
                                                <span class="badge bg-danger">Bloķēts</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Aktīvs</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="user-details.php?id=<?= $user['ID_user'] ?>" 
                                               class="btn btn-sm btn-primary">
                                               <i class="fas fa-eye"></i> Apskatīt
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container" id="all-users-pagination"></div>
                </div>
            </div>

   



        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../functions/adminscript.js" defer></script>
</body>
</html>