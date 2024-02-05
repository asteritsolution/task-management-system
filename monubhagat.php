<?php
// Set initial WHERE clause based on login type
$where = match ($_SESSION['login_type']) {
    2 => " where manager_id = '{$_SESSION['login_id']}' ",
    3 => " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ",
    default => "",
};

$where2 = match ($_SESSION['login_type']) {
    2 => " where p.manager_id = '{$_SESSION['login_id']}' ",
    3 => " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ",
    default => "",
};

?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <b>Project Progress</b>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <colgroup>
                            <col width="5%">
                            <col width="30%">
                            <col width="35%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <th>Sr.No</th>
                            <th>Project</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $stat = ["Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done"];
                            
                            // Fetch projects using the WHERE clause
                            $qry = $conn->query("SELECT * FROM project_list $where order by name asc, manager_id asc");
                            
                            while ($row = $qry->fetch_assoc()) :
                                // Calculate project progress
                                $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['manager_id']}")->num_rows;
                                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['manager_id']} and status = 3")->num_rows;
                                $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                                $prog = $prog > 0 ? number_format($prog, 2) : $prog;

                                // Update project status
                                if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])) :
                                    if ($conn->query("SELECT * FROM user_productivity where project_id = {$row['manager_id']}")->num_rows > 0  || $cprog > 0)
                                        $row['status'] = 2;
                                    else
                                        $row['status'] = 1;
                                elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])) :
                                    $row['status'] = 4;
                                endif;
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <a><?= ucwords($row['name']) ?></a>
                                        <br>
                                        <small>Due: <?= date("Y-m-d", strtotime($row['end_date'])) ?></small>
                                    </td>
                                    <td class="project_progress">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?= $prog ?>%"></div>
                                        </div>
                                        <small><?= $prog ?>% Complete</small>
                                    </td>
                                    <td class="project-state">
                                        <span class="badge <?= ($row['status'] >= 0 && $row['status'] < count($stat)) ? "badge-".strtolower($stat[$row['status']]) : "badge-secondary" ?>"><?= $stat[$row['status']] ?></span>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?= $row['id'] ?>">
                                            <i class="fas fa-folder"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
