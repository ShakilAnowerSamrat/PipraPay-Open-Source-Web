<?php
    $plugin_slug = 'duitku';
    $plugin_info = pp_get_plugin_info($plugin_slug);
    $settings = pp_get_plugin_setting($plugin_slug);
?>

<form id="duitkuSettingsForm" method="post" action="">
    <!-- Page Header -->
    <div class="page-header">
      <div class="row align-items-end">
        <div class="col-sm mb-2 mb-sm-0">
          <h1 class="page-header-title">Edit Gateway</h1>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="d-grid gap-3 gap-lg-5">
          <!-- Card -->
          <div class="card">
            <div class="card-header">
              <h2 class="card-title h4">Gateway Information</h2>
            </div>

            <!-- Body -->
            <div class="card-body">
                <input type="hidden" name="action" value="plugin_update-submit">
                <input type="hidden" name="plugin_slug" value="<?php echo $plugin_slug?>">
                
                <div class="row mb-4">
                  <div class="col-sm-6">
                    <label for="name" class="col-sm-12 col-form-label form-label">Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($settings['name'] ?? $plugin_info['plugin_name']) ?>" readonly>
                    </div>
                    <div class="text-secondary mt-2">Gateway identifier name</div>
                  </div>
                  <div class="col-sm-6">
                    <label for="display_name" class="col-sm-12 col-form-label form-label">Display name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="display_name" id="display_name" value="<?= htmlspecialchars($settings['display_name'] ?? 'Duitku') ?>">
                    </div>
                    <div class="text-secondary mt-2">Display name on checkout page</div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-sm-6">
                    <label for="min_amount" class="col-sm-12 col-form-label form-label">Min amount</label>
                    <div class="input-group">
                        <span class="input-group-text">IDR</span>
                        <input type="text" class="form-control" name="min_amount" id="min_amount" value="<?= htmlspecialchars($settings['min_amount'] ?? '1000') ?>">
                    </div>
                    <div class="text-secondary mt-2">Minimum transaction amount</div>
                  </div>
                  <div class="col-sm-6">
                    <label for="max_amount" class="col-sm-12 col-form-label form-label">Max amount</label>
                    <div class="input-group">
                        <span class="input-group-text">IDR</span>
                        <input type="text" class="form-control" name="max_amount" id="max_amount" value="<?= htmlspecialchars($settings['max_amount'] ?? '999999999') ?>">
                    </div>
                    <div class="text-secondary mt-2">Maximum transaction amount</div>
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col-sm-6">
                    <label for="fixed_charge" class="col-sm-12 col-form-label form-label">Fixed charge</label>
                    <div class="input-group">
                        <span class="input-group-text">IDR</span>
                        <input type="text" class="form-control" name="fixed_charge" id="fixed_charge" value="<?= htmlspecialchars($settings['fixed_charge'] ?? '0') ?>">
                    </div>
                    <div class="text-secondary mt-2">Fixed transaction fee</div>
                  </div>
                    
                  <div class="col-sm-6">
                    <label for="percent_charge" class="col-sm-12 col-form-label form-label">Percent charge</label>
                    <div class="input-group">
                        <span class="input-group-text">%</span>
                        <input type="text" class="form-control" name="percent_charge" id="percent_charge" value="<?= htmlspecialchars($settings['percent_charge'] ?? '0') ?>">
                    </div>
                    <div class="text-secondary mt-2">Percentage transaction fee</div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label for="status" class="col-sm-12 col-form-label form-label">Status</label>
                    <div class="input-group">
                      <select class="form-control" name="status" id="status">
                        <?php $status_gateway = isset($settings['status']) ? strtolower($settings['status']) : ''; ?>
                        <option value="disable" <?php echo ($status_gateway === 'disable') ? 'selected' : ''; ?>>Disable</option>
                        <option value="enable" <?php echo ($status_gateway === 'enable') ? 'selected' : ''; ?>>Enable</option>
                      </select>
                    </div>
                    <div class="text-secondary mt-2">Enable or disable this gateway</div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label for="category" class="col-sm-12 col-form-label form-label">Category</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="category" id="category" value="Online Payment Gateway" readonly>
                    </div>
                    <div class="text-secondary mt-2">Payment gateway category</div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label for="currency" class="col-sm-12 col-form-label form-label">Currency</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="currency" id="currency" value="IDR" readonly>
                    </div>
                    <div class="text-secondary mt-2">Default currency: Indonesian Rupiah</div>
                  </div>
                </div>
            </div>
            <!-- End Body -->
          </div>
          
          <div class="card">
            <div class="card-header">
              <h2 class="card-title h4">API Configuration</h2>
            </div>

            <!-- Body -->
            <div class="card-body">
                <div class="row mb-4">
                  <div class="col-sm-12">
                    <label for="merchant_code" class="col-sm-12 col-form-label form-label">Merchant Code</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="merchant_code" id="merchant_code" value="<?= htmlspecialchars($settings['merchant_code'] ?? '') ?>">
                    </div>
                    <div class="text-secondary mt-2">Your Duitku Merchant Code</div>
                  </div>

                  <div class="col-sm-12">
                    <label for="api_key" class="col-sm-12 col-form-label form-label">API Key</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="api_key" id="api_key" value="<?= htmlspecialchars($settings['api_key'] ?? '') ?>">
                    </div>
                    <div class="text-secondary mt-2">Your Duitku API Key</div>
                  </div>
                  
                  <div class="col-sm-12">
                    <label for="environment" class="col-sm-12 col-form-label form-label">Environment</label>
                    <div class="input-group">
                      <select class="form-control" name="environment" id="environment">
                        <?php $env = isset($settings['environment']) ? strtolower($settings['environment']) : 'sandbox'; ?>
                        <option value="sandbox" <?php echo ($env === 'sandbox') ? 'selected' : ''; ?>>Sandbox (Testing)</option>
                        <option value="production" <?php echo ($env === 'production') ? 'selected' : ''; ?>>Production (Live)</option>
                      </select>
                    </div>
                    <div class="text-secondary mt-2">Select environment mode</div>
                  </div>
                </div>
            </div>
            <!-- End Body -->
          </div>

          <div class="card">
            <div class="card-header">
              <h2 class="card-title h4">Documentation</h2>
            </div>
            <div class="card-body">
              <p>For API keys and configuration, visit: <a href="https://docs.duitku.com/" target="_blank">Duitku Documentation</a></p>
              <p>Dashboard: <a href="https://dashboard.duitku.com/" target="_blank">Duitku Dashboard</a></p>
            </div>
          </div>

          <div class="text-center mb-3">
            <button type="submit" class="btn btn-primary">Save Settings</button>
          </div>
        </div>
      </div>
    </div>
</form>
