<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlatFinders - Database Setup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .step {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .step h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .step p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .code {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin: 10px 0;
        }
        .btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
        }
        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
            margin-bottom: 20px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
            margin-bottom: 20px;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
            margin-bottom: 20px;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
            margin-bottom: 20px;
        }
        .credential {
            background: #e7f3ff;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            font-family: monospace;
        }
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏠 FlatFinders Database Setup</h1>
        <p class="subtitle">Property Rental Platform - Automated Setup Script</p>

        <div id="message"></div>

        <div class="info">
            <strong>ℹ️ Setup Information</strong>
            <p>This script will automatically:</p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>Create the flatfinders_db database</li>
                <li>Create all necessary tables</li>
                <li>Insert sample data (15 users, 15 properties, 12 inquiries, etc.)</li>
                <li>Set up default admin account</li>
            </ul>
        </div>

        <div class="step">
            <h3>📋 Pre-requisites</h3>
            <p>Before running setup, make sure:</p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>✓ XAMPP is installed and running</li>
                <li>✓ Apache and MySQL services are started</li>
                <li>✓ PHP and MySQL are accessible</li>
            </ul>
        </div>

        <div class="step">
            <h3>🔐 Default Login Credentials</h3>
            <div class="credential"><strong>Admin:</strong> admin@flatfinders.com / password123</div>
            <div class="credential"><strong>Owner:</strong> abdul.rahman@gmail.com / password123</div>
            <div class="credential"><strong>Customer:</strong> rafiq.ahmed@gmail.com / password123</div>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p style="margin-top: 15px; color: #667eea;">Setting up database...</p>
        </div>

        <div class="btn-group">
            <button class="btn" onclick="runSetup()">🚀 Run Setup</button>
            <a href="public/index.html" class="btn" style="background: #28a745;">🏠 Go to Homepage</a>
            <a href="public/login.html" class="btn" style="background: #17a2b8;">🔑 Go to Login</a>
        </div>

        <div class="step" style="margin-top: 30px;">
            <h3>📝 Manual Setup (Alternative)</h3>
            <p>If automatic setup fails, follow these steps:</p>
            <ol style="margin-left: 20px; margin-top: 10px;">
                <li>Open phpMyAdmin (http://localhost/phpmyadmin)</li>
                <li>Click on "Import" tab</li>
                <li>Choose file: <code>backend/database/schema.sql</code></li>
                <li>Click "Go" to create database and tables</li>
                <li>Import again with: <code>backend/database/sample-data.sql</code></li>
                <li>Click "Go" to insert sample data</li>
            </ol>
        </div>
    </div>

    <script>
        function runSetup() {
            const messageDiv = document.getElementById('message');
            const loadingDiv = document.getElementById('loading');
            
            // Show loading
            loadingDiv.style.display = 'block';
            messageDiv.innerHTML = '';

            // Make AJAX request
            fetch('setup-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                loadingDiv.style.display = 'none';
                
                if (data.success) {
                    messageDiv.innerHTML = `
                        <div class="success">
                            <strong>✅ Success!</strong><br>
                            ${data.message}<br><br>
                            <strong>Setup Details:</strong><br>
                            ${data.details ? data.details.map(d => `• ${d}`).join('<br>') : ''}
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="error">
                            <strong>❌ Error!</strong><br>
                            ${data.message}<br><br>
                            Please check the manual setup instructions below or contact support.
                        </div>
                    `;
                }
            })
            .catch(error => {
                loadingDiv.style.display = 'none';
                messageDiv.innerHTML = `
                    <div class="error">
                        <strong>❌ Connection Error!</strong><br>
                        Could not connect to the setup handler. Please make sure:<br>
                        • XAMPP Apache server is running<br>
                        • You're accessing via http://localhost<br>
                        • The setup-handler.php file exists<br><br>
                        Error: ${error.message}
                    </div>
                `;
            });
        }
    </script>
</body>
</html>
