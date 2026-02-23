    <main class="main-content">
        <div class="dashboard">

            <div class="section-header">
                <h1 class="page-title" style="margin-bottom: 0;">Add New Customer</h1>
                <a href="<?= base_url('customers/index') ?>" class="qt-btn" style="text-decoration: none; padding: 10px 24px; display: inline-block; background: var(--card-bg); border: 1px solid var(--border); color: var(--text-main);">Back to List</a>
            </div>

            <!-- Upload Error Alert -->
            <?php if(isset($upload_error)): ?>
                <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                    <strong>Upload Error:</strong><br>
                    <?= $upload_error; ?>
                </div>
            <?php endif; ?>

            <div class="transactions-card" style="margin-top: 24px; max-width: 800px;">
                
                <!-- --- FORM HELPER SHOWCASE --- -->
                <!-- form_open_multipart is required when uploading files. It automatically injects the hidden CSRF token! -->
                <?= form_open_multipart('customers/store') ?>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 14px;">Full Name *</label>
                        <!-- set_value() safely repopulates the input if validation fails! -->
                        <input type="text" name="name" value="<?= set_value('name'); ?>" class="qt-input" style="width: 100%;">
                        <!-- form_error() displays the specific error for this field if it failed validation -->
                        <?= form_error('name'); ?>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 14px;">Email Address *</label>
                        <input type="email" name="email" value="<?= set_value('email'); ?>" class="qt-input" style="width: 100%;">
                        <?= form_error('email'); ?>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 14px;">Phone Number</label>
                        <input type="text" name="phone" value="<?= set_value('phone'); ?>" class="qt-input" style="width: 100%;">
                        <?= form_error('phone'); ?>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 14px;">Account Status *</label>
                        <!-- set_select() re-selects the dropdown option if validation fails -->
                        <select name="status" class="qt-input" style="width: 100%;">
                            <option value="Active" <?= set_select('status', 'Active', TRUE); ?>>Active Account</option>
                            <option value="Inactive" <?= set_select('status', 'Inactive'); ?>>Inactive / Locked</option>
                        </select>
                        <?= form_error('status'); ?>
                    </div>
                </div>

                <div style="margin-bottom: 32px; border: 1px dashed var(--border); padding: 24px; border-radius: 8px; text-align: center; background: rgba(0,0,0,0.1);">
                    <label style="display: block; margin-bottom: 12px; color: var(--text-muted); font-size: 14px;"><i class="fa-solid fa-cloud-arrow-up" style="font-size: 24px; display: block; margin-bottom: 8px;"></i> Upload Customer Avatar</label>
                    <input type="file" name="avatar" style="color: var(--text-main);">
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 8px;">Max size 2MB (jpg, png, gif)</div>
                </div>

                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="qt-btn" style="padding: 12px 32px;"><i class="fa-solid fa-save"></i> Save Customer</button>
                </div>

                <?= form_close() ?>

            </div>
        </div>
    </main>
