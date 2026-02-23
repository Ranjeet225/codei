    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search transactions, users, etc...">
            </div>

            <div class="header-actions">
                <button class="icon-btn">
                    <i class="fa-regular fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <button class="icon-btn">
                    <i class="fa-regular fa-envelope"></i>
                    <span class="badge">5</span>
                </button>
                
                <div class="user-profile">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Admin Avatar" class="avatar">
                    <div class="user-info">
                        <div class="name">Alex Carter</div>
                        <div class="role">Super Admin</div>
                    </div>
                    <i class="fa-solid fa-chevron-down" style="color: var(--text-muted); font-size: 12px;"></i>
                </div>
            </div>
        </header>

        <!-- Dashboard Workspace -->
        <div class="dashboard">
            <h1 class="page-title">Overview Dashboard</h1>

            <!-- KPIs Overview -->
            <div class="overview-grid">
                <?php foreach($kpis as $kpi): ?>
                <div class="card">
                    <div class="card-header">
                        <span class="card-title"><?= $kpi['title'] ?></span>
                        <div class="card-icon <?= $kpi['color_class'] ?>">
                            <i class="fa-solid <?= $kpi['icon'] ?>"></i>
                        </div>
                    </div>
                    <div class="card-amount"><?= $kpi['amount'] ?></div>
                    <div class="card-trend <?= $kpi['trend'] ?>">
                        <i class="fa-solid <?= $kpi['trend_icon'] ?>"></i>
                        <span><?= $kpi['trend_text'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Complex Grid: Chart & Secondary Info -->
            <div class="main-grid">
                <!-- Analytics Chart -->
                <div class="chart-card">
                    <div class="section-header">
                        <h2 class="section-title">Revenue Flow</h2>
                        <select style="background: var(--bg-color); color: var(--text-main); border: 1px solid var(--border); padding: 4px 12px; border-radius: 6px;">
                            <option>This Year</option>
                            <option>Last Year</option>
                        </select>
                    </div>
                    <canvas id="revenueChart" height="120"></canvas>
                </div>

                <!-- Side Panel (Quick Transfer & Cards) -->
                <div>
                    <!-- Quick Transfer -->
                    <div class="transactions-card" style="margin-bottom: 24px;">
                        <h2 class="section-title">Quick Transfer</h2>
                        <div class="quick-transfer">
                            <div class="qt-users">
                                <div class="qt-user add-btn">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <?php foreach($quick_transfers as $qt_avatar): ?>
                                <div class="qt-user"><img src="<?= $qt_avatar ?>" alt="User"></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="qt-form">
                                <input type="text" class="qt-input" placeholder="Amount ($)">
                                <button class="qt-btn">Send</button>
                            </div>
                        </div>
                    </div>

                    <!-- Security Alert -->
                    <div class="card" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05)); border-color: rgba(239, 68, 68, 0.2);">
                        <div class="card-header">
                            <span class="card-title" style="color: var(--danger);"><i class="fa-solid fa-shield-halved"></i> Security Update</span>
                        </div>
                        <p style="font-size: 14px; color: var(--text-muted); line-height: 1.5; margin-bottom: 12px;">System detected 3 failed login attempts from IP 192.168.1.45 on the admin gateway.</p>
                        <button style="background: var(--danger); color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500;">Review Logs</button>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions List -->
            <div class="transactions-card" style="margin-top: 24px;">
                <div class="section-header">
                    <h2 class="section-title">Recent Transactions</h2>
                    <button class="btn-ghost">View All</button>
                </div>
                
                <table class="tx-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Date & Time</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transactions as $tx): ?>
                        <tr>
                            <td><?= $tx['id'] ?></td>
                            <td>
                                <div class="tx-user">
                                    <?php if ($tx['avatar']): ?>
                                        <img src="<?= $tx['avatar'] ?>" alt="" class="tx-avatar">
                                    <?php else: ?>
                                        <div class="tx-avatar" style="background: var(--primary); color: white;"><?= $tx['initials'] ?></div>
                                    <?php endif; ?>
                                    <span><?= $tx['name'] ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?= $tx['date'] ?></td>
                            <td style="font-weight: 600;"><?= $tx['amount'] ?></td>
                            <td><span class="tx-status <?= $tx['status_class'] ?>"><?= $tx['status'] ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
