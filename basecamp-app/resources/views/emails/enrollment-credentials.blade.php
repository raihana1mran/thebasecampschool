<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Credentials</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #1e293b; margin: 0; padding: 0; background: #f8fafc; }
        .container { max-width: 560px; margin: 40px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #006479, #40cef3); padding: 32px 40px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { color: rgba(255,255,255,0.85); margin: 8px 0 0; font-size: 14px; }
        .body { padding: 32px 40px; }
        .body h2 { font-size: 18px; margin: 0 0 8px; }
        .body p { color: #64748b; font-size: 14px; margin: 0 0 24px; }
        .credentials { background: #f1f5f9; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .credentials div { margin-bottom: 12px; }
        .credentials div:last-child { margin-bottom: 0; }
        .credentials label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8; font-weight: 700; display: block; margin-bottom: 2px; }
        .credentials span { font-size: 16px; font-weight: 700; color: #0f172a; font-family: 'SF Mono', 'Fira Code', monospace; }
        .cta { display: inline-block; background: linear-gradient(135deg, #006479, #40cef3); color: white; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 14px; }
        .footer { padding: 24px 40px; border-top: 1px solid #e2e8f0; text-align: center; }
        .footer p { color: #94a3b8; font-size: 12px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to The Base Camp School</h1>
            <p>Your enrollment is now active</p>
        </div>
        <div class="body">
            <h2>Hello, {{ $user->name }}!</h2>
            <p>Your admission has been approved. Below are your enrollment credentials to access the student dashboard.</p>

            <div class="credentials">
                <div>
                    <label>Enrollment Number</label>
                    <span>{{ $user->enrollment_number }}</span>
                </div>
                <div>
                    <label>Temporary Password</label>
                    <span>{{ $password }}</span>
                </div>
                <div>
                    <label>Dashboard URL</label>
                    <span>{{ config('app.url') }}/dashboard</span>
                </div>
            </div>

            <p style="margin-bottom: 20px;">Please log in and change your password on first access.</p>

            <a href="{{ config('app.url') }}/dashboard" class="cta">Go to Dashboard</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} The Base Camp School. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
