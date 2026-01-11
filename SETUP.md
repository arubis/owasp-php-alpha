# Quick Setup Guide - PHP Installation

## Fastest Method: Using Winget (Windows Package Manager)

If you have Windows 10/11 with winget installed, run:

```powershell
winget install --id PHP.PHP -e
```

Then close and reopen PowerShell, and verify:
```powershell
php -v
```

## Alternative: Manual Installation (5 minutes)

### Step 1: Download PHP
1. Go to: **https://windows.php.net/download/**
2. Download: **PHP 8.2.x Thread Safe (x64)** ZIP file
3. Extract to: **C:\php**

### Step 2: Add to PATH
1. Press `Win + X` → Select **"System"**
2. Click **"Advanced system settings"** (right side)
3. Click **"Environment Variables"** button
4. Under **"System variables"**, find **"Path"** → Click **"Edit"**
5. Click **"New"** → Type: `C:\php`
6. Click **OK** on all dialogs
7. **Close and reopen PowerShell** (important!)

### Step 3: Verify
```powershell
php -v
```

You should see PHP version information.

### Step 4: Run the Application
```powershell
# Initialize database
php db/init.php

# Start server
php -S localhost:8000 -t public
```

Then open: **http://localhost:8000**

## Using XAMPP (If you prefer a full stack)

1. Download: https://www.apachefriends.org/
2. Install XAMPP
3. Use full path to PHP:
   ```powershell
   C:\xampp\php\php.exe db/init.php
   C:\xampp\php\php.exe -S localhost:8000 -t public
   ```

## Need Help?

- Check that PHP is in PATH: `$env:PATH -split ';' | Select-String php`
- Verify PHP location: `Get-Command php -ErrorAction Stop`
