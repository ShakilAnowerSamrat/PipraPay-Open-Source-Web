<?php
    $transaction_details = pp_get_transation($payment_id);
    $setting = pp_get_settings();
    $faq_list = pp_get_faq();
    $support_links = pp_get_support_links();

    $plugin_slug = 'duitku';
    $plugin_info = pp_get_plugin_info($plugin_slug);
    $settings = pp_get_plugin_setting($plugin_slug);
    
    $transaction_amount = convertToDefault($transaction_details['response'][0]['transaction_amount'], $transaction_details['response'][0]['transaction_currency'], $settings['currency']);
    $transaction_fee = safeNumber($settings['fixed_charge']) + ($transaction_amount * (safeNumber($settings['percent_charge']) / 100));
    $transaction_amount = $transaction_amount + $transaction_fee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $settings['display_name'] ?? 'Duitku'; ?> - <?php echo $setting['response'][0]['site_name']?></title>
    <link rel="icon" type="image/x-icon" href="<?php if(isset($setting['response'][0]['favicon'])){if($setting['response'][0]['favicon'] == "--"){echo 'https://cdn.piprapay.com/media/favicon.png';}else{echo $setting['response'][0]['favicon'];};}else{echo 'https://cdn.piprapay.com/media/favicon.png';}?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        :root {
            --secondary: #e74c3c;
            --success: #00b894;
            --danger: #d63031;
            --warning: #fdcb6e;
            --dark: #2d3436;
            --light: #f5f6fa;
            --gray: #636e72;
            --border: #dfe6e9;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .payment-container {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .payment-header {
            display: flex;
            background: var(--light);
            border-radius: 8px;
            padding: 1rem;
            align-items: center;
            margin-top: 1.5rem;
            margin-left: 1.5rem;
            margin-right: 1.5rem;
            justify-content: space-between;
            color: <?php echo $setting['response'][0]['global_text_color'] ?? '#2d3436'?>;
        }
        
        .payment-logo {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .payment-body {
            padding: 1.5rem;
        }
        
        .payment-amount {
            display: flex;
            background: var(--light);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
            justify-content: space-between;
        }
        
        .merchant-logo {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
            background: white;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .amount-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
        }
        
        .amount-label {
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        .payment-details {
            margin-bottom: 1.5rem;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }
        
        .detail-item:last-child {
            border-bottom: 2px solid var(--secondary);
            font-weight: 600;
        }
        
        .detail-label {
            color: var(--gray);
        }
        
        .detail-value {
            font-weight: 500;
        }
        
        .btn-pay {
            width: 100%;
            padding: 1rem;
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-pay:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }
        
        .btn-pay:disabled {
            background: var(--gray);
            cursor: not-allowed;
            transform: none;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        
        .spinner {
            border: 4px solid var(--light);
            border-top: 4px solid var(--secondary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .info-box {
            background: #fadbd8;
            border-left: 4px solid var(--secondary);
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .footer-links {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
            font-size: 0.85rem;
        }
        
        .footer-links a {
            color: var(--secondary);
            text-decoration: none;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <div class="payment-logo">
                <i class="fas fa-wallet" style="color: var(--secondary);"></i>
                <span><?php echo $settings['display_name'] ?? 'Duitku'; ?></span>
            </div>
            <div style="font-size: 0.9rem; color: var(--gray);">Fast & Secure</div>
        </div>

        <div class="payment-body">
            <div class="info-box">
                <i class="fas fa-info-circle"></i> Complete your payment through Duitku's secure payment gateway.
            </div>

            <div class="payment-amount">
                <?php if (!empty($setting['response'][0]['logo'])): ?>
                    <img src="<?php echo htmlspecialchars($setting['response'][0]['logo']); ?>" alt="Merchant Logo" class="merchant-logo">
                <?php endif; ?>
                <div>
                    <div class="amount-label">Total Amount</div>
                    <div class="amount-value">IDR <?php echo number_format($transaction_amount, 0, ',', '.'); ?></div>
                </div>
            </div>

            <div class="payment-details">
                <div class="detail-item">
                    <span class="detail-label">Transaction ID</span>
                    <span class="detail-value"><?php echo htmlspecialchars($transaction_details['response'][0]['transaction_id']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Invoice</span>
                    <span class="detail-value"><?php echo htmlspecialchars($transaction_details['response'][0]['invoice_id'] ?? 'N/A'); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Description</span>
                    <span class="detail-value" style="text-align: right; max-width: 200px;"><?php echo htmlspecialchars(substr($transaction_details['response'][0]['transaction_description'], 0, 30)); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Total</span>
                    <span class="detail-value">IDR <?php echo number_format($transaction_amount, 0, ',', '.'); ?></span>
                </div>
            </div>

            <button class="btn-pay" id="payButton" onclick="processPayment()">
                <i class="fas fa-credit-card me-2"></i>Pay Now with Duitku
            </button>

            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p>Processing your payment...</p>
            </div>
        </div>

        <div style="padding: 0 1.5rem 1.5rem;">
            <div class="footer-links">
                <a href="javascript:history.back()"><i class="fas fa-arrow-left me-1"></i>Back</a>
                <a href="<?php echo $support_links[0]['link'] ?? '#'; ?>" target="_blank"><i class="fas fa-question-circle me-1"></i>Help</a>
            </div>
        </div>
    </div>

    <script>
        function processPayment() {
            document.getElementById('payButton').disabled = true;
            document.getElementById('loading').style.display = 'block';

            var transactionId = '<?php echo htmlspecialchars($transaction_details['response'][0]['transaction_id']); ?>';
            var amount = <?php echo $transaction_amount; ?>;

            // This would normally make an API call to Duitku to generate payment link
            // For now, showing placeholder implementation
            console.log('Processing payment with Duitku');
            console.log('Transaction ID:', transactionId);
            console.log('Amount:', amount);

            // Simulate API call
            setTimeout(function() {
                alert('Duitku integration requires server-side API implementation');
                document.getElementById('payButton').disabled = false;
                document.getElementById('loading').style.display = 'none';
            }, 2000);
        }
    </script>
</body>
</html>
