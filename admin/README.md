# Analytics Dashboard & Booking Management System

This system provides a comprehensive analytics dashboard and booking management interface for the In & Out Cleaning service.

## Features

### 1. Analytics Dashboard
- Real-time statistics showing total bookings, pending, approved, declined counts
- Total revenue calculation from approved bookings
- Interactive charts:
  - Monthly revenue trend (line chart)
  - Booking status distribution (doughnut chart)

### 2. Booking Management
- Complete list of all bookings with customer details
- Approve/Decline actions for pending bookings
- Status tracking (pending, approved, declined)

### 3. Email Notifications
- Automated email notifications for booking approvals and declines
- Custom message support
- Preset email templates
- Professional HTML email formatting
- PHPMailer integration for reliable delivery

## Setup Instructions

### Email Configuration

1. **Copy the example configuration file:**
   ```bash
   cp admin/email_config.example.php admin/email_config.php
   ```

2. **Edit `admin/email_config.php` with your email credentials:**
   - Update `smtp_username` with your SMTP email address
   - Update `smtp_password` with your SMTP password
   - Adjust `smtp_host` and `smtp_port` if using a different email provider
   - Update contact information as needed

3. **Using Environment Variables (Recommended for production):**
   Set the following environment variables:
   ```bash
   export SMTP_USERNAME="your-email@gmail.com"
   export SMTP_PASSWORD="your-app-password"
   export FROM_EMAIL="your-email@gmail.com"
   ```

### For Gmail Users

If using Gmail, you'll need to:
1. Enable 2-factor authentication on your Google account
2. Generate an "App Password" specifically for this application
3. Use the App Password instead of your regular Gmail password

Learn more: https://support.google.com/accounts/answer/185833

### For Other Email Providers

Update the SMTP settings in `admin/email_config.php`:
- **Gmail**: smtp.gmail.com, port 587, TLS
- **Outlook/Office365**: smtp.office365.com, port 587, TLS
- **Yahoo**: smtp.mail.yahoo.com, port 587, TLS
- **Custom SMTP**: Check with your email provider

## Usage

### Accessing the Dashboard

Navigate to: `admin/analytics.php`

The dashboard will automatically:
1. Load all booking data from the database
2. Calculate analytics metrics
3. Display interactive charts
4. Show the booking management table

### Managing Bookings

1. **To Approve a Booking:**
   - Click the "Approve" button next to a pending booking
   - Enter a custom message or use the preset template
   - Click "Send & Confirm"
   - The booking status will update and an email will be sent

2. **To Decline a Booking:**
   - Click the "Decline" button next to a pending booking
   - Enter a custom message explaining the reason
   - Click "Send & Confirm"
   - The booking status will update and an email will be sent

### Email Templates

Two preset templates are available:
- **Approval Template**: Confirms the booking and informs next steps
- **Decline Template**: Politely declines with option for alternatives

You can customize these messages before sending.

## API Endpoints

### GET `/admin/booking_management_api.php?action=get_bookings`
Returns all bookings and analytics data in JSON format.

**Response:**
```json
{
  "success": true,
  "bookings": [...],
  "analytics": {
    "total_bookings": 10,
    "pending_count": 3,
    "approved_count": 6,
    "declined_count": 1,
    "total_revenue": 1245.00,
    "avg_booking": 207.50
  },
  "charts": {
    "monthly_revenue": [...],
    "status_distribution": {...}
  }
}
```

### POST `/admin/booking_management_api.php`
Updates booking status and sends email notification.

**Parameters:**
- `action`: "update_booking"
- `booking_id`: The booking ID to update
- `booking_action`: "approve" or "decline"
- `email_message`: Custom message to include in email

**Response:**
```json
{
  "success": true,
  "message": "Booking approved successfully",
  "email_sent": true
}
```

## Database Schema

The system uses the existing `bookings` table with the following relevant fields:
- `id`: Primary key
- `booking_ref`: Unique booking reference
- `status`: ENUM('pending', 'approved', 'declined')
- `customer_email`: For email notifications
- `customer_name`: Customer name
- `service`: Service type
- `price`: Booking price
- `created_at`: Timestamp

## Security Considerations

1. **Never commit `admin/email_config.php` to version control**
   - The file is already in `.gitignore`
   - Only commit the example file

2. **Use environment variables in production**
   - More secure than storing credentials in files
   - Easier to manage across different environments

3. **Use app-specific passwords**
   - Never use your main email password
   - Generate app-specific passwords for better security

4. **SSL/TLS Encryption**
   - Always use STARTTLS or SSL for SMTP connections
   - Default configuration uses TLS

## Troubleshooting

### Emails Not Sending

1. Check that `admin/email_config.php` exists and has correct credentials
2. Verify SMTP password is set (not empty)
3. Check server error logs for detailed error messages
4. Ensure firewall allows outbound connections on SMTP ports
5. For Gmail, ensure 2FA is enabled and you're using an App Password

### Charts Not Displaying

1. Ensure Chart.js CDN is accessible
2. Check browser console for JavaScript errors
3. Verify the API is returning data correctly

### Data Not Loading

1. Verify database connection settings in `includes/config.php`
2. Check that the bookings table exists and has the status column
3. Check browser console and network tab for API errors

## Dependencies

- PHP 8.0+
- MySQL/MariaDB
- PHPMailer (installed via Composer)
- Chart.js (loaded via CDN)
- Tailwind CSS (loaded via CDN)
- Font Awesome (loaded via CDN)
- SweetAlert2 (loaded via CDN)

## Support

For issues or questions, please contact the development team or refer to the main project documentation.
