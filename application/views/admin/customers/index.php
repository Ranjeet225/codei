    <main class="main-content">
        <!-- Dashboard Workspace -->
        <div class="dashboard">

            <!-- --- SESSION FLASHDATA ALERT SHOWCASE --- -->
            <?php if($this->session->flashdata('success')): ?>
                <div style="background-color: rgba(16, 185, 129, 0.1); border: 1px solid var(--success); color: var(--success); padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="section-header">
                <h1 class="page-title" style="margin-bottom: 0;">Customer Management</h1>
                <a href="<?= base_url('customers/create') ?>" class="qt-btn" style="text-decoration: none; padding: 10px 24px; display: inline-block;">+ Add Customer</a>
            </div>

            <div class="transactions-card" style="margin-top: 24px;">
                <div class="section-header">
                    <h2 class="section-title">All Customers</h2>
                    
                    <!-- Form helper mapping to GET requests for search -->
                    <?= form_open('customers/index', ['method' => 'get', 'style' => 'display: flex; gap: 8px;']) ?>
                        <input type="text" name="q" value="<?= isset($search) ? html_escape($search) : '' ?>" class="qt-input" placeholder="Search name or email..." style="width: 250px;">
                        <button type="submit" class="btn-ghost" style="background: var(--card-bg); border: 1px solid var(--border); padding: 8px 16px; border-radius: 8px; color: var(--text-main);">Search</button>
                        <?php if(!empty($search)): ?>
                            <a href="<?= base_url('customers/index') ?>" class="btn-ghost" style="padding: 8px; color: var(--danger);">Clear</a>
                        <?php endif; ?>
                    <?= form_close() ?>
                </div>
                
                <table class="tx-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Contact Strategy</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($customers)): ?>
                            <tr><td colspan="5" style="text-align: center; color: var(--text-muted);">No customers found.</td></tr>
                        <?php endif; ?>
                        
                        <?php foreach($customers as $customer): ?>
                        <tr>
                            <td>
                                <div class="tx-user">
                                    <?php if ($customer->avatar): ?>
                                        <img src="<?= $customer->avatar ?>" alt="" class="tx-avatar">
                                    <?php else: ?>
                                        <div class="tx-avatar" style="background: var(--primary); color: white;"><?= $customer->initials ?></div>
                                    <?php endif; ?>
                                    <div>
                                        <div style="font-weight: 500;"><?= $customer->name ?></div>
                                        <div style="font-size: 12px; color: var(--text-muted);">ID: <?= $customer->id ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="fa-regular fa-envelope" style="width: 16px; color: var(--text-muted);"></i> <?= $customer->email ?></div>
                                <?php if($customer->phone): ?>
                                    <div style="font-size: 12px; margin-top: 4px;"><i class="fa-solid fa-phone" style="width: 16px; color: var(--text-muted);"></i> <?= $customer->phone ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($customer->status == 'Active'): ?>
                                    <span class="tx-status status-completed">Active</span>
                                <?php else: ?>
                                    <span class="tx-status status-failed">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted"><?= date('M d, Y', strtotime($customer->created_at)) ?></td>
                            <td>
                                <a href="<?= base_url('customers/delete/'.$customer->id) ?>" class="btn-ghost" style="color: var(--danger);" onclick="return confirm('Are you sure you want to delete this customer?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- --- PAGINATION LINKS SHOWCASE --- -->
                <div style="margin-top: 24px; display: flex; justify-content: flex-end;">
                    <style>
                        .pagination { display: flex; list-style: none; gap: 8px; margin: 0; padding: 0; }
                        .page-item .page-link { display: block; padding: 8px 14px; background: var(--card-bg); border: 1px solid var(--border); border-radius: 6px; color: var(--text-main); text-decoration: none; transition: var(--transition); }
                        .page-item .page-link:hover { background: rgba(255, 255, 255, 0.05); }
                        .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }
                    </style>
                    <?= $pagination_links ?>
                </div>

            </div>
        </div>
    </main>
