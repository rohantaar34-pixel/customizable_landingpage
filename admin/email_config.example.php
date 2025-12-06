<?php
/**
 * Email Configuration
 * 
 * IMPORTANT: This file contains sensitive information.
 * Do not commit actual credentials to version control.
 * 
 * For production use:
 * 1. Copy this file to email_config.php
 * 2. Update with your actual credentials
 * 3. Ensure email_config.php is in .gitignore
 */

return [
    // SMTP Server Configuration
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_secure' => 'tls', // 'tls' or 'ssl'
    'smtp_auth' => true,
    
    // From Address
    // IMPORTANT: Replace these with actual credentials or use environment variables
    'smtp_username' => getenv('SMTP_USERNAME') ?: 'your-email@example.com',
    'smtp_password' => getenv('SMTP_PASSWORD') ?: '', // Set via environment variable
    
    // From Address
    'from_email' => getenv('FROM_EMAIL') ?: 'noreply@example.com',
    'from_name' => 'In & Out Cleaning Experts',
    
    // Contact Information (displayed in emails)
    'contact_email' => 'contact@example.com',
    'contact_phone' => '0000000000',
    
    // Company Information
    'company_name' => 'In & Out Cleaning Experts',
    'company_tagline' => 'Professional Cleaning Services',
];
